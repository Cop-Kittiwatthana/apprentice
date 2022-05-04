<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Untitled Document</title>
  <?php include("../../head.php"); ?>
</head>

<body>
  <?php
  include("../../connect.php");
  //**************************************INSERT*********************************************************** */
  if (isset($_POST['btnsave'])) {
    $district_id = $_POST['district_id'];
    $province_id = $_POST['provinces'];
    $amphure_id = $_POST['amphures'];
    $district_name_th = $_POST['district_name_th'];
    $zip_code = $_POST['zip_code'];

    if ((empty($district_name_th)) || (empty($zip_code))) {
      $msg = "";
      if (!$district_name_th) $msg = $msg . " ตำบล";
      if (!$zip_code) $msg = $msg . " รหัสไปรษณีย์";
      echo "<script>Swal.fire({
			type: 'error',
			title: 'กรุณากรอก{$msg}',
			showConfirmButton: true,
			timer: 1500
		  }).then(() => { 
			 window.history.back()
			});
		  </script>";
    }
    if ((empty($amphure_id)) || (empty($province_id))) {
      $msg = "";
      if (!$province_id) $msg = $msg . " จังหวัด";
      if (!$amphure_id) $msg = $msg . " อำเภอ";
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
      $query = "SELECT districts.*, amphures.*, provinces.* FROM districts
                INNER JOIN amphures ON districts.amphure_id = amphures.amphure_id
                INNER JOIN provinces ON amphures.province_id = provinces.province_id
                WHERE (districts.district_name_th='" . $district_name_th . "') 
                      and (districts.zip_code='" . $zip_code . "') and (districts.amphure_id='" . $amphure_id . "') 
                      and (amphures.province_id='" . $province_id . "') ";
      //echo $amphure_id, '/', $province_id, '/', $district_name_th, '/', $zip_code, '/', $district_id;
      $result = mysqli_query($conn, $query);
      $total = mysqli_num_rows($result);
      if ($total != 0) {
        echo "<script>Swal.fire({
          type: 'error',
          title: 'ข้อมูลนี้มีอยู่แล้ว',
          showConfirmButton: true,
          timer: 1500
          }).then(() => { 
           window.history.back(-1)
          });
          </script>";
      } else {

        $query = "INSERT INTO districts (zip_code,district_name_th,amphure_id) VALUES ('$zip_code','$district_name_th','$amphure_id')";
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
    $district_id = $_POST['district_id'];
    $province_id = $_POST['provinces'];
    $amphure_id = $_POST['amphures'];
    $district_name_th = $_POST['district_name_th'];
    $zip_code = $_POST['zip_code'];

    if ((empty($district_name_th)) || (empty($zip_code))) {
      $msg = "";
      if (!$district_name_th) $msg = $msg . " ตำบล";
      if (!$zip_code) $msg = $msg . " รหัสไปรษณีย์";
      echo "<script>
    Swal.fire({
      type: 'error',
      title: 'กรุณากรอก{$msg}',
      showConfirmButton: true,
      timer: 1500
    }).then(() => {
      window.history.back()
    });
  </script>";
    }
    if ((empty($amphure_id)) || (empty($province_id))) {
      $msg = "";
      if (!$province_id) $msg = $msg . " จังหวัด";
      if (!$amphure_id) $msg = $msg . " อำเภอ";
      echo "<script>
    Swal.fire({
      type: 'error',
      title: 'กรุณาเลือก{$msg}',
      showConfirmButton: true,
      timer: 1500
    }).then(() => {
      window.history.back()
    });
  </script>";
    } else {
      //echo $amphure_id,'/',$province_id,'/',$district_name_th,'/',$zip_code,'/',$district_id;
      $query = "UPDATE districts SET amphure_id ='$amphure_id',district_name_th ='$district_name_th',zip_code ='$zip_code' WHERE district_id = '$district_id'";
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
  //**************************************DELETE*********************************************************** */
  if (isset($_POST['btndelect'])) {
    $district_id = $_POST['district_id'];
    $query = "DELETE FROM districts WHERE district_id = '$district_id'";
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

  if (isset($_POST['btndelect'])) {
    $district_id = $_POST['district_id'];
    $query = "SELECT * FROM districts WHERE amphure_id != '$amphure_id'";
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
      $query = "DELETE FROM districts WHERE district_id = '$district_id'";
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
  }
  ?>
</body>

</html>