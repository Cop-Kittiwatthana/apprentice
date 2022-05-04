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
  //**************************************INSERT*********************************************************** */
  if (isset($_POST['btnsave'])) {
    //$s_id = $_POST['cs_id']; //ห้ามซ้ำ
    $cs_tna = $_POST['cs_tna'];
    $cs_na = $_POST['cs_na'];
    $cs_department = $_POST['cs_department'];
    $cs_position = $_POST['cs_position'];
    $cs_tel = $_POST['cs_tel'];
    $cs_mail = $_POST['cs_mail'];
    $cs_fax = $_POST['cs_fax'];
    $cs_date = $_POST['cs_date'];
    $c_id = $_POST['c_id'];

    if ((empty($cs_na)) || (empty($cs_department)) || (empty($cs_position)) || (empty($cs_tel))) {
      $msg = "";
      if (!$cs_na) $msg = $msg . " ชื่อ-นามสกุล";
      if (!$cs_department) $msg = $msg . " แผนก";
      if (!$cs_position) $msg = $msg . " ตำแหน่ง";
      if (!$cs_tel) $msg = $msg . " เบอร์";
      echo "<script>Swal.fire({
			type: 'error',
			title: 'กรุณาใส่{$msg}',
			showConfirmButton: true,
			timer: 1500
		  }).then(() => { 
			 window.history.back()
			});
		  </script>";
    }
     else {
      $query = "SELECT  contact_staff.* FROM contact_staff WHERE (contact_staff.cs_na='" . $cs_na . "') and cs_id != '$cs_id'";
      $result = mysqli_query($conn, $query);
      $total = mysqli_num_rows($result);
      if ($total != 0) {
        echo "<script>Swal.fire({
          type: 'error',
          title: 'ข้อมูลนี้มีอยู่แล้ว',
          showConfirmButton: true,
          timer: 1500
          }).then(() => { 
           window.history.back()
          });
          </script>";
      } else {
         $query = "INSERT INTO contact_staff (cs_tna,cs_na,cs_department,cs_position,cs_tel,cs_mail,cs_fax,cs_date,c_id) VALUES ('$cs_tna','$cs_na','$cs_department','$cs_position','$cs_tel','$cs_mail','$cs_fax','$cs_date','$c_id')";
        mysqli_query($conn, $query);
        echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = '$baseURL/views/staff/index.php?c_id=$c_id'
            });
          </script>";
      }
    }
  }
 
  //**************************************UPDATE*********************************************************** */
  if (isset($_POST['btnedit'])) {
     $cs_id = $_POST['cs_id']; //ห้ามซ้ำ
     $cs_tna = $_POST['cs_tna'];
     $cs_na = $_POST['cs_na'];
     $cs_department = $_POST['cs_department'];
     $cs_position = $_POST['cs_position'];
     $cs_tel = $_POST['cs_tel'];
     $cs_mail = $_POST['cs_mail'];
     $cs_fax = $_POST['cs_fax'];
     $cs_date = $_POST['cs_date'];
     $c_id = $_POST['c_id'];

     if ((empty($cs_na)) || (empty($cs_department)) || (empty($cs_position)) || (empty($cs_tel))) {
      $msg = "";
      if (!$cs_na) $msg = $msg . " ชื่อ-นามสกุล";
      if (!$cs_department) $msg = $msg . " แผนก";
      if (!$cs_position) $msg = $msg . " ตำแหน่ง";
      if (!$cs_tel) $msg = $msg . " เบอร์";
      echo "<script>Swal.fire({
			type: 'error',
			title: 'กรุณาใส่{$msg}',
			showConfirmButton: true,
			timer: 1500
		  }).then(() => { 
			 window.history.back()
			});
		  </script>";
    }
     else {
      $query = "SELECT  contact_staff.* FROM contact_staff WHERE (contact_staff.cs_na='" . $cs_na . "') and cs_id != '$cs_id'";
      $result = mysqli_query($conn, $query);
      $total = mysqli_num_rows($result);
      if ($total != 0) {
        echo "<script>Swal.fire({
          type: 'error',
          title: 'ข้อมูลนี้มีอยู่แล้ว',
          showConfirmButton: true,
          timer: 1500
          }).then(() => { 
           window.history.back()
          });
          </script>";
      } else {
       $query = "UPDATE contact_staff set cs_tna='$cs_tna',cs_na='$cs_na',cs_department='$cs_department',cs_position='$cs_position',cs_tel='$cs_tel',cs_mail='$cs_mail',cs_fax='$cs_fax',cs_date='$cs_date',c_id='$c_id' WHERE cs_id = '$cs_id'";
        mysqli_query($conn, $query);
        echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = '$baseURL/views/staff/index.php?c_id=$c_id'
            });
          </script>";
      }
    }
  }
  //**************************************DELETE*********************************************************** */
  if (isset($_POST['btndelect'])) {
    $cs_id = $_POST['cs_id'];
    $c_id = $_POST['c_id'];
    $query = "DELETE FROM contact_staff WHERE cs_id = '$cs_id'";
    mysqli_query($conn, $query);
    echo "<script>Swal.fire({
	type: 'success',
	title: 'ลบข้อมูลเรียบร้อย',
	showConfirmButton: true,
	timer: 1500
  }).then(() => { 
	  window.location = '$baseURL/views/staff/index.php?c_id=$c_id'
	});
  </script>";
  }
  ?>
  <?php include("../../scr.php"); ?>
</body>

</html>