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
    <title>ข้อมูลตำบล</title>
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
              <li class="breadcrumb-item"><a href="index.php">ข้อมูลตำบล</a></li>
              <li class="breadcrumb-item active">เพิ่มข้อมูลตำบล</li>
            </ol>
          </div>
          <br>
          <div class="text-center">
            <h4 class="text-dark"><i class="fas fa-plus"></i> เพิ่มข้อมูลตำบล</h4>
          </div>
          <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
            <div class="container text-dark " style="width: 60%; height: auto;">
              <div class="form-group">
                <label for="sel1">จังหวัด:</label>
                <select class="form-control" name="provinces" id="provinces" required="" placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือก จังหวัด')" oninput="setCustomValidity('')">
                  <option value="" selected disabled>-กรุณาเลือกจังหวัด-</option>
                  <?php foreach ($result_provinces as $value) { ?>
                    <option value="<?= $value['province_id'] ?>"><?= $value['provinces_name_th'] ?></option>
                  <?php } ?>
                </select>
                <br>
                <label for="sel1">อำเภอ:</label>
                <select class="form-control" name="amphures" id="amphures" required="" placeholder="amphures" oninvalid="this.setCustomValidity('กรุณาเลือก อำเภอ')" oninput="setCustomValidity('')">
                  <option value="" selected disabled>-กรุณาเลือกอำเภอ-</option>
                </select>
                <br>
                <!-- <label for="district_name_th" class="col-form-label">รหัสตำบล:</label>
              <input class="form-control" onkeypress="isInputChar(event)" required="required" type="text" name="amphure_id" id="amphure_id" />
              <br> -->
                <label for="district_name_th" class="col-form-label">ตำบล:</label>
                <input class="form-control" placeholder="-กรอกชื่อตำบล-" onkeypress="isInputChar(event)" required type="text" name="district_name_th" id="district_name_th" />
                <br>
                <label for="recipient-name" class="col-form-label">รหัสไปรษณีย์:</label>
                <!-- <input class="form-control" placeholder="-กรอกข้อมูลรหัสไปรษณีย์-" maxlength="5" onkeypress="return onlyNumber(event)" required name="zip_code" id="zip_code"> -->
                <input class="form-control" placeholder="-กรอกรหัสไปรษณีย์ 5 หลัก-" maxlength="5" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" name="zip_code" id="zip_code" />
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
    <?php include("../../logoutmenu.php"); ?>
  </body>
  <?php include("../script.php"); ?>

  </html>
<?php
} else {
  echo "<script> alert('Please Login'); window.location='../../index.php';</script>";
  exit();
}
