<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) && $_SESSION["status"] == '3' || $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $query = "SELECT * FROM company WHERE c_user = '$username' and c_pass = '$password'";
    $result = mysqli_query($conn, $query)
        or die("3. ไม่สามารถประมวลผลคำสั่งได้") . $mysql->error();
    $data = array();
    $row = mysqli_fetch_array($result);
    $c_id1 = "$row[c_id]";
    $c_id2 = $_GET['c_id'];
    if ($c_id1 != "") {
        $c_id = $c_id1;
    } else {
        $c_id = $c_id2;
    }
    $query = "SELECT * FROM company WHERE c_id = '$c_id'";
    $result = mysqli_query($conn, $query)
        or die("3. ไม่สามารถประมวลผลคำสั่งได้") . $mysql->error();
    $data = array();
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $c_na = "$row[c_na]";
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
        <title>ข้อมูลผู้ติดต่อสถานประกอบการ</title>
        <?php include("../../head.php") ?>
        <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
        <script type="text/javascript" language="javascript">
            $(document).ready(function() {
                var dataTable = $('#data').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "data.php", // json datasource
                        type: "post", // method  , by default get
                        data: {
                            "c_id": <?= $_GET['c_id'] ?>
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
                        <?php if ($c_id1 != "") { ?>
                            
                        <?php }else{ ?>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/company/index.php">ข้อมูลสถานประกอบการ</a></li>
                                <li class="breadcrumb-item active">ข้อมูลผู้ติดต่อ</li>
                            </ol>
                        <?php } ?>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <font size="6" face="TH SarabunPSK"> รายงานข้อมูลผู้ติดต่อ[<?= $c_na ?>] </font><a href="add.php?c_id=<?= $c_id; ?>">
                                        <span class="btn btn-primary fa fas-plus float-right "><i class="fas fa-plus-circle"> เพิ่มข้อมูลผู้ติดต่อ</i></a>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered " id="data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #f8f9fc;">#</th>
                                                <th style="background-color: #f8f9fc;">คำนำหน้า</th>
                                                <th style="background-color: #f8f9fc;">ชื่อ-สกุล</th>
                                                <th style="background-color: #f8f9fc;">เบอร์</th>
                                                <th style="background-color: #f8f9fc;"></th>
                                                <th style="background-color: #f8f9fc;text-align:center;" width="200">แก้ไข/ลบ</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->
                <!-- Footer -->
                <?php include("../../footer.php") ?>
                <!-- End of Footer -->
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->

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