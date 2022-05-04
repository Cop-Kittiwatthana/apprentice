<?php

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Untitled Document</title>
  <?php include("../../head.php") ?>
</head>

<body>
  <?php
  error_reporting(0);
  include("../../connect.php");
  //**************************************INSERT*********************************************************** */
  if (isset($_POST['btnsave'])) {
    $n_na = $_POST['n_na']; //ห้ามซ้ำ
    $n_detail = $_POST['n_detail'];
    $n_date = $_POST['n_date'];
    $n_enddate = $_POST['n_enddate'];
    $img = $_POST['img'];
    $file = $_POST['file'];
    $token = $_POST['token'];
    $t_id  = $_POST['t_id'];

    $fileupload = $_FILES['img']['tmp_name'];
    $fileupload_name = uniqid() . '_' . $_FILES['img']['name'];

    $fileupload1 = $_FILES['file']['tmp_name'];
    $fileupload_name1 = uniqid() . '_' . $_FILES['file']['name'];

    if ((empty($n_na)) && (empty($n_detail)) || ($fileupload == "")) {
      $msg = "";
      if (!$n_na) $msg = $msg . " หัวข้อข่าว";
      if (!$n_detail) $msg = $msg . " รายละเอียด";
      if (!$fileupload) $msg = $msg . " รูป";
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
      $query = "SELECT  news.* FROM news WHERE (news.n_na ='" . $n_na . "' and news.n_detail ='" . $n_detail . "' ) and n_id != '$n_id'";
      $result = mysqli_query($conn, $query);
      $total = mysqli_num_rows($result);
      if ($total != 0) {
        echo "<script>Swal.fire({
          type: 'error',
          title: 'มีข้อมูลนี้แล้ว',
          showConfirmButton: true,
          timer: 1500
          }).then(() => { 
           window.history.back()
          });
          </script>";
      } else {
        //เซ็ครูปภาพ
        if ($fileupload != "" && $fileupload1 != "") {
          copy($fileupload, "../../picture/" . $fileupload_name);
          copy($fileupload1, "../../files/" . $fileupload_name1);
          $query = "INSERT INTO news(n_na,n_detail,n_date,n_enddate,n_pic,n_file,t_id)VALUES ('$n_na','$n_detail','$n_date','$n_enddate','$fileupload_name','$fileupload_name1','$t_id')";
        }
        if ($fileupload == "" && $fileupload1 == "") {
          $query = "INSERT INTO news(n_na,n_detail,n_date,n_enddate,t_id)VALUES ('$n_na','$n_detail','$n_date','$n_enddate','$t_id')";
        }
        if (($fileupload == "" && $fileupload1 != "") || ($fileupload != "" && $fileupload1 == "")) {
          if ($fileupload1 == "") {
            copy($fileupload, "../../picture/" . $fileupload_name);
            $query = "INSERT INTO news(n_na,n_detail,n_date,n_enddate,n_pic,t_id)VALUES ('$n_na','$n_detail','$n_date','$n_enddate','$fileupload_name','$t_id')";
          }
          if ($fileupload == "") {
            copy($fileupload1, "../../files/" . $fileupload_name1);
            $query = "INSERT INTO news(n_na,n_detail,n_date,n_enddate,n_file,t_id)VALUES ('$n_na','$n_detail','$n_date','$n_enddate','$fileupload_name1','$t_id')";
          }
        } //else เงื่อนไขเพิ่มข้อมูลแแบบ--ไม่มีรูปภาพ
        //$query = "INSERT INTO provinces (provinces_name_th,geo_id) VALUES ('$provinces_name_th','$geo_id')";
        mysqli_query($conn, $query);
        $n_id = mysqli_insert_id($conn);
        echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = 'index.php'
            });
          </script>";
        // *****************************************
        if ($_POST['token'] == "") {
        } else {
          $header = "แจ้งเตือนข่าวสาร";
          $nost = "กรุณาตรวจสอบข้อมูลนักศึกษา ";
          $link = "$baseURL/indexviewdetailnew.php?id=$n_id";
          $message = $header .
            "\n" . 'หัวข้อข่าว: ' . $n_na .
            "\n" . 'วันที่: ' . $n_date .
            "\n" . 'ลิงค์: ' . $link . "\n";

          ///ส่วนที่ 2 line แจ้งเตือน  ส่วนนี้จะทำการเรียกใช้ function sendlinemesg() เพื่อทำการส่งข้อมูลไปที่ line
          sendlinemesg();
          header('Content-Type: text/html; charset=utf8');
          $res = notify_message($message);
          ///ส่วนที่ 3 line แจ้งเตือน
        }
      }
    }
  }
  //window.location = 'index.php'
  //**************************************UPDATE*********************************************************** */
  if (isset($_POST['btnedit'])) {
    $n_id = $_POST['n_id']; //ห้ามซ้ำ
    $n_na = $_POST['n_na']; //ห้ามซ้ำ
    $n_detail = $_POST['n_detail'];
    $n_date = $_POST['n_date'];
    $n_enddate = $_POST['n_enddate'];
    $n_pic = $_POST['n_pic'];
    $n_file = $_POST['n_file'];
    $token = $_POST['token'];
    $t_id  = $_POST['t_id'];

    $fileupload = $_FILES['img']['tmp_name'];
    $pic = $_FILES['img']['tmp_name'];
    $fileupload_name = uniqid() . '_' . $_FILES['img']['name'];

    $fileupload1 = $_FILES['file']['tmp_name'];
    $fileupload_name1 = uniqid() . '_' . $_FILES['file']['name'];

    if ((empty($n_na)) || (empty($n_detail))) {
      $msg = "";
      if (!$n_na) $msg = $msg . " หัวข้อข่าว";
      if (!$n_detail) $msg = $msg . " รายละเอียด";
      if (!$pic) $msg = $msg . " รูป";
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
      $query = "SELECT  news.* FROM news WHERE (news.n_na ='" . $n_na . "' and news.n_detail ='" . $n_detail . "' ) and n_id != '$n_id'";
      $result = mysqli_query($conn, $query);
      $total = mysqli_num_rows($result);
      if ($total != 0) {
        echo "<script>Swal.fire({
          type: 'error',
          title: 'มีข้อมูลนี้แล้ว',
          showConfirmButton: true,
          timer: 1500
          }).then(() => { 
           window.history.back()
          });
          </script>";
      } else {
        //เซ็ครูปภาพ
        if ($fileupload != "") {
          if ($n_pic != "") {
            unlink("../../picture/$n_pic");
          }
          copy($fileupload, "../../picture/" . $fileupload_name);
          $query = "UPDATE news set n_na='$n_na',n_detail='$n_detail',n_date='$n_date',n_enddate='$n_enddate',n_pic='$fileupload_name',t_id='$t_id' WHERE n_id = '$n_id'";
          mysqli_query($conn, $query);
        } else {
          unlink("../../picture/$n_pic");
           $query = "UPDATE news set n_na='$n_na',n_detail='$n_detail',n_date='$n_date',n_enddate='$n_enddate',n_pic='',t_id='$t_id' WHERE n_id = '$n_id'";
          mysqli_query($conn, $query);
        }
        if ($fileupload1 != "") {
          if ($n_file != "") {
            unlink("../../files/$n_file");
          }
          copy($fileupload1, "../../files/" . $fileupload_name1);
          $query = "UPDATE news set n_na='$n_na',n_detail='$n_detail',n_date='$n_date',n_enddate='$n_enddate',n_file='$fileupload_name1',t_id='$t_id' WHERE n_id = '$n_id'";
          mysqli_query($conn, $query);
        } else {
          unlink("../../files/$n_file");
          $query = "UPDATE news set n_na='$n_na',n_detail='$n_detail',n_date='$n_date',n_enddate='$n_enddate',n_file='',t_id='$t_id' WHERE n_id = '$n_id'";
          mysqli_query($conn, $query);
        }
        $query = "UPDATE news set n_na='$n_na',n_detail='$n_detail',n_date='$n_date',n_enddate='$n_enddate',t_id='$t_id' WHERE n_id = '$n_id'";
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
        // ***************************************** 
        if ($_POST['token'] == "") {
        } else {
          $header = "แจ้งเตือนข่าวสาร";
          $link = "$baseURL/indexviewdetailnew.php?id=$n_id";
          $message = $header .
            "\n" . 'หัวข้อข่าว: ' . $n_na .
            "\n" . 'วันที่: ' . $n_date .
            "\n" . 'ลิงค์: ' . $link . "\n";

          ///ส่วนที่ 2 line แจ้งเตือน  ส่วนนี้จะทำการเรียกใช้ function sendlinemesg() เพื่อทำการส่งข้อมูลไปที่ line
          sendlinemesg();
          header('Content-Type: text/html; charset=utf8');
          $res = notify_message($message);
          ///ส่วนที่ 3 line แจ้งเตือน
        }
      }
    }
  }
  //**************************************DELETE*********************************************************** */
  if (isset($_POST['btndelect'])) {
    $n_id = $_POST['n_id'];
    $query = "DELETE FROM news WHERE n_id = '$n_id'";
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
  //**************************************EDITME*********************************************************** */
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