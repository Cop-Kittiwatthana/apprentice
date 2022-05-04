<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    include("status.php");//sql การอัพเดท
    $br_id = $_GET['id'];
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
        <title>ข้อมูลนักศึกษา</title>
        <?php include("../../head.php") ?>
        <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
        <script type="text/javascript" language="javascript">
            $(document).ready(function() {
                var dataTable = $('#data').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "ajax": {
                        url: "data.php", // json datasource
                        type: "post", // method  , by default get
                        data: {
                            br_id: <?= $br_id ?>,
                            year: <?= $year ?>,
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
                            <!-- <li class="breadcrumb-item"><a href="../../indexnews.php">หน้าหลัก</a></li> -->
                            <li class="breadcrumb-item"><a href="indexsub.php?year=<?= $year ?>">จัดการข้อมูลนักศึกษา</a></li>
                            <li class="breadcrumb-item active">ข้อมูลนักศึกษา</li>
                        </ol>
                        <?php
                        if ($year != 0 || $year != "") {
                            $query = "SELECT advisor.*,branch.*,student.*,SUBSTR(student.s_id,1,2) As id
                            from  student
                            LEFT JOIN advisor ON advisor.s_id = student.s_id
                            LEFT JOIN branch ON student.br_id = branch.br_id
                            WHERE  advisor.t_id = '0' and student.s_id LIKE '$year%' and branch.br_id = '$br_id' 
                            GROUP BY student.s_group,student.br_id,id
                            ORDER BY id DESC";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_array($result)) {
                                if ($row['t_id'] == '0') { ?>
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>กรุณาเพิ่มอาจารย์ที่ปรึกษา!</strong>
                                        รุ่น<?= $row['id'] ?> กลุ่ม<?= $row['s_group'] ?> สาขา<?= $row['br_na'] ?>
                                        <a class="float-right " style="text-align:right;" href="<?= $baseURL; ?>/views/advisor/edit.php?id=<?= $row['id'] ?>&br_id=<?= $row['br_id'] ?>&s_group=<?= $row['s_group'] ?>">จัดการอาจารย์ที่ปรึกษา</a>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                        <?php
                                }
                            }
                        } ?>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <font size="6" face="TH SarabunPSK"> รายงานข้อมูลนักศึกษา</font>

                                    <a href="addexcel.php?id=<?= $br_id ?>&year=<?= $year ?>"><span class="btn btn-info fa fas-plus float-right "><i class="fas fa-plus-circle"> เพิ่มข้อมูลนักศึกษา Excel</i></a>
                                    <a href="add.php?id=<?= $br_id ?>&year=<?= $year ?>"><span class="btn btn-primary fa fas-plus float-right "><i class="fas fa-plus-circle"> เพิ่มข้อมูลนักศึกษา</i></a>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered " id="data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #f8f9fc;" width="15%">#</th>
                                                <th style="background-color: #f8f9fc;" width="15%">คำนำหน้า</th>
                                                <th style="background-color: #f8f9fc;">ชื่อ-นามสกุล</th>
                                                <!-- <th style="background-color: #f8f9fc;">สถานะการฝึก</th> -->
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