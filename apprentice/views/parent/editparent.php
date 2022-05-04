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
        $district_id = "$row[district_id]";
        $amphure_id = $row['amphure_id'];
        $province_id = $row['province_id'];
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
        $district_id2 = $row2['district_id'];
        $amphure_id2 = $row2['amphure_id'];
        $province_id2 = $row2['province_id'];
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
        $district_id3 = $row3['district_id'];
        $amphure_id3 = $row3['amphure_id'];
        $province_id3 = $row3['province_id'];
        $zip_code3 = $row3['zip_code'];
    }


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
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="indexme.php?s_id=<?= $s_id ?>">ข้อมูลผู้ปกครอง</a></li>
                            <li class="breadcrumb-item active">แก้ไขข้อมูลผู้ปกครอง</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> แก้ไขข้อมูลผู้ปกครอง</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <input type=hidden name="s_id" id="s_id" value="<?= $s_id ?>">
                            <input type=hidden name="pa_status" id="pa_status" value="1">
                            <input type=hidden name="pa_status1" id="pa_status1" value="2">
                            <input type=hidden name="pa_status2" id="pa_status2" value="0">
                            <!-- <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>นักศึกษา :</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="s_na" id="s_na" value="<?= $s_na ?>" class="form-control" type="text" readonly>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr> -->
                            <br>
                            <h5 class="text-dark"><i class="fas fa-user-plus"></i> กรอกข้อมูลบิดา</h5>
                            <div class="card">
                                <div class="card-body">
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <th>คำนำหน้า :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <select class="form-control" name="pa_tna" id="pa_tna" required placeholder="-กรุณาเลือกคำนำหน้า-" oninvalid="this.setCustomValidity('-กรุณาเลือกคำนำหน้า-')" oninput="setCustomValidity('')">
                                                            <option value="" disabled>-กรุณาเลือก-</option>
                                                            <option value="0" <?= $pa_tna == 0 ? 'selected' : '' ?>>นาย</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-5">
                                                <th>ชื่อ :<a style="color:red;">*ภาษาไทย</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="pa_fna" id="pa_fna" maxlength="25" value="<?= $pa_fna ?>" class="form-control" placeholder="-กรุณาใส่ชื่อ-" onkeypress="isInputCharth(event)" required type="text">
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-5">
                                                <th>นามสกุล :<a style="color:red;">*ภาษาไทย</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="pa_lna" id="pa_lna" maxlength="25" value="<?= $pa_lna ?>" class="form-control" placeholder="-กรุณาใส่นามสกุล-" onkeypress="isInputCharth(event)" required type="text">
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <th>อายุ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="pa_age" id="pa_age" value="<?= $pa_age ?>" class="form-control" required placeholder="-กรุณาอายุ-" maxlength="2" onkeypress="isInputNumber(event)" type="text">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-de_num">ปี</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-8">
                                                <th>เบอร์โทร :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="pa_tel" id="pa_tel" value="<?= $pa_tel ?>" maxlength="10" class="form-control" placeholder="-กรุณาใส่เบอร์โทร-" onkeypress="isInputNumber(event)" required type="text">
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <th>อาชีพ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <textarea name="pa_career" id="pa_career" value="<?= $pa_career ?>" required class="form-control" placeholder="-กรุณาใส่ที่อยู่-" type="text"><?= $pa_add ?></textarea>
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-6">
                                                <th>ที่อยู่ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <textarea name="pa_add" id="pa_add" value="<?= $pa_add ?>" required class="form-control" placeholder="-กรุณาใส่ที่อยู่-" type="text"><?= $pa_add ?></textarea>
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
                                    </tr>
                                </div>
                            </div>
                            <br>
                            <h5 class="text-dark"><i class="fas fa-user-plus"></i> กรอกข้อมูลมารดา</h5>
                            <div class="card">
                                <div class="card-body">
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <th>คำนำหน้า :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <select class="form-control" name="pa_tna2" id="pa_tna2" required placeholder="-กรุณาเลือกคำนำหน้า-" oninvalid="this.setCustomValidity('-กรุณาเลือกคำนำหน้า-')" oninput="setCustomValidity('')">
                                                            <option value="" disabled >-กรุณาเลือก-</option>
                                                            <option value="1" <?= $pa_tna2 == 1 ? 'selected' : '' ?>>นาง</option>
                                                            <option value="2" <?= $pa_tna2 == 2 ? 'selected' : '' ?>>นางสาว</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-5">
                                                <th>ชื่อ :<a style="color:red;">*ภาษาไทย</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="pa_fna2" id="pa_fna2" maxlength="25" value="<?= $pa_fna2 ?>" class="form-control" placeholder="-กรุณาใส่ชื่อ-" onkeypress="isInputCharth(event)" required type="text">
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-5">
                                                <th>นามสกุล :<a style="color:red;">*ภาษาไทย</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="pa_lna2" id="pa_lna2" maxlength="25" value="<?= $pa_lna2 ?>" class="form-control" placeholder="-กรุณาใส่นามสกุล-" onkeypress="isInputCharth(event)" required type="text">
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <th>อายุ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="pa_age2" id="pa_age2" value="<?= $pa_age2 ?>" required class="form-control" require placeholder="-กรุณาอายุ-" maxlength="2" onkeypress="isInputNumber(event)" type="text">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-de_num">ปี</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-8">
                                                <th>เบอร์โทร :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="pa_tel2" id="pa_tel2" value="<?= $pa_tel2 ?>" maxlength="10" class="form-control" placeholder="-กรุณาใส่เบอร์โทร-" onkeypress="isInputNumber(event)" required type="text">
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <th>อาชีพ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <textarea name="pa_career2" id="pa_career2" value="<?= $pa_career2 ?>" required class="form-control" placeholder="-กรุณาใส่ที่อยู่-" type="text"><?= $pa_career2 ?></textarea>
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-6">
                                                <th>ที่อยู่ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <textarea name="pa_add2" id="pa_add2" value="<?= $pa_add2 ?>" required class="form-control" placeholder="-กรุณาใส่ที่อยู่-" type="text"><?= $pa_add2 ?></textarea>
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
                                                        <select class="form-control" name="provinces2" id="provinces2" required="" placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือก จังหวัด')" oninput="setCustomValidity('')">
                                                            <option value="" <?= $district_id2 == "" ? 'selected' : '' ?> disabled>-กรุณาเลือกจังหวัด-</option>
                                                            <?php foreach ($result_provinces as $value2) { ?>
                                                                <option value="<?= $value2['province_id'] ?>" <?= $value2['province_id'] == $province_id2 ? 'selected' : '' ?>>
                                                                    <?= $value2['provinces_name_th'] ?></option>
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
                                                            <?php foreach ($result_amphures2 as $value2) { ?>
                                                                <option value="<?= $value2['amphure_id'] ?>" <?= $value2['amphure_id'] == $amphure_id2 ? 'selected' : '' ?>>
                                                                    <?= $value2['amphures_name_th'] ?></option>
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
                                                            <?php foreach ($result_district2 as $value2) { ?>
                                                                <option value="<?= $value2['district_id'] ?>" <?= $value2['district_id'] == $district_id2 ? 'selected' : '' ?>>
                                                                    <?= $value2['district_name_th'] ?></option>
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
                                    </tr>
                                </div>
                            </div>
                            <br>
                            <h5 class="text-dark"><i class="fas fa-user-plus"></i> กรอกข้อมูลผู้ปกครอง</h5>
                            <div class="card">
                                <div class="card-body">
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <th>คำนำหน้า :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <select class="form-control" name="pa_tna3" id="pa_tna3"  required placeholder="-กรุณาเลือกคำนำหน้า-" oninvalid="this.setCustomValidity('-กรุณาเลือกคำนำหน้า-')" oninput="setCustomValidity('')">
                                                            <option value="" disabled>-กรุณาเลือก-</option>
                                                            <option value="0" <?= $pa_tna3 == 0 ? 'selected' : '' ?>>นาย</option>
                                                            <option value="1" <?= $pa_tna3 == 1 ? 'selected' : '' ?>>นาง</option>
                                                            <option value="2" <?= $pa_tna3 == 2 ? 'selected' : '' ?>>นางสาว</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-5">
                                                <th>ชื่อ :<a style="color:red;">*ภาษาไทย</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="pa_fna3" id="pa_fna3" maxlength="25" value="<?= $pa_fna3 ?>" class="form-control" placeholder="-กรุณาใส่ชื่อ-" onkeypress="isInputCharth(event)" required type="text">
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-5">
                                                <th>นามสกุล :<a style="color:red;">*ภาษาไทย</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="pa_lna3" id="pa_lna3" maxlength="25" value="<?= $pa_lna3 ?>" class="form-control" placeholder="-กรุณาใส่นามสกุล-" onkeypress="isInputCharth(event)" required type="text">
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <th>อายุ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="pa_age3" id="pa_age3" value="<?= $pa_age3 ?>" required class="form-control" require placeholder="-กรุณาอายุ-" maxlength="2" onkeypress="isInputNumber(event)" type="text">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-de_num">ปี</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-4">
                                                <th>ความสัมพันธ์ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="pa_relations3" id="pa_relations3" value="<?= $pa_relations3 ?>" class="form-control" placeholder="-กรุณาใส่ความสัมพันธ์-" onkeypress="isInputChar(event)" required type="text">
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-4">
                                                <th>เบอร์โทร :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input name="pa_tel3" id="pa_tel3" value="<?= $pa_tel3 ?>" maxlength="10" class="form-control" placeholder="-กรุณาใส่เบอร์โทร-" onkeypress="isInputNumber(event)" required type="text">
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <th>อาชีพ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <textarea name="pa_career3" id="pa_career3" required value="<?= $pa_career3 ?>" class="form-control" placeholder="-กรุณาใส่ที่อยู่-" type="text"><?= $pa_career3 ?></textarea>
                                                    </div>
                                                </td>
                                            </div>
                                            <div class="col-md-6">
                                                <th>ที่อยู่ :<a style="color:red;">*</a></th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <textarea name="pa_add3" id="pa_add3" required value="<?= $pa_add3 ?>" class="form-control" placeholder="-กรุณาใส่ที่อยู่-" type="text"><?= $pa_add3 ?></textarea>
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
                                                        <select class="form-control" name="provinces3" id="provinces3" required="" placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือก จังหวัด')" oninput="setCustomValidity('')">
                                                            <option value="" <?= $district_id3 == "" ? 'selected' : '' ?> disabled>-กรุณาเลือกจังหวัด-</option>
                                                            <?php foreach ($result_provinces as $value3) { ?>
                                                                <option value="<?= $value3['province_id'] ?>" <?= $value3['province_id'] == $province_id3 ? 'selected' : '' ?>>
                                                                    <?= $value3['provinces_name_th'] ?></option>
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
                                                            <?php foreach ($result_amphures3 as $value3) { ?>
                                                                <option value="<?= $value3['amphure_id'] ?>" <?= $value3['amphure_id'] == $amphure_id3 ? 'selected' : '' ?>>
                                                                    <?= $value3['amphures_name_th'] ?></option>
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
                                                            <?php foreach ($result_district3 as $value3) { ?>
                                                                <option value="<?= $value3['district_id'] ?>" <?= $value3['district_id'] == $district_id3 ? 'selected' : '' ?>>
                                                                    <?= $value3['district_name_th'] ?></option>
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
                                    </tr>
                                </div>
                            </div>
                            <br>
                            <div class="footer d-flex justify-content-center">
                                <button class="btn btn-success btn-lg" type="submit" name="editparent" id="editparent" value="บันทึก">บันทึก</button>&nbsp;
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
<?php include("../script.php"); ?>
<?php include("../script2.php"); ?>
<?php include("../script3.php"); ?>