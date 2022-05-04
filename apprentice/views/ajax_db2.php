<?php

include "../connect.php";

if (isset($_POST['function']) && $_POST['function'] == 'provinces2') {
  $id = $_POST['id'];
  $sql = "SELECT * FROM amphures WHERE province_id='$id'";
  $query = mysqli_query($conn, $sql);
  echo '<option value="" selected disabled>-กรุณาเลือกอำเภอ-</option>';
  foreach ($query as $value) {
    echo '<option value="' . $value['amphure_id'] . '">' . $value['amphures_name_th'] . '</option>';
  }
}

if (isset($_POST['function']) && $_POST['function'] == 'amphures2') {
  $id = $_POST['id'];
  $sql2 = "SELECT * FROM districts WHERE amphure_id='$id'";
  $query2 = mysqli_query($conn, $sql2);
  echo '<option value="" selected disabled>-กรุณาเลือกตำบล-</option>';
  foreach ($query2 as $value2) {
    echo '<option value="' . $value2['district_id'] . '">' . $value2['district_name_th'] . '</option>';
  }
}

if (isset($_POST['function']) && $_POST['function'] == 'districts2') {
  $id = $_POST['id'];
  $sql3 = "SELECT * FROM districts WHERE district_id='$id'";
  $query3 = mysqli_query($conn, $sql3);
  $result = mysqli_fetch_assoc($query3);
  echo $result['zip_code'];
  exit();
}
