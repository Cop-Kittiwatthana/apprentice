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
    $province_id = $_POST['province_id'];
    $amphures_name_th = $_POST['amphures_name_th'];

    if ((empty($amphures_name_th))) {
      $msg = "";
      if (!$amphures_name_th) $msg = $msg . " อำเภอ";
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
    if ((empty($province_id))) {
      $msg = "";
      if (!$province_id) $msg = $msg . " จังหวัด";
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
      $query = "SELECT amphures.*, provinces.* FROM amphures
                INNER JOIN provinces ON amphures.province_id = provinces.province_id
                WHERE (amphures.amphures_name_th='" . $amphures_name_th . "') 
                and (amphures.province_id='" . $province_id . "')";
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

        $query = "INSERT INTO amphures (amphures_name_th,province_id) VALUES ('$amphures_name_th','$province_id')";
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
    $province_id = $_POST['province_id'];
    $amphure_id = $_POST['amphure_id'];
    $amphures_name_th = $_POST['amphures_name_th'];

    if ((empty($amphures_name_th))) {
      $msg = "";
      if (!$amphures_name_th) $msg = $msg . " อำเภอ";
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
    if ((empty($province_id))) {
      $msg = "";
      if (!$province_id) $msg = $msg . " จังหวัด";
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
      $query = "SELECT amphures.*, provinces.* FROM amphures
                INNER JOIN provinces ON amphures.province_id = provinces.province_id
                WHERE (amphures.amphures_name_th='" . $amphures_name_th . "') 
                and (amphures.province_id='" . $province_id . "') and amphures.amphure_id != $amphure_id ";
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
        $query = "UPDATE amphures SET amphures_name_th ='$amphures_name_th',province_id ='$province_id' WHERE amphure_id = '$amphure_id'";
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
    $amphure_id = $_POST['amphure_id'];
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
      $query = "DELETE FROM amphures WHERE amphure_id = '$amphure_id'";
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