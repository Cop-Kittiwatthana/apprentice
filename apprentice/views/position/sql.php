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
    $p_na = $_POST['p_na'];

    if ((empty($p_na))) {
      $msg = "";
      if (!$p_na) $msg = $msg . " ชื่อตำแหน่ง";
      echo "<script>Swal.fire({
			type: 'error',
			title: 'กรุณากรอก{$msg}',
			showConfirmButton: true,
			timer: 1500
		  }).then(() => { 
			 window.history.back()
			});
		  </script>";
    } else {
      $query = "SELECT * FROM position
                WHERE (p_na = '$p_na') 
                and (p_id != '$p_id')";
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

        $query = "INSERT INTO position (p_na) VALUES ('$p_na')";
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
  }
  //**************************************UPDATE*********************************************************** */
  if (isset($_POST['btnedit'])) {
    $p_id = $_POST['p_id'];
    $p_na = $_POST['p_na'];

    if ((empty($p_na))) {
      $msg = "";
      if (!$p_na) $msg = $msg . " ชื่อแผนก";
      echo "<script>Swal.fire({
			type: 'error',
			title: 'กรุณากรอก{$msg}',
			showConfirmButton: true,
			timer: 1500
		  }).then(() => { 
			 window.history.back()
			});
		  </script>";
    } else {
      $query = "SELECT * FROM position
      WHERE (p_na = '$p_na') 
      and (p_id != '$p_id')";
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
        //echo $amphure_id,'/',$province_id,'/',$district_name_th,'/',$zip_code,'/',$district_id;
        $query = "UPDATE position SET p_na ='$p_na' WHERE p_id = '$p_id'";
        mysqli_query($conn, $query);
        echo "<script>
    Swal.fire({
      type: 'success',
      title: 'แก้ไขข้อมูลเรียบร้อย',
      showConfirmButton: true,
      timer: 1500
    }).then(() => {
      window.location = 'index.php'
    });
  </script>";
      }
    }
  }
  //**************************************DELETE*********************************************************** */
  if (isset($_POST['btndelect'])) {
    $p_id = $_POST['p_id'];
    $query = "SELECT * FROM teacher WHERE p_id != '$p_id'";
    $result = mysqli_query($conn, $query);
    $total = mysqli_num_rows($result);
    if ($total != 0) {
      echo "<script>Swal.fire({
        type: 'error',
        title: 'ข้อมูลมีการใช้งานไม่สามารถลบได้!!',
        showConfirmButton: true,
        timer: 2000
        }).then(() => { 
          window.location = 'index.php'
        });
        </script>";
      exit();
    } else {
      $query = "DELETE FROM position WHERE p_id = '$p_id'";
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
      exit();
    }
  }
  ?>
  <?php include("../../scr.php"); ?>
</body>

</html>