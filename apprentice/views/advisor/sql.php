<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Untitled Document</title>
  <?php include("../../head.php") ?>
</head>

<body>
  <?php
  include("../../connect.php");
  //**************************************UPDATE*********************************************************** */

  $t_id = $_POST['t_id']; //ห้ามซ้ำ
  $s_id = $_POST['s_id'];
  $id = $_POST['id'];
  $s_group = $_POST['s_group'];
  $br_id = $_POST['br_id'];

  if ((empty($t_id))) {
    $msg = "";
    if (!$t_id) $msg = $msg . " อาจารย์";
    echo "<script>Swal.fire({
        type: 'error',
        title: 'กรุณาเลือก{$msg}',
        showConfirmButton: true,
        timer: 1500
        }).then(() => { 
         window.history.back()
        });
        </script>";
  } else {
    foreach ($s_id as $s) {
      $query = "DELETE FROM advisor WHERE s_id = '$s' ";
      mysqli_query($conn, $query);
    }
    foreach ($t_id as $t) {
      foreach ($s_id as $s) {
        $query = "INSERT INTO advisor (s_id,br_id,t_id) VALUES ('$s','$br_id','$t')";
        mysqli_query($conn, $query);
      }
      echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = 'index.php?id=$br_id'
            });
          </script>";
    }
  }

  //}

  ?>
  <?php include("../../scr.php"); ?>
</body>

</html>