<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $s_id = $_GET['s_id'];
    $id = $_GET['id'];
    $pe_semester = $_GET['pe_semester'];

    $query_company = "SELECT * FROM company";
    $result_company = mysqli_query($conn, $query_company);
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
        <title>ข้อมูลความต้องการ</title>

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
                            <li class="breadcrumb-item"><a href="indexdismiss.php">หน้าหลัก</a></li>
                            <li class="breadcrumb-item "><a href="indexdismissstd.php?id=<?= $id ?>&pe_semester=<?= $pe_semester ?>">รายชื่อข้อมูลนักศึกษาที่ยกเลิกการฝึก</a></li>
                            <li class="breadcrumb-item active">รายงานข้อมูลนักศึกษาที่ยกเลิกการฝึก</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fa fa-file" aria-hidden="true"></i> รายงานข้อมูลนักศึกษาที่ยกเลิกการฝึก</h4>
                    </div>
                    <?php
                    $query = "SELECT petition.*,student.*,company.*,demand.*,branch.*,department.*
                    FROM petition 
                    LEFT JOIN student ON student.s_id  = petition.s_id  
                    LEFT JOIN demand ON petition.de_id  = demand.de_id  
                    LEFT JOIN company ON demand.c_id  = company.c_id  
                    LEFT JOIN branch ON student.br_id  = branch.br_id  
                    LEFT JOIN department ON branch.dp_id  = department.dp_id  
                    WHERE petition.s_id= '$s_id' and petition.pe_semester = '$pe_semester' and petition.pe_status = '11'";
                    $result = mysqli_query($conn, $query)
                        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
                    while ($row = mysqli_fetch_array($result)) {
                        $c_na = "$row[c_na]";
                        $pe_id = "$row[pe_id]";
                        $s_id = "$row[s_id]";
                        $s_tna = "$row[s_tna]";
                        $s_fna = "$row[s_fna]";
                        $s_lna = "$row[s_lna]";
                        $pe_id = "$row[pe_id]";
                        $br_na = "$row[br_na]";
                        $dp_na = "$row[dp_na]";
                        $note = "$row[note]";
                        if ($s_tna == 0) {
                            $tna = "นาย";
                        }
                        if ($s_tna == 1) {
                            $tna = "นาง";
                        }
                        if ($s_tna == 2) {
                            $tna = "นางสาว";
                        } ?>
                        <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                            <div class="container text-dark " style="width: 70%; height: auto;">
                                <div class="card">
                                    <div class="card-body">
                                        <tr>
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h5 class="text"><a style="color:black;">รหัสนักศึกษา :</a> <?= $s_id ?></h5>
                                                </div>
                                                <div class="col-md-3">
                                                    <h5 class="text"><a style="color:black;">รหัสใบคำร้องที่ :</a> <?= $pe_id ?></h5>
                                                </div>
                                            </div>
                                        </tr>
                                        <tr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="text"><a style="color:black;">ชื่อ-นามสกุล :</a> <?= $tna ?> <?= $s_fna ?> <?= $s_lna ?></h5>
                                                </div>
                                            </div>
                                        </tr>
                                        <tr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5 class="text"><a style="color:black;">แผนก :</a> <?= $dp_na ?> </h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5 class="text"><a style="color:black;">สาขา :</a> <?= $br_na ?> </h5>
                                                </div>
                                            </div>
                                        </tr>
                                        <tr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="text"><a style="color:black;">สถานประกอบการ :</a> <?= $c_na ?></h5>
                                                    </h5>
                                                </div>
                                            </div>
                                        </tr>
                                        <tr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="text"><a style="color:black;">รายละเอียด :</a> <?= $note ?></h5>
                                                </div>
                                            </div>
                                        </tr>
                                    </div>
                                </div>
                            </div>
                        </form><br>
                    <?php }
                    ?><br>
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