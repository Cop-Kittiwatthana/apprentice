<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];

    $s_id = $_GET['s_id'];
    $pe_id = $_GET['pe_id'];
    $id = substr("$s_id", 0, 2);


    $query_department = "SELECT * FROM teacher WHERE t_user = '$username' and t_pass = '$password' ";
    $result_department = mysqli_query($conn, $query_department)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_assoc($result_department))  {
        $t_id = "$row[t_id]";
    }

    $query = "SELECT petition.*,student.*,company.*,demand.*
    FROM petition 
    LEFT JOIN student ON student.s_id  = petition.s_id  
    LEFT JOIN demand ON petition.de_id  = demand.de_id  
    LEFT JOIN company ON demand.c_id  = company.c_id  
    WHERE student.s_id= '$s_id' and petition.pe_id = '$pe_id'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {
        $br_id = "$row[br_id]";
        $s_group = "$row[s_group]";
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
        <title>หนังสือคําร้องขอฝึกอาชีพในสถานประกอบการ</title>
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
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/reportteacher/indexpetition.php?t_id=<?= $t_id ?>">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active"><a href="<?= $baseURL; ?>/views/reportteacher/detailstudent.php?id=<?= $id ?>&br_id=<?= $br_id ?>&s_group=<?= $s_group ?>">ข้อมูลการยื่นเรื่องฝึกงาน</a></li>
                            <li class="breadcrumb-item active">หนังสือคําร้องขอฝึกอาชีพในสถานประกอบการ</li>
                        </ol>
                        <div class="card shadow mb-4">
                            <object data="1.php?s_id=<?= $s_id ?>&pe_id=<?= $pe_id ?>" type="application/pdf" width="100%" height="580px">
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