<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) && $_SESSION["status"] == '3' || $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $cs_id = $_GET['cs_id'];
    $c_id = $_GET['c_id'];
    $query = "SELECT contact_staff.*,company.*,districts.*,amphures.*,provinces.* FROM contact_staff
    inner join company on  contact_staff.c_id = company.c_id
    inner join districts on  districts.district_id = company.district_id
    inner join amphures on  amphures.amphure_id = districts.amphure_id
    inner join provinces on  provinces.province_id = amphures.province_id
    WHERE contact_staff.cs_id = '$cs_id'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $cs_tna = "$row[cs_tna]";
        $cs_na = "$row[cs_na]";
        $cs_department = "$row[cs_department]";
        $cs_position = "$row[cs_position]";
        $cs_tel = "$row[cs_tel]";
        $cs_mail = "$row[cs_mail]";
        $cs_fax = "$row[cs_fax]";
        $cs_date = "$row[cs_date]";
        $c_na = "$row[c_na]";
        $c_hnum = "$row[c_hnum]";
        $c_village = "$row[c_village]";
        $c_road = "$row[c_road]";
        $district_name_th = "$row[district_name_th]";
        $amphures_name_th = "$row[amphures_name_th]";
        $provinces_name_th = "$row[provinces_name_th]";
        $zip_code = "$row[zip_code]";
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

        <title>ข้อมูลผู้ติดต่อสถานประกอบการ</title>

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
                            <li class="breadcrumb-item"><a href="index.php?c_id=<?= $c_id ?>">ข้อมูลผู้ติดต่อ</a></li>
                            <li class="breadcrumb-item active">เเก้ไขข้อมูลผู้ติดต่อ</li>
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
                                                <h6 class="text">ชื่อผู้ติดต่อ : &nbsp;<?= $cs_na ?></h6>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="text">สถานประกอบการ : &nbsp;<?= $c_na ?></h6>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6 class="text">สถานที่ปฏิบัติงาน : <?= $c_hnum ?> หมู่ <?= $c_village ?> <?php if($c_road == ""){echo 'ถนน -';}else{echo 'ถนน'.$c_road;};  ?>
                                                    ตำบล<?= $district_name_th ?> อำเภอ<?= $amphures_name_th ?> จังหวัด<?= $provinces_name_th ?> <?= $zip_code ?>&nbsp;
                                                </h6>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6 class="text">โทรศัพท์  : <?php if($cs_tel == ""){echo  '-';}else{echo $cs_tel;};  ?></h6>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6 class="text">อีเมล์   : <?php if($cs_mail == ""){echo  '-';}else{echo $cs_mail;};  ?></h6>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6 class="text">แฟกซ์   : <?php if($cs_fax == ""){echo  '-';}else{echo $cs_fax;};  ?></h6>
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