<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
  include("../../connect.php");
  $username = $_SESSION["username"];
  $password = $_SESSION["password"];
  $status = $_SESSION["status"];
  $dp_id = $_GET['dp_id'];

  $query = "SELECT * FROM department 
    WHERE dp_id = '$dp_id'";
  $result = mysqli_query($conn, $query)
    or die("3. ไม่สามารถประมวลผลคำสั่งได้") . $mysql->error();
  $data = array();
  while ($row = mysqli_fetch_array($result)) {  // preparing an array
    $dp_na = "$row[dp_na]";
  }
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/brand.png">
    <title>ข้อมูลสาขา</title>

    <?php include("../../head.php"); ?>
    <script>
      $(document).ready(function() {
        $("select").each(function() {
          $(this).val($(this).find('option[selected]').val());
        });
      })
    </script>
  </head>

  <body id="page-top">

    <div id="wrapper">
      <?php include("../../sidebar_login.php"); ?>
      <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
          <?php include("../../menu_login.php"); ?>
          <div class="container-fluid">
            <ol class="breadcrumb mb-4">
              <li class="breadcrumb-item"><a href="index.php?dp_id=<?= $dp_id ?>">ข้อมูลสาขา</a></li>
              <li class="breadcrumb-item active">เพิ่มข้อมูลสาขา</li>
            </ol>
          </div>
          <br>
          <div class="text-center">
            <h4 class="text-dark"><i class="fas fa-plus"></i> เพิ่มข้อมูลสาขา</h4>
          </div>
          <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
            <div class="container text-dark " style="width: 60%; height: auto;">
              <div class="form-group">
                <br>
                <input name="dp_id" type="hidden" id="dp_id" value="<?= $dp_id ?>" />
                <label for="dp_na" class="col-form-label">ชื่อแผนก:</label>
                <input class="form-control" onkeypress="isInputChar(event)" required type="text" name="dp_na" id="dp_na" value="<?php echo $dp_na ?>" readonly>
                <br>
                <label for="br_na" class="col-form-label">ชื่อสาขา:</label>
                <input class="form-control" placeholder="-กรอกชื่อตำแหน่ง-" onkeypress="isInputChar(event)" required type="text" name="br_na" id="br_na">
              </div>

              <div class="footer d-flex justify-content-center">
                <button class="btn btn-success btn-lg" type="submit" name="btnsave" id="btnsave" value="บันทึก">บันทึก</button>&nbsp;
                <button class="btn btn-danger btn-lg" type="reset" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button>
                <!-- <button class="btn btn-danger" type="reset" onclick="window.history.back()" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button> -->
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <?php include("../../scr.php") ?>
    <?php include("../script.php"); ?>
  </body>

  </html>
<?php
} else {
  echo "<script> alert('Please Login'); window.location='../../index.php';</script>";
  exit();
}
?>