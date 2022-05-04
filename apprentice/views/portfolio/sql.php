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
    $s_id = $_POST['s_id']; //ห้ามซ้ำ
    $pf_na = $_POST['pf_na'];
    $img = $_POST['img'];

    $fileupload = $_FILES['img']['tmp_name'];
    $fileupload_name = uniqid() . '_' . $_FILES['img']['name'];

    if ((empty($pf_na))) {
      $msg = "";
      if (!$pf_na) $msg = $msg . " ชื่อผลงาน";
      echo "<script>Swal.fire({
			type: 'error',
			title: 'กรุณาใส่{$msg}',
			showConfirmButton: true,
			timer: 1500
		  }).then(() => { 
			 window.history.back()
			});
		  </script>";
    } else {
        //เซ็ครูปภาพ
        if ($fileupload != "") {
          copy($fileupload, "../../picture/" . $fileupload_name);
            $query = "INSERT INTO portfolio(pf_na,pf_file,s_id)VALUES ('$pf_na','$fileupload_name','$s_id')";
        } else {
            $query = "INSERT INTO portfolio(pf_na,s_id)VALUES ('$pf_na','$s_id')";
        }
        mysqli_query($conn, $query);
        $n_id = mysqli_insert_id($conn);
        echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = 'index.php'
            });
          </script>";
      }
    }
  
  //
  //**************************************UPDATE*********************************************************** */
  if (isset($_POST['btnedit'])) {
    $pf_id = $_POST['pf_id'];
    $s_id = $_POST['s_id'];
    $pf_na = $_POST['pf_na'];
    $pf_file = $_POST['pf_file'];
    

    $fileupload = $_FILES['img']['tmp_name'];
    $fileupload_name = uniqid() . '_' . $_FILES['img']['name'];

    if ((empty($pf_na))) {
      $msg = "";
      if (!$pf_na) $msg = $msg . " ชื่อผลงาน";
      echo "<script>Swal.fire({
      type: 'error',
      title: 'กรุณาใส่{$msg}',
      showConfirmButton: true,
      timer: 1500
      }).then(() => { 
      window.history.back()
      });
      </script>";
    }  else {
        //เซ็ครูปภาพ
        if ($fileupload != "") {
          if ($n_file != "") {
            unlink("../../picture/$n_file");
          }
          copy($fileupload, "../../picture/" . $fileupload_name);
          $query = "UPDATE portfolio set pf_na='$pf_na',pf_file='$fileupload_name',s_id='$s_id' WHERE pf_id = '$pf_id'";
        } else {
           $query = "UPDATE portfolio set pf_na='$pf_na',s_id='$s_id' WHERE pf_id = '$pf_id'";
        }
        mysqli_query($conn, $query);
        echo "<script>Swal.fire({
          type: 'success',
          title: 'บันทึกข้อมูลเรียบร้อย',
          showConfirmButton: true,
          timer: 1500
        }).then(() => { 
          window.location = 'index.php'
          });
        </script>";
      }
    }
// 
  //**************************************DELETE*********************************************************** */
  if (isset($_POST['btndelect'])) {
    $pf_id = $_POST['pf_id'];
    $pf_na = $_POST['pf_na'];
    if ($pf_na != "") {
      unlink("../../picture/$pf_na");
    }
    $query = "DELETE FROM portfolio WHERE pf_id = '$pf_id'";
    mysqli_query($conn, $query);
    echo "<script>Swal.fire({
    type: 'success',
    title: 'ลบข้อมูลเรียบร้อย',
    showConfirmButton: true,
    timer: 1500
    }).then(() => { 
      window.location = 'index.php'
    });
    </script>";
  }
  ?>
</body>

</html>