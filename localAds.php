<?php

if(isset($_POST['email']) && isset($_POST['password'])){

    // DB Configs
    define('DB_HOST', 'localhost');
    define('DB_USER', 'darkeye42_darkeye');
    define('DB_PASS', '@DarkEye-2021!');
    define('DB_NAME', 'darkeye42_RentalOrb');

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if(mysqli_connect_errno()){
        die('Unable to connect with database' . mysqli_connect_error());
    }

        require_once "validate.php";

        $email_var = validate($_POST['email']);
        $password_var = validate($_POST['password']);
        $md5Pass = md5($password_var);
        
    if(isset($_POST['lat']) && isset($_POST['long']) && isset($_POST['distanceMax'])){
        // your input variables
        $lat_var = validate($_POST['lat']);
        $long_var = validate($_POST['long']);
        $radius = validate(($_POST['distanceMax'])); // expressed in Km

        // every latitude degree° is ~ 111Km
        $angle_radius_lat = $radius / 111;

        // longitude takes into account equator distance
        $angle_radius_lon = $angle_radius_lat * cos( deg2rad( $lat_var ) );

        // define a simple square with your lat/lng as center
        $min_lat = $lat_var - $angle_radius_lat;
        $max_lat = $lat_var + $angle_radius_lat;
        $min_lon = $long_var - $angle_radius_lon;
        $max_lon = $long_var + $angle_radius_lon;
        
        /*$result = $conn->query( "SELECT `id`, `latitude`, `longitude`
        FROM rentalPosts WHERE (`latitude` BETWEEN $min_lat AND $max_lat) AND (`longitude` BETWEEN $min_lon AND $max_lon) ");

        // filter the surplus outside the circle
        $results = [];
        if (mysqli_num_rows($result) > 0) {
            while( $row = mysqli_fetch_assoc($result) ) {*/

                
                    
                    $stmt = $conn->prepare("SELECT `id`, `post_owner`, `title`, `description`, `coverImage`, `coverImage2nd`,
                    `coverImage3rd`, `renter_type`, `takeOver`, `street`, `area`, `policeStation`, `district`,
                    `cost`, `building_type`, `contact`, `date`, `latitude`, `longitude` FROM rentalPosts
                    WHERE (`latitude` BETWEEN $min_lat AND $max_lat) AND (`longitude` BETWEEN $min_lon AND $max_lon)
                    ORDER BY `date` DESC;");

                    $stmt->bind_result($id, $post_owner, $title, $description, $coverImage, $coverImage2nd,
                    $coverImage3rd, $renter_type, $takeOver, $street, $area, $policeStation, $district,
                    $cost, $building_type, $contact, $date, $latitude, $longitude);

                    $stmt->execute();

                    $adsData = array();

                    while($stmt->fetch()){
                        if( getDistanceBetweenPointsNew( $lat_var, $long_var, $latitude, $longitude ) <= $radius ) {
                            $temp = array();
                            $temp['id'] = $id;
                            $temp['post_owner'] = $post_owner;
                            $temp['title'] = $title;
                            $temp['description'] = $description;
                            $temp['coverImage'] = $coverImage;
                            $temp['coverImage2nd'] = $coverImage2nd;
                            $temp['coverImage3rd'] = $coverImage3rd;
                            $temp['renter_type'] = $renter_type;
                            $temp['takeOver'] = $takeOver;
                            $temp['street'] = $street;
                            $temp['area'] = $area;
                            $temp['policeStation'] = $policeStation;
                            $temp['district'] = $district;
                            $temp['cost'] = $cost;
                            $temp['building_type'] = $building_type;
                            $temp['contact'] = $contact;
                            $temp['date'] = $date;
                            $temp['latitude'] = $latitude;
                            $temp['longitude'] = $longitude;
                            $temp['distance'] = getDistanceBetweenPointsNew( $lat_var, $long_var, $latitude, $longitude );
                            
                            array_push($adsData, $temp);
                            $success = true;
                        } else {
                            $success = false;
                        }
                    }
                    if($success == true){
                        echo json_encode($adsData);
                    } else {
                        echo "noData";
                    }
                    
                }
        
    }

function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2) {
    $theta = $longitude1 - $longitude2;
    $distance_var = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))+
                (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))));
    $distance_1 = acos($distance_var);
    $distance_2 = rad2deg($distance_1); 
    $distance_3 = $distance_2 * 60 * 1.1515;

    $distance = $distance_3 * 1.609344; 

    return (round($distance,2)); 
}

?>