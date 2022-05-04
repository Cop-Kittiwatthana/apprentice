<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) && $_SESSION["status"] == '2') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $c_id = $_GET['c_id'];
    $de_id = $_GET['de_id'];
    $s_id = $_GET['s_id'];
    $query = "SELECT company.*,demand.*,branch.* FROM company
    INNER JOIN demand on demand.c_id=company.c_id
    INNER JOIN branch on branch.br_id=demand.br_id
    WHERE company.c_id = '$c_id' and demand.de_id='$de_id'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {
        $c_na = "$row[c_na]";
        $br_id = "$row[br_id]";
    }
    $date = date("d-m-Y");
    // $de_day = date('d', strtotime($i . 'd'));
    // $de_month = date('m', strtotime($i . 'm'));
    // $de_year = date('Y', strtotime($i . 'year'));

    $query_branch = "SELECT department.*,branch.* FROM department inner JOIN branch ON department.dp_id = branch.dp_id";
    $result_branch = mysqli_query($conn, $query_branch);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>ข้อมูลผู้ติดต่อ</title>

        <?php include("../../head.php"); ?>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js" integrity="sha256-0YPKAwZP7Mp3ALMRVB2i8GXeEndvCq3eSl/WsAl1Ryk=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
        <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js" integrity="sha512-cp+S0Bkyv7xKBSbmjJR0K7va0cor7vHYhETzm2Jy//ZTQDUvugH/byC4eWuTii9o5HN9msulx2zqhEXWau20Dg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>

    <body id="page-top">

        <div id="wrapper">
            <?php include("../../sidebar_login.php"); ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php"); ?>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> ยื่นคำร้อง</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <input type=hidden name="c_id" id="c_id" value="<?= $c_id ?>">
                            <input type=hidden name="s_id" id="s_id" value="<?= $s_id ?>">
                            <input type=hidden name="pe_status" id="pe_status" value="0">
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
                                                <input name="pe_semester" id="pe_semester" maxlength="4" class="form-control" require placeholder="-กรุณาใส่ปีการศึกษา-" onkeypress="isInputNumber(event)" type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>วันที่เริ่มต้น :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input class="form-control" placeholder="กรุณาเลือก ว/ด/ป " autocomplete="off" type="text" name="pe_date1" id="pe_date1" data-date-language="th-th" />
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-6">
                                        <th>วันที่สิ้นสุด:<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input class="form-control" placeholder="กรุณาเลือก ว/ด/ป " autocomplete="off" type="text" name="pe_date2" id="pe_date2" data-date-language="th-th" />
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <br>
                            <div class="footer d-flex justify-content-center">
                                <button class="btn btn-success btn-lg" type="submit" name="btnsave" id="btnsave" value="บันทึก">บันทึก</button>&nbsp;
                                <button class="btn btn-danger btn-lg" type="reset" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button>
                                <!-- <button class="btn btn-danger" type="reset" onclick="window.history.back()" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button> -->
                            </div>
                        </div>
                    </form>
                </div>
                <?php include("../../footer.php"); ?>
            </div>
        </div>
        <script type="text/javascript">
            $(function() {
                $("#pe_date1").datepicker({
                    minDate: 0,
                    locale: 'th',
                    numberOfMonths: 2,
                    onSelect: function(selected) {
                        var dt = new Date(selected);
                        dt.setDate(dt.getDate() + 1);
                        $("#pe_date2").datepicker("option", "minDate", dt);
                    },
                    format: 'dd-mm-yyyy',

                });
                $("#pe_date2").datepicker({
                    locale: 'th',
                    minDate: 0,
                    yearOffset: +543,
                    numberOfMonths: 2,
                    onSelect: function(selected) {
                        var dt = new Date(selected);
                        dt.setDate(dt.getDate() - 1);
                        $("#pe_date1").datepicker("option", "maxDate", dt);
                    },
                    format: 'dd-mm-yyyy',
                });
            });
        </script>
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
    <!-- <script src="<?= $baseURL ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="<?= $baseURL ?>/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= $baseURL ?>/js/sb-admin-2.min.js"></script>
    <script src="<?= $baseURL ?>/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= $baseURL ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    </body>

    </html>
<?php
} else {
    echo "<script> alert('Please Login'); window.location='../../index.php';</script>";
    exit();
}
?>