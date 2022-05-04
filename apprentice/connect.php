<?php

$host = "localhost";
$username = "schooltest_db";
$password = "jOb2aU76kR";
$db_name = "schooltest_db"; //ชื่อฐานข้อมูล

$conn = mysqli_connect($host, $username, $password, $db_name);
mysqli_set_charset($conn, "utf8");
error_reporting(error_reporting() & ~E_NOTICE);
date_default_timezone_set('Asia/Bangkok');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$baseURL = "$actual_link/apprentice";

?>
