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
  //**************************************INSERT*********************************************************** */
  if (isset($_POST['btneditstusup'])) {
     //ห้ามซ้ำ
    $num = $_POST['num'];
    $br_id = $_POST['br_id'];
    $pe_semester = $_POST['pe_semester'];
    $su_no = $_POST['su_no'];
    $su_problem = $_POST['su_problem'];
    $su_workaround = $_POST['su_workaround'];
    $su_suggestion = $_POST['su_suggestion'];
    $su_score = $_POST['su_score'];
    $t_id = $_POST['t_id'];
    

    if ((empty($su_problem)) || (empty($su_workaround))|| (empty($su_suggestion))|| (empty($su_score))) {
      $msg = "";
      if (!$su_problem) $msg = $msg . " ปัญหาที่พบ";
      if (!$su_workaround) $msg = $msg . " วิธีแก้ปัญหา";
      if (!$su_suggestion) $msg = $msg . " ข้อเสนอแนะ ";
      if (!$su_score) $msg = $msg . " คะแนน";
      echo "<script>Swal.fire({
			type: 'error',
			title: 'กรุณาใส่{$msg}',
			showConfirmButton: true,
			timer: 1500
		  }).then(() => { 
			 window.history.back()
			});
		  </script>";
    }else {
        $query = "UPDATE supervision set su_problem='$su_problem',su_workaround='$su_workaround',su_suggestion='$su_suggestion',su_score='$su_score',t_id='$t_id' WHERE num = '$num' and su_no='$su_no'";
        mysqli_query($conn, $query);
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