<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
  include("../../connect.php");
  $username = $_SESSION["username"];
  $password = $_SESSION["password"];
  $status = $_SESSION["status"];

  $province_id = $_GET['province_id'];

$query = "SELECT provinces.* FROM provinces
WHERE provinces.province_id = $province_id";
  $result = mysqli_query($conn, $query)
    or die("3. ไม่สามารถประมวลผลคำสั่งได้") . $mysql->error();
  $data = array();
  while ($row = mysqli_fetch_array($result)) {  // preparing an array
    $province_id = "$row[province_id]";
    $provinces_name_th = "$row[provinces_name_th]";
    $geo_id = "$row[geo_id]";
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
    <title>ข้อมูลจังหวัด</title>
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
      <?php include("../../sidebar_login.php") ?>
      <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
          <?php include("../../menu_login.php") ?>
          <div class="container-fluid">
            <ol class="breadcrumb mb-4">
              <li class="breadcrumb-item"><a href="index.php">ข้อมูลจังหวัด</a></li>
              <li class="breadcrumb-item active">เพิ่มข้อมูลจังหวัด</li>
            </ol>
          </div>
          <br>
          <center>
            <h4 class="text-dark"><i class="fas fa-plus"></i> แก้ไขข้อมูลจังหวัด</h4>
          </center>
          <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
            <div class="container text-dark " style="width: 60%; height: auto;">
              <div class="form-group">
                <br>
                <label for="sel1">ภาค:</label>
                <select class="form-control" name="geo_id" id="geo_id" required="" placeholder="-กรุณาเลือกภาค-" oninvalid="this.setCustomValidity('-กรุณาเลือกภาค-')" oninput="setCustomValidity('')">

                  <option value="" <?= "" == $geo_id ? 'selected' : '' ?> disabled>-กรุณาเลือกภาค-</option>
                  <option value="1" <?= 1 == $geo_id ? 'selected' : '' ?>>ภาคเหนือ</option>
                  <option value="2" <?= 2 == $geo_id ? 'selected' : '' ?>>ภาคกลาง</option>
                  <option value="3" <?= 3 == $geo_id ? 'selected' : '' ?>>ภาคตะวันออกเฉียงเหนือ</option>
                  <option value="4" <?= 4 == $geo_id ? 'selected' : '' ?>>ภาคตะวันตก</option>
                  <option value="5" <?= 5 == $geo_id ? 'selected' : '' ?>>ภาคตะวันออก</option>
                  <option value="6" <?= 6 == $geo_id ? 'selected' : '' ?>>ภาคใต้</option>
                </select>
                <br>
                <input name="province_id" type="hidden" id="province_id" value="<?= $province_id ?>" />
                <label for="provinces_name_th" class="col-form-label">จังหวัด:</label>
                <input class="form-control" placeholder="-กรอกชื่อจังหวัด-" onkeypress="isInputChar(event)" required type="text" name="provinces_name_th" id="provinces_name_th" value="<?= $provinces_name_th ?>" />
              </div>
              <div class="footer d-flex justify-content-center">
                <button class="btn btn-success btn-lg" type="submit" name="btnedit" id="btnedit" value="บันทึก">บันทึก</button>&nbsp;
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
    <?php include("../../logoutmenu.php"); ?>
  </body>
  <?php include("../script.php") ?>

  </html>
<?php
} else {
  echo "<script> alert('Please Login'); window.location='../../index.php';</script>";
  exit();
}
?>