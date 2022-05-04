<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];

    $s_id = $_GET['s_id'];
    $pe_id = $_GET['pe_id'];
    $id = $_GET['id'];
    $s = substr("$id", 0,-1);
    $s2 = substr("$id", 1);

    $query = "SELECT petition.*,student.*,company.*,demand.*
    FROM petition 
    LEFT JOIN student ON student.s_id  = petition.s_id  
    LEFT JOIN demand ON petition.de_id  = demand.de_id  
    LEFT JOIN company ON demand.c_id  = company.c_id  
    WHERE student.s_id= '$s_id' and petition.pe_id = '$pe_id'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {
        $c_id = "$row[c_id]";	 
        $pe_semester = "$row[pe_semester]"; 	 
    }
    if ($s == 1) {
        $name = "หนังสือคําร้องขอฝึกอาชีพในสถานประกอบการ";
    }if ($s == 2) {
        $name = "หนังสืออนุญาตจากผู้ปกครอง";
    }if ($s == 3) {
        $name = "สัญญาการฝึกอาชีพในสถานประกอบการ (๑)";
    }if ($s == 4) {
        $name = "สัญญาการฝึกอาชีพ (๒)";
    }

    if ($s2 == 0) {
        $hname = "คำร้องรอการตรวจสอบ";
    }
    if ($s2 == 1) {
        $hname = "ตรวจสอบแล้ว";
    }
    if ($s2 == 2) {
        $hname = "สถานประกอบการตอบรับ";
    }
    if ($s2 == 3) {
        $hname = "สถานประกอบการปฏิเสธ";
    }
    if ($s2 == 5) {
        $hname = "กำลังออกฝึก";
    }
    if ($s2 == 6) {
        $hname = "เสร็จสิ้นการฝึกงานเทอม1";
    }
    if ($s2 == 7) {
        $hname = "เปลี่ยนสถานที่ฝึก";
    }
    if($s2 == 8){
        $hname = "เสร็จสิ้นการฝึกงาน"; 
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
        <title><?= $name ?></title>
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
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/status/indexstatus.php?id=<?= $s2 ?>&year=<?= $pe_semester ?>">รายงานสถานะ<?= $hname ?></a></li>
                            <li class="breadcrumb-item active"><a href="<?= $baseURL; ?>/views/status/editstatus.php?id=<?= $s2 ?>&c_id=<?= $c_id ?>&s_id=<?= $s_id ?>">จัดการสถานะการฝึก</a></li>
                            <li class="breadcrumb-item active">หนังสือคําร้องขอฝึกอาชีพในสถานประกอบการ</li>
                        </ol>
                        <div class="card shadow mb-4">
                            <object data="<?= $s ?>.php?s_id=<?= $s_id ?>&pe_id=<?= $pe_id ?>" type="application/pdf" width="100%" height="580px">
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