<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $query = "SELECT company.* FROM company  WHERE c_id = '$c_id'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;

    $query_branch = "SELECT department.*,branch.* FROM department inner JOIN branch ON department.dp_id = branch.dp_id";
    $result_branch = mysqli_query($conn, $query_branch);

    $query_position = "SELECT * FROM position";
    $result_position = mysqli_query($conn, $query_position);

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
        <title>ข้อมูลสถานประกอบการ</title>

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
                            <li class="breadcrumb-item"><a href="index.php">ข้อมูลสถานประกอบการ</a></li>
                            <li class="breadcrumb-item active">เพิ่มข้อมูลสถานประกอบการ</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> เพิ่มข้อมูลสถานประกอบการ</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <input type="hidden" name="c_status" id="c_status" value="1">
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>ชื่อผู้ใช้ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="c_user" id="c_user" class="form-control" placeholder="-กรุณาใส่ชื่อผู้ใช้-" onkeypress="isInputPassword(event)" required type="text" name="t_user" id="t_user">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>รหัสผ่าน :</th>
                                        <td>
                                            <div class="input-group mb-3" id="test">
                                                <input name="c_pass" id="c_pass" class="form-control pwd" placeholder="-กรุณาใส่รหัสผ่าน-" onkeypress="isInputPassword(event)" required type="password">
                                                <!-- <span class="input-group-btn">
                                                    <button class="btn btn-default reveal" type="button" style="border-collapse: collapse;border-color: #dedede;"><i class="fa fa-eye-slash"></i></button>
                                                </span> -->
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>ชื่อสถานประกอบการ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="c_na" id="c_na" maxlength="60" class="form-control" placeholder="-กรุณาใส่ชื่อ-" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <th>บ้านเลขที่ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="c_hnum" id="c_hnum" class="form-control" placeholder="-กรุณาใส่ที่อยู่-" onkeypress="isInputNumber2(event)" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-4">
                                        <th>หมู่ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="c_village" id="c_village" class="form-control" placeholder="-กรุณาใส่ที่หมู่-" onkeypress="isInputNumber2(event)" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-4">
                                        <th>ถนน :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="c_road" id="c_road" class="form-control" placeholder="-กรุณาใส่ถนน-" onkeypress="isInputChar2(event)" type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <th>จังหวัด :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="provinces" id="provinces" required>
                                                    <option value="0" selected disabled>-กรุณาเลือกจังหวัด-</option>
                                                    <?php foreach ($result_provinces as $value) { ?>
                                                        <option value="<?= $value['province_id'] ?>"><?= $value['provinces_name_th'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-3">
                                        <th>อำเภอ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="amphures" id="amphures" required>
                                                    <option value="0" selected disabled>-กรุณาเลือกอำเภอ-</option>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-3">
                                        <th>ตำบล :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="districts" id="districts" required>
                                                    <option value="0" selected disabled>-กรุณาเลือกตำบล-</option>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-3">
                                        <th>รหัสไปรษณีย์ :</th>
                                        <td>
                                            <div class="input-group mb-4">
                                                <input type="text" name="zip_code" id="zip_code" class="form-control" readonly>
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

    </html>
<?php
} else {
    echo "<script> alert('Please Login'); window.location='../../index.php';</script>";
    exit();
}
?>
<script>
    $(document).on("click", ".browse", function() {
        var file = $(this).parents().find(".file");
        file.trigger("click");

    });
    $(document).on("click", ".delect", function() {
        document.getElementById('preview').src = "";
        document.getElementById('preview').style = "display: none;";
        document.getElementById('photo').value = null;
    });
    $('input[type="file"]').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#photo").val(fileName);

        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview").style = "display: block;";
            document.getElementById("preview").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });
</script>
<script>
    $(".reveal").on('click', function() {
        var $pwd = $(".pwd");
        if ($pwd.attr('type') === 'password') {
            $pwd.attr('type', 'text');
            $('#test i').removeClass("fa-eye-slash");
            $('#test i').addClass("fa-eye");
        } else {
            $pwd.attr('type', 'password');
            $('#test i').addClass("fa-eye-slash");
            $('#test i').removeClass("fa-eye");
        }
    });
</script>
<?php include("../script.php"); ?>