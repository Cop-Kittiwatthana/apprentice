<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];

    $c_id = $_GET["c_id"];
    $pe_semester = $_GET["pe_semester"];
    $su_term = $_GET["su_term"];


    $id = $_GET["id"];
    $s_group = $_GET["s_group"];
    $br_id = $_GET["br_id"];
    $thai_year = date('Y') + 543;
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
        <title>รายงานข้อมูลโรคประจำตัวนักศึกษาฝึกงาน</title>
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
                            <li class="breadcrumb-item"><a href="indexdisease.php?c_id=<?= $c_id ?>">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">รายงานข้อมูลโรคประจำตัวนักศึกษาฝึกงาน</li>
                        </ol>
                        <div class="card shadow mb-4">
                            <object data="diseasepdf.php?c_id=<?= $c_id ?>&pe_semester=<?= $pe_semester ?>&su_term=<?= $su_term ?>" type="application/pdf" width="100%" height="580px">
                                <p>Alternative text - include a link <a href="MyPDF.pdf">to the PDF!</a></p>
                            </object>
                        </div>
                    </div>
                </div>
                <?php include("../../footer.php") ?>
            </div>
        </div>
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <?php include("../../logoutmenu.php"); ?>
    </body>

    </html>
<?php
} else {
    echo ("<script> alert('please login'); window.location='../../index.php';</script>");
    exit();
}
?>