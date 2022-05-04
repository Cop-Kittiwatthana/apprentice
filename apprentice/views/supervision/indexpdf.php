<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];

    $pe_id = $_GET['pe_id'];
    $su_term = $_GET['su_term'];
    
    $query3 = "SELECT *
    FROM petition 
    INNER JOIN supervision ON petition.pe_id  = supervision.pe_id
    INNER JOIN student ON petition.s_id  = student.s_id
    WHERE petition.pe_id = '$pe_id' and supervision.su_term = $su_term ";
    $result3 = mysqli_query($conn, $query3);
    while ($row3 = mysqli_fetch_array($result3)) {
        $s_id = $row3['s_id'];
        $br_id = $row3['br_id'];
        $pe_semester = $row3['pe_semester'];
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
        <title>รายงานข้อมูลรายละเอียดการนิเทส</title>
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
                            <li class="breadcrumb-item"><a href="index.php?year=<?= $pe_semester ?>">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="indexstd.php?id=<?= $br_id ?>&year=<?= $pe_semester ?>">จัดการข้อมูลอาจารย์นิเทส</a></li>
                            <li class="breadcrumb-item"><a href="indexstdsup.php?s_id=<?= $s_id ?>&br_id=<?= $br_id ?>&year=<?= $pe_semester ?>">จัดการข้อมูลรายละเอียดการนิเทศ</a></li>
                            <li class="breadcrumb-item active">รายงานข้อมูลรายละเอียดการนิเทส</li>
                        </ol>
                        <div class="card shadow mb-4">
                            <object data="pdf.php?pe_id=<?= $pe_id ?>&su_term=<?= $su_term ?>" type="application/pdf" width="100%" height="580px">
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