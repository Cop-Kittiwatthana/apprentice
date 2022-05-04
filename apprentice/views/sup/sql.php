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
    $t_id = $_POST['t_id'];
    $t_id1 = $t_id[0];
    $t_id2 = $t_id[1];
    $s_id = $_POST['s_id'];
    $br_id = $_POST['br_id'];
    $pe_semester = $_POST['pe_semester'];

    if ((empty($t_id))) {
      $msg = "";
      if (!$t_id) $msg = $msg . " อาจารย์";
      echo "<script>Swal.fire({
    type: 'error',
    title: 'กรุณาเลือก{$msg}',
    showConfirmButton: true,
    timer: 2000
    }).then(() => { 
      window.history.back()
    });
    </script>";
    }
    if ($s_id == "0") {
      $msg = "";
      if (!$s_id) $msg = $msg . "นักศึกษา";
      echo "<script>Swal.fire({
    type: 'error',
    title: 'ไม่มีข้อมูล{$msg}<br>ที่ต้องเพิ่มอาจารย์นิเทศ',
    showConfirmButton: true,
    timer: 2000
    }).then(() => { 
      window.history.back()
    });
    </script>";
      exit();
    }
    if ($t_id1 == "") {
      echo "<script>Swal.fire({
        type: 'error',
        title: 'กรุณาเลือกอาจารย์นิเทศ<br>อย่างน้อย 1 คน',
        showConfirmButton: true,
        timer: 1500
        }).then(() => { 
          window.history.back()
        });
        </script>";
    } else {
      foreach ($s_id as $s) {
        $query = "DELETE FROM sup_instructor WHERE s_id = '$s' ";
        mysqli_query($conn, $query);
      }
      foreach ($t_id as $t) {
        foreach ($s_id as $s) {
          $sql = "SELECT petition.pe_id
            FROM petition  
            where petition.s_id = '$s' ORDER BY petition.pe_id DESC";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_array($result);
          $query1 = "INSERT INTO sup_instructor (t_id,s_id,pe_id) VALUES ('$t','$s','$row[pe_id]')";
          mysqli_query($conn, $query1);
        }
      }
      echo "<script>Swal.fire({
      type: 'success',
      title: 'บันทึกข้อมูลเรียบร้อย',
      showConfirmButton: true,
      timer: 1500
    }).then(() => { 
      window.location = 'indexstd.php?id=$br_id&year=$pe_semester'
      });
    </script>";
    }
  }
  //window.location = 'indexstd.php?id=$br_id&year=$pe_semester'
  //**************************************EDITALL*********************************************************** */
  if (isset($_POST['btneditall'])) {
    $t_id = $_POST['t_id'];
    $t_id1 = $t_id[0];
    $t_id2 = $t_id[1];
    $s_id = $_POST['student'];
    $br_id = $_POST['br_id'];
    $pe_semester = $_POST['pe_semester'];

    if ((empty($t_id))) {
      $msg = "";
      if (!$t_id) $msg = $msg . " อาจารย์";
      echo "<script>Swal.fire({
			type: 'error',
			title: 'กรุณาเลือก{$msg}',
			showConfirmButton: true,
			timer: 1500
		  }).then(() => { 
        window.history.back()
			});
		  </script>";
    }
    if ($t_id1 == "") {
      echo "<script>Swal.fire({
          type: 'error',
          title: 'กรุณาเลือกอาจารย์นิเทศ<br>อย่างน้อย 1 คน',
          showConfirmButton: true,
          timer: 1500
          }).then(() => { 
            window.history.back()
          });
          </script>";
    } else {
      foreach ($s_id as $s) {
        $query = "DELETE FROM sup_instructor WHERE s_id = '$s' ";
        mysqli_query($conn, $query);
      }
      foreach ($t_id as $t) {
        foreach ($s_id as $s) {
          $sql = "SELECT petition.pe_id
          FROM petition  
          where petition.s_id = '$s' ORDER BY petition.pe_id DESC";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_array($result);
          $query1 = "INSERT INTO sup_instructor (t_id,s_id,pe_id) VALUES ('$t','$s','$row[pe_id]')";
          mysqli_query($conn, $query1);
        }
      }
      echo "<script>Swal.fire({
        type: 'success',
        title: 'บันทึกข้อมูลเรียบร้อย',
        showConfirmButton: true,
        timer: 1500
      }).then(() => { 
        window.location = 'indexstd.php?id=$br_id&year=$pe_semester'
        });
      </script>";
    }
  }
  // window.location = 'indexstd.php?id=1&year=2564'
  //**************************************EDIT*********************************************************** */
  if (isset($_POST['btnedit'])) {
    $t_id = $_POST['t_id'];
    $t_id1 = $t_id[0];
    $t_id2 = $t_id[1];
    $s_id = $_POST['s_id'];
    $br_id = $_POST['br_id'];
    $pe_semester = $_POST['pe_semester'];

    if ((empty($t_id))) {
      $msg = "";
      if (!$t_id) $msg = $msg . " อาจารย์";
      echo "<script>Swal.fire({
			type: 'error',
			title: 'กรุณาเลือก{$msg}',
			showConfirmButton: true,
			timer: 1500
		  }).then(() => { 
        window.history.back()
			});
		  </script>";
    }
    if ($t_id1 == "") {
      echo "<script>Swal.fire({
          type: 'error',
          title: 'กรุณาเลือกอาจารย์นิเทศ<br>อย่างน้อย 1 คน',
          showConfirmButton: true,
          timer: 1500
          }).then(() => { 
            window.history.back()
          });
          </script>";
    } else {
      $query = "DELETE FROM sup_instructor WHERE s_id = '$s_id' ";
      mysqli_query($conn, $query);
      foreach ($t_id as $t) {
        $sql = "SELECT petition.pe_id
        FROM petition  
        where petition.s_id = '$s_id' ORDER BY petition.pe_id DESC";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $query1 = "INSERT INTO sup_instructor (t_id,s_id,pe_id) VALUES ('$t','$s_id','$row[pe_id]')";
        mysqli_query($conn, $query1);
      }
      echo "<script>Swal.fire({
        type: 'success',
        title: 'บันทึกข้อมูลเรียบร้อย',
        showConfirmButton: true,
        timer: 1500
      }).then(() => { 
        window.location = 'indexstd.php?id=$br_id&year=$pe_semester'
        });
      </script>";
    }
  }
  //
  ?>
  <?php include("../../scr.php"); ?>
</body>

</html>