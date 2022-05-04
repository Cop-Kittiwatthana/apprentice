<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
   $t_id1 = $_GET['t_id'];
    $query = "SELECT teacher.*,districts.*, amphures.*, provinces.*
                FROM teacher
                LEFT JOIN districts ON teacher.district_id = districts.district_id
                LEFT JOIN amphures ON districts.amphure_id = amphures.amphure_id
                LEFT JOIN provinces ON amphures.province_id = provinces.province_id
                WHERE teacher.t_id = '$t_id1'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_assoc($result)) {  // preparing an array
        $t_tna = "$row[t_tna]";
        $t_fna = "$row[t_fna]";
        $t_lna = "$row[t_lna]";
        $t_tel = "$row[t_tel]";
        $t_mail = "$row[t_mail]";
        $photo = "$row[t_pic]";
        $t_date = "$row[t_date]";
        $t_add = "$row[t_add]";
        $t_user = "$row[t_user]";
        $t_pass = "$row[t_pass]";
        $type1 = "$row[type]";
        $dp_id = "$row[dp_id]";
        $p_id = "$row[p_id]";
        $district_id = "$row[district_id]";
        $amphure_id = "$row[amphure_id]";
        $province_id = "$row[province_id]";
        $zip_code = $row['zip_code'];
    }
    $query_department = "SELECT * FROM department ";
    $result_department = mysqli_query($conn, $query_department);

    $query_position = "SELECT * FROM position";
    $result_position = mysqli_query($conn, $query_position);

    $query_provinces = "SELECT * FROM provinces";
    $result_provinces = mysqli_query($conn, $query_provinces);

    $query_amphures = "SELECT * FROM amphures WHERE province_id=$province_id";
    $result_amphures = mysqli_query($conn, $query_amphures);

    $query_district = "SELECT * FROM districts WHERE amphure_id=$amphure_id";
    $result_district = mysqli_query($conn, $query_district);

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
                            <li class="breadcrumb-item active">แก้ไขข้อมูลอาจารย์</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> แก้ไขข้อมูลอาจารย์</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <input type=hidden name="t_id" id="t_id" value="<?= $t_id1 ?>">
                            <input name="t_pic" type="hidden" id="t_pic" value="<?= "$photo"; ?>" />
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-8">
                                        <th>ชื่อผู้ใช้ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="t_user" id="t_user" value="<?= $t_user ?>" class="form-control" placeholder="-กรุณาใส่ชื่อผู้ใช้-" onkeypress="isInputPassword(event)" required type="text">
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
                                                <input name="t_pass" id="t_pass" value="<?= $t_pass ?>" class="form-control pwd" placeholder="-กรุณาใส่รหัสผ่าน-" onkeypress="isInputPassword(event)" required type="password">
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
                                                <?php if ($username == 'admin' && $password == '1234') { ?>
                                                    <input type=hidden name="type" value="1">
                                                    <input class="form-control-input mt-0" type=checkbox name="type" value="0" <?php if ($type1 == 0) {
                                                                                                                                    echo "checked";
                                                                                                                                }  ?>>&nbsp;ผู้ดูแลระบบ
                                                <?php } else { ?>
                                                    <input type=hidden name="type" value="1">
                                                    <input disabled class="form-control-input mt-0" type=checkbox name="type" value="0" <?php if ($type1 == 0) {
                                                                                                                                    echo "checked";
                                                                                                                                } ?>>&nbsp;ผู้ดูแลระบบ
                                                <?php } ?>
                                                <!-- <input class="form-control-input mt-0" type=checkbox name="type" value="0">&nbsp;ผู้ดูแลระบบ -->
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <th>คำนำหน้า :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="t_tna" id="t_tna" required="" placeholder="-กรุณาเลือกคำนำหน้า-" oninvalid="this.setCustomValidity('-กรุณาเลือกคำนำหน้า-')" oninput="setCustomValidity('')">
                                                    <option value="" disabled>-กรุณาเลือก-</option>
                                                    <option value="0" <?= $t_tna == 0 ? 'selected' : '' ?>>นาย</option>
                                                    <option value="1" <?= $t_tna == 1 ? 'selected' : '' ?>>นาง</option>
                                                    <option value="2" <?= $t_tna == 2 ? 'selected' : '' ?>>นางสาว</option>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-5">
                                        <th>ชื่อ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="t_fna" id="t_fna" maxlength="25" value="<?= $t_fna ?>" class="form-control" placeholder="-กรุณาใส่ชื่อ-" onkeypress="isInputChar(event)" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-4">
                                        <th>นามสกุล :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="t_lna" id="t_lna" maxlength="25" value="<?= $t_lna ?>" class="form-control" placeholder="-กรุณาใส่นามสกุล-" onkeypress="isInputChar(event)" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>แผนก :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="dp_id" id="dp_id" placeholder="-กรุณาเลือกแผนก-" oninvalid="this.setCustomValidity('-กรุณาเลือกแผนก-สาขา-')" oninput="setCustomValidity('')">
                                                    <option value="0" <?= $dp_id == 0 ? 'selected' : '' ?> disabled>-กรุณาเลือกแผนก-</option>
                                                    <?php foreach ($result_department as $value) { ?>
                                                        <option value="<?= $value['dp_id'] ?>" <?= $value['dp_id'] == $dp_id ? 'selected' : '' ?>>
                                                            <?= $value['dp_na'] ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-6">
                                        <th>ตำแหน่ง :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="p_id" id="p_id" placeholder="-กรุณาเลือกตำแหน่ง-" oninvalid="this.setCustomValidity('-กรุณาเลือกตำแหน่ง-')" oninput="setCustomValidity('')">
                                                    <option value="0" <?= $p_id == 0 ? 'selected' : '' ?> disabled>-กรุณาเลือกตำแหน่ง-</option>
                                                    <?php foreach ($result_position as $value) { ?>
                                                        <option value="<?= $value['p_id'] ?>" <?= $value['p_id'] == $p_id ? 'selected' : '' ?>>
                                                            <?= $value['p_na'] ?></option>
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
                                                <textarea name="t_add" id="t_add"  class="form-control" placeholder="-กรุณาใส่ที่อยู่-" onkeypress="isInputChar2(event)" type="text"><?= $t_add ?></textarea>
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
                                                <select class="form-control" name="provinces" id="provinces"  placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือก จังหวัด')" oninput="setCustomValidity('')">
                                                    <option value="0" <?= $district_id == 0 ? 'selected' : '' ?> disabled>-กรุณาเลือกจังหวัด-</option>
                                                    <?php foreach ($result_provinces as $value) { ?>
                                                        <option value="<?= $value['province_id'] ?>" <?= $value['province_id'] == $province_id ? 'selected' : '' ?>>
                                                            <?= $value['provinces_name_th'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-3">
                                        <th>อำเภอ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="amphures" id="amphures" placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือก อำเภอ')" oninput="setCustomValidity('')">
                                                <option value="0" <?= $district_id == 0 ? 'selected' : '' ?> disabled>-กรุณาเลือกอำเภอ-</option>
                                                    <?php foreach ($result_amphures as $value) { ?>
                                                        <option value="<?= $value['amphure_id'] ?>" <?= $value['amphure_id'] == $amphure_id ? 'selected' : '' ?>>
                                                            <?= $value['amphures_name_th'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-3">
                                        <th>ตำบล :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="districts" id="districts"  placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือก ตำบล')" oninput="setCustomValidity('')">
                                                <option value="0" <?= $district_id == 0 ? 'selected' : '' ?> disabled>-กรุณาเลือกตำบล-</option>
                                                    <?php foreach ($result_district as $value) { ?>
                                                        <option value="<?= $value['district_id'] ?>" <?= $value['district_id'] == $district_id ? 'selected' : '' ?>>
                                                            <?= $value['district_name_th'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-3">
                                        <th>รหัสไปรษณีย์ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input type="text" name="zip_code" id="zip_code" maxlength="10" class="form-control" value="<?= $zip_code; ?>" readonly>
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
                                                <input name="t_tel" id="t_tel" value="<?= $t_tel ?>" maxlength="10" class="form-control" placeholder="-กรุณาใส่เบอร์-" onkeypress="isInputNumber(event)" type="text">
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
                                                <input name="t_mail" id="t_mail" value="<?= $t_mail ?>" class="form-control" placeholder="-กรุณาใส่อีเมล์-" type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>รูป :</th>
                                        <?php if ($photo != "") { ?>
                                            <img src="../../picture/<?= $photo ?>" style="display:block;" width="120" height="120" id="preview" class="img-thumbnail">
                                        <?php } else { ?>
                                            <img src="../../picture/<?= $photo ?>" style="display:none;" width="120" height="120" id="preview" class="img-thumbnail">
                                        <?php  } ?>
                                        <td>
                                            <div class="form-group mb-3">
                                                <input type="file" name="preview" class="file" accept="image/*">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" disabled placeholder="Upload File" id="photo" value="<?= $photo ?>">
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
                                                <textarea name="t_date" id="t_date" class="form-control" placeholder="-กรุณาใส่วันเวลาที่ติดต่อได้-" type="text"><?= $t_date ?></textarea>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <div class="footer d-flex justify-content-center">
                                <button class="btn btn-success btn-lg" type="submit" name="btnedit" id="btnedit" value="บันทึก">บันทึก</button>&nbsp;
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
<?php include("../script.php"); ?>