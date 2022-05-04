<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $s_id = $_GET['s_id'];
    $query = "SELECT student.*,districts.*, amphures.*, provinces.* FROM student 
    LEFT JOIN districts ON student.district_id1 = districts.district_id 
    LEFT JOIN amphures ON districts.amphure_id = amphures.amphure_id
    LEFT JOIN provinces ON amphures.province_id = provinces.province_id
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
        $district_id = $row['district_id1'];
        $amphure_id = $row['amphure_id'];
        $province_id = $row['province_id'];
        $zip_code = $row['zip_code'];
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
        $district_id2 = $row2['district_id2'];
        $amphure_id2 = $row2['amphure_id'];
        $province_id2 = $row2['province_id'];
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
        $district_id3 = $row3['district_id3'];
        $amphure_id3 = $row3['amphure_id'];
        $province_id3 = $row3['province_id'];
        $zip_code3 = $row3['zip_code'];
    }

    $query_branch = "SELECT department.*,branch.* FROM department inner JOIN branch ON department.dp_id = branch.dp_id";
    $result_branch = mysqli_query($conn, $query_branch);

    $query_position = "SELECT * FROM position";
    $result_position = mysqli_query($conn, $query_position);

    $query_provinces = "SELECT * FROM provinces";
    $result_provinces = mysqli_query($conn, $query_provinces);

    $query_amphures = "SELECT * FROM amphures WHERE province_id=$province_id";
    $result_amphures = mysqli_query($conn, $query_amphures);

    $query_district = "SELECT * FROM districts WHERE amphure_id=$amphure_id";
    $result_district = mysqli_query($conn, $query_district);

    $query_amphures2 = "SELECT * FROM amphures WHERE province_id=$province_id2";
    $result_amphures2 = mysqli_query($conn, $query_amphures2);

    $query_district2 = "SELECT * FROM districts WHERE amphure_id=$amphure_id2";
    $result_district2 = mysqli_query($conn, $query_district2);

    $query_amphures3 = "SELECT * FROM amphures WHERE province_id=$province_id3";
    $result_amphures3 = mysqli_query($conn, $query_amphures3);

    $query_district3 = "SELECT * FROM districts WHERE amphure_id=$amphure_id3";
    $result_district3 = mysqli_query($conn, $query_district3);

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
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="indexme.php?s_id=<?= $s_id ?>">ข้อมูลส่วนตัวนักศึกษา</a></li>
                            <li class="breadcrumb-item active">แก้ไขข้อมูลนักศึกษา</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> ข้อมูลส่วนตัวนักศึกษา</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 70%; height: auto;">
                            <br>
                            <div class="card">
                                <div class="card-body">
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <th>รหัสนักศึกษา/ชื่อผู้ใช้ :</th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_id" id="s_id" value="<?= $s_id ?>" class="form-control" maxlength="10" onkeypress="isInputNumber(event)" readonly type="text">
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-6">
                                                <th>รหัสผ่าน :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3" id="test">
                                                        <input name="s_pass" id="s_pass" value="<?= $s_pass ?>" class="form-control pwd" placeholder="-กรุณาใส่รหัสผ่าน-" onkeypress="isInputPassword(event)" required type="password">
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
                                            <div class="col-md-8">
                                                <th>แผนก-สาขา :</th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <select class="form-control" name="br_id" id="br_id" disabled placeholder="-กรุณาเลือกแผนก-สาขา-" oninvalid="this.setCustomValidity('-กรุณาเลือกแผนก-สาขา-')" oninput="setCustomValidity('')">
                                                            <option value="0" <?= $br_id == 0 ? 'selected' : '' ?> disabled>-กรุณาเลือกแผนก-สาขา-</option>
                                                            <?php foreach ($result_branch as $value) { ?>
                                                                <option value="<?= $value['br_id'] ?>" <?= $value['br_id'] == $br_id ? 'selected' : '' ?>>
                                                                    <?= $value['dp_na'] ?>-<?= $value['br_na'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-4">
                                                <th>กลุ่ม :</th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_group" id="s_group" value="<?= $s_group ?>" class="form-control" readonly placeholder="-กรุณาใส่เลขกลุ่มที่/ห้องที่-" type="text">
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <th>คำนำหน้า :</th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <select class="form-control" name="s_tna" id="s_tna" disabled placeholder="-กรุณาเลือกคำนำหน้า-" oninvalid="this.setCustomValidity('-กรุณาเลือกคำนำหน้า-')" oninput="setCustomValidity('')">
                                                            <option value="" disabled>-กรุณาเลือก-</option>
                                                            <option value="0" <?= $t_tna == 0 ? 'selected' : '' ?>>นาย</option>
                                                            <option value="1" <?= $t_tna == 1 ? 'selected' : '' ?>>นาง</option>
                                                            <option value="2" <?= $t_tna == 2 ? 'selected' : '' ?>>นางสาว</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-5">
                                                <th>ชื่อ :</th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_fna" id="s_fna" maxlength="25" value="<?= $s_fna ?>" readonly class="form-control" placeholder="-กรุณาใส่ชื่อ-" onkeypress="isInputCharth(event)" required type="text">
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-5">
                                                <th>นามสกุล :</th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_lna" id="s_lna" maxlength="25" value="<?= $s_lna ?>" readonly class="form-control" placeholder="-กรุณาใส่นามสกุล-" onkeypress="isInputCharth(event)" required type="text">
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <th>วันเกิด :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input class="form-control" placeholder="กรุณาเลือก ว/ด/ป " required value="<?= $s_bdate ?>" autocomplete="off" type="text" name="s_bdate" id="s_bdate" />
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-4">
                                                <th>อายุ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_age" id="s_age" value="<?= $s_age ?>" class="form-control" required placeholder="-กรุณาอายุ-" maxlength="2" onkeypress="isInputNumber(event)" type="text">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-de_num">ปี</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <th>เบอร์ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_tel" id="s_tel" value="<?= $s_tel ?>" required maxlength="10" class="form-control" maxlength="10" require placeholder="-กรุณาใส่เบอร์-" onkeypress="isInputNumber(event)" type="text">
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-6">
                                                <th>อีเมล์ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_mail" id="s_mail" value="<?= $s_mail ?>" required class="form-control" placeholder="-กรุณาใส่อีเมล์-" type="text">
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <th>ส่วนสูง :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_height" id="s_height" value="<?= $s_height ?>" class="form-control" required placeholder="-กรุณาใส่ส่วนสูง-" onkeypress="isInputNumber2(event)" type="text">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-de_num">เซนติเมตร</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-4">
                                                <th>น้ำหนัก :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_weight" id="s_weight" value="<?= $s_weight ?>" required class="form-control" placeholder="-กรุณาใส่น้ำหนัก-" onkeypress="isInputNumber2(event)" type="text">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-de_num">กิโลกรัม</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-4">
                                                <th>กรุ็ปเลือด :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <select class="form-control" name="s_lbood" id="s_lbood" required placeholder="-กรุณาเลือกกรุ็ปเลือด-" oninvalid="this.setCustomValidity('-กรุณาเลือกคำนำหน้า-')" oninput="setCustomValidity('')">
                                                            <option value="" <?= $s_lbood == "" ? 'selected' : '' ?> disabled>-กรุณาเลือก-</option>
                                                            <option value="0" <?= $s_lbood == 0 ? 'selected' : '' ?>>A</option>
                                                            <option value="1" <?= $s_lbood == 1 ? 'selected' : '' ?>>B</option>
                                                            <option value="2" <?= $s_lbood == 2 ? 'selected' : '' ?>>AB</option>
                                                            <option value="3" <?= $s_lbood == 3 ? 'selected' : '' ?>>O</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <th>สัญชาติ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_nation" id="s_nation" value="<?= $s_nation ?>" required class="form-control" placeholder="-กรุณาใส่สัญชาติ-" onkeypress="isInputCharth(event)" type="text">
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-4">
                                                <th>เชื้อชาติ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_race" id="s_race" value="<?= $s_race ?>" required class="form-control" require placeholder="-กรุณาใส่เชื้อชาติ-" onkeypress="isInputCharth(event)" type="text">
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-4">
                                                <th>ศาสนา :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_cult" id="s_cult" value="<?= $s_cult ?>" required class="form-control" placeholder="-กรุณาใส่ศาสนา-" onkeypress="isInputCharth(event)" type="text">
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <th>โรคประจำตัว :<a style="color:red;">ไม่มีกรุณาใส่ - </a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <textarea name="s_disease" id="s_disease" required class="form-control" placeholder="-กรุณาใส่โรคประจำตัว(ถ้ามี)-" type="text"><?= $s_disease ?></textarea>
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-6">
                                                <th>ยาที่แพ้ :<a style="color:red;">ไม่มีกรุณาใส่ - </a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <textarea name="s_drug" id="s_drug" class="form-control" required placeholder="-กรุณาใส่ยาที่แพ้(ถ้ามี)-" type="text"><?= $s_drug ?></textarea>
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-2">
                                            </div>
                                            <div class="col-md-8">
                                                <th>คะแนนเฉลี่ยภาคเรียนสุดท้าย :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_points" id="s_points" value="<?= $s_points ?>" class="form-control" required placeholder="-กรุณาใส่คะแนนเฉลี่ยภาคเรียนสุดท้าย-" onkeypress="isInputNumber2(event)" type="text">
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-2">
                                            </div>
                                            <div class="col-md-8">
                                                <th>ความสามรถพิเศษ :</th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_ability1" id="s_ability1" value="<?= $s_ability1 ?>" class="form-control" placeholder="-กรุณาใส่ความสามรถพิเศษ-" onkeypress="isInputCharth(event)" type="text">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_ability2" id="s_ability2" value="<?= $s_ability2 ?>" class="form-control" placeholder="-กรุณาใส่ความสามรถพิเศษ-" onkeypress="isInputCharth(event)" type="text">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_ability3" id="s_ability3" value="<?= $s_ability3 ?>" class="form-control" placeholder="-กรุณาใส่ความสามรถพิเศษ-" onkeypress="isInputCharth(event)" type="text">
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                    </tr>
                                </div>
                            </div>
                            <br>
                            <tr>
                                <th>ภูมิลำเนาเดิม :</th>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <th>บ้านเลขที่ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_No1" id="s_No1" value="<?= $s_No1 ?>" required class="form-control" placeholder="-กรุณาใส่ที่อยู่-" onkeypress="isInputNumber2(event)" type="text">
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-4">
                                                <th>หมู่ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_village1" id="s_village1" value="<?= $s_village1 ?>" required class="form-control" placeholder="-กรุณาใส่ที่อยู่-" onkeypress="isInputNumber2(event)" type="text">
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-4">
                                                <th>ถนน :<a style="color:red;">ไม่มีกรุณาใส่ - </a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_road1" id="s_road1" value="<?= $s_road1 ?>" required class="form-control" placeholder="-กรุณาใส่ที่อยู่-" onkeypress="isInputChar2(event)" type="text">
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <th>จังหวัด :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <select class="form-control" name="provinces" id="provinces" required="" placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือก จังหวัด')" oninput="setCustomValidity('')">
                                                            <option value="" <?= $district_id == "" ? 'selected' : '' ?> disabled>-กรุณาเลือกจังหวัด-</option>
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
                                                            <option value="" <?= $district_id == "" ? 'selected' : '' ?> disabled>-กรุณาเลือกอำเภอ-</option>
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
                                                            <option value="" <?= $district_id == "" ? 'selected' : '' ?> disabled>-กรุณาเลือกตำบล-</option>
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
                                                        <input type="text" name="zip_code" id="zip_code" class="form-control" value="<?= $zip_code ?>" readonly>
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            <br>
                            <tr>
                                <th>ที่อยู่ปัจจุบัน :</th>
                                <div class="card">
                                    <div class="card-body" value="บ้านเลขที่">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <td>
                                                    <input type="checkbox" name="chk" id="chk" onClick="copy()" />ใช้ที่อยู่เดียวกันกับข้อมูลภูมิลำเนา
                                                    <!-- <input type="checkbox" name="chkColor1" value="chkColor1">ใช้ที่อยู่เดียวกันกับข้อมูลภูมิลำเนา -->
                                                </td>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <th>บ้านเลขที่ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_No2" id="s_No2" value="<?= $s_No2 ?>" required class="form-control" placeholder="-กรุณาใส่ที่อยู่-" onkeypress="isInputNumber2(event)" type="text">
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-4">
                                                <th>หมู่ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_village2" id="s_village2" value="<?= $s_village2 ?>" required class="form-control" placeholder="-กรุณาใส่ที่อยู่-" onkeypress="isInputNumber2(event)" type="text">
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-4">
                                                <th>ถนน :<a style="color:red;">ไม่มีกรุณาใส่ - </a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_road2" id="s_road2" value="<?= $s_road2 ?>" required class="form-control" placeholder="-กรุณาใส่ที่อยู่-" onkeypress="isInputChar2(event)" type="text">
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <th>จังหวัด :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <select class="form-control" name="provinces2" id="provinces2" required="" placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือก จังหวัด')" oninput="setCustomValidity('')">
                                                            <option value="" <?= $district_id2 == "" ? 'selected' : '' ?> disabled>-กรุณาเลือกจังหวัด-</option>
                                                            <?php foreach ($result_provinces as $value) { ?>
                                                                <option value="<?= $value['province_id'] ?>" <?= $value['province_id'] == $province_id2 ? 'selected' : '' ?>>
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
                                                        <select class="form-control" name="amphures2" id="amphures2" required="" placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือก อำเภอ')" oninput="setCustomValidity('')">
                                                            <option value="" <?= $district_id2 == "" ? 'selected' : '' ?> disabled>-กรุณาเลือกอำเภอ-</option>
                                                            <?php foreach ($result_amphures2 as $value) { ?>
                                                                <option value="<?= $value['amphure_id'] ?>" <?= $value['amphure_id'] == $amphure_id2 ? 'selected' : '' ?>>
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
                                                        <select class="form-control" name="districts2" id="districts2" required="" placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือก ตำบล')" oninput="setCustomValidity('')">
                                                            <option value="" <?= $district_id2 == "" ? 'selected' : '' ?> disabled>-กรุณาเลือกตำบล-</option>
                                                            <?php foreach ($result_district2 as $value) { ?>
                                                                <option value="<?= $value['district_id'] ?>" <?= $value['district_id'] == $district_id2 ? 'selected' : '' ?>>
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
                                                        <input type="text" name="zip_code2" id="zip_code2" class="form-control" value="<?= $zip_code2 ?>" readonly>
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            <br>
                            <tr>
                                <th>เพื่อนสนิท :</th>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <th>ชื่อ-นามสกุล :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_frina" id="s_frina" value="<?= $s_frina ?>" required class="form-control" placeholder="-กรุณาใส่ที่อยู่-" onkeypress="isInputCharth(event)" type="text">
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-4">
                                                <th>เบอร์โทร :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_ftel" id="s_ftel" value="<?= $s_ftel ?>" required maxlength="10" class="form-control" placeholder="-กรุณาใส่ที่อยู่-" onkeypress="isInputNumber(event)" type="text">
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-4">
                                                <th>ที่อยู่ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="s_friadd" id="s_friadd" value="<?= $s_friadd ?>" required class="form-control" placeholder="-กรุณาใส่ที่อยู่-" type="text">
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <th>จังหวัด :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <select class="form-control" name="provinces3" id="provinces3" required="" placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือก จังหวัด')" oninput="setCustomValidity('')">
                                                            <option value="" <?= $district_id3 == "" ? 'selected' : '' ?> disabled>-กรุณาเลือกจังหวัด-</option>
                                                            <?php foreach ($result_provinces as $value) { ?>
                                                                <option value="<?= $value['province_id'] ?>" <?= $value['province_id'] == $province_id3 ? 'selected' : '' ?>>
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
                                                        <select class="form-control" name="amphures3" id="amphures3" required="" placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือก อำเภอ')" oninput="setCustomValidity('')">
                                                            <option value="" <?= $district_id3 == "" ? 'selected' : '' ?> disabled>-กรุณาเลือกอำเภอ-</option>
                                                            <?php foreach ($result_amphures3 as $value) { ?>
                                                                <option value="<?= $value['amphure_id'] ?>" <?= $value['amphure_id'] == $amphure_id3 ? 'selected' : '' ?>>
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
                                                        <select class="form-control" name="districts3" id="districts3" required="" placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือก ตำบล')" oninput="setCustomValidity('')">
                                                            <option value="" <?= $district_id3 == "" ? 'selected' : '' ?> disabled>-กรุณาเลือกตำบล-</option>
                                                            <?php foreach ($result_district3 as $value) { ?>
                                                                <option value="<?= $value['district_id'] ?>" <?= $value['district_id'] == $district_id3 ? 'selected' : '' ?>>
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
                                                        <input type="text" name="zip_code3" id="zip_code3" class="form-control" value="<?= $zip_code3 ?>" readonly>
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            <br>
                            <div class="footer d-flex justify-content-center">
                                <button class="btn btn-success btn-lg" type="submit" name="btneditme" id="btneditme" value="บันทึก">บันทึก</button>&nbsp;
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
<script language="javascript">
    function copy() {
        var frm = document.form1;
        var s_No = frm.s_No1.value;
        var s_village = frm.s_village1.value;
        var s_road = frm.s_road1.value;
        var provinces = frm.provinces.value;
        var amphures = frm.amphures.value;
        var districts = frm.districts.value;
        var zip_code = frm.zip_code.value;
        if (frm.s_No1.value == '') s_No = 0;
        frm.s_No2.value = s_No;
        if (frm.s_village1.value == '') s_village = 0;
        frm.s_village2.value = s_village;
        if (frm.s_road1.value == '') s_road = 0;
        frm.s_road2.value = s_road;
        if (frm.provinces.value == '') provinces = 0;
        frm.provinces2.value = '';
        if (frm.amphures.value == '') amphures = 0;
        frm.amphures2.value = '';
        if (frm.districts.value == '') districts = 0;
        frm.districts2.value = '';
        if (frm.zip_code.value == '') zip_code = 0;
        frm.zip_code2.value = '';
    }
</script>
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
<?php include("../script.php"); ?>
<?php include("../script2.php"); ?>
<?php include("../script3.php"); ?>