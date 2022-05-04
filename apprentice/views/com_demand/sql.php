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
    $de_id = $_POST['de_id']; //ห้ามซ้ำ
    $c_id = $_POST['c_id'];
    $br_id = $_POST['br_id'];
    $de_year = $_POST['de_year'];
    $de_num = $_POST['de_num'];
    $de_Jobdetails = $_POST['de_Jobdetails'];
    $de_Welfare = $_POST['de_Welfare'];

    if ((empty($de_num)) || (empty($de_Jobdetails))) {
      $msg = "";
      if (!$de_num) $msg = $msg . " จำนวนนักศึกษา";
      if (!$de_Jobdetails) $msg = $msg . " รายละเอียดงาน";
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
    if ((empty($de_year)) || (empty($c_id)) || (empty($br_id))) {
      $msg = "";
      if (!$de_year) $msg = $msg . " ปี";
      if (!$c_id) $msg = $msg . " สถานประกอบการ";
      if (!$br_id) $msg = $msg . " แผนก/สาขา";
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
      $query = "SELECT  demand.* FROM demand WHERE (demand.c_id ='" . $c_id . "' and demand.br_id ='" . $br_id . "' and demand.de_num ='" . $de_num . "' and demand.de_year ='" . $de_year . "') and de_id != '$de_id'";
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
        $query = "INSERT INTO demand (de_year,de_num,de_Jobdetails,de_Welfare,c_id,br_id) VALUES ('$de_year','$de_num','$de_Jobdetails','$de_Welfare','$c_id','$br_id')";
        mysqli_query($conn, $query);
        echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = '$baseURL/views/com_demand/index.php?c_id=$c_id'
            });
          </script>";
      }
    }
  }

  //**************************************UPDATE*********************************************************** */
  if (isset($_POST['btnedit'])) {
    $de_id = $_POST['de_id']; //ห้ามซ้ำ
    $c_id = $_POST['c_id'];
    $br_id = $_POST['br_id'];
    $de_year = $_POST['de_year'];
    $de_num = $_POST['de_num'];
    $de_Jobdetails = $_POST['de_Jobdetails'];
    $de_Welfare = $_POST['de_Welfare'];

    if ((empty($de_num)) || (empty($de_Jobdetails))) {
      $msg = "";
      if (!$de_num) $msg = $msg . " จำนวนนักศึกษา";
      if (!$de_Jobdetails) $msg = $msg . " รายละเอียดงาน";
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
    if ((empty($de_year)) || (empty($c_id)) || (empty($br_id))) {
      $msg = "";
      if (!$de_year) $msg = $msg . " ปี";
      if (!$c_id) $msg = $msg . " สถานประกอบการ";
      if (!$br_id) $msg = $msg . " แผนก/สาขา";
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
      $query = "SELECT  demand.* FROM demand WHERE (demand.c_id ='" . $c_id . "' and demand.br_id ='" . $br_id . "' and demand.de_num ='" . $de_num . "' and demand.de_year ='" . $de_year . "') and de_id != '$de_id'";
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
        $query = "UPDATE demand set de_year='$de_year',de_num='$de_num',de_Jobdetails='$de_Jobdetails',de_Welfare='$de_Welfare',c_id='$c_id',br_id='$br_id' WHERE de_id = '$de_id'";
        mysqli_query($conn, $query);
        echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = '$baseURL/views/com_demand/index.php?c_id=$c_id'
            });
          </script>";
      }
    }
  }
  //
  //**************************************DELETE*********************************************************** */
  if (isset($_POST['btndelect'])) {
    $de_id = $_POST['de_id'];
    $c_id = $_POST['c_id'];
    $query = "SELECT * FROM petition WHERE de_id = '$de_id'";
    $result = mysqli_query($conn, $query);
    $total = mysqli_num_rows($result);
    if ($total != 0) {
      echo "<script>Swal.fire({
        type: 'error',
        title: 'ข้อมูลมีการใช้งานไม่สามารถลบได้!!',
        showConfirmButton: true,
        timer: 3000
        }).then(() => { 
          window.location = '$baseURL/views/com_demand/index.php?c_id=$c_id'
        });
        </script>";
      exit();
    } else {
      $query = "DELETE FROM demand WHERE de_id = '$de_id'";
      mysqli_query($conn, $query);
      echo "<script>Swal.fire({
      type: 'success',
      title: 'ลบข้อมูลเรียบร้อย',
      showConfirmButton: true,
      timer: 2000
      }).then(() => { 
        window.location = '$baseURL/views/com_demand/index.php?c_id=$c_id'
      });
      </script>";
      exit();
    }
  }
  ?>
  <?php include("../../scr.php"); ?>
</body>

</html>