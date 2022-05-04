<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '2') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $s_id = $_GET['s_id'];

    $query = "SELECT petition.* FROM petition
    WHERE petition.s_id= '$s_id'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {
        $pe_status = "$row[pe_status]";
        $note = "$row[note]";
    }
    $query = "SELECT student.* FROM student
    WHERE student.s_id= '$s_id'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {
        $s_status = "$row[s_status]";
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
        <script type="text/javascript" language="javascript">
            $(document).ready(function() {
                var dataTable = $('#data').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "data.php", // json datasource
                        type: "post",
                        data: {
                            "s_id": <?= $_GET['s_id'] ?>
                        }, // method  , by default get
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
    <div></div>

    <body id="page-top">
        <div id="wrapper">
            <?php include("../../sidebar_login.php") ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php") ?>
                    <div class="container-fluid">
                        <!-- <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/petition/indexcompany.php?s_id=<?= $s_id ?>">รายชื่อสถานประกอบการ</a></li>
                            <li class="breadcrumb-item active">สถานะการยื่นเรื่อง </li>
                        </ol> -->
                        <?php if ($pe_status == 4) { ?>
                            <div class="alert alert-danger" role="alert">
                                กรุณาตรวจสอบข้อมูล : <?= $note ?><br>
                                <br>
                                หมายเหตุ : หากแก้ไขข้อมูลเรีบยร้อยแล้ว ให้กดปุ้มแก้ไขแล้วบันทึกเพื่อส่งเรื่องการแก้ไขข้อมูล
                            </div>
                            <!-- <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div> -->
                        <?php } ?>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <font size="6" face="TH SarabunPSK"> รายงานสถานะการยื่นเรื่อง </font>
                                    <?php if ($s_status == '2') {
                                        if ($pe_status == "" || $pe_status == 7 || $pe_status == 10) { ?>
                                            <a href="indexcompany.php?s_id=<?= $s_id ?>"><span class="btn btn-primary fa fas-plus float-right "><i class="fas fa-plus-circle"> ยื่นคำร้องขอฝึกงาน</i></a>
                                        <?php }
                                        if ($pe_status == "8") {
                                        } ?>
                                        <?php
                                    } else {
                                        if ($pe_status != "8") { ?>
                                            <a href=""><span class="btn btn-primary fa fas-plus float-right "><i class="fas fa-plus-circle"> ยังไม่เปิดให้ยื่นคำร้องขอฝึกงาน</i></a>
                                    <?php }
                                    }  ?>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered " id="data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #f8f9fc;">#</th>
                                                <th style="background-color: #f8f9fc;">ชื่อสถานประกอบการ</th>
                                                <th style="background-color: #f8f9fc;">วันที่ยื่นเรื่อง</th>
                                                <th style="background-color: #f8f9fc;">สถานะ</th>
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