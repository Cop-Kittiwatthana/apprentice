<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0' &&  $_SESSION["type"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];

    $query = "SELECT * FROM petition ORDER BY pe_semester ASC";
    $result = mysqli_query($conn, $query);

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
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
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <font size="6" face="TH SarabunPSK"> รายงานสถานะการยื่นเรื่อง </font>
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
                                                <th style="background-color: #f8f9fc;">
                                                    <select name="category" id="category" class="form-control">
                                                        <option value="">กรุณาเลือกสถานะ</option>
                                                        <option value="0">รอตรวจสอบ</option>
                                                        <option value="2">รับเข้าฝึก</option>
                                                        <option value="3">ปฏิเสธรับเข้าฝึก</option>
                                                        <option value="4">ข้อมูลไม่ถูกต้อง</option>
                                                        <option value="5">กำลังออกฝึก</option>
                                                        <option value="6">ฝึกเสร็จเทอม1</option>
                                                        <option value="7">เปลี่ยนที่ฝึก</option>
                                                        <option value="8">ฝึกเสร็จสิ้น</option>
                                                    </select>
                                                </th>
                                                <th style="background-color: #f8f9fc;text-align:center;" width="120"></th>
                                                <th style="background-color: #f8f9fc;text-align:center;" width="120"></th>
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

            function load_data(is_category) {
                var dataTable = $('#data').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "ajax": {
                        url: "test_db.php",
                        type: "POST",
                        data: {
                            is_category: is_category
                        }
                    },
                    "columnDefs": [{
                        "targets": [3],
                        "orderable": false,
                    }, ],
                });
            }

            $(document).on('change', '#category', function() {
                var category = $(this).val();
                $('#data').DataTable().destroy();
                if (category != '') {
                    load_data(category);
                } else {
                    load_data();
                }
            });
        });
    </script>
<?php
} else {
    echo "<script> alert('Please Login'); window.location='../../frm_loginteac.php';</script>";
    exit();
}
?>