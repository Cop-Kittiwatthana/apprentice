<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $s_id = $_GET["id"];
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
        <title>ข้อมูลนักศึกษาที่ยกเลิกการฝึก</title>
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
                            <li class="breadcrumb-item"><a href="indexdismiss.php">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">รายชื่อข้อมูลนักศึกษาที่ยกเลิกการฝึก</li>
                        </ol>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <font size="6" face="TH SarabunPSK"> รายชื่อข้อมูลนักศึกษาที่ยกเลิกการฝึก </font>
                                   
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered " id="data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                            <th style="background-color: #f8f9fc;"width="10%">รหัสนักศึกษา</th>
                                                <th style="background-color: #f8f9fc;" width="30%">ชื่อ-สกุล</th>
                                                <th style="background-color: #f8f9fc;" width="30%">
                                                    <select name="branch" id="branch" class="form-control">
                                                        <option value="">สาขา</option>
                                                        <?php
                                                        $query = "SELECT branch.*  FROM branch  GROUP BY br_id  ORDER BY br_id ASC";
                                                        $result = mysqli_query($conn, $query);
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <option value="<?php echo $row["br_id"]; ?>"><?php echo $row["br_na"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </th>
                                                <th style="background-color: #f8f9fc;text-align:center;" width="30%"></th>
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

            function load_data(is_branch) {
                var dataTable = $('#data').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "ajax": {
                        url: "datadismissstd.php",
                        type: "POST",
                        data: {
                            s_id: <?= $s_id ?>,
                            pe_semester: <?= $pe_semester ?>,
                            is_branch: is_branch
                        },
                        error: function() { // error handling
                            $(".data-error").html("");
                            $("#data").append('<tbody class="parish-data-error"><tr><th colspan="4">No data found in the server</th></tr></tbody>');
                            $("#data-processing").css("display", "none");
                        }
                    },
                    "columnDefs": [{
                        "targets": [2],
                        "orderable": false,
                    }, ],
                });
            }
            $(document).on('change', '#branch', function() {
                var branch = $(this).val();
                $('#data').DataTable().destroy();
                if (branch != '') {
                    load_data(branch);
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