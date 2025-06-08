<?php

        
    include "config.php";
    
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if(mysqli_connect_errno()){
            die('Unable to connect with database' . mysqli_connect_error());
        }

        if(isset($_POST['upload']) && isset($_POST['email']) && isset($_POST['password'])){

            require_once "validate.php";
            $target_dir = "/files/users/images";
            $image = $_POST['upload'];
            $email_var = validate($_POST['email']);
            $password_var = validate($_POST['password']);
            $md5Pass = md5($password_var);


            $imageStore = rand()."_".time().".jpeg";
            $target_dir = $target_dir."/".$imageStore;
            $file_url = "https://rentalorb.com".$target_dir;
            file_put_contents($file_url, base64_decode($image));
            $select = "update users set avatar='".$target_dir."' where email like '".$email_var."' and password like '".$md5Pass."'";
            
            /*$select = "insert into tbl_staff (image)
            values ('".$imageStore."')";*/

           $response = mysqli_query($conn, $select);

            if($response === TRUE){
                echo "Image Uploaded";
                mysqli_close($conn);
            } else {
                echo "Failed";
            }
            
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