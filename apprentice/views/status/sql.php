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
  error_reporting(0);
  //**************************************btnedit*********************************************************** */
  if (isset($_POST['btnedit'])) {
    $pe_id = $_POST['pe_id']; //ห้ามซ้ำ
    $s_id = $_POST['s_id']; //ห้ามซ้ำ
    $c_id = $_POST['c_id']; //ห้ามซ้ำ
    $de_id = $_POST['de_id']; //ห้ามซ้ำ
    $pe_status = $_POST['pe_status'];
    $num = $_POST['num'];
    // $totalsum = $_POST['totalsum'];
    $note = $_POST['note'];
    $pe_semester = $_POST['pe_semester'];
    $id = $_POST['id'];
    $pe_term = $_POST['pe_term'];

    if($pe_status == 3 || $pe_status == 4 || $pe_status == 7 || $pe_status == 10 || $pe_status == 11){
      if ((empty($note))) {
        $msg = "";
        if (!$note) $msg = $msg . "กรุณาระบุหมายเหตุ";
        echo "<script>Swal.fire({
        type: 'error',
        title: '{$msg}',
        showConfirmButton: true,
        timer: 1500
        }).then(() => { 
         window.history.back()
        });
        </script>";
        exit();
      }
    }
    if ($pe_status == 1) {
      $query2 = "UPDATE petition set pe_status='1' WHERE pe_id = '$pe_id'";
      mysqli_query($conn, $query2);
      echo "<script>Swal.fire({
          type: 'success',
          title: 'บันทึกข้อมูลเรียบร้อย',
          showConfirmButton: true,
          timer: 1500
        }).then(() => { 
          window.location = 'indexstatus.php?id=0&year=$pe_semester'
          });
        </script>";
      exit();
    }
    //ข้อมูลไม่ถูกต้อง
    if ($pe_status == 4) {
      $query = "UPDATE petition set pe_status='4',note='$note' WHERE pe_id = '$pe_id'";
      mysqli_query($conn, $query);
      $strTo = $_POST['s_mail']; //ผู้รับ
      $strSubject = "ตรวจสอบความถูกต้องของข้อมูล"; //
      $strHeader = "ตรวจสอบความถูกต้องของข้อมูล";
      $strVar = "My Message";
      $strMessage = $_POST['note'];
      $flgSend = mail($strTo, $strSubject, $strMessage, $strHeader);  // @ = No Show Error //
      echo "<script>Swal.fire({
        type: 'success',
        title: 'บันทึกข้อมูลเรียบร้อย',
        showConfirmButton: true,
        timer: 1500
      }).then(() => { 
        window.location = 'indexstatus.php?id=0&year=$pe_semester'
        });
      </script>";
    }
    if ($pe_status == 2) {
      $query2 = "UPDATE petition set pe_status='2' WHERE pe_id = '$pe_id'";
      mysqli_query($conn, $query2);
      echo "<script>Swal.fire({
          type: 'success',
          title: 'บันทึกข้อมูลเรียบร้อย',
          showConfirmButton: true,
          timer: 1500
        }).then(() => { 
          window.location = 'indexstatus.php?id=1&year=$pe_semester'
          });
        </script>";
      exit();
    }
    if ($pe_status == 5) {
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
        // $query1 = "SELECT COUNT(petition.s_id)as totalsum,petition.pe_term 
        // FROM petition WHERE petition.s_id = '$s_id' 
        // AND (petition.pe_status != 3 AND petition.pe_status != 4 AND petition.pe_status != 7 AND petition.pe_status != 10) GROUP BY petition.pe_id";
        // $result1 = mysqli_query($conn, $query1) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
        // while ($row1 = mysqli_fetch_array($result1)) {
        //   $pe_term = array();
        //   $pe_term[1] = $row1['pe_term'];
        //   $i++;
        // }
        // $totalsum = $i;
        // $pe_term2 = $pe_term[1];
        if ($pe_term == 1 || $pe_term == 3) {
          for ($su_no = 1; $su_no < 4; $su_no++) {
            $query1 = "SELECT supervision.*,petition.pe_id
            FROM petition 
            INNER JOIN supervision ON petition.pe_id  = supervision.pe_id
            WHERE petition.s_id = '$s_id' and supervision.su_no = '$su_no' ";
            $result1 = mysqli_query($conn, $query1) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
            $total = mysqli_num_rows($result1);
            while ($row1 = mysqli_fetch_array($result1)) {
              $su_score1 = $row1['su_score'];
              $num1 = $row1['num'];
            }
            if ($total != 0) {
              if ($su_score1 == "") {
                $query = "UPDATE supervision set su_no='$su_no',pe_id='$pe_id' WHERE num = '$num1'";
                mysqli_query($conn, $query);
                $query2 = "SELECT sup_instructor.* FROM sup_instructor WHERE sup_instructor.s_id = '$s_id'";
                $result2 = mysqli_query($conn, $query2);
                while ($row2 = mysqli_fetch_array($result2)) {
                  $query = "UPDATE sup_instructor set pe_id='$pe_id' WHERE s_id='$s_id' and num='$row2[num]'";
                  mysqli_query($conn, $query);
                }
              }
            } else {
              $query = "INSERT INTO supervision (su_no,su_term,pe_id) VALUES ('$su_no',1,'$pe_id')";
              mysqli_query($conn, $query);
            }
          }
          $query = "UPDATE petition set pe_status='5' WHERE pe_id = '$pe_id'";
          mysqli_query($conn, $query);
          echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = 'indexstatus.php?id=2&year=$pe_semester'
            });
          </script>";
          exit();
        } // window.location = 'indexstatus.php?id=2&year=$pe_semester'
        if ($pe_term == 2) {
          // for ($su_no = 4; $su_no < 7; $su_no++) {
          //   $query = "INSERT INTO supervision (su_no,su_term,pe_id) VALUES ('$su_no',$pe_term,'$pe_id')";
          //   mysqli_query($conn, $query);
          // }
          for ($su_no = 4; $su_no < 7; $su_no++) {
            $query1 = "SELECT supervision.*,petition.pe_id
            FROM petition 
            INNER JOIN supervision ON petition.pe_id  = supervision.pe_id
            WHERE petition.s_id = '$s_id' and supervision.su_no = '$su_no' ";
            $result1 = mysqli_query($conn, $query1) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
            $total = mysqli_num_rows($result1);
            while ($row1 = mysqli_fetch_array($result1)) {
              $su_score1 = $row1['su_score'];
              $num1 = $row1['num'];
            }
            if ($total != 0) {
              if ($su_score1 == "") {
                $query = "UPDATE supervision set su_no='$su_no',pe_id='$pe_id' WHERE num = '$num1'";
                mysqli_query($conn, $query);
                $query2 = "SELECT sup_instructor.* FROM sup_instructor WHERE sup_instructor.s_id = '$s_id'";
                $result2 = mysqli_query($conn, $query2);
                while ($row2 = mysqli_fetch_array($result2)) {
                  $query = "UPDATE sup_instructor set pe_id='$pe_id' WHERE s_id='$s_id' and num='$row2[num]'";
                  mysqli_query($conn, $query);
                }
              }
            } else {
              $query = "INSERT INTO supervision (su_no,su_term,pe_id) VALUES ('$su_no',$pe_term,'$pe_id')";
              mysqli_query($conn, $query);
            }
          }
          $query2 = "UPDATE petition set pe_status='6' WHERE pe_id = '$pe_id'";
          mysqli_query($conn, $query2);
          echo "<script>Swal.fire({
              type: 'success',
              title: 'บันทึกข้อมูลเรียบร้อย',
              showConfirmButton: true,
              timer: 1500
            }).then(() => { 
              window.location = 'indexstatus.php?id=2&year=$pe_semester'
              });
            </script>";
          exit();
        }
      }
    } //
    if ($pe_status == 3) {
      $query = "UPDATE petition set pe_status='3',note='$note' WHERE pe_id = '$pe_id'";
      mysqli_query($conn, $query);
      $strTo = $_POST['s_mail']; //ผู้รับ
      $strSubject = "ตรวจสอบความถูกต้องของข้อมูล"; //
      $strHeader = "ตรวจสอบความถูกต้องของข้อมูล";
      $strVar = "My Message";
      $strMessage = $_POST['note'];
      $flgSend = mail($strTo, $strSubject, $strMessage, $strHeader);  // @ = No Show Error //
      echo "<script>Swal.fire({
        type: 'success',
        title: 'บันทึกข้อมูลเรียบร้อย',
        showConfirmButton: true,
        timer: 1500
      }).then(() => { 
        window.location = 'indexstatus.php?id=1&year=$pe_semester'
        });
      </script>";
      exit();
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
        for ($su_no = 4; $su_no < 7; $su_no++) {
          $query = "INSERT INTO supervision (su_no,su_term,pe_id) VALUES ('$su_no',2,'$pe_id')";
          mysqli_query($conn, $query);
        }
        $query = "SELECT SUM(su_score)as totalscore FROM supervision 
        LEFT JOIN petition ON supervision.pe_id  = petition.pe_id
        WHERE petition.s_id = '$s_id'  and su_no BETWEEN 1 AND 3";
        $result = mysqli_query($conn, $query) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
        $row = mysqli_fetch_array($result);
        $r_esupervision = round(($row['totalscore']) / 7.5);
        $query1 = "INSERT INTO results (r_term,r_esupervision,sum,pe_id ) VALUES ('1','$r_esupervision','$r_esupervision','$pe_id')";
        mysqli_query($conn, $query1);
        $query2 = "UPDATE petition set pe_status='6' WHERE pe_id = '$pe_id'";
        mysqli_query($conn, $query2);
        echo "<script>Swal.fire({
          type: 'success',
          title: 'บันทึกข้อมูลเรียบร้อย',
          showConfirmButton: true,
          timer: 1500
        }).then(() => { 
          window.location = 'indexstatus.php?id=5&year=$pe_semester'
          });
        </script>";
        exit();
      }
    } //
    if ($pe_status == 8) {
      $query = "SELECT SUM(su_score)as totalscore FROM supervision 
      LEFT JOIN petition ON supervision.pe_id  = petition.pe_id
      WHERE petition.s_id = '$s_id'  and su_no BETWEEN 4 AND 6 ";
      $result = mysqli_query($conn, $query) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
      $row = mysqli_fetch_array($result);
      $r_esupervision = round(($row['totalscore']) / 7.5);
      $query1 = "INSERT INTO results (r_term,r_esupervision,sum,pe_id ) VALUES ('2','$r_esupervision','$r_esupervision','$pe_id')";
      mysqli_query($conn, $query1);
      $query2 = "UPDATE petition set pe_status='8' WHERE pe_id = '$pe_id'";
      mysqli_query($conn, $query2);
      echo "<script>Swal.fire({
          type: 'success',
          title: 'บันทึกข้อมูลเรียบร้อย',
          showConfirmButton: true,
          timer: 1500
        }).then(() => { 
          window.location = 'indexstatus.php?id=6&year=$pe_semester'
          });
        </script>";
      exit();
    }
    if ($pe_status == 10) {
      for ($su_no = 4; $su_no < 7; $su_no++) {
        // $query = "DELETE FROM supervision WHERE su_no = '$su_no' and pe_id = '$pe_id'  ";
        // mysqli_query($conn, $query);
        // $query = "DELETE FROM sup_instructor WHERE pe_id = '$pe_id'  ";
        // mysqli_query($conn, $query);
        $query2 = "UPDATE petition set pe_status='10',note='$note' WHERE pe_id = '$pe_id'";
        mysqli_query($conn, $query2);
      }
      $strTo = $_POST['s_mail']; //ผู้รับ
      $strSubject = "ตรวจสอบความถูกต้องของข้อมูล"; //
      $strHeader = "ตรวจสอบความถูกต้องของข้อมูล";
      $strVar = "My Message";
      $strMessage = $_POST['note'];
      $flgSend = mail($strTo, $strSubject, $strMessage, $strHeader);  // @ = No Show Error //
      echo "<script>Swal.fire({
        type: 'success',
        title: 'บันทึกข้อมูลเรียบร้อย',
        showConfirmButton: true,
        timer: 1500
      }).then(() => { 
        window.location = 'indexstatus.php?id=$id&year=$pe_semester'
        });
      </script>";
      exit();
    } //
    if ($pe_status == 7) {

      for ($su_no = 1; $su_no < 4; $su_no++) {
        // $query = "DELETE FROM supervision WHERE su_no = '$su_no' and pe_id = '$pe_id'  ";
        // mysqli_query($conn, $query);
        // $query = "DELETE FROM sup_instructor WHERE pe_id = '$pe_id'  ";
        // mysqli_query($conn, $query);
        $query2 = "UPDATE petition set pe_status='7',note='$note' WHERE pe_id = '$pe_id'";
        mysqli_query($conn, $query2);
      }
      $strTo = $_POST['s_mail']; //ผู้รับ
      $strSubject = "ตรวจสอบความถูกต้องของข้อมูล"; //
      $strHeader = "ตรวจสอบความถูกต้องของข้อมูล";
      $strVar = "My Message";
      $strMessage = $_POST['note'];
      $flgSend = mail($strTo, $strSubject, $strMessage, $strHeader);  // @ = No Show Error //
      echo "<script>Swal.fire({
        type: 'success',
        title: 'บันทึกข้อมูลเรียบร้อย',
        showConfirmButton: true,
        timer: 1500
      }).then(() => { 
        window.location = 'indexstatus.php?id=$id&year=$pe_semester'
        });
      </script>";
      exit();
    } //
    if ($pe_status == 11) {
      $query1 = "SELECT max(supervision.su_term) AS status FROM petition 
      INNER JOIN supervision ON petition.pe_id  = supervision.pe_id
      WHERE petition.s_id = '$s_id' and supervision.su_term = 2";
      $result1 = mysqli_query($conn, $query1) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
      $total = mysqli_num_rows($result1);
      while ($row1 = mysqli_fetch_array($result1)) {
        $status = $row1['status'];
      }
      //เทอม1
      if ($status != '2') {
        for ($su_no = 1; $su_no < 4; $su_no++) {
          $query1 = "SELECT supervision.*,petition.pe_id
          FROM petition 
          INNER JOIN supervision ON petition.pe_id  = supervision.pe_id
          WHERE petition.s_id = '$s_id' and supervision.su_no = '$su_no' ";
          $result1 = mysqli_query($conn, $query1) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
          $total = mysqli_num_rows($result1);
          while ($row1 = mysqli_fetch_array($result1)) {
            $num1 = $row1['num'];
          }
          if ($total != 0) {
            $query = "DELETE FROM supervision WHERE num = '$num1'";
            mysqli_query($conn, $query);
            // $query = "DELETE FROM sup_instructor WHERE pe_id = '$pe_id'  ";
            // mysqli_query($conn, $query);
          }
        }
        $query = "UPDATE petition set pe_status='11',note='$note' WHERE pe_id = '$pe_id'";
        mysqli_query($conn, $query);
      }
      //เทอม2
      else {
        for ($su_no = 4; $su_no < 7; $su_no++) {
          $query1 = "SELECT supervision.*,petition.pe_id
          FROM petition 
          INNER JOIN supervision ON petition.pe_id  = supervision.pe_id
          WHERE petition.s_id = '$s_id' and supervision.su_no = '$su_no' ";
          $result1 = mysqli_query($conn, $query1) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
          $total = mysqli_num_rows($result1);
          while ($row1 = mysqli_fetch_array($result1)) {
            $num1 = $row1['num'];
          }
          if ($total != 0) {
            $query = "DELETE FROM supervision WHERE num = '$num1'";
            mysqli_query($conn, $query);
            // $query = "DELETE FROM sup_instructor WHERE pe_id = '$pe_id'  ";
            // mysqli_query($conn, $query);
          }
        }
        $query = "UPDATE petition set pe_status='11',note='$note' WHERE pe_id = '$pe_id'";
        mysqli_query($conn, $query);
      }
      $strTo = $_POST['s_mail']; //ผู้รับ
      $strSubject = "ตรวจสอบความถูกต้องของข้อมูล"; //
      $strHeader = "ตรวจสอบความถูกต้องของข้อมูล";
      $strVar = "My Message";
      $strMessage = $_POST['note'];
      $flgSend = mail($strTo, $strSubject, $strMessage, $strHeader);  // @ = No Show Error //
      echo "<script>Swal.fire({
        type: 'success',
        title: 'บันทึกข้อมูลเรียบร้อย',
        showConfirmButton: true,
        timer: 1500
      }).then(() => { 
        window.location = 'indexstatus.php?id=$id&year=$pe_semester'
        });
      </script>";
      exit();
    } //
    echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = 'indexstatus.php?id=$id&year=$pe_semester'
            });
          </script>";
  }

  //window.location = 'indexstatus.php?id=0&year=$pe_semester'
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