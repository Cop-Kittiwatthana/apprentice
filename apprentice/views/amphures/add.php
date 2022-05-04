<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
  include("../../connect.php");
  $username = $_SESSION["username"];
  $password = $_SESSION["password"];
  $status = $_SESSION["status"];


  $query_provinces = "SELECT * FROM provinces";
  $result_provinces = mysqli_query($conn, $query_provinces);
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
    <title>ข้อมูลอำเภอ</title>
    <?php include("../../head.php") ?>
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
              <li class="breadcrumb-item"><a href="index.php">ข้อมูลอำเภอ</a></li>
              <li class="breadcrumb-item active">เพิ่มข้อมูลอำเภอ</li>
            </ol>
          </div>
          <br>
          <div class="text-center">
            <h4 class="text-dark"><i class="fas fa-plus"></i> เพิ่มข้อมูลอำเภอ</h4>
          </div>
          <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
            <div class="container text-dark " style="width: 60%; height: auto;">
              <div class="form-group">
                <br>
                <label for="sel1">จังหวัด:</label>
                <select class="form-control" name="province_id" id="province_id" required="" placeholder="-กรุณาเลือกจังหวัด-" oninvalid="this.setCustomValidity('-กรุณาเลือกจังหวัด-')" oninput="setCustomValidity('')">
                  <option value="" selected disabled>-กรุณาเลือกจังหวัด-</option>
                  <?php foreach ($result_provinces as $value) { ?>
                    <option value="<?= $value['province_id'] ?>"><?= $value['provinces_name_th'] ?></option>
                  <?php } ?>
                </select>
                <br>
                <label for="amphures_name_th" class="col-form-label">อำเภอ:</label>
                <input class="form-control" placeholder="-กรอกชื่ออำเภอ-" onkeypress="isInputChar(event)" required type="text" name="amphures_name_th" id="amphures_name_th">
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
    <?php include("../../scr.php") ?>
  </body>

  </html>

<?php
} else {
  echo "<script> alert('Please Login'); window.location='../../index.php';</script>";
  exit();
}
?>