<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '2') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $type = $_SESSION["type"];

    $s_id = $_GET["s_id"];

    $query1 = "SELECT * FROM teacher WHERE t_user = '$username' and t_pass = '$password'";
    $result1 = mysqli_query($conn, $query1);
    while ($row1 = mysqli_fetch_array($result1)) {
        $t_id1 = $row1['t_id'];
    }

    $query = "SELECT student.*
    FROM student  
    where s_id='$s_id'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $s_tna = "$row[s_tna]";
        $s_fna = "$row[s_fna]";
        $s_lna = "$row[s_lna]";
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

    $query1 = "SELECT results.*
    FROM petition 
    INNER JOIN results ON petition.pe_id  = results.pe_id
    WHERE petition.s_id = '$s_id' ORDER BY results.r_id";
    $result1 = mysqli_query($conn, $query1) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row1 = mysqli_fetch_array($result1)) {
        $num[] = $row1;
    }
    $r_id1 = $num[0]['r_id'];
    $r_id2 = $num[1]['r_id'];


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
        <title>รายงานข้อมูลผลการประเมิน</title>

        <?php include("../../head.php"); ?>
    </head>

    <body id="page-top">

        <div id="wrapper">
            <?php include("../../sidebar_login.php"); ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php"); ?>
                    <div class="container-fluid">
                        <!-- <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/reportstudent/indexstdscore.php?s_id=<?= $s_id ?>">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">รายงานข้อมูลผลการประเมิน </li>
                        </ol> -->
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fa fa-file" aria-hidden="true"></i>รายงานข้อมูลผลการประเมิน</h4>
                    </div>
                    <div class="container text-dark " style="width: 80%; height: auto;">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered " style="border-color: black;" id="data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #f8f9fc;text-align: center;">สถานประกอบการ</th>
                                                <th style="background-color: #f8f9fc;text-align: center;">ผลการประเมิน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($r_id1 != "") { ?>
                                                <tr>
                                                    <?php
                                                    $query1 = "SELECT company.c_na
                                                FROM student 
                                                LEFT JOIN petition ON petition.s_id  = student.s_id  
                                                LEFT JOIN demand ON petition.de_id  = demand.de_id  
                                                LEFT JOIN company ON demand.c_id  = company.c_id  
                                                LEFT JOIN results ON results.pe_id  = petition.pe_id 
                                                where petition.s_id='$s_id' and results.r_term= 1";
                                                    $result1 = mysqli_query($conn, $query1);
                                                    $row1 = mysqli_fetch_array($result1) ?>
                                                    <td class="name" style="text-align:center;">
                                                        <?php if ($row1['c_na'] == "") {
                                                            echo "<p style='color:red;'>ยังไม่มีสถานประกอบการ</p>";
                                                        } else {
                                                            echo "<p style='color:red;'>$row1[c_na]</p>";
                                                        }  ?>
                                                    </td>
                                                    <td class="name" style="text-align:center;">
                                                        <?php if ($r_id1 == "") {
                                                            echo "<p style='color:red;'>ยังไม่มีการนิเทศ</p>";
                                                        } else {
                                                            echo "<a href='indexpdfscore.php?s_id=$s_id&su_term=1'><button type='button' class='btn btn-info'><i class='fas fa-info-circle'> รายงานผลการประเมิน </i></button></a>";
                                                        }  ?>
                                                    </td>
                                                </tr>
                                            <?php } else { ?>
                                                <tr>
                                                    <td style="text-align: center;font-size:14pt;margin-top:4px;" colspan="3">ไม่มีข้อมูล</td>
                                                </tr>
                                            <?php }
                                            ?>
                                            <?php
                                            if ($r_id2 != "") { ?>
                                                <tr>
                                                    <?php
                                                    $query2 = "SELECT company.c_na
                                                FROM student 
                                                LEFT JOIN petition ON petition.s_id  = student.s_id  
                                                LEFT JOIN demand ON petition.de_id  = demand.de_id  
                                                LEFT JOIN company ON demand.c_id  = company.c_id  
                                                LEFT JOIN results ON results.pe_id  = petition.pe_id 
                                                where petition.s_id='$s_id' and results.r_term= 2";
                                                    $result2 = mysqli_query($conn, $query2);
                                                    $row2 = mysqli_fetch_array($result2) ?>
                                                    <td class="name" style="text-align:center;">
                                                        <?php if ($row2['c_na'] == "") {
                                                            echo "<p style='color:red;'>ยังไม่มีสถานประกอบการ</p>";
                                                        } else {
                                                            echo "<p style='color:red;'>$row2[c_na]</p>";
                                                        }  ?>
                                                    </td>
                                                    <td class="name" style="text-align:center;">
                                                        <?php if ($r_id2 == "") {
                                                            echo "<p style='color:red;'>ยังไม่มีการนิเทศ</p>";
                                                        } else {
                                                            echo "<a href='indexpdfscore.php?s_id=$s_id&su_term=2'><button type='button' class='btn btn-info'><i class='fas fa-info-circle'> รายงานผลการประเมิน </i></button></a>";
                                                        }  ?>
                                                    </td>
                                                </tr>
                                            <?php }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
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