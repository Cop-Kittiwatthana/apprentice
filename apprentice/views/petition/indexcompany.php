<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) && $_SESSION["status"] == '2' ) {
    include("../../connect.php");
    include("pagination_function.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $s_id = $_GET['s_id'];
    //$c_id = $_GET['c_id'];
    // *-****************************สถานะการลงทะเบียน******************************************
    $query = "SELECT student.* FROM student WHERE student.s_id= '$s_id'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {
        $s_status = "$row[s_status]";
    }
    if ($s_status != '2') {
        // echo "<script> alert('ยังไม่เปิดให้ยื่นคำร้องขอฝึกงาน'); window.history.back()</script>";
        echo "<script> alert('ยังไม่เปิดให้ยื่นคำร้องขอฝึกงาน'); window.location='$baseURL/views/petition/index.php?s_id=$s_id';</script>";
        exit();
    }
    // *-********************************************************************************
    $query_branch = "SELECT petition.*,student.* 
        FROM petition 
        inner JOIN student ON student.s_id = petition.s_id
        where petition.s_id = '$s_id' and petition.pe_status != 3 and petition.pe_status != 4 and petition.pe_status != 7 and petition.pe_status != 10";
    $result_branch = mysqli_query($conn, $query_branch) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result_branch)) {
        $c_id = "$row[c_id]";
    }

    $query_branch = "SELECT department.*,branch.*,student.* 
    FROM department 
    inner JOIN branch ON department.dp_id = branch.dp_id
    inner JOIN student ON student.br_id = branch.br_id
    where student.s_id = '$s_id'";
    $result_branch = mysqli_query($conn, $query_branch) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result_branch)) {
        $s_id = "$row[s_id]";
        $br_id = "$row[br_id]";
        $br_na = "$row[br_na]";
    }

    $query_provinces = "SELECT * FROM provinces";
    $result_provinces = mysqli_query($conn, $query_provinces);

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
            <?php include("../../sidebar_login.php") ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php") ?>
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/petition/index.php?s_id=<?= $s_id ?>">สถานะการยื่นเรื่อง</a></li>
                            <li class="breadcrumb-item active">รายชื่อสถานประกอบการ </li>
                        </ol>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <font size="6" face="TH SarabunPSK"> รายชื่อสถานประกอบการ </font>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="card border-dark">
                                        <div class="card-body">
                                            <form class="form-inline" name="form1" method="get" action="" style="margin-right:15px; float:right;">
                                                <div style="margin-right:15px; float:right;">
                                                    <input type=hidden name="s_id" id="s_id" value="<?= $s_id ?>">
                                                    <div style="margin-right:15px;">สถานที่ปฏิบัติงาน</div>
                                                    <select name="myselect2" class="form-control  mr-sm-2 " id="myselect2" style="float:right;">
                                                        <option value="" selected>-กรุณาเลือกจังหวัด-</option>
                                                        <<?php foreach ($result_provinces as $value) { ?> <!-- <option value="<?= $value['province_id'] ?>"><?= $value['provinces_name_th'] ?></option> -->
                                                            <option value="<?= $value['province_id'] ?>" <?= $value['province_id'] == $_GET['myselect2'] ? 'selected' : '' ?>>
                                                                <?= $value['provinces_name_th'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div style="margin-right:15px; float:right;">
                                                    <div style="margin-right:15px;">คำที่ต้องการค้นหา</div>
                                                    <input class="form-control mr-sm-2 " name="keyword" type="text" id="keyword" value="<?= (isset($_GET['keyword'])) ? $_GET['keyword'] : "" ?>" />
                                                    <button type="submit" class="btn btn-primary" id="btn_search">ค้นหา</button>
                                                    &nbsp;
                                                    <!-- <a href="<?= $baseURL; ?>/views/petition/indexcompany.php?s_id=<?= $s_id ?>" class="btn btn-danger">ล้างค่า</a> -->
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                    <br>

                                    <?php
                                    $num = 0;
                                    $thai_year = date('Y') + 543;
                                    $thai_year2 = date('Y') + 543 + 1;
                                    $sql = "SELECT company.*,districts.*, amphures.*,provinces.*,demand.*,branch.*
                                    FROM company 
                                    INNER JOIN demand ON company.c_id=demand.c_id
                                    LEFT JOIN branch ON branch.br_id=demand.br_id 
                                    INNER JOIN districts ON company.district_id=districts.district_id 
                                    INNER JOIN amphures ON districts.amphure_id=amphures.amphure_id 
                                    INNER JOIN provinces ON amphures.province_id=provinces.province_id 
                                    where 1 and company.c_status = 0 and demand.br_id = '$br_id' and company.c_id NOT IN ('$c_id')";
                                    if (isset($_GET['keyword']) && $_GET['keyword'] != "") {
                                        $sql .= " AND company.c_na LIKE '%" . trim($_GET['keyword']) . "%' ";
                                    }
                                    if (isset($_GET['myselect2']) && $_GET['myselect2'] != "") {
                                        $sql .= " AND provinces.province_id LIKE '" . trim($_GET['myselect2']) . "%' ";
                                    }
                                    $sql .= " and demand.de_year = $thai_year AND $thai_year2 ";
                                    $result = mysqli_query($conn, $sql);
                                    $total = mysqli_num_rows($result);
                                    $e_page = 5; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
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
                                    $sql .= " ORDER BY company.c_id DESC  LIMIT " . $s_page . ",$e_page";
                                    //while ($row = mysqli_fetch_array($result)) {  // preparing an array
                                    $result = mysqli_query($conn, $sql);
                                    if ($result && $result->num_rows > 0) {  // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
                                        while ($row = $result->fetch_assoc()) { // วนลูปแสดงรายการ
                                            $num++;
                                    ?>
                                            <div class="card border-primary " style="margin-right:10%;margin-left: 10%;">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="jobbkk-detail-want margin-bottom-1 overflow-hidden">
                                                                <div class="col-md-12 col-sm-12 col-xs-12 name-company">
                                                                    <div class="row">
                                                                        <h5>
                                                                            <a href="#" class="hover-work work-com" title="company"><?= $row['c_na'] ?></a>
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-10 col-sm-10 col-xs-10 jobbkk-applying jobbkk-applying-44">
                                                                <div class="row row-applying">
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 list-company-salary">
                                                                        <h6><?= $row['provinces_name_th'] ?></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 jobbkk-social-company">
                                                                <div class="row">
                                                                    <ul class="social-company">
                                                                        <?php $query_petition  = "SELECT * FROM petition  where de_id = $row[de_id] and pe_status != 3";
                                                                        $result_petition = mysqli_query($conn, $query_petition);
                                                                        $de_num = mysqli_num_rows($result_petition);
                                                                        $total1 = ($row['de_num'] - $de_num);
                                                                        if ($total1 == 0) { ?>
                                                                            <i class="fa fa-check-circle" aria-hidden="true"></i> เต็มแล้ว
                                                                        <?php } else { ?>
                                                                            <a href="add.php?s_id=<?= $s_id ?>&br_id=<?= $br_id ?>&c_id=<?= $row['c_id'] ?>&de_id=<?= $row['de_id'] ?>" class="hover-work work-com" title="company"><i class="fa fa-check-circle" aria-hidden="true"></i> ยื่นคำร้องขอฝึกงาน</a>
                                                                        <?php } ?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="jobbkk-detail-want">
                                                                <div class="col-md-10 col-sm-10 col-xs-10 jobbkk-applying jobbkk-applying-44">
                                                                    <div class="row row-applying">
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 list-company-salary">
                                                                            <h6>ต้องการนักศึกษา : <?= $row['br_na'] ?> </h6>
                                                                            <h6>จำนวนทั่งหมด : <?= $row['de_num'] ?> คน</h6>
                                                                            <h6>ว่าง : <?= $total1 ?> คน</h6>
                                                                            <h6>รายละเอียดงาน : <?= $row['de_Jobdetails'] ?></h6>
                                                                            <h6>สวัสดิการ : <?php if ($row['de_Welfare'] != "") {
                                                                                                echo $row['de_Welfare'];
                                                                                            } else {
                                                                                                echo "-";
                                                                                            }  ?></h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        <?php
                                        }
                                    } else { ?>
                                        <div class="card border " style="margin-right:10%;margin-left: 10%;">
                                            <div class="card-body">
                                                <div class="footer d-flex justify-content-center">
                                                    <h4 style="align-items: center;"> ไม่มีข้อมูล </h4>
                                                </div>
                                            </div>
                                        </div>
                                    <?php   }
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <center>
                        <?php
                        page_navi($total, (isset($_GET['page'])) ? $_GET['page'] : 1, $e_page, $_GET);
                        ?>
                    </center>
                    <br>
                </div>
                <!-- End of Main Content -->
                <!-- Footer -->
                <?php include("../../footer.php") ?>
                <!-- End of Footer -->
            </div>
        </div>
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <!-- Logout Modal-->
        <?php include("../../logoutmenu.php"); ?>
    </body>

    </html>
<?php
} else {
    echo "<script> alert('Please Login'); window.location='../../index.php';</script>";
    exit();
}
?>