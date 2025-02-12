<?php
$servername = "sql311.infinityfree.com";
$username = "if0_37763906";
$password = "zWDSpMpDAGc15Nv";
$dbname = "if0_37763906_lp2";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8mb4');
error_reporting(E_ALL);
ini_set('display_errors', 1);