<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $type = $_SESSION["type"];


    $id = $_GET["id"];
    $s_id = $_GET["s_id"];
    $pe_id = $_GET["pe_id"];
    $query = "SELECT company.*,petition.*,student.*
    FROM petition 
    LEFT JOIN demand ON petition.de_id  = demand.de_id 
    LEFT JOIN company ON demand.c_id  = company.c_id 
    LEFT JOIN student ON petition.s_id  = student.s_id  
    where petition.pe_id='$pe_id' and petition.s_id='$s_id'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $c_id = "$row[c_id]";
        $pe_semester = "$row[pe_semester]";
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
        <title>รายงานเอกสารฝึกงาน</title>

        <?php include("../../head.php"); ?>
    </head>

    <body id="page-top">
        <div id="wrapper">
            <?php include("../../sidebar_login.php") ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php") ?>
                    <div class="container-fluid">
                    <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="indexstd.php?c_id=<?= $c_id ?>&pe_semester=<?= $pe_semester ?>">รายชื่อนักศึกษาฝึกงาน</a></li>
                            <li class="breadcrumb-item"><a href="indexstddoc.php?pe_id=<?= $pe_id ?>&s_id=<?= $s_id ?>&c_id=<?= $c_id ?>&pe_semester=<?= $pe_semester ?>">จัดการเอกสารฝึกงาน</a></li>
                            <li class="breadcrumb-item active">รายงานเอกสารฝึกงาน</li>
                        </ol>
                        <div class="card shadow mb-4">
                            <object data="<?= $baseURL?>/files/<?= $id ?>" type="application/pdf" width="100%" height="580px">
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