<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) && $_SESSION["status"] == '2') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];

    $s_id = $_GET['s_id'];
    $query = "SELECT student.*,parent.*,districts.*, amphures.*, provinces.* FROM student
    LEFT JOIN parent on  student.s_id = parent.s_id
    LEFT JOIN districts ON parent.district_id = districts.district_id 
    LEFT JOIN amphures ON districts.amphure_id = amphures.amphure_id
    LEFT JOIN provinces ON amphures.province_id = provinces.province_id
    WHERE student.s_id = '$s_id' and parent.pa_status = 1";
    $result = mysqli_query($conn, $query) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {
        $s_na = "$row[s_fna]&nbsp;$row[s_lna]";
        $pa_tna = "$row[pa_tna]";
        $pa_fna = "$row[pa_fna]";
        $pa_lna = "$row[pa_lna]";
        $pa_age = "$row[pa_age]";
        $pa_career = "$row[pa_career]";
        $pa_relations = "$row[pa_relations]";
        $pa_status = "$row[pa_status]";
        $pa_tel = "$row[pa_tel]";
        $pa_add = "$row[pa_add]";
        $district_name_th = $row['district_name_th'];
        $amphures_name_th = $row['amphures_name_th'];
        $provinces_name_th = $row['provinces_name_th'];
        $zip_code = $row['zip_code'];
    }
    $query2 = "SELECT student.*,parent.*,districts.*, amphures.*, provinces.* FROM student
    LEFT JOIN parent on  student.s_id = parent.s_id
    LEFT JOIN districts ON parent.district_id = districts.district_id 
    LEFT JOIN amphures ON districts.amphure_id = amphures.amphure_id
    LEFT JOIN provinces ON amphures.province_id = provinces.province_id
    WHERE student.s_id = '$s_id' and parent.pa_status = 2";
    $result2 = mysqli_query($conn, $query2) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row2 = mysqli_fetch_array($result2)) {  // preparing an array
        $pa_tna2 = "$row2[pa_tna]";
        $pa_fna2 = "$row2[pa_fna]";
        $pa_lna2 = "$row2[pa_lna]";
        $pa_age2 = "$row2[pa_age]";
        $pa_career2 = "$row2[pa_career]";
        $pa_relations2 = "$row2[pa_relations]";
        $pa_status2 = "$row2[pa_status]";
        $pa_tel2 = "$row2[pa_tel]";
        $pa_add2 = "$row2[pa_add]";
        $district_name_th2 = $row2['district_name_th'];
        $amphures_name_th2 = $row2['amphures_name_th'];
        $provinces_name_th2 = $row2['provinces_name_th'];
        $zip_code2 = $row2['zip_code'];
    }
    $query3 = "SELECT student.*,parent.*,districts.*, amphures.*, provinces.* FROM student
    LEFT JOIN parent on  student.s_id = parent.s_id
    LEFT JOIN districts ON parent.district_id = districts.district_id 
    LEFT JOIN amphures ON districts.amphure_id = amphures.amphure_id
    LEFT JOIN provinces ON amphures.province_id = provinces.province_id
    WHERE student.s_id = '$s_id' and parent.pa_status = 0";
    $result3 = mysqli_query($conn, $query3) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row3 = mysqli_fetch_array($result3)) {  // preparing an array
        $pa_tna3 = "$row3[pa_tna]";
        $pa_fna3 = "$row3[pa_fna]";
        $pa_lna3 = "$row3[pa_lna]";
        $pa_age3 = "$row3[pa_age]";
        $pa_career3 = "$row3[pa_career]";
        $pa_relations3 = "$row3[pa_relations]";
        $pa_status3 = "$row3[pa_status]";
        $pa_tel3 = "$row3[pa_tel]";
        $pa_add3 = "$row3[pa_add]";
        $district_name_th3 = $row3['district_name_th'];
        $amphures_name_th3 = $row3['amphures_name_th'];
        $provinces_name_th3 = $row3['provinces_name_th'];
        $zip_code3 = $row3['zip_code'];
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
        <title>ข้อมูลผู้ปกครอง</title>

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
                        <h4 class="text-dark"><i class="fas fa-plus"></i> ข้อมูลผู้ปกครอง</h4>
                        <a href="editparent.php?s_id=<?= $s_id ?>"><span class="btn btn-primary fa fas-plus float-center "><i class="fas fa-plus-circle"> แก้ไขข้อมูลผู้ปกครอง</i></a>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                        <br>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-dark"><i class="fas fa-user-plus"></i> ข้อมูลบิดา</h5>
                                    <tr>
                                        <div class="row"> 
                                            <div class="col-md-6 mb-2">
                                                <?php
                                                if ($pa_tna == 0) {
                                                    $tna = "นาย";
                                                }
                                                if ($pa_tna == 1) {
                                                    $tna = "นาง";
                                                }
                                                if ($pa_tna == 2) {
                                                    $tna = "นางสาว";
                                                }
                                                ?>
                                                <th>ชื่อ-นามสกุล : <a style="color:black;"><?= $tna ?> <?= $pa_fna ?> <?= $pa_lna ?></a></th>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <th>อายุ : <a style="color:black;"><?= $pa_age ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <th>เบอร์โทร : <a style="color:black;"><?= $pa_tel ?></a></th>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <th>อาชีพ : <a style="color:black;"><?= $pa_career ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <th>ที่อยู่ : <a style="color:black;"><?= $pa_add ?></a></th>
                                                <th><a style="color:black;">ตำบล<?= $district_name_th ?> อำเภอ<?= $amphures_name_th ?> จังหวัด<?= $provinces_name_th ?> รหัสไปรษณีย์ <?= $zip_code ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-dark"><i class="fas fa-user-plus"></i> ข้อมูลมารดา</h5>
                                    <tr>
                                        <div class="row"> 
                                            <div class="col-md-6 mb-2">
                                                <?php
                                                if ($pa_tna2 == 0) {
                                                    $tna2 = "นาย";
                                                }
                                                if ($pa_tna2 == 1) {
                                                    $tna2 = "นาง";
                                                }
                                                if ($pa_tna2 == 2) {
                                                    $tna2 = "นางสาว";
                                                }
                                                ?>
                                                <th>ชื่อ-นามสกุล : <a style="color:black;"><?= $tna2 ?> <?= $pa_fna2 ?> <?= $pa_lna2 ?></a></th>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <th>อายุ : <a style="color:black;"><?= $pa_age2 ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <th>เบอร์โทร : <a style="color:black;"><?= $pa_tel2 ?></a></th>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <th>อาชีพ : <a style="color:black;"><?= $pa_career2 ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <th>ที่อยู่ : <a style="color:black;"><?= $pa_add2 ?></a></th>
                                                <th><a style="color:black;">ตำบล<?= $district_name_th2 ?> อำเภอ<?= $amphures_name_th2 ?> จังหวัด<?= $provinces_name_th2 ?> รหัสไปรษณีย์ <?= $zip_code2 ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-dark"><i class="fas fa-user-plus"></i> ข้อมูลผู้ปกครอง</h5>
                                    <tr>
                                        <div class="row"> 
                                            <div class="col-md-6 mb-2">
                                                <?php
                                                if ($pa_tna3 == 0) {
                                                    $tna3 = "นาย";
                                                }
                                                if ($pa_tna3 == 1) {
                                                    $tna3 = "นาง";
                                                }
                                                if ($pa_tna3 == 2) {
                                                    $tna3 = "นางสาว";
                                                }
                                                ?>
                                                <th>ชื่อ-นามสกุล : <a style="color:black;"><?= $tna3 ?> <?= $pa_fna3 ?> <?= $pa_lna3 ?></a></th>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <th>อายุ : <a style="color:black;"><?= $pa_age3 ?></a></th>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <th>ความสัมพันธ์ : <a style="color:black;"><?= $pa_relations3 ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <th>เบอร์โทร : <a style="color:black;"><?= $pa_tel3 ?></a></th>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <th>อาชีพ : <a style="color:black;"><?= $pa_career3 ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <th>ที่อยู่ : <a style="color:black;"><?= $pa_add3 ?></a></th>
                                                <th><a style="color:black;">ตำบล<?= $district_name_th3 ?> อำเภอ<?= $amphures_name_th3 ?> จังหวัด<?= $provinces_name_th3 ?> รหัสไปรษณีย์ <?= $zip_code3 ?></a></th>
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
<?php include("../script.php"); ?>
<?php include("../script2.php"); ?>
<?php include("../script3.php"); ?>