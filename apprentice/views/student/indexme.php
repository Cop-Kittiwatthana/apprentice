<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $s_id = $_GET['s_id'];
    $query = "SELECT student.*,districts.*, amphures.*, provinces.*,branch.*,department.* FROM student 
    LEFT JOIN districts ON student.district_id1 = districts.district_id 
    LEFT JOIN amphures ON districts.amphure_id = amphures.amphure_id
    LEFT JOIN provinces ON amphures.province_id = provinces.province_id
    LEFT JOIN branch ON student.br_id = branch.br_id
    LEFT JOIN department ON branch.dp_id = department.dp_id
    WHERE student.s_id = '$s_id'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $s_tna = "$row[s_tna]";
        $s_fna = "$row[s_fna]";
        $s_lna = "$row[s_lna]";
        $s_group = $row['s_group'];
        $s_pass = "$row[s_pass]";
        $br_id = "$row[br_id]";
        $s_bdate = $row['s_bdate'];
        $s_age = $row['s_age'];
        $s_tel = $row['s_tel'];
        $s_mail = $row['s_mail'];
        $s_height = $row['s_height'];
        $s_weight = $row['s_weight'];
        $s_race = $row['s_race'];
        $s_cult = $row['s_cult'];
        $s_nation = $row['s_nation'];
        $s_lbood = $row['s_lbood'];
        $s_points = $row['s_points'];
        $s_disease = $row['s_disease'];
        $s_drug = $row['s_drug'];
        $s_ability1 = $row['s_ability1'];
        $s_ability2 = $row['s_ability2'];
        $s_ability3 = $row['s_ability3'];
        $s_No1 = $row['s_No1'];
        $s_village1 = $row['s_village1'];
        $s_road1 = $row['s_road1'];
        $s_No2 = $row['s_No2'];
        $s_village2 = $row['s_village2'];
        $s_road2 = $row['s_road2'];
        $s_frina = $row['s_frina'];
        $s_friadd = $row['s_friadd'];
        $s_ftel = $row['s_ftel'];
        $district_name_th = $row['district_name_th'];
        $amphures_name_th = $row['amphures_name_th'];
        $provinces_name_th = $row['provinces_name_th'];
        $zip_code = $row['zip_code'];
        $br_na = $row['br_na'];
        $dp_na = $row['dp_na'];
    }
    //ที่อยู่ปัจจุบัน
    $query2 = "SELECT student.*,districts.*, amphures.*, provinces.* FROM student 
    INNER JOIN districts ON student.district_id2 = districts.district_id 
    INNER JOIN amphures ON districts.amphure_id = amphures.amphure_id
    INNER JOIN provinces ON amphures.province_id = provinces.province_id
    WHERE student.s_id = '$s_id'";
    $result2 = mysqli_query($conn, $query2)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row2 = mysqli_fetch_array($result2)) {  // preparing an array
        $district_name_th2 = $row2['district_name_th'];
        $amphures_name_th2 = $row2['amphures_name_th'];
        $provinces_name_th2 = $row2['provinces_name_th'];
        $zip_code2 = $row2['zip_code'];
    }
    //ที่อยู่เพื่อน
    $query3 = "SELECT student.*,districts.*, amphures.*, provinces.* FROM student 
    INNER JOIN districts ON student.district_id3 = districts.district_id 
    INNER JOIN amphures ON districts.amphure_id = amphures.amphure_id
    INNER JOIN provinces ON amphures.province_id = provinces.province_id
    WHERE student.s_id = '$s_id'";
    $result3 = mysqli_query($conn, $query3)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row3 = mysqli_fetch_array($result3)) {  // preparing an array
        $district_name_th3 = $row3['district_name_th'];
        $amphures_name_th3 = $row3['amphures_name_th'];
        $provinces_name_th3 = $row3['provinces_name_th'];
        $zip_code3 = $row3['zip_code'];
    }

    $query_branch = "SELECT department.*,branch.* FROM department inner JOIN branch ON department.dp_id = branch.dp_id";
    $result_branch = mysqli_query($conn, $query_branch);
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
        <title>ข้อมูลนักศึกษา</title>

        <?php include("../../head.php"); ?>
        <?php include("script_date.php"); ?>
        <!--ปฏิทิน-->

    </head>

    <body id="page-top">

        <div id="wrapper">
            <?php include("../../sidebar_login.php"); ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php"); ?>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> ข้อมูลส่วนตัวนักศึกษา</h4>
                        <a href="editme.php?s_id=<?= $s_id ?>"><span class="btn btn-primary fa fas-plus float-center "><i class="fas fa-plus-circle"> แก้ไขข้อมูลส่วนตัว</i></a>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 70%; height: auto;">
                            <br>
                            <div class="card">
                                <div class="card-body">
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6 ">
                                                <th>รหัสนักศึกษา/ชื่อผู้ใช้ : <a style="color:black;"><?= $s_id ?></a></th>

                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <th>แผนก-สาขา : <a style="color:black;"><?= $dp_na ?>-<?= $br_na ?></a></th>

                                            </div>
                                            <!-- <div class="col-md-6">
                                                <th>รหัสผ่าน : <a style="color:black;"><?= $s_pass ?></a></th>
                                            </div> -->
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row"> 
                                            <div class="col-md-6 mb-2">
                                                <?php
                                                if ($s_tna == 0) {
                                                    $tna = "นาย";
                                                }
                                                if ($s_tna == 1) {
                                                    $tna = "นาง";
                                                }
                                                if ($s_tna == 2) {
                                                    $tna = "นางสาว";
                                                }
                                                ?>
                                                <th>ชื่อ-นามสกุล : <a style="color:black;"><?= $tna ?> <?= $s_fna ?> <?= $s_lna ?></a></th>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <th>กลุ่ม : <a style="color:black;"><?= $s_group ?></a></th>
                                            </div>
                                        </div>
                                    </tr>

                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <th>วันเกิด : <a style="color:black;"><?= $s_bdate ?></a></th>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <th>อายุ : <a style="color:black;"><?= $s_age ?></a></th>
                                            </div>
                                        </div>
                                    </tr>

                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <th>เบอร์ : <a style="color:black;"><?= $s_tel ?></a></th>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <th>อีเมล์ : <a style="color:black;"><?= $s_mail ?></a></th>
                                            </div>
                                        </div>
                                    </tr>

                                    <tr>
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <th>ส่วนสูง : <a style="color:black;"><?= $s_height ?></a></th>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <th>น้ำหนัก : <a style="color:black;"><?= $s_weight ?></a></th>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <?php
                                                if ($s_lbood == 0) {
                                                    $bood = "A";
                                                }
                                                if ($s_lbood == 1) {
                                                    $bood = "B";
                                                }
                                                if ($s_lbood == 2) {
                                                    $bood = "AB";
                                                }
                                                if ($s_lbood == 3) {
                                                    $bood = "O";
                                                }
                                                ?>
                                                <th>กรุ็ปเลือด : <a style="color:black;"><?= $bood ?></a></th>
                                            </div>
                                        </div>
                                    </tr>

                                    <tr>
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <th>สัญชาติ : <a style="color:black;"><?= $s_nation ?></a></th>
                                            </div> 
                                            <div class="col-md-4 mb-2">
                                                <th>เชื้อชาติ : <a style="color:black;"><?= $s_race ?></a></th>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <th>ศาสนา : <a style="color:black;"><?= $s_cult ?></a></th>
                                            </div>
                                        </div>
                                    </tr>

                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <th>โรคประจำตัว : <a style="color:black;"><?= $s_disease ?></a></th>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <th>ยาที่แพ้ : <a style="color:black;"><?= $s_drug ?></a></th>
                                            </div>
                                        </div>
                                    </tr>

                                    <tr>
                                        <div class="row">
                                            <div class="col-md-8 mb-2">
                                                <th>คะแนนเฉลี่ยภาคเรียนสุดท้าย : <a style="color:black;"><?= $s_points ?></a></th>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                    </tr>

                                    <tr>
                                        <div class="row">
                                            <div class="col-md-8 mb-2">
                                                <?php
                                                if ($s_ability1 == "") {
                                                    $ability1 = "-";
                                                }
                                                if ($s_ability2 == "") {
                                                    $ability2 = "-";
                                                }
                                                if ($s_ability3 == "") {
                                                    $ability3 = "-";
                                                }
                                                ?>
                                                <th>ความสามรถพิเศษ1 : <a style="color:black;"><?= $ability1 ?><br></a></th>
                                                <th>ความสามรถพิเศษ2 : <a style="color:black;"><?= $ability2 ?><br></a></th>
                                                <th>ความสามรถพิเศษ3 : <a style="color:black;"><?= $ability3 ?><br></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <th>ภูมิลำเนาเดิม : <a style="color:black;"><?= $s_No1 ?> หมู่ <?= $s_village1 ?> ถนน <?= $s_road1 ?></a></th>
                                                <th><a style="color:black;">ตำบล<?= $district_name_th ?> อำเภอ<?= $amphures_name_th ?> จังหวัด<?= $provinces_name_th ?> รหัสไปรษณีย์ <?= $zip_code ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <th>ที่อยู่ปัจจุบัน : <a style="color:black;"><?= $s_No2 ?> หมู่ <?= $s_village2 ?> ถนน <?= $s_road2 ?></a></th>
                                                <th><a style="color:black;">ตำบล<?= $district_name_th2 ?> อำเภอ<?= $amphures_name_th2 ?> จังหวัด<?= $provinces_name_th2 ?> รหัสไปรษณีย์ <?= $zip_code2 ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <th>ชื่อ-นามสกุลเพื่อนสนิท : <a style="color:black;"><?= $s_frina ?>  เบอร์โทร : <a style="color:black;"><?= $s_ftel ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <th>ที่อยู่เพื่อนสนิท : <a style="color:black;"><?= $s_friadd ?></a></th>
                                                <th><a style="color:black;">ตำบล<?= $district_name_th3 ?> อำเภอ<?= $amphures_name_th3 ?> จังหวัด<?= $provinces_name_th3 ?> รหัสไปรษณีย์ <?= $zip_code3 ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                </div>
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
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">คำเตือน!</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">คุณต้องการออกจากระบบใช่หรือไม่?</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                        <a class="btn btn-primary" href="../../logout.php">ออกจากระบบ</a>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
        <!-- <script src="<?= $baseURL ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
        <script src="<?= $baseURL ?>/js/sb-admin-2.min.js"></script>
        <script src="<?= $baseURL ?>/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= $baseURL ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
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