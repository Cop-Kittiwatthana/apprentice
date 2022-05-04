<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];

    $n_group = $_GET['n_group'];
    $n_year = $_GET['n_year'];

    $query = "SELECT * FROM advisor
    LEFT JOIN student ON advisor.s_id  = student.s_id 
    LEFT JOIN teacher ON advisor.t_id  = teacher.t_id 
    WHERE n_group = '$n_group' and n_year = '$n_year' ";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {  // preparing an array

    }

    $query_teacher = "SELECT * FROM teacher where t_fna !='ผู้ดูแลระบบ' and t_lna !='สูงสุด' ";
    $result_teacher = mysqli_query($conn, $query_teacher);

    $query_student = "SELECT * FROM student ";
    $result_student = mysqli_query($conn, $query_student);


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
                        <h4 class="text-dark"><i class="fas fa-plus"></i> แก้ไขข้อมูลอาจารย์ทีปรึกษา</h4>
                    </div>
                    <form action="sql.php?n_group=<?= $n_group ?>&n_year=<?= $n_year ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <input type=hidden name="num[]" id="num" value="<?= $num ?>">
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>อาจารย์ที่ปรึกษา :<a style="color:red;">*</a></th>
                                        <td>
                                            <select id="t_id" name="t_id[]" class="form-control" placeholder="กรุณาเลือกอาจารย์ที่ปรึกษา" multiple size="1">
                                                <?php
                                                $query_teacher = "SELECT teacher.t_id,teacher.t_fna,teacher.t_lna,'ture' as status 
                                                    from advisor ,teacher 
                                                    WHERE advisor.n_group = '$n_group' and advisor.n_year = '$n_year' and advisor.t_id = teacher.t_id  GROUP BY advisor.t_id
                                                    UNION SELECT  teacher.t_id,teacher.t_fna,teacher.t_lna,'false' as status
                                                    from advisor ,teacher 
                                                    WHERE   teacher.t_fna !='ผู้ดูแลระบบ' and teacher.t_lna !='สูงสุด' and teacher.t_id  not in (
                                                    SELECT advisor.t_id  as status 
                                                    from advisor ,teacher  
                                                    WHERE  advisor.t_id = teacher.t_id and advisor.n_group = '$n_group' and advisor.n_year = '$n_year' )";
                                                $result_teacher = mysqli_query($conn, $query_teacher);
                                                while ($rs = mysqli_fetch_array($result_teacher)) {
                                                    echo "<option value=\"$rs[t_id]\"";
                                                    if ("$rs[status]" == "ture") {
                                                        echo 'selected';
                                                    }
                                                    echo ">$rs[t_fna]&nbsp;$rs[t_lna]";
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
                                        <th>นักศึกษา :<a style="color:red;">*</a></th>
                                        <td>
                                            <select id="s_id" name="s_id[]" class="form-control" placeholder="กรุณาเลือกนักศึกษา" multiple size="1">
                                                <?php
                                                $query_student = "SELECT student.s_id,student.s_fna,student.s_lna,'ture' as status 
                                                from advisor ,student 
                                                WHERE advisor.n_group = '$n_group' and advisor.n_year = '$n_year' and advisor.s_id = student.s_id GROUP BY advisor.s_id
                                                UNION SELECT student.s_id,student.s_fna,student.s_lna,'false' as status
                                                from advisor ,student 
                                                WHERE  student.s_id not in ( SELECT advisor.s_id  as status 
                                                from advisor ,student  
                                                WHERE  advisor.n_group = '$n_group' and advisor.n_year = '$n_year' and advisor.n_year='2564')";
                                                $result_student = mysqli_query($conn, $query_student);
                                                while ($rs1 = mysqli_fetch_array($result_student)) {
                                                    echo "<option value=\"$rs1[s_id]\"";
                                                    if ("$rs1[status]" == "ture") {
                                                        echo 'selected';
                                                    }
                                                    echo ">$rs1[s_id]&nbsp;$rs1[s_fna]&nbsp;$rs1[s_lna]";
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
                                    <div class="col-md-6">
                                        <th>กลุ่มที่/ห้องที่ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="n_group" id="n_group" value="<?= $n_group ?>" maxlength="1" class="form-control" require placeholder="-กรุณาใส่เลขกลุ่มที่/ห้องที่-" onkeypress="isInputNumber(event)" type="text">
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-6">
                                        <th>ปีการศึกษา :<a style="color:red;">*พ.ศ.</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="n_year" id="n_year" value="<?= $n_year ?>" maxlength="4" class="form-control" require placeholder="-กรุณาใส่ปีการศึกษา-" onkeypress="isInputNumber(event)" type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <br>
                            <div class="footer d-flex justify-content-center">
                                <button class="btn btn-success btn-lg" type="submit" name="btnedit" id="btnedit" value="บันทึก">บันทึก</button>&nbsp;
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
                maxItemCount: 2,
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