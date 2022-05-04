<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) && $_SESSION["status"] == '2' ) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $c_id = $_GET['c_id'];
    $de_id = $_GET['de_id'];
    $s_id = $_GET['s_id'];
    $pe_id = $_GET['pe_id'];
    // *-****************************สถานะการลงทะเบียน******************************************
    $query = "SELECT student.* FROM student WHERE student.s_id= '$s_id'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {
        $s_status = "$row[s_status]";
    }
    if ($s_status != '2') {
        // echo "<script> alert('ยังไม่เปิดให้ยื่นคำร้องขอฝึกงาน'); window.history.back()</script>";
        echo "<script> alert('ยังไม่เปิดให้ยื่นคำร้องขอฝึกงาน'); window.location='$baseURL/views/petition/index.php?s_id=$s_id';</script>";
        exit();
    }
    // *-********************************************************************************
    $query = "SELECT petition.*,company.*,demand.*,branch.*,department.* FROM petition
    LEFT JOIN demand ON petition.de_id  = demand.de_id 
    LEFT JOIN company ON demand.c_id  = company.c_id 
    INNER JOIN branch on branch.br_id=demand.br_id
    INNER JOIN department on department.dp_id=branch.dp_id
    WHERE petition.pe_id= '$pe_id' and company.c_id = '$c_id' and demand.de_id='$de_id'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {
        $c_na = "$row[c_na]";
        $br_id = "$row[br_id]";
        $pe_semester1 = "$row[pe_semester]";
        $pe_term = "$row[pe_term]";
        $pe_date1 = "$row[pe_date1]";
        $pe_date2 = "$row[pe_date2]";
    }
    $date = date("d-m-Y", strtotime($Result["order_sent"] . "+543 year"));
    // $de_day = date('d', strtotime($i . 'd'));
    // $de_month = date('m', strtotime($i . 'm'));
    // $de_year = date('Y', strtotime($i . 'year'));
    for ($i = 0; $i < 3; $i++) {
        $de_year1 = date('Y', strtotime($i . 'year'));
    }

    $query_branch = "SELECT department.*,branch.* FROM department inner JOIN branch ON department.dp_id = branch.dp_id";
    $result_branch = mysqli_query($conn, $query_branch);

    $query_notify = "SELECT * FROM notify WHERE name = 'กลุ่มผู้ดูแลระบบ' ";
    $result_notify = mysqli_query($conn, $query_notify);
    while ($row = mysqli_fetch_array($result_notify)) {
        $token = "$row[token]";
    }

    $query1 = "SELECT count(petition.s_id) as total,pe_semester
        FROM petition 
        inner JOIN student ON student.s_id = petition.s_id 
        where petition.s_id = '$s_id' and petition.pe_status = 10";
    $result1 = mysqli_query($conn, $query1) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result1)) {
        $total = "$row[total]";
        $pe_semester = "$row[pe_semester]";
    }
    $year = date("Y", strtotime($Result["order_sent"] . "+543 year"));
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
        <title>ข้อมูลคำร้อง</title>

        <?php include("../../head.php"); ?>
        <?php include("script_date.php"); ?>
        <style>
            input[type="radio"] {
                -ms-transform: scale(1.5);
                /* IE 9 */
                -webkit-transform: scale(1.5);
                /* Chrome, Safari, Opera */
                transform: scale(1.5);
                margin-top: 10px;
                margin-left: 10px;
            }
        </style>
    </head>

    <body id="page-top">

        <div id="wrapper">
            <?php include("../../sidebar_login.php"); ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php"); ?>
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php?s_id=<?= $s_id ?>">รายชื่อสถานประกอบการ</a></li>
                            <li class="breadcrumb-item active">สถานะการยื่นเรื่อง </li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> ยื่นคำร้อง</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <input type=hidden name="c_id" id="c_id" value="<?= $c_id ?>">
                            <input type=hidden name="de_id" id="de_id" value="<?= $de_id ?>">
                            <input type=hidden name="s_id" id="s_id" value="<?= $s_id ?>">
                            <input type=hidden name="pe_id" id="pe_id" value="<?= $pe_id ?>">
                            <input type=hidden name="pe_status" id="pe_status" value="0">
                            <input type=hidden name="token" id="token" value="<?= $token ?>">
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>สถานประกอบการ :</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="c_na" id="c_na" value="<?= $c_na ?>" class="form-control" type="text" readonly>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-6">
                                        <th>วันที่ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input class="form-control" readonly type="text" size="10" id="pe_date" name="pe_date" value="<?= $date ?>" require />
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-8">
                                        <th>แผนก-สาขา :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="br_id" id="br_id" disabled placeholder="-กรุณาเลือกแผนก-สาขา-" oninvalid="this.setCustomValidity('-กรุณาเลือกแผนก-สาขา-')" oninput="setCustomValidity('')">
                                                    <option value="0" <?= $br_id == 0 ? 'selected' : '' ?> disabled>-กรุณาเลือกแผนก-สาขา-</option>
                                                    <?php foreach ($result_branch as $value) { ?>
                                                        <option value="<?= $value['br_id'] ?>" <?= $value['br_id'] == $br_id ? 'selected' : '' ?>>
                                                            <?= $value['dp_na'] ?>-<?= $value['br_na'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-4">
                                        <th>ปีการศึกษา:<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="pe_semester" id="pe_semester" readonly value="<?= $pe_semester1 ?>" maxlength="4" class="form-control" require placeholder="-กรุณาใส่ปีการศึกษา-" onkeypress="isInputNumber(event)" type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if ($total == 0) { ?>
                                            <input type=hidden name="pe_term" id="pe_term" value="3">
                                        <?php  } else { ?>
                                            <td>
                                            <th>เทอม :<a style="color:red;">* </a><?php echo $pe_semester, '/', $year; ?></th>
                                            <?php if ($pe_semester != $year) { ?>
                                                <div class="input-group mb-3">
                                                    <input <?php echo ($pe_term == '' || $pe_term == '1') ? 'checked' : '' ?> class="form-check-input" type="radio" name="pe_term" id="pe_term" value="1">
                                                    <label class="form-check-label" style="margin-top: 5px;margin-left: 30px;">
                                                        &nbsp;1.เทอม1
                                                    </label>
                                                </div>
                                            <?php } else { ?>
                                                </td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input <?php echo ($pe_term == '' || $pe_term == '2') ? 'checked' : '' ?> class="form-check-input" type="radio" name="pe_term" id="pe_term" value="2">
                                                        <label class="form-check-label" style="margin-top: 5px;margin-left: 30px;">
                                                            &nbsp;2.เทอม2
                                                        </label>
                                                    </div>
                                                </td>
                                        <?php  }
                                        } ?>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>วันที่เริ่มต้น :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input class="form-control" placeholder="กรุณาเลือก ว/ด/ป " value="<?= $pe_date1 ?>" autocomplete="off" type="text" name="pe_date1" id="pe_date1" />
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-6">
                                        <th>วันที่สิ้นสุด:<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input class="form-control" placeholder="กรุณาเลือก ว/ด/ป " value="<?= $pe_date2 ?>" autocomplete="off" type="text" name="pe_date2" id="pe_date2" />
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <br>
                            <div class="footer d-flex justify-content-center">
                                <button class="btn btn-success btn-lg" type="submit" name="btnedit" id="btnedit" value='Send'>บันทึก</button>&nbsp;
                                <button class="btn btn-danger btn-lg" type="reset" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button>
                                <!-- <button class="btn btn-danger" type="reset" onclick="window.history.back()" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button> -->
                            </div>
                        </div>
                    </form>
                </div>
                <?php include("../../footer.php"); ?>
            </div>
        </div>
    </body>
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

    </html>
<?php
} else {
    echo "<script> alert('Please Login'); window.location='../../index.php';</script>";
    exit();
}
?>