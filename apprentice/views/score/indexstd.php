<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $type = $_SESSION["type"];

    $r_term = $_GET["r_term"];
    $s_group = $_GET["s_group"];
    $pe_semester = $_GET["pe_semester"];
    $br_id = $_GET["id"];

    $sql1 = "SELECT SUBSTR(student.s_id,1,2) As id
            FROM student 
            LEFT JOIN petition ON petition.s_id  = student.s_id  
            where petition.pe_semester ='$pe_semester' and student.s_group ='$s_group' and student.br_id = '$br_id'
            GROUP by id";
    $result1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_array($result1);
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
        <title>ข้อมูลผลการฝึกงาน</title>

        <?php include("../../head.php"); ?>
    </head>

    <body id="page-top">

        <div id="wrapper">
            <?php include("../../sidebar_login.php"); ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php"); ?>
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="indexsub.php">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="index.php?id=<?= $br_id ?>">รายงานข้อมูลผลการฝึกงาน</a></li>
                            <li class="breadcrumb-item active">ข้อมูลผลการฝึกงาน</li>
                        </ol>
                    </div>
                    <div class="table-responsive">
                        <form action="sqlscore.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                            <div class="container text-dark " style="width: 100%; height: auto;">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <h4 class="text-dark"><i class="fa fa-file" aria-hidden="true"></i> ข้อมูลผลการฝึกงาน </h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered " style="border-color: black;" id="data" style="width: 100%;">
                                                <thead>
                                                    <tr style="text-align: center;background-color:#DFF3F7;" class="text-dark">
                                                        <td width="15%">#</td>
                                                        <td width="20%">ชื่อสกุล</td>
                                                        <td width="15%">คะแนนจากสมุด(20)</td>
                                                        <td width="25%">คะแนนจากสถานประกอบการ(60)</td>
                                                        <td width="15%">คะแนนนิเทศ(20)</td>
                                                        <td width="15%">รวม(100)</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $query = "SELECT branch.*,student.*,petition.*,results.*
                                                    FROM student 
                                                    LEFT JOIN branch ON student.br_id  = branch.br_id
                                                    LEFT JOIN petition ON petition.s_id  = student.s_id  
                                                    LEFT JOIN results ON results.pe_id  = petition.pe_id 
                                                    where petition.pe_semester ='$pe_semester' and student.s_group ='$s_group' 
                                                    and results.r_term='$r_term' and branch.br_id = '$br_id'
                                                    Order by student.s_id";
                                                    $result = mysqli_query($conn, $query);
                                                    $total = mysqli_num_rows($result);
                                                    if ($total != 0) {
                                                        $i = 0;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            $i++; ?>
                                                            <script language="javascript">
                                                                var int1 = document.getElementById('r_ework<?= $i; ?>').value;
                                                                var int2 = document.getElementById('r_ecompany<?= $i; ?>').value;
                                                                var int3 = document.getElementById('r_esupervision<?= $i; ?>').value;
                                                                var sum = ((int1 * 1) + (int2 * 1) + (int3 * 1)).toFixed();
                                                                document.form1.sum<?= $i; ?>.value = sum;

                                                                function nStr<?= $i; ?>() {
                                                                    var int1 = document.getElementById('r_ework<?= $i; ?>').value;
                                                                    var int2 = document.getElementById('r_ecompany<?= $i; ?>').value;
                                                                    var int3 = document.getElementById('r_esupervision<?= $i; ?>').value;
                                                                    if (int1 > 20 || int2 > 60) {
                                                                        if (int1 > 20) {
                                                                            eval("document.form1.r_ework<?= $i; ?>.value=''");
                                                                            var sum = ((int1 * 0) + (int2 * 1) + (int3 * 1)).toFixed();
                                                                            document.form1.sum<?= $i; ?>.value = sum;
                                                                            alert("คุณใส่จำนวนเกิน !  " + int1 + "   โปรดทำรายการอีกครั้ง !!");
                                                                        }
                                                                        if (int2 > 60) {
                                                                            eval("document.form1.r_ecompany<?= $i; ?>.value=''");
                                                                            var sum = ((int1 * 1) + (int2 * 0) + (int3 * 1)).toFixed();
                                                                            document.form1.sum<?= $i; ?>.value = sum;
                                                                            alert("คุณกรอกคะแนนเกิน !  " + int2 + "   โปรดทำรายการอีกครั้ง !!");
                                                                        }
                                                                    } else {
                                                                        var sum = ((int1 * 1) + (int2 * 1) + (int3 * 1)).toFixed();
                                                                        document.form1.sum<?= $i; ?>.value = sum;
                                                                    }
                                                                }
                                                            </script>
                                                            <tr class="text-dark" style="text-align: center;">
                                                                <input name="s_id<?= $i; ?>" type="hidden" id="s_id" value="<?= $row['s_id']; ?>">
                                                                <input name="r_id<?= $i; ?>" type="hidden" id="r_id" value="<?= $row['r_id']; ?>">
                                                                <input name="br_id" type="hidden" id="br_id" value="<?= $br_id ?>">
                                                                <input name="r_term" type="hidden" id="r_term" value="<?= $r_term ?>">
                                                                <input name="pe_semester" type="hidden" id="pe_semester" value="<?= $pe_semester ?>">
                                                                <input name="s_group" type="hidden" id="s_group" value="<?= $s_group ?>">
                                                                <td><?php echo $row['s_id']; ?></td>
                                                                <td style="text-align: left;">
                                                                    <?php echo $row['s_fna'] ?>&nbsp;<?php echo $row['s_lna']; ?>
                                                                </td>
                                                                <td><input name="r_ework<?= $i ?>" id="r_ework<?= $i ?>" value="<?php echo $row['r_ework'] ?>" onkeyup="nStr<?= $i ?>()" maxlength="2" class="form-control" placeholder="-กรุณาใส่คะแนน-" onkeypress="isInputNumber(event)" type="text">
                                                                </td>
                                                                <td><input name="r_ecompany<?= $i ?>" id="r_ecompany<?= $i ?>" value="<?php echo $row['r_ecompany'] ?>" onkeyup="nStr<?= $i ?>()" maxlength="2" class="form-control" placeholder="-กรุณาใส่คะแนน-" onkeypress="isInputNumber(event)" type="text"></td>
                                                                <td><input name="r_esupervision<?= $i ?>" id="r_esupervision<?= $i ?>" value="<?php echo $row['r_esupervision'] ?>" readonly class="form-control" onkeypress="isInputNumber(event)" type="text" required></td>
                                                                <td><input name="sum<?= $i ?>" id="sum<?= $i ?>" value="<?= $row['sum'] ?>" readonly value="" class="form-control" type="text"></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else { ?>
                                                        <td style="padding:16px;text-align:center;" colspan="6">ไม่มีข้อมูล<br>กรุณาตรวจสอบ ข้อมูลการนิเทศนักศึกษา</td>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <div class="footer d-flex justify-content-center">
                                                <input type="hidden" name="hdnLine" value="<?= $i ?>">
                                                <button class="btn btn-success btn-lg" type="submit" name="btnsave" id="btnsave" value="บันทึก">บันทึก</button>&nbsp;
                                                <button class="btn btn-danger btn-lg" type="reset" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button>
                                                <!-- <button class="btn btn-danger" type="reset" onclick="window.history.back()" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br>
                        <?php
                        if ($total != 0) { ?>
                            <div class="d-flex justify-content-center">
                                <a href="indexpdf.php?br_id=<?= $br_id ?>&id=<?= $row1['id'] ?>&s_group=<?= $s_group ?>&pe_semester=<?= $pe_semester ?>&r_term=<?= $r_term ?>"><button  class="btn btn-primary btn-lg fa fas-plus float-left "><i class="fa fa-print" aria-hidden="true"></i>รายงายผลประเมินคะแนนการฝึกงาน</button></a>
                            </div>
                        <?php } ?>
                    </div>
                    </table>
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