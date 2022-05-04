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
    $year = $_GET['year'];

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
                            <li class="breadcrumb-item"><a href="indexsup.php?year=<?= $year ?>">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">รายงานอาจารย์นิเทศ</li>
                        </ol>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <font size="6" face="TH SarabunPSK"> รายงานอาจารย์นิเทศ </font>
                                    <a href="editall.php?id=<?= $id; ?>&year=<?= $year ?>">
                                        <span class="btn btn-success fa fas-plus float-right "><i class="fas fa-plus-circle"> แก้ไขข้อมูลอาจารย์นิเทศทังหมด</i></a>
                                    <a href="add.php?id=<?= $id; ?>&year=<?= $year ?>">
                                        <span class="btn btn-primary fa fas-plus float-right "><i class="fas fa-plus-circle"> เพิ่มอาจารย์นิเทศ</i></a>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered " id="data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #f8f9fc;">#</th>
                                                <th style="background-color: #f8f9fc;">ชื่อนักศึกษา</th>
                                                <!-- <th style="background-color: #f8f9fc;">สถานประกอบการ</th> -->
                                                <th style="background-color: #f8f9fc;">
                                                    <select name="company" id="company" class="form-control">
                                                        <option value="">กรุณาเลือกสถานประกอบการ</option>
                                                        <?php
                                                        $query = "SELECT company.* FROM company GROUP BY c_id  ORDER BY c_id DESC";
                                                        $result = mysqli_query($conn, $query);
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <option value="<?php echo $row["c_id"]; ?>"><?php echo $row["c_na"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </th>
                                                <th style="background-color: #f8f9fc;text-align:center;" width="200"></th>
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

            function load_data(is_company) {
                var dataTable = $('#data').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "ajax": {
                        url: "data_std.php",
                        type: "POST",
                        data: {
                            br_id: <?= $id ?>,
                            year: <?= $year ?>,
                            is_company: is_company
                        },
                        error: function() { // error handling
                            $(".data-error").html("");
                            $("#data").append('<tbody class="parish-data-error"><tr><th colspan="4">No data found in the server</th></tr></tbody>');
                            $("#data-processing").css("display", "none");
                        }
                    },
                    "columnDefs": [{
                        "targets": [2, 3],
                        "orderable": false,
                    }, ],
                });
            }

            $(document).on('change', '#company', function() {
                var company = $(this).val();
                $('#data').DataTable().destroy();
                if (company != '') {
                    load_data(company);
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