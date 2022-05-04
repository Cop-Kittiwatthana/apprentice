<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    include("../pagination_function.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];

    $query_provinces = "SELECT * FROM provinces";
    $result_provinces = mysqli_query($conn, $query_provinces);

    $query = "SELECT MAX(SUBSTR(student.s_id,1,2)) As id FROM student  ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {
        $num = $row['id'];
    }
    if ($_POST['year'] != "") {
        $year1 = $_GET['year'];
    }
    if ($_GET['year'] != "") {
        $num = $_GET['year'];
        $year1 = $_GET['year'];
    }
    if ($year1 == "") {
        $year = $num;
    } else {
        $year = $year1;
    }

    $query1 = "SELECT SUBSTR(student.s_id,1,2) As id,student.s_sdate,student.s_edate 
    FROM student WHERE s_id LIKE '$id%' GROUP BY id ";
    $result1 = mysqli_query($conn, $query1);
    while ($row = mysqli_fetch_array($result1)) {  // preparing an array
        $s_sdate = "$row[s_sdate]";
        $s_edate = "$row[s_edate]";
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
        <title>ข้อมูลสถานประกอบการ</title>
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
                    <div class="card border">
                        <div class="card-body bg-info">
                            <h4 style="color: white;">จัดการข้อมูลนักศึกษา<br>
                                รหัสนักศึกษา : <?= $year ?>
                                <form action="indexsub.php" method="get" enctype="multipart/form-data" name="form1" id="form1" class="form-inline" style="margin-right:15px; float:right;">
                                    <div style="margin-right:15px; float:right;">
                                        <select type="text" name="year" id="year" class="form-control mr-sm-2" aria-label="Search" style="float:right;width:250px;">
                                            <!-- <option value="<?= $year ?>" selected disabled>--กรุณาเลือกรหัสนักศึกษา--</option> -->
                                            <?php
                                            $query = "SELECT SUBSTR(student.s_id,1,2) As id FROM student GROUP BY id  ORDER BY id DESC";
                                            $result = mysqli_query($conn, $query);
                                            ?>
                                            <?php foreach ($result as $value) { ?>
                                                <option value="<?= $value['id'] ?>" <?= $value['id'] == $year ? 'selected' : '' ?>>
                                                    <?= $value['id'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div style="margin-right:15px; float:right;">
                                        <button type="submit" class="btn btn-primary" id="btnsave">ค้นหา</button>
                                        &nbsp;
                                        <!-- <a href="<?= $baseURL; ?>/views/student/indexsub.php" class="btn btn-danger">ล้างค่า</a> -->
                                    </div>
                                </form>
                            </h4>
                        </div>
                    </div>
                    <br>
                    <!-- Content Row -->
                    <div class="container-fluid">
                        <div class="row my-4">
                            <?php
                            $num = 0;
                            $sql = "SELECT branch.* FROM branch GROUP BY branch.br_id ";
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
                                                    <?php $sql1 = "SELECT COUNT(DISTINCT student.s_id) AS total
                                                                FROM branch
                                                                LEFT JOIN student ON branch.br_id  = student.br_id
                                                                where 1=1 ";
                                                    if ($year != "") {
                                                        $sql1 .= " and student.s_id LIKE '" . $year . "%' ";
                                                    }
                                                    if ($row['br_id'] != "") {
                                                        $sql1 .= " and branch.br_id = $row[br_id] ";
                                                    }
                                                    $sql1 .= " GROUP BY branch.br_id ";
                                                    $sql1 .= " ORDER BY branch.br_id ASC";
                                                    $result1 = mysqli_query($conn, $sql1);
                                                    $row1 = mysqli_fetch_array($result1);
                                                    if ($row1['total'] != "") {
                                                        echo $row1['total'];
                                                    } else {
                                                        echo "0";
                                                    }
                                                    ?></i></h2>
                                                <hr class="sidebar-divider d-none d-md-block ">
                                                <div align="center">
                                                    <a class="card-text text-success" align="center" href="<?= $baseURL; ?>/views/student/index.php?id=<?= $row['br_id'] ?>&year=<?= $year ?>"> More info <i class="fas fa-arrow-circle-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                $l = 1;
                            }
                            ?>
                        </div>
                        <?php if ($l == 1) { ?>
                            <div class="card ">
                                <div class="card-body d-flex justify-content-center">
                                    <font size="5" face="TH SarabunPSK" style="text-align: center;">ไม่มีข้อมูล</font>
                                </div>
                            </div>
                        <?php } ?>
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