<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    include("../pagination_function.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];

    $query_provinces = "SELECT * FROM provinces";
    $result_provinces = mysqli_query($conn, $query_provinces);

    $department = $_POST['department'];
    if ($department == "") {
        $department = "ทั้งหมด";
    } else {
        $query_branch = "SELECT * FROM department WHERE dp_id = $_POST[department]";
        $result_branch = mysqli_query($conn, $query_branch) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
        while ($row = mysqli_fetch_array($result_branch)) {
            $department = "$row[dp_na]";
        }
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
        <title>ข้อมูลผลการฝึกงาน</title>
        <?php include("../../head.php") ?>
    </head>

    <body id="page-top">
        <div id="wrapper">
            <?php include "../../sidebar_login.php"; ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php
                    include "../../menu_login.php";
                    ?>
                    <div class="container-fluid">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <font size="6" face="TH SarabunPSK"> จัดการข้อมูลผลการฝึกงาน </font>
                                    <!-- <a href="add.php"><span class="btn btn-primary fa fas-plus float-right "><i class="fas fa-plus-circle"> เพิ่มข้อมูลอาจารย์ทีปรึกษา</i></a> -->
                                </h6>
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->
                    <div class="container-fluid">
                        <div class="row my-4">
                            <?php
                            $num = 0;
                            $sql = "SELECT branch.*,petition.pe_semester,COUNT(DISTINCT student.s_group) AS total
                            FROM branch
                            LEFT JOIN student ON student.br_id  = branch.br_id
                            LEFT JOIN petition ON student.s_id  = student.s_id  
                            where 1  ";
                            $sql .= " GROUP BY branch.br_id ";
                            $result = mysqli_query($conn, $sql);
                            $total = mysqli_num_rows($result);
                            $e_page = 8; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
                            $step_num = 0;
                            if (!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1)) {
                                $_GET['page'] = 1;
                                $step_num = 0;
                                $s_page = 0;
                            } else {
                                $s_page = $_GET['page'] - 1;
                                $step_num = $_GET['page'] - 1;
                                $s_page = $s_page * $e_page;
                            }
                            $sql .= " ORDER BY branch.br_id ASC  LIMIT " . $s_page . ",$e_page";
                            //while ($row = mysqli_fetch_array($result)) {  // preparing an array
                            $result = mysqli_query($conn, $sql);
                            if ($result && $result->num_rows > 0) {  // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
                                while ($row = $result->fetch_assoc()) { // วนลูปแสดงรายการ
                                    $num++;
                            ?>
                                    <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0 ">
                                        <div class="card card shadow mb-4">
                                            <h5 class="card-header bg-success text-white">
                                                <font size="5" face="TH SarabunPSK"><b><?= $row['br_na'] ?></b></font>
                                            </h5>
                                            <div class="card-body">
                                                <h2 class="card-title" align="center"><i class="far fa-copy"></i></i>
                                                    <?= $row['total'] ?> </i></h2>
                                                <hr class="sidebar-divider d-none d-md-block ">
                                                <div align="center">
                                                    <a class="card-text text-success" align="center" href="<?= $baseURL; ?>/views/score/index.php?id=<?= $row['br_id'] ?>"> More info <i class="fas fa-arrow-circle-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo '<font size="5" face="TH SarabunPSK"></font>';
                            }
                            ?>
                        </div>
                    </div>

                </div>
                <center>
                    <?php
                    page_navi($total, (isset($_GET['page'])) ? $_GET['page'] : 1, $e_page, $_GET);
                    ?>
                </center>
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