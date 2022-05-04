<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $id = $_GET['id'];

    $query1 = "SELECT SUBSTR(student.s_id,1,2) As id,student.s_sdate,student.s_edate 
    FROM student WHERE s_id LIKE '$id%' GROUP BY id ";
    $result1 = mysqli_query($conn, $query1);
    while ($row = mysqli_fetch_array($result1)) {  // preparing an array
        $s_sdate = "$row[s_sdate]";
        $s_edate = "$row[s_edate]";
    }
    //$date = date("d-m-Y", strtotime($Result["order_sent"] . "+543 year"));
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
        <title>ข้อมูลระยะเวลาการยื่นเรื่องฝึกงาน</title>

        <?php include("../../head.php"); ?>
        <?php include("script_date.php"); ?>
       
    </head>

    <body id="page-top">

        <div id="wrapper">
            <?php include("../../sidebar_login.php"); ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php"); ?>
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">ข้อมูลระยะเวลาการยื่นเรื่องฝึกงาน</a></li>
                            <li class="breadcrumb-item active">จัดการระยะเวลาการยื่นเรื่องฝึกงาน</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> จัดการระยะเวลาการยื่นเรื่องฝึกงาน</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <input type=hidden name="id" id="id" value="<?= $n_id ?>">
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>รหัสนักศึกษา :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input class="form-control" readonly type="text" id="id" name="id" value="<?= $id ?>"/>
                                            </div>
                                        </td>
                                    </div>

                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>วันที่เปิดลงทะเบียน :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input class="form-control" placeholder="กรุณาเลือก ว/ด/ป " value="<?= $s_sdate ?>" autocomplete="off" type="text" name="s_sdate" id="s_sdate" />
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-6">
                                        <th>วันที่สิ้นสุดลงทะเบียน:<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input class="form-control" placeholder="กรุณาเลือก ว/ด/ป " value="<?= $s_edate ?>" autocomplete="off" type="text" name="s_edate" id="s_edate" />
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <div class="footer d-flex justify-content-center">
                                <button class="btn btn-success btn-lg" type="submit" name="btnsave" id="btnsave" value="บันทึก">บันทึก</button>&nbsp;
                                <button class="btn btn-danger btn-lg" type="reset" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button>
                            </div>
                        </div>
                    </form>
                </div>
                <?php include("../../footer.php"); ?>
            </div>
        </div>
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">คำเตือน!</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">คุณต้องการออกจากระบบใช่หรือไม่?</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                        <a class="btn btn-primary" href="../../logout.php">ออกจากระบบ</a>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
        <!-- <script src="<?= $baseURL ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
        <script src="<?= $baseURL ?>/js/sb-admin-2.min.js"></script>
        <script src="<?= $baseURL ?>/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= $baseURL ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    </body>

    </html>
<?php
} else {
    echo ("<script> alert('please login'); window.location='../../index.php';</script>");
    exit();
}
?>
<?php include("../script.php"); ?>