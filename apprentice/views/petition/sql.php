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
  // *-****************************สถานะการลงทะเบียน******************************************
  $s_id = $_POST['s_id'];
  $query = "SELECT student.* FROM student WHERE student.s_id= '$s_id'";
  $result = mysqli_query($conn, $query)
    or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
  while ($row = mysqli_fetch_array($result)) {
    $s_status = "$row[s_status]";
  }
  if ($s_status != '2') {
    // echo "<script> alert('ยังไม่เปิดให้ยื่นคำร้องขอฝึกงาน'); window.history.back()</script>";
    echo "<script> alert('ยังไม่เปิดให้ยื่นคำร้องขอฝึกงาน'); window.location='$baseURL/views/petition/index.php?s_id=$s_id';</script>";
    exit();
  }
  // *-********************************************************************************
  //**************************************INSERT*********************************************************** */
  if (isset($_POST['btnsave'])) {
    $s_id = $_POST['s_id']; //ห้ามซ้ำ
    $br_id = $_POST['br_id'];
    $de_id = $_POST['de_id'];
    $pe_date = $_POST['pe_date'];
    $pe_date1 = $_POST['pe_date1'];
    $pe_date2 = $_POST['pe_date2'];
    $pe_status = $_POST['pe_status'];
    $pe_semester = $_POST['pe_semester'];
    $pe_term = $_POST['pe_term'];


    // if($s_id != ""){
    //   $query = "SELECT petition.* FROM petition WHERE petition.s_id='" . $s_id . "'and (petition.pe_status != '3' and petition.pe_status != '7') and pe_id != '$pe_id'";
    //   $result = mysqli_query($conn, $query);

    // }
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
    }
    if ($s_id != "") {
      $query = "SELECT parent.*,student.* FROM student 
      LEFT JOIN parent on student.s_id = parent.s_id
      WHERE student.s_id = '$s_id'";
      $result = mysqli_query($conn, $query);
      //$total = mysqli_num_rows($result);
      while ($row = mysqli_fetch_array($result)) {
        if (
          $row['s_pass'] == null || $row['s_bdate'] == null || $row['s_age'] == null || $row['s_tel'] == null
          || $row['s_mail'] == null || $row['s_height'] == null || $row['s_weight'] == null || $row['s_race'] == null
          || $row['s_cult'] == null || $row['s_nation'] == null || $row['s_lbood'] == null || $row['s_points'] == null
          || $row['s_No1'] == null || $row['s_village1'] == null || $row['s_road1'] == null || $row['s_No2'] == null
          || $row['s_village2'] == null || $row['s_road2'] == null || $row['s_frina'] == null || $row['s_friadd'] == null
          || $row['s_ftel'] == null || $row['district_id1'] == null || $row['district_id2'] == null || $row['district_id3'] == null
          || $row['br_id'] == null || $row['s_fna'] == null || $row['s_lna'] == null || $row['s_group'] == null
          || $row['pa_fna'] == null || $row['pa_lna'] == null || $row['pa_age'] == null || $row['pa_add'] == null
          || $row['pa_tel'] == null || $row['pa_career'] == null || $row['pa_relations'] == null || $row['pa_status'] == null
          || $row['district_id'] == null || $row['s_id'] == null
        ) {
          $i = 1;
        }
      }
    }
    if ($i == 1) {
      echo "<script>Swal.fire({
          type: 'error',
          title: 'กรุณาตรวสสอบข้อมูลส่วนตัวและข้อมูลผู้ปกครอง',
          showConfirmButton: true,
          timer: 1500
          }).then(() => { 
           window.history.back()
          });
          </script>";
      exit();
    } else {
      //echo $query = "SELECT petition.* FROM petition WHERE (petition.s_id='" . $s_id . "'and petition.de_id='" . $de_id . "'and (petition.pe_status != '3'or petition.pe_status != '7')) and pe_id != '$pe_id'";
      $query = "SELECT petition.* FROM petition 
      WHERE (petition.s_id='$s_id' and petition.de_id='$de_id'
      and (petition.pe_status != '3' and petition.pe_status != '7' and petition.pe_status != '10' and petition.pe_status != '11')) and pe_id != '$pe_id'";
      $result = mysqli_query($conn, $query);
      $total = mysqli_num_rows($result);
      //if ($total != 0 && $pe_status != '7') {
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
        // window.history.back()
      } else {
        $query = "INSERT INTO petition (pe_date,pe_semester,pe_term,pe_date1,pe_date2,pe_status,s_id,de_id) VALUES ('$pe_date','$pe_semester','$pe_term','$pe_date1','$pe_date2','$pe_status','$s_id','$de_id')";
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
        //window.location = '$baseURL/views/petition/index.php?s_id=$s_id'
        // *********************************
        $query1 = "SELECT * FROM student
        WHERE s_id = '$s_id'";
        $result1 = mysqli_query($conn, $query1);
        while ($row = mysqli_fetch_array($result1)) {
          $s_tna = "$row[s_tna]";
          $s_fna = "$row[s_fna]";
          $s_lna = "$row[s_lna]";
        }
        if ($s_tna == '0') {
          $s_tna = "นาย";
        }
        if ($s_tna == '1') {
          $s_tna = "นาง";
        }
        if ($s_tna == '2') {
          $s_tna = "นางสาว";
        }
        $header = 'แจ้งเตือนคำร้องข้อฝึกงาน';
        $id = "$s_id";
        $name = "$s_tna $s_fna $s_lna";
        $nost = "กรุณาตรวจสอบข้อมูลนักศึกษา ";
        $link = "$baseURL/views/status/indexstatus.php";
        $message = $header .
          "\n" . 'รหัสนักศึกษา: ' . $id .
          "\n" . 'ชื่อนักศึกษา: ' . $name .
          "\n" . 'หมายเหตุ: ' . $nost .
          "\n" . $link . "\n";

        ///ส่วนที่ 2 line แจ้งเตือน  ส่วนนี้จะทำการเรียกใช้ function sendlinemesg() เพื่อทำการส่งข้อมูลไปที่ line
        sendlinemesg();
        header('Content-Type: text/html; charset=utf8');
        $res = notify_message($message);
        ///ส่วนที่ 3 line แจ้งเตือน
      }
    }
  }
  //**************************************UPDATE*********************************************************** */
  if (isset($_POST['btnedit'])) {
    $pe_id = $_POST['pe_id']; //ห้ามซ้ำ
    $s_id = $_POST['s_id']; //ห้ามซ้ำ
    $de_id = $_POST['de_id']; //ห้ามซ้ำ
    $pe_date = $_POST['pe_date'];
    $pe_date1 = $_POST['pe_date1'];
    $pe_date2 = $_POST['pe_date2'];
    $pe_status = $_POST['pe_status'];
    $pe_semester = $_POST['pe_semester'];
    //************************************************************************************************ */
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
    }
    if ((empty($s_id))) {
      $query = "SELECT * FROM student 
      LEFT JOIN parent on student.s_id = parent.s_id
      WHERE student.s_id = '$s_id'";
      $result = mysqli_query($conn, $query);
      $total = mysqli_num_rows($result);
      if ($total != 3) {
        echo "<script>Swal.fire({
			type: 'error',
			title: 'กรุณาใส่ตรวสสอบข้อมูลส่วนตัวและข้อมูลผู้ปกครอง',
			showConfirmButton: true,
			timer: 1500
		  }).then(() => { 
			 window.history.back()
			});
		  </script>";
      }
    } else {
      $query = "SELECT petition.* FROM petition 
      WHERE (petition.s_id='$s_id' and petition.de_id='$de_id'
      and (petition.pe_status != '3' and petition.pe_status != '7' and petition.pe_status != '10' and petition.pe_status != '11')) and pe_id != '$pe_id'";
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
        $query = "UPDATE petition set pe_date='$pe_date',pe_semester='$pe_semester',pe_date1='$pe_date1',pe_date2='$pe_date2',pe_status='$pe_status' WHERE pe_id = '$pe_id'";
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
        //  
        // *****************************************
        $query1 = "SELECT * FROM student
        WHERE s_id = '$s_id'";
        $result1 = mysqli_query($conn, $query1);
        while ($row = mysqli_fetch_array($result1)) {
          $s_tna = "$row[s_tna]";
          $s_fna = "$row[s_fna]";
          $s_lna = "$row[s_lna]";
        }
        if ($s_tna == '0') {
          $s_tna = "นาย";
        }
        if ($s_tna == '1') {
          $s_tna = "นาง";
        }
        if ($s_tna == '2') {
          $s_tna = "นางสาว";
        }
        $header = 'แจ้งเตือนการแก้ไขคำร้องข้อฝึกงาน';
        $id = "$s_id";
        $name = "$s_tna $s_fna $s_lna";
        $nost = "กรุณาตรวจสอบข้อมูลนักศึกษา ";
        $link = "$baseURL/views/status/indexstatus.php";
        $message = $header .
          "\n" . 'รหัสนักศึกษา: ' . $id .
          "\n" . 'ชื่อนักศึกษา: ' . $name .
          "\n" . 'หมายเหตุ: ' . $nost .
          "\n" . $link . "\n";

        ///ส่วนที่ 2 line แจ้งเตือน  ส่วนนี้จะทำการเรียกใช้ function sendlinemesg() เพื่อทำการส่งข้อมูลไปที่ line
        sendlinemesg();
        header('Content-Type: text/html; charset=utf8');
        $res = notify_message($message);
        ///ส่วนที่ 3 line แจ้งเตือน
      }
    }
  }
  //**************************************DELETE*********************************************************** */
  if (isset($_POST['btndelect'])) {
    $pe_id = $_POST['pe_id'];
    $s_id = $_POST['s_id'];
    $query = "DELETE FROM petition WHERE pe_id = '$pe_id'";
    mysqli_query($conn, $query);
    echo "<script>Swal.fire({
	type: 'success',
	title: 'ลบข้อมูลเรียบร้อย',
	showConfirmButton: true,
	timer: 1500
  }).then(() => { 
	  window.location = '$baseURL/views/petition/index.php?s_id=$s_id'
	});
  </script>";
  }
  // ****************************************************************************************************/

  function sendlinemesg()
  {
    define('LINE_API', "https://notify-api.line.me/api/notify");
    define('LINE_TOKEN', $_POST['token']); //เปลี่ยนใส่ Token ของเราที่นี่ 

    function notify_message($message)
    {
      $queryData = array('message' => $message);
      $queryData = http_build_query($queryData, '', '&');
      $headerOptions = array(
        'http' => array(
          'method' => 'POST',
          'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
            . "Authorization: Bearer " . LINE_TOKEN . "\r\n"
            . "Content-Length: " . strlen($queryData) . "\r\n",
          'content' => $queryData
        )
      );
      $context = stream_context_create($headerOptions);
      $result = file_get_contents(LINE_API, FALSE, $context);
      $res = json_decode($result);
      return $res;
    }
  }
  ?>
  <?php include("../../scr.php"); ?>
</body>

</html>