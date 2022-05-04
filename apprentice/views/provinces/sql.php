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
    $geo_id = $_POST['geo_id'];
    $provinces_name_th = $_POST['provinces_name_th'];

    if ((empty($provinces_name_th))) {
      $msg = "";
      if (!$provinces_name_th) $msg = $msg . " จังหวัด";
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
    if ((empty($geo_id))) {
      $msg = "";
      if (!$geo_id) $msg = $msg . " ภาค";
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
      $query = "SELECT provinces.* FROM provinces
                WHERE (provinces.provinces_name_th='" . $provinces_name_th . "') 
                and (provinces.geo_id='" . $geo_id . "')";
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
        $query = "INSERT INTO provinces (provinces_name_th,geo_id) VALUES ('$provinces_name_th','$geo_id')";
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
    $geo_id = $_POST['geo_id'];
    $provinces_name_th = $_POST['provinces_name_th'];

    if ((empty($provinces_name_th))) {
      $msg = "";
      if (!$provinces_name_th) $msg = $msg . " จังหวัด";
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
    if ((empty($geo_id))) {
      $msg = "";
      if (!$geo_id) $msg = $msg . " ภาค";
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
      $query = "SELECT provinces.* FROM provinces
                WHERE (provinces.provinces_name_th='" . $provinces_name_th . "') 
                      and (provinces.geo_id='" . $geo_id . "') and provinces.province_id != $province_id ";
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
        $query = "UPDATE provinces SET provinces_name_th ='$provinces_name_th',geo_id ='$geo_id' WHERE province_id = '$province_id'";
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
    $province_id = $_POST['province_id'];
    $query = "SELECT * FROM amphures WHERE province_id != '$province_id'";
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
      $query = "DELETE FROM provinces WHERE province_id = '$province_id'";
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
  <?php include("../../scr.php"); ?>
</body>

</html>