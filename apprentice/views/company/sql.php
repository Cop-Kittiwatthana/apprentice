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
    //$c_id = $_POST['c_id']; //ห้ามซ้ำ
    $c_na = $_POST['c_na'];
    $c_hnum = $_POST['c_hnum'];
    $c_village = $_POST['c_village'];
    $c_road = $_POST['c_road'];
    $c_user = $_POST['c_user'];
    $c_pass = $_POST['c_pass'];
    $c_status = $_POST['c_status'];
    $districts = $_POST['districts'] ? intval($_POST['districts']) : '0';
    $amphures = $_POST['amphures'] ? intval($_POST['amphures']) : '0';
    $provinces = $_POST['provinces'] ? intval($_POST['provinces']) : '0';

    if ((empty($c_na)) || (empty($c_hnum)) || (empty($c_village)) || (empty($c_road)) || (empty($c_user)) || (empty($c_pass))) {
      $msg = "";
      if (!$c_na) $msg = $msg . " ชื่อ";
      if (!$c_hnum) $msg = $msg . " เลขที่บ้าน";
      if (!$c_village) $msg = $msg . " หมู่";
      if (!$c_road) $msg = $msg . " ถนน";
      if (!$c_user) $msg = $msg . " Username";
      if (!$c_pass) $msg = $msg . " Password";
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
    if ((empty($districts))) {
      $msg = "";
      if (!$provinces) $msg = $msg . " จังหวัด";
      if (!$amphures) $msg = $msg . " อำเภอ";
      if (!$districts) $msg = $msg . " ตำบล";
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
      $query = "SELECT  company.* FROM company WHERE (company.c_na='" . $c_na . "' or company.c_user='" . $c_user . "') and company.c_id != '$c_id'";
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
        $query = "INSERT INTO company (c_na,c_hnum,c_village,c_road,c_user,c_pass,c_status,district_id) VALUES ('$c_na','$c_hnum','$c_village','$c_road','$c_user','$c_pass','$c_status','$districts')";
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
  //
  //**************************************UPDATE*********************************************************** */
  if (isset($_POST['btnedit'])) {
    $c_id = $_POST['c_id']; //ห้ามซ้ำ
    $c_na = $_POST['c_na'];
    $c_hnum = $_POST['c_hnum'];
    $c_village = $_POST['c_village'];
    $c_road = $_POST['c_road'];
    $c_user = $_POST['c_user'];
    $c_pass = $_POST['c_pass'];
    $c_status = $_POST['c_status'];
    $districts = $_POST['districts'] ? intval($_POST['districts']) : '0';
    $amphures = $_POST['amphures'] ? intval($_POST['amphures']) : '0';
    $provinces = $_POST['provinces'] ? intval($_POST['provinces']) : '0';

    if ((empty($c_na)) || (empty($c_hnum)) || (empty($c_village)) || (empty($c_road)) || (empty($c_user)) || (empty($c_pass))) {
      $msg = "";
      if (!$c_na) $msg = $msg . " ชื่อ";
      if (!$c_hnum) $msg = $msg . " เลขที่บ้าน";
      if (!$c_village) $msg = $msg . " หมู่";
      if (!$c_road) $msg = $msg . " ถนน";
      if (!$c_user) $msg = $msg . " Username";
      if (!$c_pass) $msg = $msg . " Password";
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
    if ((empty($districts))) {
      $msg = "";
      if (!$provinces) $msg = $msg . " จังหวัด";
      if (!$amphures) $msg = $msg . " อำเภอ";
      if (!$districts) $msg = $msg . " ตำบล";
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
      $query = "SELECT  company.* FROM company WHERE (company.c_na='" . $c_na . "' or company.c_user='" . $c_user . "') and c_id != '$c_id'";
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
        $query = "UPDATE company SET c_na ='$c_na',c_hnum ='$c_hnum',c_village ='$c_village',c_road ='$c_road',c_user ='$c_user',c_pass ='$c_pass',c_status ='$c_status',district_id ='$districts' WHERE c_id = '$c_id'";
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
  //window.location = 'index.php'
  //**************************************DELETE*********************************************************** */
  if (isset($_POST['btndelect'])) {
    $c_id = $_POST['c_id'];
    $query = "DELETE FROM company WHERE c_id = '$c_id'";
    mysqli_query($conn, $query);
    $query = "DELETE FROM contact_staff WHERE c_id = '$c_id'";
    mysqli_query($conn, $query);
    $query = "DELETE FROM demand WHERE c_id = '$c_id'";
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
  //**************************************UPDATEME*********************************************************** */
  if (isset($_POST['btneditme'])) {
    $c_id = $_POST['c_id'];
    $c_na = $_POST['c_na'];
    $c_hnum = $_POST['c_hnum'];
    $c_village = $_POST['c_village'];
    $c_road = $_POST['c_road'];
    $c_user = $_POST['c_user'];
    $c_pass = $_POST['c_pass'];
    //$c_status = $_POST['c_status'];
    $districts = $_POST['districts'] ? intval($_POST['districts']) : '0';

    if ((empty($c_na)) || (empty($c_hnum)) || (empty($c_village)) || (empty($c_road)) ||  (empty($c_pass))) {
      $msg = "";
      if (!$c_na) $msg = $msg . " ชื่อ";
      if (!$c_hnum) $msg = $msg . " เลขที่บ้าน";
      if (!$c_village) $msg = $msg . " หมู่";
      if (!$c_road) $msg = $msg . " ถนน";
      if (!$c_pass) $msg = $msg . " Password";
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
    if ((empty($districts))) {
      $msg = "";
      if (!$provinces) $msg = $msg . " จังหวัด";
      if (!$amphures) $msg = $msg . " อำเภอ";
      if (!$districts) $msg = $msg . " ตำบล";
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
      $query = "SELECT  company.* FROM company WHERE (company.c_na='" . $c_na . "' or company.c_user='" . $c_user . "') and c_id != '$c_id'";
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
        $query = "SELECT  company.c_pass FROM company WHERE c_id = '$c_id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        if ($row['c_pass'] != $c_pass) {
          $query = "UPDATE company SET c_na ='$c_na',c_hnum ='$c_hnum',c_village ='$c_village',c_road ='$c_road',c_pass ='$c_pass',district_id ='$districts' WHERE c_id = '$c_id'";
          mysqli_query($conn, $query);
          echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = '$baseURL/logoutcony.php'
            });
          </script>";
        } else {
          $query = "UPDATE company SET c_na ='$c_na',c_hnum ='$c_hnum',c_village ='$c_village',c_road ='$c_road',district_id ='$districts' WHERE c_id = '$c_id'";
          mysqli_query($conn, $query);
          echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = '$baseURL/views/company/editme.php?c_id=$c_id'
            });
          </script>";
        }
      }
    }
  }
  //window.location = 'index.php'
  ?>
  <?php include("../../scr.php"); ?>
</body>

</html>