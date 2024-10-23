<?php
$servername = "localhost";
$username = "u297599468_guidancesrc";
$password = "Guidancesrc2024";
$dbname = "u297599468_guidancesrc_db";

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
