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
  if (isset($_POST['editparent'])) {
    $s_id = $_POST['s_id'];
    $pa_id  = $_POST['pa_id ']; //ห้ามซ้ำ
    $pa_tna = $_POST['pa_tna'];
    $pa_fna = $_POST['pa_fna'];
    $pa_lna = $_POST['pa_lna'];
    $pa_age = $_POST['pa_age'];
    $pa_add = $_POST['pa_add'];
    $pa_tel = $_POST['pa_tel'];
    $pa_career = $_POST['pa_career'];
    $pa_status = $_POST['pa_status'];
    $district_id = $_POST['districts'];
    ////////////////////////////////////
    $pa_tna2 = $_POST['pa_tna2'];
    $pa_fna2 = $_POST['pa_fna2'];
    $pa_lna2 = $_POST['pa_lna2'];
    $pa_age2 = $_POST['pa_age2'];
    $pa_add2 = $_POST['pa_add2'];
    $pa_tel2 = $_POST['pa_tel2'];
    $pa_career2 = $_POST['pa_career2'];
    $pa_status2 = $_POST['pa_status2'];
    $district_id2 = $_POST['districts2'];
    ////////////////////////////////////
    $pa_tna3 = $_POST['pa_tna3'];
    $pa_fna3 = $_POST['pa_fna3'];
    $pa_lna3 = $_POST['pa_lna3'];
    $pa_age3 = $_POST['pa_age3'];
    $pa_add3 = $_POST['pa_add3'];
    $pa_tel3 = $_POST['pa_tel3'];
    $pa_relations3 = $_POST['pa_relations3'];
    $pa_career3 = $_POST['pa_career3'];
    $pa_status3 = $_POST['pa_status3'];
    $district_id3 = $_POST['districts3'];


    // if ((empty($pa_fna)) || (empty($pa_lna)) || (empty($pa_age)) || (empty($pa_add)) || (empty($pa_tel)) || (empty($pa_career)) || (empty($pa_status)) || (empty($district_id))
    //    || (empty($pa_fna2)) || (empty($pa_lna2)) || (empty($pa_age2)) || (empty($pa_add2)) || (empty($pa_tel2)) || (empty($pa_career2))  || (empty($pa_status2)) || (empty($district_id2))
    //    || (empty($pa_fna3)) || (empty($pa_lna3)) || (empty($pa_age3)) || (empty($pa_add3)) || (empty($pa_tel3)) || (empty($pa_career3)) || (empty($pa_relations3)) || (empty($pa_status3)) || (empty($district_id3))
    //   || (empty($s_id))
    // ) {
    //   $msg = "";
    //   // if (!$cs_na) $msg = $msg . " ชื่อ-นามสกุล";
    //   // if (!$cs_department) $msg = $msg . " แผนก";
    //   // if (!$cs_position) $msg = $msg . " ตำแหน่ง";
    //   // if (!$cs_tel) $msg = $msg . " เบอร์";
    //   echo "<script>Swal.fire({
    // 	type: 'error',
    // 	title: 'กรุณาใส่{$msg}',
    // 	showConfirmButton: true,
    // 	timer: 1500
    //   }).then(() => { 
    // 	 window.history.back()
    // 	});
    //   </script>";
    // } else {
       $query = "UPDATE parent set pa_tna='$pa_tna',pa_fna='$pa_fna',pa_lna='$pa_lna',pa_age='$pa_age',pa_add='$pa_add',pa_tel='$pa_tel',pa_career='$pa_career',pa_relations= 'บิดา',district_id='$district_id' WHERE s_id = '$s_id' and pa_status= 1 ";
      mysqli_query($conn, $query);
       $query = "UPDATE parent set pa_tna='$pa_tna2',pa_fna='$pa_fna2',pa_lna='$pa_lna2',pa_age='$pa_age2',pa_add='$pa_add2',pa_tel='$pa_tel2',pa_career='$pa_career2',pa_relations= 'มาดาร',district_id='$district_id2' WHERE s_id = '$s_id' and pa_status= 2 ";
      mysqli_query($conn, $query);
       $query = "UPDATE parent set pa_tna='$pa_tna3',pa_fna='$pa_fna3',pa_lna='$pa_lna3',pa_age='$pa_age3',pa_add='$pa_add3',pa_tel='$pa_tel3',pa_career='$pa_career3',pa_relations='$pa_relations3',district_id='$district_id3' WHERE s_id = '$s_id' and pa_status= 0 ";
      mysqli_query($conn, $query);
      echo "<script>Swal.fire({
          type: 'success',
          title: 'บันทึกข้อมูลเรียบร้อย',
          showConfirmButton: true,
          timer: 1500
        }).then(() => { 
          window.location = '$baseURL/views/parent/indexme.php?s_id=$s_id'
          });
        </script>";
    }
  //}
  //
  ?>
  <?php include("../../scr.php"); ?>
</body>

</html>
