<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
   
    if($username == 'admin' && $password == '1234'){
        $t_type = 0;
    }else{
        $t_type = 1;
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
        <title>ข้อมูลแจ้งเตือนไลน์</title>
        <?php include("../../head.php") ?>
        <script type="text/javascript" language="javascript">
            $(document).ready(function() {
                var dataTable = $('#data').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "data.php", // json datasource
                        type: "post", // method  , by default get
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
                    <!-- <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="../../indexnews.php">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">ข้อมูลแจ้งเตือนไลน์</li>
                        </ol> -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <font size="6" face="TH SarabunPSK"> รายงานข้อมูลแจ้งเตือนไลน์ </font><a href="add.php"><span class="btn btn-primary fa fas-plus float-right "><i class="fas fa-plus-circle"> เพิ่มข้อมูลแจ้งเตือนไลน์</i></a>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered " id="data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #f8f9fc;" >ชื่อกลุ่ม</th>
                                                <th style="background-color: #f8f9fc;" width="300">token</th>
                                                <th style="background-color: #f8f9fc;text-align:center;" width="200">แก้ไข/ลบ</th>
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