<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0' &&  $_SESSION["type"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];

    $query = "SELECT * FROM petition ORDER BY pe_semester ASC";
    $result = mysqli_query($conn, $query);
    $id = $_GET['id'];
    $pe_semester = $_GET['year'];


    if ($id == 0) {
        $hname = "คำร้องรอการตรวจสอบ";
    }
    if ($id == 1) {
        $hname = "ตรวจสอบแล้ว";
    }
    if ($id == 2) {
        $hname = "สถานประกอบการตอบรับ";
    }
    if ($id == 3) {
        $hname = "สถานประกอบการปฏิเสธ";
    }
    if ($id == 5) {
        $hname = "กำลังออกฝึก";
    }
    if ($id == 6) {
        $hname = "เสร็จสิ้นการฝึกงานเทอม1";
    }
    if ($id == 7) {
        $hname = "เปลี่ยนสถานที่ฝึก";
    }
    if ($id == 8) {
        $hname = "เสร็จสิ้นการฝึกงาน";
    }
    if ($id == 10) {
        $hname = "ยกเลิกการฝึกงาน";
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
        <title>ข้อมูลการยื่นเรื่องฝึกงาน</title>
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
                            <li class="breadcrumb-item"><a href="index.php?year=<?= $pe_semester ?>">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">รายงานสถานะ<?= $hname ?></li>
                        </ol>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <font size="6" face="TH SarabunPSK"> รายงานสถานะ<?= $hname ?></font>

                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered " id="data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #f8f9fc;">#</th>
                                                <th style="background-color: #f8f9fc;">ชื่อนักศึกษา</th>
                                                <th style="background-color: #f8f9fc;">วันที่ยื่นเรื่อง</th>
                                                <th style="background-color: #f8f9fc;">ปีการศึกษา</th>
                                                <th style="background-color: #f8f9fc;">
                                                    <select name="year" id="year" class="form-control">
                                                        <option value="">กรุณาเลือกสาขา</option>
                                                        <?php
                                                        $query = "SELECT branch.* FROM branch GROUP BY br_id  ORDER BY br_id ASC";
                                                        $result = mysqli_query($conn, $query);
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <option value="<?php echo $row["br_id"]; ?>"><?php echo $row["br_na"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </th>
                                                <th style="background-color: #f8f9fc;" width="160">สถานะ</th>
                                                <!-- <th style="background-color: #f8f9fc;">
                                                    <select name="category" id="category" class="form-control">
                                                        <option value="">กรุณาเลือกสถานะ</option>
                                                        <option selected value="0">รอตรวจสอบ</option>
                                                        <option value="2">รับเข้าฝึก</option>
                                                        <option value="3">ปฏิเสธรับเข้าฝึก</option>
                                                        <option value="4">ข้อมูลไม่ถูกต้อง</option>
                                                        <option value="5">กำลังออกฝึก</option>
                                                        <option value="6">ฝึกเสร็จเทอม1</option>
                                                        <option value="7">เปลี่ยนที่ฝึก</option>
                                                        <option value="8">ฝึกเสร็จสิ้น</option>
                                                    </select>
                                                </th> -->
                                                <th style="background-color: #f8f9fc;text-align:center;" width="120"></th>
                                                <!-- <th style="background-color: #f8f9fc;text-align:center;" width="120"></th> -->
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
    <script type="text/javascript" language="javascript">
        $(document).ready(function() {

            load_data();

            function load_data(is_year) {
                var dataTable = $('#data').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "ajax": {
                        url: "data_db.php",
                        type: "POST",
                        data: {
                            status: <?= $id ?>,
                            "pe_semester": <?= $pe_semester ?>,
                            is_year: is_year

                        },
                        error: function() { // error handling
                            $(".data-error").html("");
                            $("#data").append('<tbody class="parish-data-error"><tr><th colspan="4">No data found in the server</th></tr></tbody>');
                            $("#data-processing").css("display", "none");
                        }
                    },
                    "columnDefs": [{
                        "targets": [4],
                        "orderable": false,
                    }, ],
                });
            }

            $(document).on('change', '#year', function() {
                var year = $(this).val();
                $('#data').DataTable().destroy();
                if (year != '') {
                    load_data(year);
                } else {
                    load_data();
                }
            });
        });
    </script>
<?php
} else {
    echo "<script> alert('Please Login'); window.location='../../index.php';</script>";
    exit();
}
?>