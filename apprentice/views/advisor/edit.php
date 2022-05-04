<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];

    $id = $_GET['id'];
    $s_group = $_GET['s_group'];
    $br_id = $_GET['br_id'];

    $query = "SELECT * FROM branch
    WHERE  br_id = '$br_id' ";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $br_na = "$row[br_na]";
    }

    $query_teacher = "SELECT teacher.*,position.* FROM teacher 
    LEFT JOIN position ON position.p_id = teacher.p_id
    where t_fna !='ผู้ดูแลระบบ' and t_lna !='สูงสุด'";
    $result_teacher = mysqli_query($conn, $query_teacher);

    $query_student = "SELECT student.*,branch.* FROM student 
    LEFT JOIN branch ON branch.br_id = student.br_id
    ORDER BY s_id";
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
        <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/brand.png">
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
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="indexsup.php">จัดการข้อมูลอาจารย์ที่ปรึกษา</a></li>
                            <li class="breadcrumb-item"><a href="index.php?id=<?= $br_id ?>">ข้อมูลอาจารย์ที่ปรึกษา</a></li>
                            <li class="breadcrumb-item active">จัดการข้อมูลอาจารย์ที่ปรึกษา</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> จัดการข้อมูลอาจารย์ที่ปรึกษา</h4>
                    </div>
                    <form action="check.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <input type=hidden name="id" id="id" value="<?= $id ?>">
                            <input type=hidden name="s_group" id="s_group" value="<?= $s_group ?>">
                            <input type=hidden name="br_id" id="br_id" value="<?= $br_id ?>">

                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>สาขา :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input readonly name="br_na" id="br_na" value="<?= $br_na ?>" maxlength="1" class="form-control" require placeholder="-กรุณาใส่เลขกลุ่มที่/ห้องที่-" onkeypress="isInputNumber(event)" type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>กลุ่มที่ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input readonly name="s_group" id="s_group" value="<?= $s_group ?>" maxlength="2" class="form-control" require placeholder="-กรุณาใส่เลขกลุ่มที่/ห้องที่-" onkeypress="isInputNumber(event)" type="text">
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-6">
                                        <th>รหัสรุ่น :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input readonly name="id" id="id" value="<?= $id ?>" maxlength="4" class="form-control" require placeholder="-กรุณาใส่ปีการศึกษา-" onkeypress="isInputNumber(event)" type="text">
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
                                            <select id="t_id" name="t_id[]" class="form-control" multiple size="2">
                                                <?php
                                                $query_teacher = "SELECT teacher.t_id,teacher.t_fna,teacher.t_lna,position.p_na,'ture' as status 
                                                from teacher 
                                                left join advisor on teacher.t_id = advisor.t_id
                                                left join student on student.s_id = advisor.s_id
                                                left join position ON teacher.p_id = position.p_id
                                                WHERE student.br_id='$br_id' and student.s_group='$s_group' and student.s_id LIKE '$id%' 
                                                GROUP BY teacher.t_id
                                                UNION SELECT  teacher.t_id,teacher.t_fna,teacher.t_lna,position.p_na,'false' as status
                                                from teacher 
                                                left join advisor on teacher.t_id = advisor.t_id
                                                left join student on student.s_id = advisor.s_id
                                                left join position ON teacher.p_id = position.p_id
                                                WHERE   teacher.t_fna !='ผู้ดูแลระบบ' and teacher.t_lna !='สูงสุด' and teacher.t_id  not in 
                                                (SELECT advisor.t_id  as status 
                                                from teacher 
                                                left join advisor on teacher.t_id = advisor.t_id
                                                 left join student on student.s_id = advisor.s_id
                                                left join position ON teacher.p_id = position.p_id
                                                 WHERE  student.s_id LIKE '$id%')GROUP BY teacher.t_id";
                                                $result_teacher = mysqli_query($conn, $query_teacher); ?>
                                                <?php while ($rs = mysqli_fetch_array($result_teacher)) {
                                                ?>
                                                    <option value="<?= $rs['t_id'] ?>" <?= $rs['status'] == "ture" ? 'selected' : '' ?>>
                                                        <?= $rs['t_fna'] ?> <?= $rs['t_lna'] ?> (<?= $rs['p_na'] ?>)</option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <br>
                            <tr>
                                <div class="card-body" style="background-color: white;">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-dark" style="width: 100%;" align="center">
                                            <thead>
                                                <tr align="center">
                                                    <th style="background-color: #eaecf4;">รหัสนักศึกษา</th>
                                                    <th style="background-color: #eaecf4;">ชื่อขนามสกุล</th>
                                                    <th style="background-color: #eaecf4;">สาขา</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query_student = "SELECT student.s_id,student.s_tna,student.s_fna,student.s_lna,branch.br_na
                                                from student
                                                LEFT JOIN advisor ON advisor.s_id = student.s_id
                                                LEFT JOIN branch ON branch.br_id = student.br_id
                                                WHERE  student.br_id = '$br_id' and student.s_group = '$s_group' and student.s_id LIKE '$id%'
                                                GROUP BY student.s_id
                                                ORDER BY student.s_id";
                                                $result_student = mysqli_query($conn, $query_student);
                                                while ($row1 = mysqli_fetch_array($result_student)) {
                                                    if ($row1['s_tna'] == 0) {
                                                        $s_tna = "นาย";
                                                    }
                                                    if ($row1['s_tna'] == 1) {
                                                        $s_tna = "นาง";
                                                    }
                                                    if ($row1['s_tna'] == 2) {
                                                        $s_tna = "นางสาว";
                                                    }
                                                ?>
                                                    <tr>
                                                        <td align="center"><?php echo "$row1[s_id]"; ?></td>
                                                        <td> <?php echo " $s_tna"; ?><?php echo "$row1[s_fna]"; ?> <?php echo "$row1[s_lna]"; ?></td>
                                                        <td><?php echo "$row1[br_na]"; ?></td>
                                                    </tr>
                                                    <input type=hidden name="s_id[]" id="s_id" value="<?= $row1['s_id'] ?>">
                                                <?php
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </tr>
                            <br>
                            <br>
                            <div class="footer d-flex justify-content-center">
                                <!-- <button class="btn btn-success btn-lg" type="submit" name="btnedit" id="btnedit" value="บันทึก">บันทึก</button>&nbsp; -->
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
            var CancelButton = new Choices('#t_id', {
                removeItemButton: true,
                // maxItemCount: 2,
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