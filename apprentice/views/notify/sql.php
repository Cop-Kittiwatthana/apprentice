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
    $name = $_POST['name']; //ห้ามซ้ำ
    $token = $_POST['token'];

    if ((empty($name)) && (empty($token))) {
      $msg = "";
      if (!$name) $msg = $msg . " ชื่อกลุ่ม ";
      if (!$token) $msg = $msg . " token line ";
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
      $query = "SELECT * FROM notify WHERE (name ='" . $name . "' and token ='" . $token . "' ) and id != '$id'";
      $result = mysqli_query($conn, $query);
      $total = mysqli_num_rows($result);
      if ($total != 0) {
        echo "<script>Swal.fire({
          type: 'error',
          title: 'มีคนใช้ username นี้แล้ว',
          showConfirmButton: true,
          timer: 1500
          }).then(() => { 
           window.history.back()
          });
          </script>";
      } else {
        $query = "INSERT INTO notify (name,token) VALUES ('$name','$token')";
        mysqli_query($conn, $query);
        echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = '$baseURL/views/notify/index.php'
            });
          </script>";
      }
    }
  }
  //**************************************UPDATE*********************************************************** */
  if (isset($_POST['btnedit'])) {
    $id = $_POST['id'];
    $name = $_POST['name']; //ห้ามซ้ำ
    $token = $_POST['token'];

    if ((empty($name)) && (empty($token))) {
      $msg = "";
      if (!$name) $msg = $msg . " ชื่อกลุ่ม ";
      if (!$token) $msg = $msg . " token line ";
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
      $query = "SELECT * FROM notify WHERE (name ='" . $name . "' and token ='" . $token . "' ) and id != '$id'";
      $result = mysqli_query($conn, $query);
      $total = mysqli_num_rows($result);
      if ($total != 0) {
        echo "<script>Swal.fire({
          type: 'error',
          title: 'มีคนใช้ username นี้แล้ว',
          showConfirmButton: true,
          timer: 1500
          }).then(() => { 
           window.history.back()
          });
          </script>";
      } else {
        $query = "UPDATE notify SET name ='$name',token = '$token' WHERE id = '$id'";
        mysqli_query($conn, $query);
        echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = '$baseURL/views/notify/index.php'
            });
          </script>";
      }
    }
  }
  //**************************************DELETE*********************************************************** */
  if (isset($_POST['btndelect'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM notify WHERE id = '$id'";
    mysqli_query($conn, $query);
    echo "<script>Swal.fire({
    type: 'success',
    title: 'ลบข้อมูลเรียบร้อย',
    showConfirmButton: true,
    timer: 1500
    }).then(() => { 
      window.location = '$baseURL/views/notify/index.php'
    });
    </script>";
  }
  ?>
  <?php include("../../scr.php"); ?>
</body>

</html>