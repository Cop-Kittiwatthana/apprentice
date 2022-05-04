<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $query1 = "SELECT * FROM teacher WHERE t_user = '$username' and t_pass = '$password'";
    $result1 = mysqli_query($conn, $query1);
    while ($row1 = mysqli_fetch_array($result1)) {
        $t_id = $row1['t_id'];
    }

    $pe_id = $_GET['pe_id'];
    $su_no = $_GET['su_no'];
    $su_term = $_GET['su_term'];
    $query = "SELECT supervision.*,demand.br_id,petition.* FROM supervision 
    LEFT JOIN petition ON supervision.pe_id  = petition.pe_id
    LEFT JOIN demand ON petition.de_id  = demand.de_id 
    WHERE supervision.pe_id = '$pe_id' and supervision.su_no = '$su_no'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $num = $row['num'];
        $s_id = $row['s_id'];
        $br_id = $row['br_id'];
        $pe_semester = $row['pe_semester'];
        $su_no = $row['su_no'];
        $su_problem = $row['su_problem'];
        $su_workaround = $row['su_workaround'];
        $su_suggestion  = $row['su_suggestion'];
        $su_score = $row['su_score'];
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
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php?year=<?= $pe_semester ?>">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="indexstd.php?id=<?= $br_id ?>&year=<?= $pe_semester ?>">จัดการข้อมูลอาจารย์นิเทส</a></li>
                            <li class="breadcrumb-item"><a href="indexstdsup.php?s_id=<?= $s_id ?>&br_id=<?= $br_id ?>&year=<?= $pe_semester ?>">รายงานอาจารย์นิเทศ</a></li>
                            <li class="breadcrumb-item active">จัดการรายละเอียดการนิเทศ</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> จัดการรายละเอียดการนิเทศ</h4>
                    </div>
                    <form action="sql.php?n_group=<?= $n_group ?>&n_year=<?= $n_year ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <input type=hidden name="num" id="num" value="<?= $num ?>">
                            <input type=hidden name="t_id" id="t_id" value="<?= $t_id ?>">
                            <input type=hidden name="pe_semester" id="pe_semester" value="<?= $pe_semester ?>">
                            <input type=hidden name="br_id" id="br_id" value="<?= $br_id ?>">
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <th>ครั้งที่ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="su_no" id="su_no" value="<?= $su_no ?>" class="form-control" readonly type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>ปัญหาที่พบ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <textarea name="su_problem" id="su_problem" class="form-control" placeholder="-กรุณาใส่ปัญหาที่พบ-" onkeypress="isInputCharth(event)" required type="text"><?= $su_problem ?></textarea>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>วิธีแก้ปัญหา :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <textarea name="su_workaround" id="su_workaround" class="form-control" placeholder="-กรุณาใส่วิธีแก้ปัญหา-" onkeypress="isInputCharth(event)" required type="text"><?= $su_workaround ?></textarea>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>ข้อเสนอแนะ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <textarea name="su_suggestion" id="su_suggestion" class="form-control" placeholder="-กรุณาใส่ข้อเสนอแนะ-" onkeypress="isInputCharth(event)" required type="text"><?= $su_suggestion ?></textarea>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>คะแนนการนิเทศ :<a style="color:red;">* (คะแนนสูงสุด 50 คะแนน)</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="su_score" id="su_score" onkeyup="nStr()" value="<?= $su_score ?>" maxlength="2" class="form-control" placeholder="-กรุณาใส่คะแนน-" onkeypress="isInputNumber(event)" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <br>
                            <div class="footer d-flex justify-content-center">
                                <button class="btn btn-success btn-lg" type="submit" name="btneditstusup" id="btneditstusup" value="บันทึก">บันทึก</button>&nbsp;
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
    <script language="javascript">
        function nStr() {
            var int1 = document.getElementById('su_score').value;
            if (int1 > 50) {
                eval("document.form1.su_score.value=''");
                alert("คุณใส่จำนวนเกิน 50 !!");
            }
        }
    </script>
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