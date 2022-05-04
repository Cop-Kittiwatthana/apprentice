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
        $district_name_th = $row['district_name_th'];
        $amphures_name_th = $row['amphures_name_th'];
        $provinces_name_th = $row['provinces_name_th'];
        $zip_code = "$row[zip_code]";
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
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-building"></i> ข้อมูลสถานประกอบการ</h4>
                        <a href="editme.php?c_id=<?= $c_id ?>"><span class="btn btn-primary fa fas-plus float-center "><i class="fas fa-plus-circle"> แก้ไขข้อมูลส่วนตัว</i></a>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <br>
                            <div class="card">
                                <div class="card-body">
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <th>รหัสสถานประกอบการ/ชื่อผู้ใช้ : <a style="color:black;"><?= $c_user ?></a></th>

                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <th>ชื่อสถานประกอบการ : <a style="color:black;"><?= $c_na ?></a></th>

                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <th>ที่อยู่ : <a style="color:black;"><?= $c_hnum ?> หมู่ <?= $c_village ?> ถนน <?= $c_road ?></a></th>
                                                <th><a style="color:black;">ตำบล<?= $district_name_th ?> อำเภอ<?= $amphures_name_th ?> จังหวัด<?= $provinces_name_th ?> รหัสไปรษณีย์ <?= $zip_code ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                </div>
                            </div>
                            <br>
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