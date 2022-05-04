<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_GET['status'];
    //   $query = "Select * from user WHERE username = '$username'";
    //   $result = mysqli_query($conn, $query)
    //   or die ("3.ไม่สามารถประมวลผลคำสั่งได้"). $mysqli_error;
    //   while ($row = mysqli_fetch_array($result)) {  // preparing an array
    //     $username = "$row[username]";
    //     $full_name = "$row[full_name]";
    //     $type = "$row[type]";
    //     echo $type;
    // }
    // $year=(date("Y")+543);
    $thai_year = date('Y') + 543;
    $year = $_GET['year'];
    if ($year == "") {
        $year1 = $thai_year;
    } else {
        $year1 = $_GET['year'];
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
        <meta http-equiv="refresh" content="20" />
        <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/brand.png">
        <title>ข้อมูลการยื่นเรื่องฝึกงาน</title>
        <?php include('../../head.php'); ?>


    </head>

    <body id="page-top">
        <div id="wrapper">
            <?php include "../../sidebar_login.php"; ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php
                    include "../../menu_login.php";
                    ?>
                    <div class="card border">
                        <div class="card-body bg-info">
                            <h4 style="color: white;">ปีการศึกษา: <?= $year1 ?>
                                <form action="index.php" method="get" enctype="multipart/form-data" name="form1" id="form1" class="form-inline" style="margin-right:15px; float:right;">
                                    <div style="margin-right:15px; float:right;">
                                        <select type="text" name="year" id="year" class="form-control mr-sm-2" aria-label="Search" style="float:right;width:300px;">
                                            <!-- <option value="">--กรุณาเลือกปีการศึกษา--</option> -->
                                            <?php
                                            $query = "SELECT pe_semester FROM petition GROUP BY pe_semester  ORDER BY pe_semester desc";
                                            $result = mysqli_query($conn, $query);
                                            ?>
                                            <?php foreach ($result as $value) { ?>
                                                <option value="<?= $value['pe_semester'] ?>" <?= $value['pe_semester'] == $year1 ? 'selected' : '' ?>>
                                                    <?= $value['pe_semester'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div style="margin-right:15px; float:right;">
                                        <button type="submit" class="btn btn-primary" id="btnsave">ค้นหา</button>
                                        &nbsp;
                                        <!-- <a href="<?= $baseURL; ?>/views/status/index.php" class="btn btn-danger">ล้างค่า</a> -->
                                    </div>
                                </form>
                            </h4>
                            <br>
                        </div>
                    </div>
                    <br>
                    <!-- Content Row -->
                    <div class="container-fluid">
                        <div class="row my-4">
                            <!-- *****************************************คำร้องรอการตรวจสอบ************************************************************** -->
                            <?php
                            if ($year == "") {
                                $sql1 = "SELECT * FROM petition where pe_status = 0";
                            } else {
                                $sql1 = "SELECT * FROM petition where pe_status = 0 and pe_semester = $year1";
                            }
                            //$sql1 = "SELECT * FROM petition where pe_status = 0 and pe_semester = $year1";
                            $result1 = mysqli_query($conn, $sql1);
                            $num1 = mysqli_num_rows($result1);
                            ?>
                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0 ">
                                <div class="card card shadow mb-4">
                                    <h5 class="card-header bg-warning text-white">
                                        <font size="5" face="TH SarabunPSK"><b>คำร้องรอการตรวจสอบ</b></font>
                                    </h5>
                                    <div class="card-body">
                                        <h2 class="card-title" align="center"><i class="far fa-copy"></i></i> <?php echo $num1; ?> </i></h2>
                                        <hr class="sidebar-divider d-none d-md-block ">
                                        <div align="center">
                                            <a class="card-text text-success" align="center" href="<?= $baseURL; ?>/views/status/indexstatus.php?id=0&year=<?= $year1 ?>"> More info <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ********************************************สถานประกอบการ************************************************************ -->
                            <?php
                            if ($year == "") {
                                $sql1 = "SELECT * FROM petition where pe_status = 1";
                            } else {
                                $sql1 = "SELECT * FROM petition where pe_status = 1 and pe_semester = $year1";
                            }
                            //$sql1 = "SELECT * FROM petition where pe_status = 1 and pe_semester = $year1";
                            $result1 = mysqli_query($conn, $sql1);
                            $num1 = mysqli_num_rows($result1);
                            ?>
                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0 ">
                                <div class="card card shadow mb-4">
                                    <h5 class="card-header bg-info text-white">
                                        <font size="5" face="TH SarabunPSK"><b>ตรวจสอบแล้ว</b></font>
                                    </h5>
                                    <div class="card-body">
                                        <h2 class="card-title" align="center"><i class="far fa-copy"></i> <?php echo $num1; ?> </i></h2>
                                        <hr class="sidebar-divider d-none d-md-block ">
                                        <div align="center">
                                            <a class="card-text text-success" align="center" href="<?= $baseURL; ?>/views/status/indexstatus.php?id=1&year=<?= $year1 ?>"> More info <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ********************************************สถานประกอบการ************************************************************ -->
                            <?php
                            if ($year == "") {
                                $sql1 = "SELECT * FROM petition where pe_status = 2";
                            } else {
                                $sql1 = "SELECT * FROM petition where pe_status = 2 and pe_semester = $year1";
                            }
                            //$sql1 = "SELECT * FROM petition where pe_status = 2 and pe_semester = $year1";
                            $result1 = mysqli_query($conn, $sql1);
                            $num1 = mysqli_num_rows($result1);
                            ?>
                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0 ">
                                <div class="card card shadow mb-4">
                                    <h5 class="card-header bg-success text-white">
                                        <font size="5" face="TH SarabunPSK"><b>สถานประกอบการตอบรับ</b></font>
                                    </h5>
                                    <div class="card-body">
                                        <h2 class="card-title" align="center"><i class="far fa-copy"></i> <?php echo $num1; ?> </i></h2>
                                        <hr class="sidebar-divider d-none d-md-block ">
                                        <div align="center">
                                            <a class="card-text text-success" align="center" href="<?= $baseURL; ?>/views/status/indexstatus.php?id=2&year=<?= $year1 ?>"> More info <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ********************************************ตรวจสอบแล้ว************************************************************ -->
                            <?php
                            if ($year == "") {
                                $sql1 = "SELECT * FROM petition where pe_status = 3";
                            } else {
                                $sql1 = "SELECT * FROM petition where pe_status = 3 and pe_semester = $year1";
                            }
                            //$sql1 = "SELECT * FROM petition where pe_status = 3 and pe_semester = $year1";
                            $result1 = mysqli_query($conn, $sql1);
                            $num1 = mysqli_num_rows($result1);
                            ?>
                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0 ">
                                <div class="card card shadow mb-4">
                                    <h5 class="card-header bg-danger text-white">
                                        <font size="5" face="TH SarabunPSK"><b>สถานประกอบการปฏิเสธ</b></font>
                                    </h5>
                                    <div class="card-body">
                                        <h2 class="card-title" align="center"><i class="far fa-copy"></i> <?php echo $num1; ?> </i></h2>
                                        <hr class="sidebar-divider d-none d-md-block ">
                                        <div align="center">
                                            <a class="card-text text-success" align="center" href="<?= $baseURL; ?>/views/status/indexstatus.php?id=3&year=<?= $year1 ?>"> More info <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row my-4">
                            <!-- *****************************************อาจารย์************************************************************** -->
                            <?php
                            if ($year == "") {
                                $sql1 = "SELECT * FROM petition where pe_status = 5";
                            } else {
                                $sql1 = "SELECT * FROM petition where pe_status = 5 and pe_semester = $year1";
                            }
                            //$sql1 = "SELECT * FROM petition where pe_status = 3 and pe_semester = $year1";
                            $result1 = mysqli_query($conn, $sql1);
                            $num1 = mysqli_num_rows($result1);
                            ?>
                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0 ">
                                <div class="card card shadow mb-4">
                                    <h5 class="card-header bg-warning text-white">
                                        <font size="5" face="TH SarabunPSK"><b>กำลังออกฝึก</b></font>
                                    </h5>
                                    <div class="card-body">
                                        <h2 class="card-title" align="center"><i class="far fa-copy"></i> <?php echo $num1; ?> </i></h2>
                                        <hr class="sidebar-divider d-none d-md-block ">
                                        <div align="center">
                                            <a class="card-text text-success" align="center" href="<?= $baseURL; ?>/views/status/indexstatus.php?id=5&year=<?= $year1 ?>"> More info <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- *****************************************อาจารย์************************************************************** -->
                            <?php
                            if ($year == "") {
                                $sql1 = "SELECT * FROM petition where pe_status = 6";
                            } else {
                                $sql1 = "SELECT * FROM petition where pe_status = 6 and pe_semester = $year1";
                            }
                            //$sql1 = "SELECT * FROM petition where pe_status = 3 and pe_semester = $year1";
                            $result1 = mysqli_query($conn, $sql1);
                            $num1 = mysqli_num_rows($result1);
                            ?>
                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0 ">
                                <div class="card card shadow mb-4">
                                    <h5 class="card-header bg-success text-white">
                                        <font size="5" face="TH SarabunPSK"><b>เสร็จสิ้นการฝึกงานเทอม1</b></font>
                                    </h5>
                                    <div class="card-body">
                                        <h2 class="card-title" align="center"><i class="far fa-copy"></i> <?php echo $num1; ?> </i></h2>
                                        <hr class="sidebar-divider d-none d-md-block ">
                                        <div align="center">
                                            <a class="card-text text-success" align="center" href="<?= $baseURL; ?>/views/status/indexstatus.php?id=6&year=<?= $year1 ?>"> More info <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ********************************************นักศึกษา************************************************************ -->
                            <?php
                            // $sql1 = "SELECT MAX(petition.pe_id) as id,petition.*
                            // FROM petition 
                            // where pe_status = 7 or pe_status = 10 and pe_semester = $year1 GROUP BY petition.s_id";
                            $sql1 = "SELECT petition.*
                            FROM petition 
                            where (pe_status = 7 or pe_status = 10 or pe_status = 11) and pe_semester = $year1 ";
                            //$sql1 = "SELECT * FROM petition where pe_status = 3 and pe_semester = $year1";
                            $result1 = mysqli_query($conn, $sql1);
                            $num1 = mysqli_num_rows($result1);
                            ?>
                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0 ">
                                <div class="card card shadow mb-4">
                                    <h5 class="card-header bg-danger text-white">
                                        <font size="5" face="TH SarabunPSK"><b>เปลี่ยนสถานที่ฝึก/ยกเลิกการฝึก</b></font>
                                    </h5>
                                    <div class="card-body">
                                        <h2 class="card-title" align="center"><i class="far fa-copy"></i> <?php echo $num1; ?> </i></h2>
                                        <hr class="sidebar-divider d-none d-md-block ">
                                        <div align="center">
                                            <a class="card-text text-success" align="center" href="<?= $baseURL; ?>/views/status/indexstatus.php?id=7&year=<?= $year1 ?>"> More info <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ********************************************สถานประกอบการ************************************************************ -->
                            <?php
                            if ($year == "") {
                                $sql1 = "SELECT * FROM petition where pe_status = 8";
                            } else {
                                $sql1 = "SELECT * FROM petition where pe_status = 8 and pe_semester = $year1";
                            }
                            //$sql1 = "SELECT * FROM petition where pe_status = 3 and pe_semester = $year1";
                            $result1 = mysqli_query($conn, $sql1);
                            $num1 = mysqli_num_rows($result1);
                            ?>
                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0 ">
                                <div class="card card shadow mb-4">
                                    <h5 class="card-header bg-info text-white">
                                        <font size="5" face="TH SarabunPSK"><b>เสร็จสิ้นการฝึกงาน</b></font>
                                    </h5>
                                    <div class="card-body">
                                        <h2 class="card-title" align="center"><i class="far fa-copy"></i> <?php echo $num1; ?> </i></h2>
                                        <hr class="sidebar-divider d-none d-md-block ">
                                        <div align="center">
                                            <a class="card-text text-success" align="center" href="<?= $baseURL; ?>/views/status/indexstatus.php?id=8&year=<?= $year1 ?>"> More info <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ********************************************นักศึกษา************************************************************ -->
                            <!-- <?php
                            $sql1 = "SELECT petition.*
                            FROM petition 
                            where pe_status = 11 and pe_semester = $year1 ";
                            $result1 = mysqli_query($conn, $sql1);
                            $num1 = mysqli_num_rows($result1);
                            ?>
                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0 ">
                                <div class="card card shadow mb-4">
                                    <h5 class="card-header bg-danger text-white">
                                        <font size="5" face="TH SarabunPSK"><b>ยกเลิกการฝึก</b></font>
                                    </h5>
                                    <div class="card-body">
                                        <h2 class="card-title" align="center"><i class="far fa-copy"></i> <?php echo $num1; ?> </i></h2>
                                        <hr class="sidebar-divider d-none d-md-block ">
                                        <div align="center">
                                            <a class="card-text text-success" align="center" href="<?= $baseURL; ?>/views/status/indexstatus.php?id=10&year=<?= $year1 ?>"> More info <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <?php include "../../footer.php"; ?>
            </div>
        </div>
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <!-- Logout Modal-->

        <?php include('../../logoutmenu.php'); ?>
    </body>

    </html>
<?php
} else {
    echo "<script> alert('Please Login'); window.location='../../index.php';</script>";
    exit();
}
?>