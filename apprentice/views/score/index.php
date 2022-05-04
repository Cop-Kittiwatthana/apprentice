<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];

    $br_id = $_GET["id"];
    $query = "SELECT * FROM results ORDER BY r_id ASC";
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
        <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/brand.png">
        <title>ข้อมูลผลการฝึกงาน</title>
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
                            <!-- <li class="breadcrumb-item"><a href="../../indexnews.php">หน้าหลัก</a></li> -->
                            <li class="breadcrumb-item"><a href="indexsub.php">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">ข้อมูลผลการฝึกงาน</li>
                        </ol>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                <font size="6" face="TH SarabunPSK"> รายงานข้อมูลผลการฝึกงาน </font>        
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered " id="data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <!-- <th style="background-color: #f8f9fc;">ปีการศึกษา</th> -->
                                                <th style="background-color: #f8f9fc;" width="20%">
                                                    <select name="year" id="year" class="form-control">
                                                        <option value="">ปีการศึกษา</option>
                                                        <?php
                                                        $query = "SELECT pe_semester FROM petition GROUP BY pe_semester  ORDER BY pe_semester DESC";
                                                        $result = mysqli_query($conn, $query);
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <option value="<?php echo $row["pe_semester"]; ?>"><?php echo $row["pe_semester"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </th>
                                                <th style="background-color: #f8f9fc;">กลุ่ม</th>
                                                <th style="background-color: #f8f9fc;">รหัสนักศึกษา</th>
                                                <th style="background-color: #f8f9fc;text-align:center;" width="200"></th>
                                                <th style="background-color: #f8f9fc;text-align:center;" width="200"></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include("../../footer.php") ?>
                <!-- End of Footer -->
            </div>
        </div>
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
                        url: "data.php",
                        type: "POST",
                        data: {
                            is_year: is_year,
                            is_branch: <?= $br_id ?>
                        },
                        error: function() { // error handling
                            $(".data-error").html("");
                            $("#data").append('<tbody class="parish-data-error"><tr><th colspan="4">No data found in the server</th></tr></tbody>');
                            $("#data-processing").css("display", "none");
                        }
                    },
                    "columnDefs": [{
                        "targets": [0,3,4],
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