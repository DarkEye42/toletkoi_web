<?php

include "config.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn) {
    echo "<h1> Connected </h1>";
} else {
    echo "<h1> Not Connected </h1>";
}

?>