<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];


    $s_id = $_GET["s_id"];
    $c_id = $_GET["c_id"];
    $pe_semester = $_GET["pe_semester"];

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
        <title>ข้อมูลผลงานนักศึกษา</title>
        <?php include("../../head.php") ?>
        <script type="text/javascript" language="javascript">
            $(document).ready(function() {
                var dataTable = $('#data').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "dataportfolio.php", // json datasource
                        type: "post", // method  , by default get
                        data: {
                            "s_id": <?= $s_id ?>
                        },
                        error: function() { // error handling
                            $(".data-error").html("");
                            $("#data").append('<tbody class="parish-data-error"><tr><th colspan="4">No data found in the server</th></tr></tbody>');
                            $("#data-processing").css("display", "none");
                        }
                    }
                });
            });
        </script>
    </head>

    <body id="page-top">
        <div id="wrapper">
            <?php include("../../sidebar_login.php") ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php") ?>
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                            <!-- <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/company/editme.php?c_id=<?= $c_id ?>">หน้าหลัก</a></li> -->
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/reportcompany/indexporfolio.php?c_id=<?= $c_id ?>">ข้อมูลนักศึกษาแบ่งตามสถานประกอบการ</a></li>
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/reportcompany/indexstdporfolio.php?c_id=<?= $c_id ?>&pe_semester=<?= $pe_semester ?>">รายชื่อนักศึกษาฝึกงาน</a></li>
                            <li class="breadcrumb-item active">รายงานข้อมูลผลงานนักศึกษา </li>
                        </ol>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <font size="6" face="TH SarabunPSK"> รายงานข้อมูลผลงานนักศึกษา </font>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered " id="data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #f8f9fc;">#</th>
                                                <th style="background-color: #f8f9fc;">ชื่อผลงาน</th>
                                                <th style="background-color: #f8f9fc;" width="300">รูป</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
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