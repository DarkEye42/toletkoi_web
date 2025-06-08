<?php
    require("../admin/include/essentials.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
    <link rel="stylesheet" href="api/style_main.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Merriweather&family=Poppins&display=swap"/>
</head>
<body>
<?php
    $street_var = $_GET['inp_street'];
    $area_var = $_GET['inp_area'];
    $ps_var = $_GET['inp_ps'];
    $dis_var = $_GET['inp_district'];
    $div_var = $_GET['inp_division'];
    $zip_var = $_GET['inp_zip'];
    $address_var = $street_var  . "," . $area_var  . "," . $ps_var  . "," . $dis_var  . "," . $div_var  . "-" . $zip_var;

    $geocode = httpPost('https://barikoi.xyz/v1/api/search/NDQ4NTpUNU5PNTBKOVZJ/rupantor/geocode',
    ["q"=>$address_var,
    "bangla"=>"yes",
    "thana"=>"yes",
    "district"=>"yes"]);

    //echo $address_var . "<br/>";
    //echo $street_var;
    $redirect_url = "../createads.php?inp_street=$street_var&inp_area=$area_var&inp_ps=$ps_var&inp_district=$dis_var&inp_division=$div_var&inp_zip=$zip_var&lat=".$geocode["latitude"]."&long=".$geocode["longitude"]."";
    redirect((isset($_GET['createPost'])) ? $redirect_url : "index.php?error=401");
        
    
?>

<h1>Just a moment...</h1>
<div class="slider">
	<div class="line"></div>
	<div class="break dot1"></div>
	<div class="break dot2"></div>
	<div class="break dot3"></div>
</div>
<p>You are being redirected to the ad posting page...<br/>If you have not been redirected, then please  <a href="<?=$redirect_url;?>">Click here.</a></p>

<?php
    function httpPost($url, $data){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $r = json_decode(html_entity_decode($response), true)["geocoded_address"];
        curl_close($curl);
        return $r;
    }
?>
</body>
</html>