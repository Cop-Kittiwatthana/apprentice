<?php
session_start();
if (!isset($_SESSION["username"]) && !isset($_SESSION["password"])) {
    header("Location: index.php");
} else {
    include("connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_GET['year'];
    //   $query = "Select * from user WHERE username = '$username'";
    //   $result = mysqli_query($conn, $query)
    //   or die ("3.ไม่สามารถประมวลผลคำสั่งได้"). $mysqli_error;
    //   while ($row = mysqli_fetch_array($result)) {  // preparing an array
    //     $username = "$row[username]";
    //     $full_name = "$row[full_name]";
    //     $type = "$row[type]";
    //     echo $type;
    // }
    $query = "SELECT MAX(SUBSTR(student.s_id,1,2)) As id FROM student  ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {
        $num = $row['id'];
    }

    $year = $_GET['year'];
    if ($year == "") {
        $year = "$num";
    } else {
        $year = $_GET['year'];
    }

    // 
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/brand.png">
        <title>หน้าหลัก</title>
        <?php include('head.php'); ?>


    </head>

    <body id="page-top">
        <div id="wrapper">
            <?php include "sidebar_login.php"; ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php
                    include "menu_login.php";
                    ?>
                    <div class="container-fluid">
                        <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                        </div> -->
                        <!-- Content Row -->
                        <div class="card border-dark">
                            <div class="card-body bg-info" >
                                <!-- <div class="card-header bg-info text-white">
                            <div class="d-sm-flex align-items-center justify-content-between mb-4"> -->
                                <h4 style="color: white;">ปีการศึกษา: <?= $year ?>
                                    <form action="indexnews.php" method="get" enctype="multipart/form-data" name="form1" id="form1" class="form-inline" style="margin-right:15px; float:right;">
                                        <div style="margin-right:15px; float:right;">
                                            <select type="text" name="year" id="year" class="form-control mr-sm-2" aria-label="Search" style="float:right;width:300px;">
                                                <!-- <option value="">--กรุณาเลือกปีการศึกษา--</option> -->
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
                                            <button type="submit" class="btn btn-primary" id="btnsave" >ค้นหา</button>
                                            &nbsp;
                                            <!-- <a href="<?= $baseURL; ?>/indexnews.php" class="btn btn-danger">ล้างค่า</a> -->
                                        </div>
                                    </form>
                                </h4>
                            </div>
                        </div>
                        <br>
                        <div class="row my-4">
                            <!-- *****************************************อาจารย์************************************************************** -->
                            <?php
                            $sql1 = "SELECT * FROM teacher";
                            $result1 = mysqli_query($conn, $sql1);
                            $num1 = mysqli_num_rows($result1);
                            ?>
                            <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0 ">
                                <div class="card card shadow mb-4">
                                    <h5 class="card-header bg-info text-white">
                                        <font size="5" face="TH SarabunPSK"><b>อาจารย์</b></font>
                                    </h5>
                                    <div class="card-body">
                                        <h2 class="card-title" align="center"><i class="fas fa-chalkboard-teacher"></i> <?php echo $num1; ?> </i></h2>
                                        <hr class="sidebar-divider d-none d-md-block ">
                                        <div align="center">
                                            <a class="card-text text-success" align="center" href="<?= $baseURL; ?>/views/teacher/index.php"> More info <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ********************************************นักศึกษา************************************************************ -->
                            <?php
                            if ($year == "") {
                                $sql1 = "SELECT * FROM student";
                            } else {
                                $sql1 = "SELECT * FROM student 
                                WHERE  student.s_id LIKE '$year%' ";
                            }
                            // $sql1 = "SELECT * FROM student";
                            $result1 = mysqli_query($conn, $sql1);
                            $num1 = mysqli_num_rows($result1);
                            ?>
                            <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0 ">
                                <div class="card card shadow mb-4">
                                    <h5 class="card-header bg-info text-white">
                                        <font size="5" face="TH SarabunPSK"><b>นักศึกษาที่ฝึกงาน</b></font>
                                    </h5>
                                    <div class="card-body">
                                        <h2 class="card-title" align="center"><i class="fas fa-user-graduate"></i> <?php echo $num1; ?> </i></h2>
                                        <hr class="sidebar-divider d-none d-md-block ">
                                        <div align="center">
                                            <a class="card-text text-success" align="center" href="<?= $baseURL; ?>/views/student/indexsub.php?year=<?= $year ?>"> More info <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ********************************************สถานประกอบการ************************************************************ -->
                            <?php
                            $sql1 = "SELECT * FROM company";
                            $result1 = mysqli_query($conn, $sql1);
                            $num1 = mysqli_num_rows($result1);
                            ?>
                            <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0 ">
                                <div class="card card shadow mb-4">
                                    <h5 class="card-header bg-info text-white">
                                        <font size="5" face="TH SarabunPSK"><b>สถานประกอบการ</b></font>
                                    </h5>
                                    <div class="card-body">
                                        <h2 class="card-title" align="center"><i class="fas fa-building"></i> <?php echo $num1; ?> </i></h2>
                                        <hr class="sidebar-divider d-none d-md-block ">
                                        <div align="center">
                                            <a class="card-text text-success" align="center" href="<?= $baseURL; ?>/views/company/index.php"> More info <i class="fas fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include "footer.php"; ?>
            </div>
        </div>
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <!-- Logout Modal-->

        <?php include('logoutmenu.php'); ?>
    </body>

    </html>
<?php } ?>