<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];

    $query_teacher = "SELECT * FROM teacher where t_fna !='ผู้ดูแลระบบ' and t_lna !='สูงสุด' ";
    $result_teacher = mysqli_query($conn, $query_teacher);

    $br_id = $_GET['id'];
    $pe_semester = $_GET['year'];

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
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="indexsup.php?year=<?= $pe_semester ?>">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="indexstd.php?id=<?= $br_id ?>&year=<?= $pe_semester ?>">รายงานอาจารย์นิเทศ</a></li>
                            <li class="breadcrumb-item active">เพิ่มข้อมูลอาจารย์นิเทศ</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> เพิ่มข้อมูลอาจารย์นิเทศ</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <input type=hidden name="br_id" id="br_id" value="<?= $br_id ?>">
                            <input type=hidden name="pe_semester" id="pe_semester" value="<?= $pe_semester ?>">
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>อาจารย์นิเทศ :<a style="color:red;">*</a></th>
                                        <td>
                                            <select id="t_id" name="t_id[]" class="form-control" placeholder="กรุณาเลือกอาจารย์ที่ปรึกษา" multiple size="1">
                                                <?php
                                                // $query_teacher = "SELECT  teacher.t_id,teacher.t_fna,teacher.t_lna,position.p_na
                                                // from teacher 
                                                // left join position ON teacher.p_id = position.p_id
                                                // WHERE teacher.t_fna !='ผู้ดูแลระบบ' and teacher.t_lna !='สูงสุด'";
                                                $query_teacher = "SELECT  teacher.t_id,teacher.t_fna,teacher.t_lna,position.p_na
                                                from teacher
                                                LEFT JOIN position ON teacher.p_id = position.p_id
                                                LEFT JOIN department ON teacher.dp_id = department.dp_id
                                                LEFT JOIN branch ON department.dp_id = branch.dp_id
                                                WHERE teacher.t_fna !='ผู้ดูแลระบบ' and teacher.t_lna !='สูงสุด' and branch.br_id = '$br_id'";
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

                                <?php
                                $query_student = "SELECT petition.pe_id,petition.s_id,student.s_fna,student.s_lna,company.c_na
                                                from petition 
                                                left join student on petition.s_id = student.s_id
                                                left JOIN demand ON petition.de_id  = demand.de_id
                                                left join company ON demand.c_id = company.c_id 
                                                left join sup_instructor ON petition.pe_id = sup_instructor.pe_id
                                                left join supervision ON petition.pe_id = supervision.pe_id 
                                                -- where (sup_instructor.t_id = '0' or sup_instructor.t_id is null )
                                                -- and(petition.pe_status = '5' or petition.pe_status = '6' )
                                                -- and petition.pe_semester = '$pe_semester' and student.br_id = '$br_id'
                                                where petition.pe_semester = '$pe_semester' and student.br_id = '$br_id'
                                                GROUP BY petition.s_id ";
                                $result_student = mysqli_query($conn, $query_student);
                                $total = mysqli_num_rows($result_student);
                                if ($total != 0) {
                                    while ($row1 = mysqli_fetch_array($result_student)) {
                                ?>
                                        <input type=hidden name="s_id[]" id="s_id" value="<?= $row1['s_id'] ?>">
                                <?php }
                                } ?>
                            </tr>
                            <br>
                            <div class="footer d-flex justify-content-center">
                                <input type="hidden" name="btnsave" id="btnsave" value="บันทึก">
                                <button class="btn btn-success btn-lg" type="submit" name="btnsave" id="btnsave" value="บันทึก">บันทึก</button>&nbsp;
                                <button class="btn btn-danger btn-lg" onclick="resetForm();" type="reset" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button>
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
            //$('.action').change(function() {
            //if ($(this).val() != '') {
            // var action = $(this).attr("id");
            // var query = $(this).val();
            ///var result = '';
            // if (action == 'company') {
            //     result = 'student';
            // }
            $.ajax({
                url: 'fetch.php',
                method: "POST",
                data: {
                    // action: action,
                    // query: query,
                    year: <?= $pe_semester ?>,
                    br_id: <?= $br_id ?>
                },
                success: function(data) {
                    $('#student').html(data);
                    $('#student').data('plugin_lwMultiSelect').updateList();
                }
            })
            //}
            //});
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
            $('#form1').on('reset', function(event) {
                document.getElementById("form1").reset();
                $('#student').html('');
                $('#student').data('plugin_lwMultiSelect').updateList();
                $('#student').data('plugin_lwMultiSelect').removeAll();
                $('#form1')[0].reset();

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