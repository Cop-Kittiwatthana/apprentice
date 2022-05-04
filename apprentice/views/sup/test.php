<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];

    $query_teacher = "SELECT * FROM teacher where t_fna !='ผู้ดูแลระบบ' and t_lna !='สูงสุด' ";
    $result_teacher = mysqli_query($conn, $query_teacher);

    $de_id = $_GET['de_id'];
    $c_id = $_GET['c_id'];
    $su_term = $_GET['su_term'];
    $query = "SELECT company.c_na,petition.pe_semester,branch.br_na
    FROM supervision  
    LEFT JOIN petition ON supervision.pe_id  = petition.pe_id
    LEFT JOIN demand ON petition.de_id  = demand.de_id
    LEFT JOIN branch ON demand.br_id  = branch.br_id
    LEFT JOIN company ON demand.c_id  = company.c_id
    WHERE demand.de_id = '$de_id' and company.c_id = '$c_id' and supervision.su_term = '$su_term'";
    $result = mysqli_query($conn, $query) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {
        $c_na = "$row[c_na]";
        $pe_semester = "$row[pe_semester]";
        $br_na = "$row[br_na]";
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>ข้อมูลอาจารย์นิเทศ</title>

        <?php include("../../head.php"); ?>
        <link rel="stylesheet" href="../../dist/css/choices.min.css">
        <script src="../../dist/js/choices.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="../../dist/js/jquery.lwMultiSelect.js"></script>
        <link rel="stylesheet" href="../../dist/css/jquery.lwMultiSelect.css" />
        <style>
            .lwms-main .lwms-left li.lwms-selectli,
            .lwms-main .lwms-right li.lwms-selectli {
                font-size: 16px;
                font-weight: normal;
            }

            .lwms-filterhead {
                font-size: 16px;
                font-weight: normal;
            }

            .lwms-main .lwms-left {
                margin-right: 5px;
            }

            .lwms-main .lwms-right {
                margin-left: 5px;
            }

            .lwms-main .lwms-left,
            .lwms-main .lwms-right {
                margin: auto;
                width: 50%;
                padding: 10px;
            }
        </style>
    </head>

    <body id="page-top">

        <div id="wrapper">
            <?php include("../../sidebar_login.php"); ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php"); ?>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> เพิ่มข้อมูลอาจารย์นิเทศ</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <input type=hidden name="c_id" id="c_id" value="<?= $c_id ?>">
                            <input type=hidden name="de_id" id="de_id" value="<?= $de_id ?>">
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>อาจารย์นิเทศ :<a style="color:red;">*</a></th>
                                        <td>
                                            <select id="t_id" name="t_id[]" class="form-control" placeholder="กรุณาเลือกอาจารย์ที่ปรึกษา" multiple size="1">
                                                <?php
                                                $query_teacher = "SELECT  teacher.t_id,teacher.t_fna,teacher.t_lna,position.p_na
                                                from teacher 
                                                left join position ON teacher.p_id = position.p_id
                                                WHERE teacher.t_fna !='ผู้ดูแลระบบ' and teacher.t_lna !='สูงสุด'";
                                                $result_teacher = mysqli_query($conn, $query_teacher); ?>
                                                <?php while ($rs = mysqli_fetch_array($result_teacher)) {
                                                    echo "<option value=\"$rs[t_id]\"";
                                                    if ("$rs[status]" == "ture") {
                                                        echo 'selected';
                                                    }
                                                    echo ">$rs[t_fna]&nbsp;$rs[t_lna]&nbsp;($rs[p_na])";
                                                    echo "</option>\n";
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>สถานประกอบการ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select name="company" id="company" class="form-control action">
                                                    <option value="reset">กรุณาเลือกสถานประกอบการ</option>
                                                    <option value="all">เลือกทั้งหมด</option>
                                                    <?php $query = "SELECT * FROM company GROUP BY c_id";
                                                    $result = mysqli_query($conn, $query);
                                                    foreach ($result as $value) { ?>
                                                        <option value="<?= $value['c_id'] ?>"><?= $value['c_na'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>รายชื่อนักศึกษา :<a style="color:red;">*</a></th>
                                    </div>
                                </div>
                            </tr>
                        </div>
                        <div class="container text-dark " style="width: 80%; height: auto;">
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- <th>รายชื่อนักศึกษา :<a style="color:red;">*</a></th> -->
                                        <td>
                                            <div class="input-group mb-3">
                                                <select name="student[]" id="student" multiple class="form-control"></select>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <div class="footer d-flex justify-content-center">
                                <input type="hidden" name="btntest" id="btntest" value="บันทึก">
                                <button class="btn btn-success btn-lg" type="submit" name="btntest" id="btntest" value="บันทึก">บันทึก</button>&nbsp;
                                <button class="btn btn-danger btn-lg" type="reset" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button>
                                <!-- <button class="btn btn-danger" type="reset" onclick="window.history.back()" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button> -->
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
    <script>
        $(document).ready(function() {
            var multipleCancelButton = new Choices('#t_id', {
                removeItemButton: true,
                maxItemCount: 2,
                minItemCount: 2,
                searchResultLimit: 5,
                //renderChoiceLimit: 5
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#student').lwMultiSelect();
            $('.action').change(function() {
                if ($(this).val() != '') {
                    var action = $(this).attr("id");
                    var query = $(this).val();
                    var result = '';
                    if (action == 'company') {
                        result = 'student';
                    }
                    $.ajax({
                        url: 'fetch.php',
                        method: "POST",
                        data: {
                            action: action,
                            query: query
                        },
                        success: function(data) {
                            $('#' + result).html(data);
                            if (result == 'student') {
                                $('#student').data('plugin_lwMultiSelect').updateList();
                                $('#br_na').data('plugin_lwMultiSelect').updateList();
                            }
                        }
                    })
                }
            });
            $('#form1').on('submit', function(event) {
                event.preventDefault();
                if ($('#company').val() == 'reset') {
                    Swal.fire({
                        type: 'error',
                        title: 'กรุณาเลือกสถานประกอบการ',
                        showConfirmButton: true,
                        timer: 1500
                    })
                    return false;
                } else if ($('#student').val() == '') {
                    Swal.fire({
                        type: 'error',
                        title: 'กรุณาเลือกนักศึกษา',
                        showConfirmButton: true,
                        timer: 1500
                    })
                    return false;
                } else {
                    document.getElementById("form1").submit();
                }
            });

        });
    </script>

    </html>
<?php
} else {
    echo ("<script> alert('please login'); window.location='../../index.php';</script>");
    exit();
}
?>