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
  //error_reporting(0);
  include("../../connect.php");

  if (isset($_POST['btnedit'])) {
    $dn_id = $_POST['dn_id']; //ห้ามซ้ำ
    $dn_date = $_POST['dn_date'];
    $dn_file = $_POST['dn_file'];
    $pe_id  = $_POST['pe_id'];
    $dn_name  = $_POST['dn_name'];
    $s_id  = $_POST['s_id'];

    $fileupload = $_FILES['file']['tmp_name'];
    $fileupload_name = uniqid() . '_' . $_FILES['file']['name'];

    if ((empty($fileupload))) {
      $msg = "";
      if (!$fileupload) $msg = $msg . " รูป";
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
      if ($fileupload != "") {
        if ($dn_file == "") {
          copy($fileupload, "../../files/" . $fileupload_name);
          $query = "UPDATE documents set dn_name='$dn_name',dn_date='$dn_date',dn_file='$fileupload_name',c_id='$c_id',dn_status='$dn_status' WHERE dn_id = '$dn_id'";
          //mysqli_query($conn, $query);
        }
      }
      //เซ็ครูปภาพ
      if ($fileupload != "") {
        if ($dn_file != "") {
          unlink("../../files/$dn_file");
        } else {
          copy($fileupload, "../../files/" . $fileupload_name);
        $query = "INSERT INTO documents(dn_name,dn_date,dn_file,pe_id)VALUES ('$dn_name','$dn_date','$fileupload_name','$pe_id')";
          mysqli_query($conn, $query);
          echo "<script>Swal.fire({
          type: 'success',
          title: 'บันทึกข้อมูลเรียบร้อย',
          showConfirmButton: true,
          timer: 1500
        }).then(() => { 
          window.location = 'indexstddoc.php?pe_id=$pe_id&s_id=$s_id'
          });
        </script>";
          exit();
        }
        copy($fileupload, "../../files/" . $fileupload_name);
        $query = "UPDATE documents set dn_name='$dn_name',dn_date='$dn_date',dn_file='$fileupload_name',pe_id='$pe_id' WHERE dn_id = '$dn_id'";
        mysqli_query($conn, $query);
        echo "<script>Swal.fire({
          type: 'success',
          title: 'บันทึกข้อมูลเรียบร้อย',
          showConfirmButton: true,
          timer: 1500
        }).then(() => { 
          window.location = 'indexstddoc.php?pe_id=$pe_id&s_id=$s_id'
          });
        </script>";
        exit();
      } else {
        echo "<script>Swal.fire({
            type: 'error',
            title: 'กรุณาเลือกเอกสาร',
            showConfirmButton: true,
            timer: 1500
            }).then(() => { 
             window.history.back()
            });
            </script>";
        exit();
      }
    }
    $query = "UPDATE documents set dn_name='$dn_name',dn_date='$dn_date' WHERE dn_id = '$dn_id'";
    mysqli_query($conn, $query);
    echo "<script>Swal.fire({
          type: 'success',
          title: 'บันทึกข้อมูลเรียบร้อย',
          showConfirmButton: true,
          timer: 1500
        }).then(() => { 
          window.location = 'index.php?pe_id=$pe_id&s_id =$s_id'
          });
        </script>";
  }
  // window.location = 'index.php?pe_id=$pe_id&s_id =$s_id'
  ?>
  <?php include("../../scr.php"); ?>
</body>

</html>