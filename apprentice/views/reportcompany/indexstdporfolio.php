<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0' ||  $_SESSION["status"] == '3') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $type = $_SESSION["type"];

    $c_id = $_GET["c_id"];
    $pe_semester = $_GET["pe_semester"];

    $query1 = "SELECT * FROM company WHERE c_id = '$c_id'";
    $result1 = mysqli_query($conn, $query1);
    while ($row1 = mysqli_fetch_array($result1)) {
        $c_na = $row1['c_na'];
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
                            <!-- <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/company/editme.php?c_id=<?= $c_id ?>">หน้าหลัก</a></li> -->
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/reportcompany/indexporfolio.php?c_id=<?= $c_id ?>">ข้อมูลนักศึกษาแบ่งตามสถานประกอบการ</a></li>
                            <li class="breadcrumb-item active">รายชื่อนักศึกษาฝึกงาน</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i aria-hidden="true"></i> รายชื่อนักศึกษาฝึกงาน <br><?= $c_na ?></h4>
                    </div>
                    <div class="container text-dark " style="width: 80%; height: auto;">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered " style="border-color: black;" id="data" style="width: 100%;">
                                        <thead>
                                            <tr style="text-align: center;background-color:#DFF3F7;" class="text-dark">
                                                <td width="20%">#</td>
                                                <td width="25%">ชื่อสกุล</td>
                                                <td width="25%">หมายเหตุ</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT company.*,petition.*,student.*
                                        FROM petition 
                                        LEFT JOIN demand ON petition.de_id  = demand.de_id  
	                                    LEFT JOIN company ON demand.c_id  = company.c_id 
                                        LEFT JOIN student ON petition.s_id  = student.s_id  
                                        where company.c_id='$c_id' and petition.pe_semester='$pe_semester' and 
                                        (petition.pe_status = 2 OR petition.pe_status = 5 
                                         OR petition.pe_status = 6 OR petition.pe_status = 7 OR petition.pe_status = 8) ORDER BY student.s_id ASC";
                                            $result = mysqli_query($conn, $query);
                                            while ($row = mysqli_fetch_array($result)) { ?>
                                                <tr class="text-dark" style="text-align: center;">
                                                    <td><?php echo $row['s_id']; ?></td>
                                                    <td class="name">
                                                        <?php echo $row['s_fna'] ?>&nbsp;<?php echo $row['s_lna']; ?>
                                                    </td>
                                                    <td><?php echo "<a href=\"portfolio.php?s_id=$row[s_id]&c_id=$c_id&pe_semester=$pe_semester\">" ?><button type="button" class="btn btn-warning btn fa fa-edit text-dark"><span style="color:black;">ผลงานนักศึกษา</span></button></a></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="footer d-flex justify-content-center">
                            <a href="index.php?c_id=<?= $c_id ?>"><button class="btn btn-primary btn-lg">กลับ</button></a>
                        </div>
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