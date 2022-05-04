<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])&& $_SESSION["status"] == '3') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $c_id = $_GET['c_id'];
    //$query = "SELECT company.* FROM company  WHERE c_id = '$c_id'";
    $query = "SELECT company.*,districts.*, amphures.*, provinces.*
                FROM company
                INNER JOIN districts ON company.district_id = districts.district_id
                INNER JOIN amphures ON districts.amphure_id = amphures.amphure_id
                INNER JOIN provinces ON amphures.province_id = provinces.province_id
                WHERE company.c_id = $c_id";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $c_na = "$row[c_na]";
        $c_hnum = "$row[c_hnum]";
        $c_village = "$row[c_village]";
        $c_road = "$row[c_road]";
        $c_user = "$row[c_user]";
        $c_pass = "$row[c_pass]";
        $c_status = "$row[c_status]";
        $district_id = "$row[district_id]";
        $amphure_id = "$row[amphure_id]";
        $province_id = "$row[province_id]";
        $zip_code = "$row[zip_code]";
    }

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
                        <li class="breadcrumb-item"><a href="indexme.php?c_id=<?= $c_id ?>">ข้อมูลสถานประกอบการ</a></li>
                            <li class="breadcrumb-item active">แก้ไขสถานประกอบการ</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-building"></i> ข้อมูลสถานประกอบการ</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <input type="hidden" name="c_id" id="c_id" value="<?= $c_id ?>">
                            <input type="hidden" name="c_status" id="c_status" value="<?= $c_status ?>">
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>ชื่อผู้ใช้ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="c_user" id="c_user" value="<?= $c_user ?>" class="form-control" placeholder="-กรุณาใส่ชื่อผู้ใช้-" onkeypress="isInputPassword(event)" readonly required type="text">
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-6">
                                        <th>รหัสผ่าน :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3" id="test">
                                                <input name="c_pass" id="c_pass" value="<?= $c_pass ?>" class="form-control pwd" placeholder="-กรุณาใส่รหัสผ่าน-" onkeypress="isInputPassword(event)" required type="password">
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
                                        <th>ชื่อสถานประกอบการ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="c_na" id="c_na" maxlength="60" value="<?= $c_na ?>" class="form-control" placeholder="-กรุณาใส่ชื่อ-" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <th>บ้านเลขที่ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="c_hnum" id="c_hnum" value="<?= $c_hnum ?>" class="form-control" placeholder="-กรุณาใส่ที่อยู่-" onkeypress="isInputNumber2(event)" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-4">
                                        <th>หมู่ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="c_village" id="c_village" value="<?= $c_village ?>" class="form-control" placeholder="-กรุณาใส่ที่หมู่-" onkeypress="isInputNumber2(event)" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-4">
                                        <th>ถนน :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="c_road" id="c_road" value="<?= $c_road ?>" class="form-control" placeholder="-กรุณาใส่ถนน-" onkeypress="isInputChar2(event)" type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <th>จังหวัด :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="provinces" id="provinces" required="" placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือก จังหวัด')" oninput="setCustomValidity('')">
                                                    <?php foreach ($result_provinces as $value) { ?>
                                                        <option value="<?= $value['province_id'] ?>" <?= $value['province_id'] == $province_id ? 'selected' : '' ?>>
                                                            <?= $value['provinces_name_th'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-3">
                                        <th>อำเภอ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="amphures" id="amphures" required="" placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือก อำเภอ')" oninput="setCustomValidity('')">
                                                    <?php foreach ($result_amphures as $value) { ?>
                                                        <option value="<?= $value['amphure_id'] ?>" <?= $value['amphure_id'] == $amphure_id ? 'selected' : '' ?>>
                                                            <?= $value['amphures_name_th'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-3">
                                        <th>ตำบล :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="districts" id="districts" required="" placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือก ตำบล')" oninput="setCustomValidity('')">
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
                                                <input type="text" name="zip_code" id="zip_code" value="<?= $zip_code?>" class="form-control" readonly>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <br>
                            <div class="footer d-flex justify-content-center">
                                <button class="btn btn-success btn-lg" type="submit" name="btneditme" id="btneditme" value="บันทึก">บันทึก</button>&nbsp;
                                <button class="btn btn-danger btn-lg" type="reset" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button>
                            </div>
                        </div>
                    </form>
                    <br>
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