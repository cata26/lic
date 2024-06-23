<?php

$sname ="localhost";
$unmae ="root";
$password ="";

$db_name = "secretariat";

$conn = mysqli_connect($sname,$unmae,$password,$db_name);
if(!$conn) {
    echo "Conexiune eșuată";
}

?>