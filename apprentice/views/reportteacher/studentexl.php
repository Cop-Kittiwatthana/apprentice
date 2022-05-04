<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];

    $n_group = $_GET["n_group"];
    $n_year = $_GET["n_year"];
    $br_id = $_GET["br_id"];

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>ข้อมูลอาจารย์ทีปรึกษา</title>
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
                            <li class="breadcrumb-item"><a href="">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">รายงานนักศึกษาแบ่งตามอาจารย์ทีปรึกษา</li>
                        </ol>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <font size="6" face="TH SarabunPSK"> รายงานนักศึกษาแบ่งตามอาจารย์ทีปรึกษา </font>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered " id="data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;" width="10%">รหัสนักศึกษา</th>
                                                <th style="text-align: center;" width="30%">ชื่อ-สกุล</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query1 = "SELECT student.s_id,student.s_fna,student.s_lna,advisor.n_year,advisor.n_group FROM advisor 
                                            INNER JOIN student ON advisor.s_id = student.s_id
                                            INNER JOIN teacher ON advisor.t_id = teacher.t_id
                                            WHERE  advisor.n_group = '$n_group'  and advisor.n_year= '$n_year' and advisor.br_id= '$br_id'
                                            GROUP BY advisor.s_id
                                            ORDER BY advisor.s_id";
                                            $result = mysqli_query($conn, $query1);
                                            while ($row = mysqli_fetch_array($result)) { ?>
                                                <tr class="text-dark" style="text-align: center;">
                                                    <td width="150"><?php echo $row['s_id']; ?></td>
                                                    <td  width="150" class="name">
                                                        <?php echo $row['s_fna'] ?>&nbsp;<?php echo $row['s_lna']; ?>
                                                    </td >
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <button class='DLtoExcel btn btn-success' style="clear: both;">Excel</button>
                                    <!-- Bootstrap core JavaScript-->

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
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src='excelexportjs.js'></script>
    <script type="text/javascript">
        // var $btnDLtoExcel = $('#DLtoExcel');
        $('.DLtoExcel').on('click', function() {
            // alert('00');          
            $("#data").excelexportjs({
                containerid: "data",
                datatype: 'table'
            });
        });
        /* 
         var $btnDLtoExcel = $('#DLtoExcel');
         $btnDLtoExcel.on('click', function () {
           $("#dataTable").excelexportjs({
             containerid: "dataTable"
             ,datatype: 'table'
           });
         });
         */
    </script>
<?php
} else {
    echo "<script> alert('Please Login'); window.location='../../index.php';</script>";
    exit();
}
?>