<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    include("pagination_function.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $s_id = $_GET['s_id'];
    $c_id = $_GET['c_id'];
    if ($c_id != "") {
        $c_id = $_GET['c_id'];
    } else {
        $query_branch = "SELECT petition.*,student.* 
        FROM petition 
        inner JOIN student ON student.s_id = petition.s_id
        where petition.s_id = '$s_id'";
        $result_branch = mysqli_query($conn, $query_branch) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
        while ($row = mysqli_fetch_array($result_branch)) {
            $c_id = "$row[c_id]";
        }
    }

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
    $date = date("Y", strtotime($Result["order_sent"] . "+543 year"));
    $year = $_GET['year'];
    if ($year == "") {
        $year = "$date";
    } else {
        $year = $_GET['year'];
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
                            <h4 style="color: white;">จัดการข้อมูลอาจารย์นิเทส<br>
                                <!-- แผนก :<?= $department ?> -->
                                ปีการศึกษา :<?= $year ?>
                                <form action="indexsup.php" method="get" enctype="multipart/form-data" name="form1" id="form1" class="form-inline" style="margin-right:15px; float:right;">
                                    <div style="margin-right:15px; float:right;">
                                        <select type="text" name="year" id="year" class="form-control mr-sm-2" aria-label="Search" style="float:right;width:250px;">
                                            <!-- <option value="" selected disabled>--กรุณาเลือกปีการศึกษา--</option> -->
                                            <?php
                                            $query = "SELECT pe_semester FROM petition GROUP BY pe_semester  ORDER BY pe_semester DESC";
                                            $result = mysqli_query($conn, $query);
                                            ?>
                                            <?php foreach ($result as $value) { ?>
                                                <option value="<?= $value['pe_semester'] ?>" <?= $value['pe_semester'] == $year ? 'selected' : '' ?>>
                                                    <?= $value['pe_semester'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div style="margin-right:15px; float:right;">
                                        <button type="submit" class="btn btn-primary" id="btnsave" >ค้นหา</button>
                                        &nbsp;
                                        <!-- <a href="<?= $baseURL; ?>/views/sup/indexsup.php" class="btn btn-danger">ล้างค่า</a> -->
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
                            <?php
                            $num = 0;
                            $sql = "SELECT branch.* FROM branch   
                            LEFT JOIN student ON branch.br_id  = student.br_id
                            LEFT JOIN petition ON student.s_id  = petition.s_id 
                            ";
                            if ($year != "") {
                                $sql .= " and petition.pe_semester = $year ";
                            } 
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
                                                    <?php $sql1 = "SELECT COUNT(DISTINCT student.s_id ) AS total
                                                    FROM supervision 
                                                    LEFT JOIN petition ON supervision.pe_id  = petition.pe_id 
                                                    LEFT JOIN student ON student.s_id  = petition.s_id 
                                                    LEFT JOIN demand ON petition.de_id  = demand.de_id 
                                                    LEFT JOIN branch ON demand.br_id  = branch.br_id 
                                                    LEFT JOIN company ON demand.c_id  = company.c_id  
                                                    where petition.pe_status >= '5' ";
                                                    if ($year != "") {
                                                        $sql1 .= " and petition.pe_semester = $year ";
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
                                                    <a class="card-text text-success" align="center" href="<?= $baseURL; ?>/views/sup/indexstd.php?id=<?= $row['br_id'] ?>&year=<?= $year ?>"> More info <i class="fas fa-arrow-circle-right"></i></a>
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