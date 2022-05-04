<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];

    $query_teacher = "SELECT teacher.*,position.* FROM teacher 
    LEFT JOIN position ON position.p_id = teacher.p_id
    where t_fna !='ผู้ดูแลระบบ' and t_lna !='สูงสุด'";
    $result_teacher = mysqli_query($conn, $query_teacher);

    $query_student = "SELECT student.*,branch.* FROM student 
    LEFT JOIN branch ON branch.br_id = student.br_id
    ORDER BY s_id";
    $result_student = mysqli_query($conn, $query_student);

    $result_branch = "SELECT * FROM branch";
    $result_branch  = mysqli_query($conn, $result_branch);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>ข้อมูลความต้องการ</title>

        <?php include("../../head.php"); ?>
        <link rel="stylesheet" href="../../dist/css/choices.min.css">
        <script src="../../dist/js/choices.min.js"></script>
    </head>

    <body id="page-top">

        <div id="wrapper">
            <?php include("../../sidebar_login.php"); ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php"); ?>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> เพิ่มข้อมูลอาจารย์ทีปรึกษา</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <!-- <input type=hidden name="c_id" id="c_id" value="<?= $c_id ?>"> -->
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>สาขา :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="br_id" id="br_id" placeholder="-กรุณาเลือกแผนก-" size="1" oninvalid="this.setCustomValidity('-กรุณาเลือกแผนก-')" oninput="setCustomValidity('')">
                                                    <option value="" selected disabled>-กรุณาเลือกสาขา-</option>
                                                    <?php foreach ($result_branch as $value) { ?>
                                                        <option value="<?= $value['br_id'] ?>"><?= $value['br_na'] ?></option>
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
                                        <th>อาจารย์ที่ปรึกษา :<a style="color:red;">*</a></th>
                                        <td>
                                            <select id="t_id" name="t_id[]" class="form-control" placeholder="กรุณาเลือกอาจารย์ที่ปรึกษา" multiple size="1">
                                                <?php foreach ($result_teacher as $value) { ?>
                                                    <option value="<?= $value['t_id'] ?>"><?= $value['t_fna'] ?>&nbsp;<?= $value['t_lna'] ?>&nbsp;(<?= $value['p_na'] ?>)</option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>นักศึกษา :<a style="color:red;">*</a></th>
                                        <td>
                                            <select id="s_id" name="s_id[]" class="form-control" placeholder="กรุณาเลือกนักศึกษา" multiple size="1">
                                                <?php foreach ($result_student as $value) { ?>
                                                    <option value="<?= $value['s_id'] ?>"><?= $value['s_id'] ?>&nbsp;<?= $value['s_fna'] ?>&nbsp;<?= $value['s_lna'] ?>&nbsp;(<?= $value['br_na'] ?>)</option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>กลุ่มที่/ห้องที่ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="n_group" id="n_group" maxlength="1" class="form-control" placeholder="-กรุณาใส่เลขกลุ่มที่/ห้องที่-" onkeypress="isInputNumber(event)" type="text" required>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-6">
                                        <th>ปีการศึกษา :<a style="color:red;">*พ.ศ.</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="n_year" id="n_year" maxlength="4" class="form-control" placeholder="-กรุณาใส่ปีการศึกษา-" onkeypress="isInputNumber(event)" type="text" required>
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
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <!-- Logout Modal-->
        <?php include("../../logoutmenu.php"); ?>
    </body>
    <script>
        $(document).ready(function() {
            var multipleCancelButton = new Choices('#t_id', {
                removeItemButton: true,
                maxItemCount: 1,
                searchResultLimit: 5,
                //renderChoiceLimit: 5
            });
        });
        $(document).ready(function() {
            var multipleCancelButton = new Choices('#s_id', {
                removeItemButton: true,
                //maxItemCount: 5,
                searchResultLimit: 5,
                //renderChoiceLimit: 5
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