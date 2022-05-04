<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) && $_SESSION["status"] == '3' || $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $c_id = $_GET['c_id'];
    $query = "SELECT company.* FROM company  WHERE c_id = '$c_id'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {
        $c_na = "$row[c_na]";
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
        <title>ข้อมูลผู้ติดต่อสถานประกอบการ</title>

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
                            <!-- <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/company/index.php">ข้อมูลสถานประกอบการ</a></li> -->
                            <li class="breadcrumb-item"><a href="index.php?c_id=<?= $c_id ?>">ข้อมูลผู้ติดต่อ</a></li>
                            <li class="breadcrumb-item active">เพิ่มข้อมูลผู้ติดต่อ</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> เพิ่มข้อมูลผู้ติดต่อ</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                        <input type=hidden name="c_id" id="c_id" value="<?= $c_id ?>">
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>สถานประกอบการ :</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="c_na" id="c_na" value="<?= $c_na ?>" class="form-control" type="text" readonly>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-2">
                                        <th>คำนำหน้า :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="cs_tna" id="cs_tna" required placeholder="-กรุณาเลือกคำนำหน้า-" oninvalid="this.setCustomValidity('-กรุณาเลือกคำนำหน้า-')" oninput="setCustomValidity('')">
                                                    <option value="" disabled>-กรุณาเลือก-</option>
                                                    <option value="0" selected>นาย</option>
                                                    <option value="1">นาง</option>
                                                    <option value="2">นางสาว</option>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-10">
                                        <th>ชื่อ-นามสกุล :<a style="color:red;">*ภาษาไทย</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="cs_na" id="cs_na" class="form-control" placeholder="-กรุณาใส่ชื่อ นามสกุล-" onkeypress="isInputCharth(event)" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>ตำแหน่ง :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="cs_position" id="cs_position" class="form-control" placeholder="-กรุณาใส่ตำแหน่ง-" onkeypress="isInputChar(event)" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-6">
                                        <th>แผนก :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="cs_department" id="cs_department" class="form-control" placeholder="-กรุณาใส่แผนก-" onkeypress="isInputChar(event)" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>เบอร์โทร :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="cs_tel" id="cs_tel" maxlength="10" class="form-control" placeholder="-กรุณาใส่เบอร์โทร-" onkeypress="isInputNumber(event)" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-6">
                                        <th>โทรสาร :</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="cs_fax" id="cs_fax" class="form-control" placeholder="-กรุณาใส่โทรสาร-" onkeypress="isInputNumber(event)"  type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>อีเมล์ :</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="cs_mail" id="cs_mail" class="form-control" placeholder="-กรุณาใส่อีเมล์-"   type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>วันเวลาที่ติดต่อได้ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <textarea name="cs_date" id="cs_date" class="form-control" placeholder="-กรุณาใส่วันเวลาที่ติดต่อได้-"  type="text"></textarea>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <div class="footer d-flex justify-content-center">
                                <button class="btn btn-success btn-lg" type="submit" name="btnsave" id="btnsave" value="บันทึก">บันทึก</button>&nbsp;
                                <button class="btn btn-danger btn-lg" type="reset" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button>
                                <!-- <button class="btn btn-danger" type="reset" onclick="window.history.back()" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button> -->
                            </div>
                        </div>
                    </form>
                </div>
                <?php include("../../footer.php"); ?>
            </div>
        </div>
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <!-- Logout Modal-->
        <?php include("../../logoutmenu.php"); ?>
    </body>
    <?php include("../script.php"); ?>
    </html>
    <?php
} else {
    echo "<script> alert('Please Login'); window.location='../../index.php';</script>";
    exit();
}
?>
