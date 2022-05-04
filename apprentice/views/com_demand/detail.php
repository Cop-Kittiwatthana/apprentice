<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '3') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $de_id = $_GET['de_id'];
    $c_id = $_GET['c_id'];
    $query = "SELECT demand.*,company.*,branch.*,department.* FROM demand
    inner join company on  demand.c_id = company.c_id
    inner join branch on  branch.br_id = demand.br_id
    inner join department on  department.dp_id = branch.dp_id
    WHERE demand.de_id = '$de_id'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $de_id = "$row[de_id]";
        $de_year = "$row[de_year]";
        $de_num = "$row[de_num]";
        $de_Jobdetails = "$row[de_Jobdetails]";
        $cs_de_Welfareel = "$row[de_Welfare]";
        $c_na = "$row[c_na]";
        $br_na = "$row[br_na]";
        $dp_na = "$row[dp_na]";
    }

    $query_company = "SELECT * FROM company";
    $result_company = mysqli_query($conn, $query_company);
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
        <title>ข้อมูลความต้องการ</title>

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
                            <!-- <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/company/index.php">ข้อมูลสถานประกอบการ</a></li> -->
                            <li class="breadcrumb-item"><a href="index.php?c_id=<?= $c_id ?>">ข้อมูลความต้องการ</a></li>
                            <li class="breadcrumb-item active">รายละเอียดข้อมูลผู้ติดต่อ</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fa fa-file" aria-hidden="true"></i> รายละเอียดข้อมูลผู้ติดต่อ</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <div class="card">
                                <div class="card-body">
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="text"><a style="color:black;">สถานประกอบการ :</a> <?= $c_na ?></h6>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6 class="text"><a style="color:black;">ต้องการรับนักศึกษาฝึกงานแผนก :</a> <?= $dp_na ?> <?= $br_na ?>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6 class="text"><a style="color:black;">จำนวน :</a> <?= $de_num ?> คน
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6 class="text"><a style="color:black;">ปีการศึกษา :</a> <?= $de_year ?> 
                                                </h6>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6 class="text"><a style="color:black;">รายละเอียดงาน :</a> <?= $de_Jobdetails ?>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6 class="text"><a style="color:black;">สวัสดิการ :</a> <?php if ($de_Welfare == "") {echo  '-'; } 
                                                else {echo $de_Welfare; };  ?></h6>
                                            </div>
                                        </div>
                                    </tr>
                                </div>
                            </div>
                        </div>
                    </form>
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