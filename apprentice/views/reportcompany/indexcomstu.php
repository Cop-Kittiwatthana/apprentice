<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '3') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];

    $c_id = $_GET['c_id'];
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
        <title>ข้อมูลนักศึกษาฝึกงานแบ่งตามสถานประกอบการ</title>
        <?php include("../../head.php") ?>
    </head>

    <body id="page-top">
        <div id="wrapper">
            <?php include("../../sidebar_login.php") ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php") ?>
                    <div class="container-fluid">
                    <!-- <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/company/editme.php?c_id=<?= $c_id ?>">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">รายงานข้อมูลนักศึกษาแบ่งตามสถานประกอบการ </li>
                        </ol> -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <font size="6" face="TH SarabunPSK"> รายงานข้อมูลนักศึกษาแบ่งตามสถานประกอบการ </font>
                                    <!-- <a href="add.php"><span class="btn btn-primary fa fas-plus float-right "><i class="fas fa-plus-circle"> เพิ่มข้อมูลอาจารย์ทีปรึกษา</i></a> -->
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered " id="data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #f8f9fc;" width="70%">
                                                    <select name="year" id="year" class="form-control">
                                                        <option value="">ปีการศึกษา</option>
                                                        <?php
                                                        $query = "SELECT pe_semester FROM petition GROUP BY pe_semester  ORDER BY pe_semester DESC";
                                                        $result = mysqli_query($conn, $query);
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <option value="<?php echo $row["pe_semester"]; ?>"><?php echo $row["pe_semester"]; ?>-<?php echo $pe_semester = (int)$row["pe_semester"]+1; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </th>
                                                <!-- <th style="background-color: #f8f9fc;text-align:center;" width="20%">จำนวนนักศึกษา</th> -->
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
                <?php include("../../footer.php") ?>
                <!-- End of Footer -->
            </div>
        </div>
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
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
                        url: "datacomstu.php",
                        type: "POST",
                        data: {
                            is_year: is_year,
                            c_id: <?= $c_id ?>
                        },
                        error: function() { // error handling
                            $(".data-error").html("");
                            $("#data").append('<tbody class="parish-data-error"><tr><th colspan="4">No data found in the server</th></tr></tbody>');
                            $("#data-processing").css("display", "none");
                        }
                    },
                    "columnDefs": [{
                        "targets": [0,1],
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