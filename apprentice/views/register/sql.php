<?php

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Untitled Document</title>
  <?php include("../../head.php") ?>
</head>

<body>
  <?php
  error_reporting(0);
  include("../../connect.php");
  //**************************************INSERT*********************************************************** */
  if (isset($_POST['btnsave'])) {
    $id = $_POST['id']; //ห้ามซ้ำ
    $s_sdate = $_POST['s_sdate'];
    $s_edate = $_POST['s_edate'];

    if ((empty($s_sdate)) && (empty($s_edate))) {
      $msg = "";
      if (!$s_sdate) $msg = $msg . " วันที่เปิดลงทะเบียน";
      if (!$s_edate) $msg = $msg . " วันที่สิ้นสุดลงทะเบียน";
      echo "<script>Swal.fire({
			type: 'error',
			title: 'กรุณาเลือก{$msg}',
			showConfirmButton: true,
			timer: 1500
		  }).then(() => { 
			 window.history.back()
			});
		  </script>";
      exit();
    } else {
      $query = "SELECT student.* FROM student WHERE student.s_id LIKE '$id%'";
      $result = mysqli_query($conn, $query);
      while ($row = mysqli_fetch_array($result)) {
        $query = "UPDATE student set s_sdate='$s_sdate',s_edate='$s_edate' WHERE s_id = '$row[s_id]'";
        mysqli_query($conn, $query);
      }
      echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = '$baseURL/views/register/index.php'
            });
          </script>";
    }
  }
  //window.location = '$baseURL/views/student2/index.php'
  ?>
  <?php include("../../scr.php"); ?>
</body>

</html>