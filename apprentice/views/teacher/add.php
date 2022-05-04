<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];

    $query = "SELECT student.* FROM student  WHERE s_id = '$s_id'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;

    // $query_branch = "SELECT department.*,branch.* FROM department inner JOIN branch ON department.dp_id = branch.dp_id";
    // $result_branch = mysqli_query($conn, $query_branch);
    $query_department = "SELECT department.* FROM department ";
    $result_department = mysqli_query($conn, $query_department);

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
        <title>ข้อมูลอาจารย์</title>

        <?php include("../../head.php"); ?>
        <script>
            $(document).ready(function() {
                $("select").each(function() {
                    $(this).val($(this).find('option[selected]').val());
                });
            })
        </script>
        <style>
            .file {
                visibility: hidden;
                position: absolute;
            }
        </style>
    </head>

    <body id="page-top">

        <div id="wrapper">
            <?php include("../../sidebar_login.php"); ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php"); ?>
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">ข้อมูลอาจารย์</a></li>
                            <li class="breadcrumb-item active">เพิ่มข้อมูลอาจารย์</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> เพิ่มข้อมูลอาจารย์</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-8">
                                        <th>ชื่อผู้ใช้ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="t_user" id="t_user" class="form-control" placeholder="-กรุณาใส่ชื่อผู้ใช้-" onkeypress="isInputPassword(event)" required type="text" name="t_user" id="t_user">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-8">
                                        <th>รหัสผ่าน :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3" id="test">
                                                <input name="t_pass" id="t_pass" class="form-control pwd" placeholder="-กรุณาใส่รหัสผ่าน-" onkeypress="isInputPassword(event)" required type="password">
                                                <!-- <span class="input-group-btn">
                                                    <button class="btn btn-default reveal" type="button" style="border-collapse: collapse;border-color: #dedede;"><i class="fa fa-eye-slash"></i></button>
                                                </span> -->
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-4">
                                        <th>สถานะ :</th>
                                        <td>
                                            <div class="input-group-text mb-3">
                                                <input type=hidden name="type" value="1">
                                                <input class="form-control-input mt-0" type=checkbox name="type" value="0">&nbsp;ผู้ดูแลระบบ
                                                <!-- <input id="type" name="type" class="form-control-input mt-0" type="checkbox" value="0" aria-label="Checkbox for following text input">&nbsp;ผู้ดูแลระบบ -->
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
                                                <select class="form-control" name="t_tna" id="t_tna" required="" placeholder="-กรุณาเลือกคำนำหน้า-" oninvalid="this.setCustomValidity('-กรุณาเลือกคำนำหน้า-')" oninput="setCustomValidity('')">
                                                    <option value="" disabled>-กรุณาเลือก-</option>
                                                    <option value="0" selected>นาย</option>
                                                    <option value="1">นาง</option>
                                                    <option value="2">นางสาว</option>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-5">
                                        <th>ชื่อ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="t_fna" id="t_fna" maxlength="25" class="form-control" placeholder="-กรุณาใส่ชื่อ-" onkeypress="isInputChar(event)" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-5">
                                        <th>นามสกุล :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="t_lna" id="t_lna" maxlength="25" class="form-control" placeholder="-กรุณาใส่นามสกุล-" onkeypress="isInputChar(event)" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>แผนก:<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="dp_id" id="dp_id" required="required" placeholder="-กรุณาเลือกแผนก-" oninvalid="this.setCustomValidity('-กรุณาเลือกแผนก-')" oninput="setCustomValidity('')">
                                                    <option value="0" selected disabled>-กรุณาเลือกแผนก-</option>
                                                    <?php foreach ($result_department as $value) { ?>
                                                        <option value="<?= $value['dp_id'] ?>"><?= $value['dp_na'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-6">
                                        <th>ตำแหน่ง :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="p_id" id="p_id" required="required" placeholder="-กรุณาเลือกตำแหน่ง-" oninvalid="this.setCustomValidity('-กรุณาเลือกตำแหน่ง-')" oninput="setCustomValidity('')">
                                                    <option value="0" selected disabled>-กรุณาเลือกตำแหน่ง-</option>
                                                    <?php foreach ($result_position as $value) { ?>
                                                        <option value="<?= $value['p_id'] ?>"><?= $value['p_na'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>ที่อยู่ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <textarea name="t_add" id="t_add" class="form-control" placeholder="-กรุณาใส่ที่อยู่-" onkeypress="isInputChar2(event)" type="text"></textarea>
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
                                                <select class="form-control" name="provinces" id="provinces">
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
                                                <select class="form-control" name="amphures" id="amphures">
                                                    <option value="0" selected disabled>-กรุณาเลือกอำเภอ-</option>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-3">
                                        <th>ตำบล :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="districts" id="districts">
                                                    <option value="0" selected disabled>-กรุณาเลือกตำบล-</option>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-3">
                                        <th>รหัสไปรษณีย์ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input type="text" name="zip_code" id="zip_code" class="form-control" readonly>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>เบอร์ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="t_tel" id="t_tel" maxlength="10" class="form-control" require placeholder="-กรุณาใส่เบอร์-" onkeypress="isInputPassword(event)" type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>อีเมล์ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="t_mail" id="t_mail" class="form-control" placeholder="-กรุณาใส่อีเมล์-" onkeypress="isInputPassword(event)" type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>รูป :</th>
                                        <img src="../../picture/<?= $photo ?>" style="display:none;" width="240" height="240" id="preview" class="img-thumbnail">
                                        <td>
                                            <div class="form-group mb-3">
                                                <input type="file" name="preview" class="file" accept="image/*">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" disabled placeholder="Upload File" id="photo">
                                                    <div class="input-group-append">
                                                        <button type="button" class="browse btn btn-primary">เพิ่มรูป...</button>
                                                    </div>
                                                    <!-- <div class="input-group-append">
                                                        <button type="button" class="delect btn btn-danger">ลบ...</button>
                                                    </div> -->
                                                </div>
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
                                                <textarea name="t_date" id="t_date" class="form-control" placeholder="-กรุณาใส่วันเวลาที่ติดต่อได้-" type="text"></textarea>
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
    echo ("<script> alert('please login'); window.location='../../index.php';</script>");
    exit();
}
?>
<script>
    $(document).on("click", ".browse", function() {
        var file = $(this).parents().find(".file");
        file.trigger("click");

    });
    // $(document).on("click", ".delect", function() {
    //     document.getElementById('preview').src = "";
    //     document.getElementById('preview').style = "display: none;";
    //     document.getElementById('photo').value = null;
    // });
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
<!-- <script>
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
</script> -->
<?php include("../script.php"); ?>