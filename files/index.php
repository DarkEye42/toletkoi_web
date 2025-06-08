<?php
        // // DB Configs
        // define('DB_HOST', 'localhost');
        // define('DB_USER', 'darkeye42_darkeye');
        // define('DB_PASS', '@DarkEye-2021!');
        // define('DB_NAME', 'darkeye42_RentalOrb');

        include "config.php";

        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if(isset($_POST['upload']) && isset($_POST['email']) && isset($_POST['password'])){

            if($conn){
                require_once "validate.php";
                $target_dir = "images/avatars";
                $image = $_POST['upload'];
                $email_var = validate($_POST['email']);
                $password_var = validate($_POST['password']);
                $md5Pass = md5($password_var);

                $result = $conn->query("select avatar from users where email like '$email_var'
                and password like '$md5Pass'");

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        if(file_exists($row['avatar'])){
                                if(unlink($row['avatar'])){
                                    $imageName = rand()."_".time().".jpeg";
                                    $image_path = $target_dir."/".$imageName;
                                    file_put_contents($image_path, base64_decode($image));
                
                                    $update = "update users set avatar='".$image_path."' where email like '".$email_var."' and password like '".$md5Pass."'";
                                    
                                    $response = mysqli_query($conn, $update);
                
                                    if($response === TRUE){
                                        echo "Image Uploaded";
                                        mysqli_close($conn);
                                    } else {
                                        echo "Failed";
                                        mysqli_close($conn);
                                    }
                                } else {
                                    echo "Failed";
                                    mysqli_close($conn);
                                }
                            } else {
                                $imageName = rand()."_".time().".jpeg";
                                $image_path = $target_dir."/".$imageName;
                                file_put_contents($image_path, base64_decode($image));
            
                                $update = "update users set avatar='".$image_path."' where email like '".$email_var."' and password like '".$md5Pass."'";
                                
                                $response = mysqli_query($conn, $update);
            
                                if($response === TRUE){
                                    echo "Image Uploaded";
                                    mysqli_close($conn);
                                } else {
                                    echo "Data Not Found";
                                    mysqli_close($conn);
                                }
                            }
                        }
                } 
            }
        } else {
            header('location: https://rentalorb.com/index.php?error=401');
        }

/*
$conn = mysqli_connect("localhost","root","");
    mysqli_select_db($conn,"rentalorb");

       if(isset($_POST['t1']) && isset($_POST['t2'])){

        $name = $_POST['t1'];
	    $design = $_POST['t2'];	   
	    //$img = $_POST['upload'];

        $filename="IMG".rand().".jpg";
        file_put_contents("files".$filename,base64_decode($img));

                $qry = "INSERT INTO tbl_staff (id, name, desig, image`)
                    VALUES (NULL, '".$name."', '".$design."', '".$filename."')";

                $res = mysqli_query($conn,$qry);
                
                if($res==true){
                    echo "File Uploaded Successfully";
                } else{
                    echo "Could not upload File";
                }
       }
*/
?>