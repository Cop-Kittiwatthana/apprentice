<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];

    $s_id = $_GET["s_id"];
    $query2 = "SELECT * FROM teacher WHERE t_user = '$username' and t_pass = '$password'";
    $result2 = mysqli_query($conn, $query2);
    while ($row2 = mysqli_fetch_array($result2)) {
        $t_id3 = $row2['t_id'];
        $type2 = $row2['type'];
    }
    $query3 = "SELECT sup_instructor.t_id
    FROM sup_instructor 
    where  sup_instructor.s_id='$s_id'";
    $result3 = mysqli_query($conn, $query3);
    while ($row3 = mysqli_fetch_array($result3)) {
        $num[] = $row3;
    }
    $t_id1 = $num[0]['t_id'];
    $t_id2 = $num[1]['t_id'];


    $query = "SELECT company.*,petition.*,student.*
    FROM petition 
    LEFT JOIN demand ON petition.de_id  = demand.de_id 
    LEFT JOIN company ON demand.c_id  = company.c_id 
    LEFT JOIN student ON petition.s_id  = student.s_id  
    where  petition.s_id='$s_id'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $s_tna = "$row[s_tna]";
        $s_fna = "$row[s_fna]";
        $s_lna = "$row[s_lna]";
        // $pe_semester = "$row[pe_semester]";
    }
    if ($s_tna == 0) {
        $s_tna = "นาย";
    }
    if ($s_tna == 1) {
        $s_tna = "นาง";
    }
    if ($s_tna == 2) {
        $s_tna = "นางสาว";
    }

    $br_id = $_GET["br_id"];
    $year = $_GET["year"];

    $query5 = "SELECT supervision.*
    FROM petition 
    INNER JOIN supervision ON petition.pe_id  = supervision.pe_id
    WHERE petition.s_id = '$s_id' ORDER BY supervision.su_no ASC";
    $result5 = mysqli_query($conn, $query5) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row5 = mysqli_fetch_array($result5)) {
        $num5[] = $row5;
    }
    $su_no1 = $num5[0]['su_no'];
    $su_no2 = $num5[1]['su_no'];
    $su_no3 = $num5[2]['su_no'];
    $su_no4 = $num5[3]['su_no'];
    $su_no5 = $num5[4]['su_no'];
    $su_no6 = $num5[5]['su_no'];
    $su_score1 = $num5[0]['su_score'];
    $su_score2 = $num5[1]['su_score'];
    $su_score3 = $num5[2]['su_score'];
    $su_score4 = $num5[3]['su_score'];
    $su_score5 = $num5[4]['su_score'];
    $su_score6 = $num5[5]['su_score'];


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
        <title>ข้อมูลการนิเทศ</title>
        <?php include("../../head.php") ?>
    </head>

    <body id="page-top">
        <div id="wrapper">
            <?php include("../../sidebar_login.php") ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php") ?>
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php?year=<?= $year ?>">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="indexstd.php?id=<?= $br_id ?>&year=<?= $year ?>">จัดการข้อมูลอาจารย์นิเทส</a></li>
                            <li class="breadcrumb-item active">รายงานอาจารย์นิเทศ</li>
                        </ol>
                        <div class="card shadow mb-4">

                            <div class="card-body">
                                <h6 class="m-0 font-weight-bold text-dark" style="text-align: center;">
                                    <font size="6" face="TH SarabunPSK"> บันทึกนิเทศนักศึกษา</font>
                                </h6>
                                <h6 class="m-0 font-weight-bold text-dark" style="text-align: center;">
                                    <font size="6" face="TH SarabunPSK"> <?= $s_tna . '&nbsp;' . $s_fna . '&nbsp;' . $s_lna ?>
                                    </font>
                                </h6>
                                <?php
                                $query1 = "SELECT supervision.*,company.*
                                FROM supervision 
                                left JOIN petition ON supervision.pe_id  = petition.pe_id
                                left join teacher on supervision.t_id=teacher.t_id
                                left join demand on petition.de_id=demand.de_id
                                left join company on demand.c_id=company.c_id
                                left join sup_instructor on supervision.t_id = sup_instructor.t_id
                                WHERE petition.s_id = '$s_id' and supervision.su_no BETWEEN 1 AND 3
                                GROUP by supervision.su_no
                                order by supervision.su_no";
                                $result = mysqli_query($conn, $query1);
                                $result1 = mysqli_query($conn, $query1);
                                $result2 = mysqli_query($conn, $query1);
                                $rows1 = mysqli_fetch_array($result);
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $num4[] = $row2;
                                }
                                $t_id4 = $num4[2]['t_id'];
                                $c_na1 = $num4[2]['c_na'];
                                ?>
                                <h6 class="m-0 font-weight-bold text-dark" style="text-align: center;">
                                    <font size="6" face="TH SarabunPSK"> สถานประกอบการ <?= $c_na1 ?>
                                    </font>
                                </h6>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered " id="data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #f8f9fc;text-align: center;">เทอม/ครั้งที่</th>
                                                <th style="background-color: #f8f9fc;text-align: center;" width="50%">ข้อเสนอแนะ</th>
                                                <th style="background-color: #f8f9fc;text-align: center;">คะแนน</th>
                                                <th style="background-color: #f8f9fc;text-align:center;" width="200"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row3 = mysqli_fetch_array($result1)) { ?>
                                                <tr class="text-dark" style="text-align: center;">
                                                    <td><?php echo $row3['su_term']; ?>/<?php echo $row3['su_no']; ?></td>
                                                    <td class="name">
                                                        <?php if ($row3['su_suggestion'] == "") {
                                                            echo "<p style='color:red;'>ยังไม่ได้ประเมิน</p>";
                                                        } else {
                                                            echo "<p style='text-align: left;'>$row3[su_suggestion]</p>";
                                                        }  ?>
                                                    </td>
                                                    <td class="name">
                                                        <?php if ($row3['su_score'] == "") {
                                                            echo "<p style='color:red;'>ไม่มีคะแนน</p>";
                                                        } else {
                                                            echo $row3['su_score'];
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($row3['su_no'] == '1') {
                                                            if ($type2 == 0) {
                                                                echo "<a href=\"editstusup.php?pe_id=$row3[pe_id]&su_no=$row3[su_no]&c_id=$row3[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                                <?php  } else {
                                                                if ($row3['t_id'] == "") {
                                                                    if ($t_id1 == $t_id3 || $t_id2 == $t_id3) {
                                                                        echo "<a href=\"editstusup.php?pe_id=$row3[pe_id]&su_no=$row3[su_no]&c_id=$row3[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                                    <?php
                                                                    }
                                                                }
                                                                if ($row3['t_id'] != "") {
                                                                    if ($row3['t_id'] == "$t_id3") {
                                                                        echo "<a href=\"editstusup.php?pe_id=$row3[pe_id]&su_no=$row3[su_no]&c_id=$row3[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <!-- / -->
                                                        <?php if ($row3['su_no'] == '2' && $su_score1 != "") {
                                                            if ($type2 == 0) {
                                                                echo "<a href=\"editstusup.php?pe_id=$row3[pe_id]&su_no=$row3[su_no]&c_id=$row3[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                                <?php  } else {
                                                                if ($row3['t_id'] == "") {
                                                                    if ($t_id1 == $t_id3 || $t_id2 == $t_id3) {
                                                                        echo "<a href=\"editstusup.php?pe_id=$row3[pe_id]&su_no=$row3[su_no]&c_id=$row3[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                                    <?php
                                                                    }
                                                                }
                                                                if ($row3['t_id'] != "") {
                                                                    if ($row3['t_id'] == "$t_id3") {
                                                                        echo "<a href=\"editstusup.php?pe_id=$row3[pe_id]&su_no=$row3[su_no]&c_id=$row3[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <!-- / -->
                                                        <?php if ($row3['su_no'] == '3' && $su_score1 != "" && $su_score2 != "") {
                                                            if ($type2 == 0) {
                                                                echo "<a href=\"editstusup.php?pe_id=$row3[pe_id]&su_no=$row3[su_no]&c_id=$row3[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                                <?php  } else {
                                                                if ($row3['t_id'] == "") {
                                                                    if ($t_id1 == $t_id3 || $t_id2 == $t_id3) {
                                                                        echo "<a href=\"editstusup.php?pe_id=$row3[pe_id]&su_no=$row3[su_no]&c_id=$row3[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                                    <?php
                                                                    }
                                                                }
                                                                if ($row3['t_id'] != "") {
                                                                    if ($row3['t_id'] == "$t_id3") {
                                                                        echo "<a href=\"editstusup.php?pe_id=$row3[pe_id]&su_no=$row3[su_no]&c_id=$row3[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <!-- / -->
                                                    </td>
                                                </tr>
                                            <?php }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <?php
                                if ($t_id != "") {
                                    $query2 = "SELECT supervision.*,company.*
                                    FROM supervision 
                                    left JOIN petition ON supervision.pe_id  = petition.pe_id
                                    left join teacher on supervision.t_id=teacher.t_id
                                    left join demand on petition.de_id=demand.de_id
                                    left join company on demand.c_id=company.c_id
                                    left join sup_instructor on supervision.t_id = sup_instructor.t_id
                                    WHERE petition.s_id = '$s_id' and supervision.su_no BETWEEN 4 AND 6
                                    GROUP by supervision.su_no
                                    order by supervision.su_no";
                                    $result = mysqli_query($conn, $query2);
                                    $result3 = mysqli_query($conn, $query2);
                                    $result4 = mysqli_query($conn, $query2);
                                    $rows2 = mysqli_fetch_array($result);
                                    while ($row2 = mysqli_fetch_array($result3)) {
                                        $num6[] = $row2;
                                    }
                                    $t_id5 = $num6[2]['t_id'];
                                    $c_na2 = $num6[0]['c_na'];
                                    if ($rows2['c_na'] != "") {
                                ?>
                                        <h6 class="m-0 font-weight-bold text-dark" style="text-align: center;">
                                            <font size="6" face="TH SarabunPSK"> สถานประกอบการ <?= $c_na2 ?>
                                            </font>
                                        </h6>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-bordered " id="data" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="background-color: #f8f9fc;text-align: center;">เทอม/ครั้งที่</th>
                                                        <th style="background-color: #f8f9fc;text-align: center;" width="50%">ข้อเสนอแนะ</th>
                                                        <th style="background-color: #f8f9fc;text-align: center;">คะแนน</th>
                                                        <th style="background-color: #f8f9fc;text-align:center;" width="200"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    while ($row2 = mysqli_fetch_array($result4)) {
                                                        $i = $i+1;
                                                    ?>
                                                        <tr class="text-dark" style="text-align: center;">
                                                            <td><?php echo $row2['su_term']; ?>/<?php echo $i ?></td>
                                                            <td class="name">
                                                                <?php if ($row2['su_suggestion'] == "") {
                                                                    echo "<p style='color:red;'>ยังไม่ได้ประเมิน</p>";
                                                                } else {
                                                                    echo "<p style='text-align: left;'>$row2[su_suggestion]</p>";
                                                                }  ?>
                                                            </td>
                                                            <td class="name">
                                                                <?php if ($row2['su_score'] == "") {
                                                                    echo "<p style='color:red;'>ไม่มีคะแนน</p>";
                                                                } else {
                                                                    echo $row2['su_score'];
                                                                }  ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($row2['su_no'] == '4') {
                                                                    if ($type2 == 0) {
                                                                        echo "<a href=\"editstusup.php?pe_id=$row2[pe_id]&su_no=$row2[su_no]&c_id=$row2[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                                        <?php  } else {
                                                                        if ($row2['t_id'] == "") {
                                                                            if ($t_id1 == $t_id3 || $t_id2 == $t_id3) {
                                                                                echo "<a href=\"editstusup.php?pe_id=$row2[pe_id]&su_no=$row2[su_no]&c_id=$row2[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                                            <?php
                                                                            }
                                                                        }
                                                                        if ($row2['t_id'] != "") {
                                                                            if ($row2['t_id'] == "$t_id3") {
                                                                                echo "<a href=\"editstusup.php?pe_id=$row2[pe_id]&su_no=$row2[su_no]&c_id=$row2[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                                <?php
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                                <!-- / -->
                                                                <?php if ($row2['su_no'] == '5' && $su_score4 != "") {
                                                                    if ($type2 == 0) {
                                                                        echo "<a href=\"editstusup.php?pe_id=$row2[pe_id]&su_no=$row2[su_no]&c_id=$row2[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                                        <?php  } else {
                                                                        if ($row2['t_id'] == "") {
                                                                            if ($t_id1 == $t_id3 || $t_id2 == $t_id3) {
                                                                                echo "<a href=\"editstusup.php?pe_id=$row2[pe_id]&su_no=$row2[su_no]&c_id=$row2[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                                            <?php
                                                                            }
                                                                        }
                                                                        if ($row2['t_id'] != "") {
                                                                            if ($row2['t_id'] == "$t_id3") {
                                                                                echo "<a href=\"editstusup.php?pe_id=$row2[pe_id]&su_no=$row2[su_no]&c_id=$row2[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                                <?php
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                                <!-- / -->
                                                                <?php if ($row2['su_no'] == '6' && $su_score4 != "" && $su_score5 != "" ) {
                                                                    if ($type2 == 0) {
                                                                        echo "<a href=\"editstusup.php?pe_id=$row2[pe_id]&su_no=$row2[su_no]&c_id=$row2[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                                        <?php  } else {
                                                                        if ($row2['t_id'] == "") {
                                                                            if ($t_id1 == $t_id3 || $t_id2 == $t_id3) {
                                                                                echo "<a href=\"editstusup.php?pe_id=$row2[pe_id]&su_no=$row2[su_no]&c_id=$row2[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                                            <?php
                                                                            }
                                                                        }
                                                                        if ($row2['t_id'] != "") {
                                                                            if ($row2['t_id'] == "$t_id3") {
                                                                                echo "<a href=\"editstusup.php?pe_id=$row2[pe_id]&su_no=$row2[su_no]&c_id=$row2[c_id]\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                                <?php
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                <?php }
                                } ?>
                                <?php $total1 = mysqli_num_rows($result1); ?>
                                <?php $total2 = mysqli_num_rows($result3); ?>
                                <div class=" d-flex justify-content-center">
                                    <?php if ($total1 != 0) { ?>
                                        <a href="indexpdf.php?pe_id=<?= $rows1['pe_id'] ?>&su_term=<?= $rows1['su_term']?>"><button class="btn btn-primary fa fas-plus float-left "><i class="fa fa-print" aria-hidden="true"></i><?= $c_na1 ?></button></a>
                                        <?php }
                                    if ($total2 != 0) {
                                        if ($t_id4 != "") { ?>
                                            <a href="indexpdf.php?pe_id=<?= $rows2['pe_id'] ?>&su_term=<?= $rows2['su_term']?>"><button class="btn btn-primary fa fas-plus float-left "><i class="fa fa-print" aria-hidden="true"></i><?= $c_na2 ?></button></a>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="footer d-flex justify-content-center">
                            <a href="javascript:history.back()"><button class="btn btn-primary btn-lg">กลับ</button></a>
                        </div> -->
                        <br>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->
                <!-- Footer -->
                <?php include("../../footer.php") ?>
                <!-- End of Footer -->
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <!-- Logout Modal-->
        <?php include("../../logoutmenu.php"); ?>
    </body>

    </html>
<?php
} else {
    echo "<script> alert('Please Login'); window.location='../../index.php';</script>";
    exit();
}
?>