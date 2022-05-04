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
    $br_id = $_POST['br_id'];
    $s_group = $_POST['s_group'];
    $pe_semester = $_POST['pe_semester'];
    $r_term = $_POST['r_term'];
    for ($i = 1; $i <= $_POST["hdnLine"]; $i++) {
      //$sum = ($_POST["r_ecompany$i"] + $_POST["r_ework$i"] + $_POST["r_esupervision$i"]);
      $sum = $_POST["sum$i"];
      if (($sum >= 80) && ($sum <= 100)) {
        $grade = "4";
      } elseif (($sum >= 75) && ($sum <= 79)) {
        $grade = "3.5";
      } elseif (($sum >= 70) && ($sum <= 74)) {
        $grade = "3";
      } elseif (($sum >= 65) && ($sum <= 69)) {
        $grade = "2.5";
      } elseif (($sum >= 60) && ($sum <= 64)) {
        $grade = "2";
      } elseif (($sum >= 55) && ($sum <= 59)) {
        $grade = "1.5";
      } elseif (($sum >= 50) && ($sum <= 54)) {
        $grade = "1";
      } else {
        $grade = "0";
      }
      $strSQL = "UPDATE results SET ";
      $strSQL .= "r_ecompany = '" . $_POST["r_ecompany$i"] . "' ";
      $strSQL .= ",r_ework = '" . $_POST["r_ework$i"] . "' ";
      $strSQL .= ",sum = '" . $sum . "' ";
      $strSQL .= ",grade = '" . $grade . "' ";
      $strSQL .= "WHERE r_id = '" . $_POST["r_id$i"] . "' ";
      $objQuery = mysqli_query($conn, $strSQL);
      echo "<script>Swal.fire({
                  type: 'success',
                  title: 'บันทึกข้อมูลเรียบร้อย',
                  showConfirmButton: true,
                  timer: 1500
                 }).then(() => { 
                  window.location = '$baseURL/views/score/indexstd.php?id=$br_id&s_group=$s_group&pe_semester=$pe_semester&r_term=$r_term'
                   });
                </script>";
    }
  }
  //window.location = '$baseURL/views/score/indexstd.php?id=$br_id&s_group=$s_group&pe_semester=$pe_semester&r_term=$r_term'
  ?>
</body>

</html>