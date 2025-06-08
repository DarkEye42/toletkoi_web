<?php
$directory = '../files/images/post'; // Replace with the actual directory path

$files = scandir($directory);
$files = array_diff($files, array('.', '..'));

// Sort the files array based on the name, size, or upload date
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name';
$sortTag1 = '';
$sortTag2 = '';
$sortTag3 = '';
if ($sort === 'size') {
    $sortTag2 = '(Large to Small)';
    usort($files, function($b, $a) use ($directory) {
        return filesize($directory . '/' . $a) - filesize($directory . '/' . $b);
    });
} elseif ($sort === 'date') {
    $sortTag3 = '(New to Old)';
    usort($files, function($a, $b) use ($directory) {
        return filemtime($directory . '/' . $a) - filemtime($directory . '/' . $b);
    });
} else {
    $sortTag1 = '(A to Z)';
    natcasesort($files);
}
?>
<table id="fileTable" class="table mt-3">
    <thead>
        <tr>
            <th>Preview</th>
            <th>Name <?= $sortTag1; ?></th>
            <th>Size <?= $sortTag2; ?></th>
            <th>Upload Date <?= $sortTag3; ?></th>
            <th>Post Query</th>
            <th>Post Action</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($files as $file) {
    $filePath = $directory . '/' . $file;
    $fileType = mime_content_type($filePath);
    $isImage = strpos($fileType, 'image/') === 0;

    // Get file size in KB or MB
    $fileSize = filesize($filePath);
    if ($fileSize >= 1024 * 1024) {
        $fileSize = round($fileSize / (1024 * 1024), 2) . ' MB';
    } else {
        $fileSize = round($fileSize / 1024, 2) . ' KB';
    }

    // Get file upload date
    $fileUploadDate = date('Y-m-d H:i:s', filemtime($filePath));

    // Check if a corresponding post exists in the database
    $postId = getPostIdFromDatabase($file); // Replace with your own database retrieval logic

    echo '<tr>';
    echo '<td>';
    if ($isImage) {
        echo '<img src="' . $filePath . '" class="img-thumbnail" style="max-width: 100px;">';
    } else {
        echo '<i class="file-type-icon"></i>'; // Replace "file-type-icon" with the appropriate file type icon classes from Bootstrap or another icon library
    }
    echo '</td>';
    echo '<td>' . $file . '</td>';
    echo '<td>' . $fileSize . '</td>';
    echo '<td>' . $fileUploadDate . '</td>';
    echo '<td>';
    if ($postId) {
        echo '<a class="btn btn-sm btn-inverse-info btn-fw" type="button" href="../adsDetails.php?ads=' . $postId . '"> View Post </a>';
    } else {
        echo '<button class="btn btn-sm btn-inverse-primary btn-fw" disabled> Not Found </button>';
    }
    echo '</td>';
    echo '<td><button class="btn btn-sm btn-inverse-danger btn-fw delete-btn" data-filename="' . $file . '">Delete File</button></td>';
    echo '</tr>';
}

function getPostIdFromDatabase($fileName){
    $con = $GLOBALS["con"];

    // Query to retrieve the post ID by file name using LIKE
    $sql = "SELECT id FROM rentalposts WHERE coverImage LIKE '%$fileName%' OR coverImage2nd LIKE '%$fileName%' OR coverImage3rd LIKE '%$fileName%'";

    $result = $con->query($sql);

    if ($result) {
        // Fetch the post IDs
        $postIds = array();
        while ($row = $result->fetch_assoc()) {
            $postIds[] = $row['id'];
        }

        // Output the post IDs
        foreach ($postIds as $postId) {
            return $postId;
        }
    } else {
        return $con->error;
    }
}
?>
    </tbody>
</table>