<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0' ||  $_SESSION["status"] == '3') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $type = $_SESSION["type"];

    $pe_id = $_GET["pe_id"];
    $s_id = $_GET["s_id"];
    $pe_semester = $_GET["pe_semester"];
    $c_id = $_GET["c_id"];

    $query1 = "SELECT * FROM teacher WHERE t_user = '$username' and t_pass = '$password'";
    $result1 = mysqli_query($conn, $query1);
    while ($row1 = mysqli_fetch_array($result1)) {
        $t_id1 = $row1['t_id'];
    }

    $query = "SELECT company.*,petition.*,student.*
    FROM petition 
    LEFT JOIN demand ON petition.de_id  = demand.de_id 
    LEFT JOIN company ON demand.c_id  = company.c_id 
    LEFT JOIN student ON petition.s_id  = student.s_id  
    where petition.pe_id='$pe_id' and petition.s_id='$s_id'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $c_id = "$row[c_id]";
        $c_na = "$row[c_na]";
        $s_tna = "$row[s_tna]";
        $s_fna = "$row[s_fna]";
        $s_lna = "$row[s_lna]";
        $pe_semester = "$row[pe_semester]";
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
                            <li class="breadcrumb-item"><a href="index.php">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="indexstd.php?c_id=<?= $c_id ?>&pe_semester=<?= $pe_semester ?>">รายชื่อนักศึกษาฝึกงาน</a></li>
                            <li class="breadcrumb-item active">จัดการเอกสารฝึกงาน</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fa fa-file" aria-hidden="true"></i><?= $s_tna ?><?= $s_fna ?>&nbsp;<?= $s_lna ?></h4>
                    </div>
                    <div class="container text-dark " style="width: 80%; height: auto;">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered " style="border-color: black;" id="data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #f8f9fc;text-align: center;">ชื่อเอกสาร</th>
                                                <th style="background-color: #f8f9fc;text-align: center;">เอกสาร</th>
                                                <th style="background-color: #f8f9fc;text-align:center;" width="200"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center;">คำร้องขอฝึกงานในสถานประกอบการ</td>
                                                <?php
                                                $query1 = "SELECT * FROM documents 
                                                left join petition on documents.pe_id = petition.pe_id
                                                WHERE petition.s_id = '$s_id' and documents.dn_name = 'คำร้องขอฝึกงานในสถานประกอบการ' ";
                                                $result1 = mysqli_query($conn, $query1);
                                                $row1 = mysqli_fetch_array($result1) ?>
                                                <td class="name" style="text-align:center;">
                                                    <?php if ($row1['dn_file'] == "") {
                                                        echo "<p style='color:red;'>ไม่มีเอกสาร</p>";
                                                    } else {
                                                        echo "<a href='indexpdf.php?id=$row1[dn_file]&s_id=$s_id&pe_id=$pe_id'>$row1[dn_file]</a>";
                                                    }  ?>
                                                </td>
                                                <td style="text-align:center;"><a href="editdoc.php?dn_id=<?= $row1['dn_id'] ?>&dn_name=1&pe_id=<?= $pe_id ?>"><button type="button" class="btn btn-warning btn fa fa-edit text-dark"><span style="color:black;">เอกสาร</span></button></a></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">หนังสืออนุญาติผู้ปกครอง</td>
                                                <?php
                                                $query2 = "SELECT * FROM documents 
                                                left join petition on documents.pe_id = petition.pe_id
                                                WHERE petition.s_id = '$s_id' and documents.dn_name = 'หนังสืออนุญาติผู้ปกครอง' ";
                                                $result2 = mysqli_query($conn, $query2);
                                                $row2 = mysqli_fetch_array($result2) ?>
                                                <td class="name" style="text-align:center;">
                                                    <?php if ($row2['dn_file'] == "") {
                                                        echo "<p style='color:red;'>ไม่มีเอกสาร</p>";
                                                    } else {
                                                        echo "<a href='$baseURL/files/$row2[dn_file]' target='blank' >$row2[dn_file]</a>";
                                                    }  ?>
                                                </td>
                                                <td style="text-align:center;"><a href="editdoc.php?dn_id=<?= $row2['dn_id'] ?>&dn_name=2&pe_id=<?= $pe_id ?>"><button type="button" class="btn btn-warning btn fa fa-edit text-dark"><span style="color:black;">เอกสาร</span></button></a></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">สัญญาการฝึกอาชีพ(ผู้ฝึกสอนกับนักศึกษา)</td>
                                                <?php
                                                $query3 = "SELECT * FROM documents 
                                                left join petition on documents.pe_id = petition.pe_id
                                                WHERE petition.s_id = '$s_id' and documents.dn_name = 'สัญญาการฝึกอาชีพ(ผู้ฝึกสอนกับนักศึกษา)' ";
                                                $result3 = mysqli_query($conn, $query3);
                                                $row3 = mysqli_fetch_array($result3) ?>
                                                <td class="name" style="text-align:center;">
                                                    <?php if ($row3['dn_file'] == "") {
                                                        echo "<p style='color:red;'>ไม่มีเอกสาร</p>";
                                                    } else {
                                                        echo "<a href='$baseURL/files/$row3[dn_file]' target='blank' >$row3[dn_file]</a>";
                                                    }  ?>
                                                </td>
                                                <td style="text-align:center;"><a href="editdoc.php?dn_id=<?= $row3['dn_id'] ?>&dn_name=3&pe_id=<?= $pe_id ?>"><button type="button" class="btn btn-warning btn fa fa-edit text-dark"><span style="color:black;">เอกสาร</span></button></a></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">สัญญาการฝึกอาชีพ(สถานประกอบการกับนักศึกษา)</td>
                                                <?php
                                                $query4 = "SELECT * FROM documents 
                                                left join petition on documents.pe_id = petition.pe_id
                                                WHERE petition.s_id = '$s_id' and documents.dn_name = 'สัญญาการฝึกอาชีพ(สถานประกอบการกับนักศึกษา)' ";
                                                $result4 = mysqli_query($conn, $query4);
                                                $row4 = mysqli_fetch_array($result4) ?>
                                                <td class="name" style="text-align:center;">
                                                    <?php if ($row4['dn_file'] == "") {
                                                        echo "<p style='color:red;'>ไม่มีเอกสาร</p>";
                                                    } else {
                                                        echo "<a href='$baseURL/files/$row4[dn_file]' target='blank' >$row4[dn_file]</a>";
                                                    }  ?>
                                                </td>
                                                <td style="text-align:center;"><a href="editdoc.php?dn_id=<?= $row4['dn_id'] ?>&dn_name=4&pe_id=<?= $pe_id ?>"><button type="button" class="btn btn-warning btn fa fa-edit text-dark"><span style="color:black;">เอกสาร</span></button></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                        <!-- <div class="footer d-flex justify-content-center">
                            <a href="indexstd.php?c_id=<?= $c_id ?>&pe_semester=<?= $pe_semester ?>"><button class="btn btn-primary btn-lg">กลับ</button></a>
                        </div> -->
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