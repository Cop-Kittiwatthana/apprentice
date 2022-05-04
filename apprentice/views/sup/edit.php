<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $type = $_SESSION["type"];

    $s_id = $_GET["s_id"];
    $su_term = $_GET["su_term"];
    $year = $_GET["year"];

    $query = "SELECT student.s_fna,student.s_lna,company.c_na,branch.*,petition.pe_semester
    FROM supervision 
    LEFT JOIN petition ON supervision.pe_id  = petition.pe_id
    LEFT JOIN student ON petition.s_id  = student.s_id 
    LEFT JOIN sup_instructor ON sup_instructor.s_id  = student.s_id
    LEFT JOIN branch ON student.br_id  = branch.br_id  
    LEFT JOIN demand ON petition.de_id  = demand.de_id 
    LEFT JOIN company ON demand.c_id  = company.c_id  
    where student.s_id = '$s_id' 
    GROUP BY student.s_id";
    $result = mysqli_query($conn, $query) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {
        $s_fna = $row['s_fna'];
        $s_lna = $row['s_lna'];
        $c_na = $row['c_na'];
        $br_id = $row['br_id'];
        $br_na = $row['br_na'];
        $pe_semester = $row['pe_semester'];
    }

    $query1 = "SELECT supervision.su_term,supervision.su_no,supervision.t_id
    FROM petition 
    INNER JOIN supervision ON petition.pe_id  = supervision.pe_id
    WHERE petition.s_id = '$s_id' ORDER BY supervision.su_no ASC";
    $result1 = mysqli_query($conn, $query1) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row1 = mysqli_fetch_array($result1)) {
        $num[] = $row1;
    }
    $su_term1 = $num[0]['su_term'];
    $su_term2 = $num[3]['su_term'];
    $su_no1 = $num[0]['su_no'];
    $su_no2 = $num[1]['su_no'];
    $su_no3 = $num[2]['su_no'];
    $su_no4 = $num[3]['su_no'];
    $su_no5 = $num[4]['su_no'];
    $su_no6 = $num[5]['su_no'];
    $t_id1 = $num[0]['t_id'];
    $t_id2 = $num[1]['t_id'];
    $t_id3 = $num[2]['t_id'];
    $t_id4 = $num[3]['t_id'];
    $t_id5 = $num[4]['t_id'];
    $t_id6 = $num[5]['t_id'];

?>
    <?php
    //เทอม1
    if (($su_no1 == 1 && $t_id1 == "") && ($su_no2 == 2 && $t_id2 == "") && ($su_no3 == 3 && $t_id3 == "")) {
        $su_term = $su_term1;
        $su_no = $su_no1;
    }
    if (($su_no1 == 1 && $t_id1 != "") && ($su_no2 == 2 && $t_id2 == "") && ($su_no3 == 3 && $t_id3 == "")) {
        $su_term = $su_term1;
        $su_no = $su_no2;
    }
    if (($su_no1 == 1 && $t_id1 != "") && ($su_no2 == 2 && $t_id2 != "") && ($su_no3 == 3 && ($t_id3 == "" || $t_id3 != ""))) {
        $su_term = $su_term1;
        $su_no = $su_no3;
    }
    //เทอม2
    if (($t_id1 != "") && ($t_id2 != "") && ($t_id3 != "") && ($su_no4 == 4 && $t_id4 == "") && ($su_no5 == 5 && $t_id5 == "") && ($su_no6 == 6 && $t_id6 == "")) {
        $su_term = $su_term2;
        $su_no = $su_no4;
    }
    if (($su_no4 == 4 && $t_id4 != "") && ($su_no5 == 5 && $t_id5 == "") && ($su_no6 == 6 && $t_id6 == "")) {
        $su_term = $su_term2;
        $su_no = $su_no5;
    }
    if (($su_no4 == 4 && $t_id4 != "") && ($su_no5 == 5 && $t_id5 != "") && ($su_no6 == 6 && ($t_id6 == "" || $t_id6 != ""))) {
        $su_term = $su_term2;
        $su_no = $su_no6;
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
        <title>ข้อมูลอาจารย์นิเทศ</title>

        <?php include("../../head.php"); ?>
        <link rel="stylesheet" href="../../dist/css/choices.min.css">
        <script src="../../dist/js/choices.min.js"></script>
    </head>

    <body id="page-top">

        <div id="wrapper">
            <?php include("../../sidebar_login.php"); ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php"); ?>
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="indexsup.php?year=<?= $year ?>">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="indexstd.php?id=<?= $br_id ?>&year=<?= $pe_semester ?>">รายงานอาจารย์นิเทศ</a></li>
                            <li class="breadcrumb-item active">จัดการข้อมูลอาจารย์นิเทศ</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> จัดการข้อมูลอาจารย์นิเทศ</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <input type=hidden name="br_id" id="br_id" value="<?= $br_id ?>">
                            <input type=hidden name="pe_semester" id="pe_semester" value="<?= $pe_semester ?>">
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>อาจารย์นิเทศ :<a style="color:red;">*</a></th>
                                        <td>
                                            <select id="t_id" name="t_id[]" class="form-control" multiple size="2">
                                                <?php
                                                $query_teacher = "SELECT teacher.t_id,teacher.t_fna,teacher.t_lna,position.p_na,'ture' as status 
                                                from teacher 
                                                left join sup_instructor on teacher.t_id = sup_instructor.t_id
                                                left join position ON teacher.p_id = position.p_id
                                                WHERE sup_instructor.s_id = '$s_id' 
                                                GROUP BY teacher.t_id
                                                UNION SELECT  teacher.t_id,teacher.t_fna,teacher.t_lna,position.p_na,'false' as status
                                                from teacher 
                                                left join sup_instructor on teacher.t_id = sup_instructor.t_id
                                                left join position ON teacher.p_id = position.p_id
                                                WHERE   teacher.t_fna !='ผู้ดูแลระบบ' and teacher.t_lna !='สูงสุด' and teacher.t_id  not in 
                                                (SELECT sup_instructor.t_id  as status 
                                                from teacher 
                                                left join sup_instructor on teacher.t_id = sup_instructor.t_id
                                                left join position ON teacher.p_id = position.p_id
                                                WHERE sup_instructor.s_id = '$s_id')";
                                                $result_teacher = mysqli_query($conn, $query_teacher); ?>
                                                <?php while ($rs = mysqli_fetch_array($result_teacher)) {
                                                ?>
                                                    <option value="<?= $rs['t_id'] ?>" <?= $rs['status'] == "ture" ? 'selected' : '' ?>>
                                                        <?= $rs['t_fna'] ?> <?= $rs['t_lna'] ?> (<?= $rs['p_na'] ?>)</option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <th>รหัสนักศึกษา :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="s_id" id="s_id" maxlength="25" value="<?= $s_id ?>" readonly class="form-control" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-8">
                                        <th>ชื่อ-นามสกุล :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="s_fna" id="s_fna" maxlength="25" value="<?= $s_fna ?> <?= $s_lna ?>" readonly class="form-control" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-2">
                                        <th>เทอม :</th>
                                        <td style="text-align: center;">
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="su_term" id="su_term" value="<?= $su_term ?>" readonly class="form-control" type="text" required>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-2">
                                        <th>ครั้งที่ :</th>
                                        <td style="text-align: center;">
                                        <td>
                                            <div class="input-group mb-3">
                                                <?php if ($su_no == 4) {
                                                    $su_no = 1;
                                                }if ($su_no == 5) {
                                                    $su_no = 2;
                                                }if ($su_no == 6) {
                                                    $su_no = 3;
                                                } ?>
                                                <input name="su_no" id="su_no" value="<?= $su_no ?>" readonly class="form-control" type="text" required>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-8">
                                        <th>สาขา :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="br_na" id="br_na" value="<?= $br_na ?>" readonly class="form-control" type="text" required>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>สถานประกอบการ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="c_na" id="c_na" value="<?= $c_na ?>" readonly class="form-control" type="text" required>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                        </div>
                        <br>
                        <div class="footer d-flex justify-content-center">
                            <button class="btn btn-success btn-lg" type="submit" name="btnedit" id="btnedit" value="บันทึก">บันทึก</button>&nbsp;
                            <button class="btn btn-danger btn-lg" type="reset" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button>
                            <!-- <button class="btn btn-danger" type="reset" onclick="window.history.back()" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button> -->
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
    <script>
        $(document).ready(function() {
            var multipleCancelButton = new Choices('#t_id', {
                removeItemButton: true,
                maxItemCount: 2,
                minItemCount: 2,
                searchResultLimit: 5,
                //renderChoiceLimit: 5
            });
        });
    </script>

    </html>
<?php
} else {
    echo ("<script> alert('please login'); window.location='../../index.php';</script>");
    exit();
}
?>