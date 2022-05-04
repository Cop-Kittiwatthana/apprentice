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
    $dp_na = $_POST['dp_na'];

    if ((empty($dp_na))) {
      $msg = "";
      if (!$dp_na) $msg = $msg . " ชื่อแผนก";
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
      $query = "SELECT * FROM department
                WHERE (dp_na = '$dp_na') 
                and (dp_id != '$dp_id')";
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

        $query = "INSERT INTO department (dp_na) VALUES ('$dp_na')";
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
    $dp_id = $_POST['dp_id'];
    $dp_na = $_POST['dp_na'];

    if ((empty($dp_na))) {
      $msg = "";
      if (!$dp_na) $msg = $msg . " ชื่อแผนก";
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
      $query = "SELECT * FROM department
      WHERE (dp_na = '$dp_na') 
      and (dp_id != '$dp_id')";
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
        $query = "UPDATE department SET dp_na ='$dp_na' WHERE dp_id = '$dp_id'";
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
    $dp_id = $_POST['dp_id'];
    $query = "SELECT * FROM branch WHERE dp_id != '$dp_id'";
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
    }
    $query = "SELECT * FROM teacher WHERE dp_id != '$dp_id'";
    $result = mysqli_query($conn, $query);
    $total = mysqli_num_rows($result);
    if ($total != 0) {
      echo "<script>Swal.fire({
        type: 'error',
        title: 'มีการใช้ข้อมูลนี้อยู๋จึงไม่สามารถลบได้ !!',
        showConfirmButton: true,
        timer: 2000
        }).then(() => { 
          window.location = 'index.php'
        });
        </script>";
        exit();
    }
    else{
      $query = "DELETE FROM department WHERE dp_id = '$dp_id'";
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