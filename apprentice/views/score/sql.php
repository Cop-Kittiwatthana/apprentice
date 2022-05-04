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
    $s_id = $_POST['s_id']; //ห้ามซ้ำ
    $c_id = $_POST['c_id']; //ห้ามซ้ำ
    $pe_date = $_POST['pe_date'];
    $pe_date1 = $_POST['pe_date1'];
    $pe_date2 = $_POST['pe_date2'];
    $pe_status = $_POST['pe_status'];
    $pe_semester = $_POST['pe_semester'];

    if ((empty($pe_date)) || (empty($pe_date1)) || (empty($pe_date2)) || (empty($pe_semester))) {
      $msg = "";
      if (!$pe_date) $msg = $msg . " วันที่ยื่นเรื่อง";
      if (!$pe_date1) $msg = $msg . " วันที่เริ่มฝึก";
      if (!$pe_date2) $msg = $msg . " วันที่สิ้นสุด";
      if (!$pe_semester) $msg = $msg . " ปีการศึกษา";
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
      $query = "SELECT petition.* FROM petition WHERE (petition.s_id='" . $s_id . "'and petition.c_id='" . $c_id . "'and petition.pe_status != '3') and pe_id != '$pe_id'";
      $result = mysqli_query($conn, $query);
      $total = mysqli_num_rows($result);
      if ($total != 0) {
        echo "<script>Swal.fire({
          type: 'error',
          title: 'คุณยื่นคำร้องไปแล้ว',
          showConfirmButton: true,
          timer: 1500
          }).then(() => { 
           window.history.back()
          });
          </script>";
      } else {
        $query = "INSERT INTO petition (pe_date,pe_semester,pe_date1,pe_date2,pe_status,s_id,c_id) VALUES ('$pe_date','$pe_semester','$pe_date1','$pe_date2','$pe_status','$s_id','$c_id')";
        mysqli_query($conn, $query);
        echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = '$baseURL/views/petition/index.php?s_id=$s_id'
            });
          </script>";
      }
    }
  }
  //**************************************INSERT*********************************************************** */
  if (isset($_POST['btnedit'])) {
    $pe_id = $_POST['pe_id']; //ห้ามซ้ำ
    $s_id = $_POST['s_id']; //ห้ามซ้ำ
    $c_id = $_POST['c_id']; //ห้ามซ้ำ
    $pe_status = $_POST['pe_status'];
    $num = $_POST['num'];
    $totalsum = $_POST['totalsum'];

    if ($pe_status == 4) {
      $strTo = $_POST['s_mail']; //ผู้รับ
      $strSubject = "ตรวจสอบความถูกต้องของข้อมูล"; //
      $strHeader = "ตรวจสอบความถูกต้องของข้อมูล";
      $strVar = "My Message";
      $strMessage = $_POST['note'];
      $flgSend = mail($strTo, $strSubject, $strMessage, $strHeader);  // @ = No Show Error //
      if ($flgSend) {
        echo 1;
        echo "<script type='text/javascript'>";
        echo "alert('Success');";
        echo "</script>";
      }
      // } else {
      //   //กำหนดเงื่อนไขว่าถ้าไม่สำเร็จให้ขึ้นข้อความและกลับไปหน้าเพิ่ม		
      //   echo "<script>Swal.fire({
      //     type: 'error',
      //     title: 'เกิดข้อผิดพลาด',
      //     showConfirmButton: true,
      //     timer: 1500
      //     }).then(() => { 
      //      window.history.back()
      //     });
      //     </script>";
      // }
    }
    if ($pe_status == 2) {
      $query = "SELECT * FROM supervision WHERE ( supervision.pe_id='" . $pe_id . "') and num != '$num'";
      $result = mysqli_query($conn, $query);
      $total = mysqli_num_rows($result);
      if ($total != 0) {
        echo "<script>Swal.fire({
          type: 'error',
          title: 'คุณบันทึกสถานะเดิมไปแล้ว',
          showConfirmButton: true,
          timer: 1500
          }).then(() => { 
           window.history.back()
          });
          </script>";
        exit();
      } else {
        if ($totalsum == 1) {
          for ($su_no = 1; $su_no < 4; $su_no++) {
            $query = "INSERT INTO supervision (su_no,su_term,pe_id) VALUES ('$su_no',1,'$pe_id')";
            mysqli_query($conn, $query);
          }
          $query = "UPDATE petition set pe_status='$pe_status' WHERE pe_id = '$pe_id'";
          mysqli_query($conn, $query);
          echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = 'indexstatus.php?id=0'
            });
          </script>";
          exit();
        }
        if ($totalsum == 2) {
          for ($su_no = 1; $su_no < 4; $su_no++) {
            $query = "INSERT INTO supervision (su_no,su_term,pe_id) VALUES ('$su_no',2,'$pe_id')";
            mysqli_query($conn, $query);
          }
          $query2 = "UPDATE petition set pe_status='6' WHERE pe_id = '$pe_id'";
            mysqli_query($conn, $query2);
            echo "<script>Swal.fire({
              type: 'success',
              title: 'บันทึกข้อมูลเรียบร้อย',
              showConfirmButton: true,
              timer: 1500
            }).then(() => { 
              window.location = 'indexstatus.php?id=6'
              });
            </script>";
            exit();
        }
      }
    }
    if ($pe_status == 6) {
      $query = "SELECT * FROM supervision WHERE ( supervision.pe_id='" . $pe_id . "' and su_no != 1 and su_no != 2 and su_no != 3) and num != '$num'";
      $result = mysqli_query($conn, $query);
      $total = mysqli_num_rows($result);
      if ($total != 0) {
        echo "<script>Swal.fire({
           type: 'error',
           title: 'คุณบันทึกสถานะเดิมไปแล้ว',
           showConfirmButton: true,
           timer: 1500
           }).then(() => { 
            window.history.back()
           });
           </script>";
        exit();
      } else {
        for ($su_no = 1; $su_no < 4; $su_no++) {
          $query = "INSERT INTO supervision (su_no,su_term,pe_id) VALUES ('$su_no',2,'$pe_id')";
          mysqli_query($conn, $query);
        }
        $query = "SELECT SUM(su_score)as totalscore FROM supervision WHERE pe_id = $pe_id and su_term = 1";
        $result = mysqli_query($conn, $query) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
        $row = mysqli_fetch_array($result);
        $r_esupervision = (($row['totalscore']) / 7.5);
        $query1 = "INSERT INTO results (r_term,r_esupervision,pe_id ) VALUES ('1','$r_esupervision','$pe_id')";
        mysqli_query($conn, $query1);
        $query2 = "UPDATE petition set pe_status='6' WHERE pe_id = '$pe_id'";
        mysqli_query($conn, $query2);
        echo "<script>Swal.fire({
          type: 'success',
          title: 'บันทึกข้อมูลเรียบร้อย',
          showConfirmButton: true,
          timer: 1500
        }).then(() => { 
          window.location = 'indexstatus.php?id=5'
          });
        </script>";
        exit();
      }
    } //
    if ($pe_status == 7) {
      for ($su_no = 1; $su_no < 4; $su_no++) {
        $query = "DELETE FROM supervision WHERE su_no = '$su_no' and su_term = 2 and pe_id = '$pe_id'  ";
        mysqli_query($conn, $query);
        $query2 = "UPDATE petition set pe_status='7' WHERE pe_id = '$pe_id'";
        mysqli_query($conn, $query2);
        echo "<script>Swal.fire({
          type: 'success',
          title: 'บันทึกข้อมูลเรียบร้อย',
          showConfirmButton: true,
          timer: 1500
        }).then(() => { 
          window.location = 'indexstatus.php?id=6'
          });
        </script>";
        exit();
      }
    }
    if ($pe_status == 8) {
      $query = "SELECT SUM(su_score)as totalscore FROM supervision WHERE pe_id = $pe_id and su_term = 2";
      $result = mysqli_query($conn, $query) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
      $row = mysqli_fetch_array($result);
      $r_esupervision = (($row['totalscore']) / 7.5);
      $query1 = "INSERT INTO results (r_term,r_esupervision,pe_id ) VALUES ('2','$r_esupervision','$pe_id')";
      mysqli_query($conn, $query1);
      $query2 = "UPDATE petition set pe_status='8' WHERE pe_id = '$pe_id'";
      mysqli_query($conn, $query2);
      echo "<script>Swal.fire({
          type: 'success',
          title: 'บันทึกข้อมูลเรียบร้อย',
          showConfirmButton: true,
          timer: 1500
        }).then(() => { 
          window.location = 'indexstatus.php?id=5'
          });
        </script>";
      exit();
    }
    $query = "UPDATE petition set pe_status='$pe_status',note='$strMessage' WHERE pe_id = '$pe_id'";
    mysqli_query($conn, $query);
    echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = 'indexstatus.php?id=0'
            });
          </script>";
  }
  //window.location = 'indexstatus.php'
  //**************************************DELETE*********************************************************** */
  if (isset($_POST['btndelect'])) {
    $pe_id = $_POST['pe_id'];
    $query = "DELETE FROM petition WHERE pe_id = '$pe_id'";
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
</body>

</html>