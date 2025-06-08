<?php
include '../admin/include/db_config.php';

if(isset($_POST['divisionId'])){
    $output = '';
    $divID = $_POST['divisionId'];

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM districts WHERE division_id = :divID ORDER BY name";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':divID', $divID, PDO::PARAM_INT);
        $stmt->execute();

        $output = '<option value="">Select District</option>';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
        }

        echo $output;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $pdo = null;
}

if(isset($_POST['disId'])){
    $output = '';
    $disID = $_POST['disId'];

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM upazilas WHERE district_id = :disID ORDER BY name";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':disID', $disID, PDO::PARAM_INT);
        $stmt->execute();

        $output = '<option value="">Select Thana</option>';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
        }

        echo $output;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $pdo = null;
}

if(isset($_POST['thanaId'])){
    $output = '';
    $thanaId = $_POST['thanaId'];

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM upazilas WHERE id = :thanaId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':thanaId', $thanaId, PDO::PARAM_INT);
        $stmt->execute();

		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$itemName = $result['name'];

        echo '<input type="text" name="thana" id="thana" value="'.$itemName.'" hidden>';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $pdo = null;
}

?>