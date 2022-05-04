<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];

    $br_id = $_GET['id'];
    $year = $_GET['year'];
    $query = "SELECT student.* FROM student  WHERE s_id = '$s_id'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;

    $query_branch = "SELECT department.*,branch.* FROM department inner JOIN branch ON department.dp_id = branch.dp_id where branch.br_id='$br_id'";
    $result_branch = mysqli_query($conn, $query_branch);
    while ($row = mysqli_fetch_array($result_branch)) {
        $br_na = $row['br_na'];
        $dp_na = $row['dp_na'];
    }

    $query_position = "SELECT * FROM position";
    $result_position = mysqli_query($conn, $query_position);

    $query_provinces = "SELECT * FROM provinces";
    $result_provinces = mysqli_query($conn, $query_provinces);

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
        <title>ข้อมูลนักศึกษา</title>

        <?php include("../../head.php"); ?>
        <script>
            $(document).ready(function() {
                $("select").each(function() {
                    $(this).val($(this).find('option[selected]').val());
                });
            })
        </script>
    </head>

    <body id="page-top">

        <div id="wrapper">
            <?php include("../../sidebar_login.php"); ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php"); ?>
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="indexsub.php?year=<?= $year ?>">จัดการข้อมูลนักศึกษา</a></li>
                            <li class="breadcrumb-item"><a href="index.php?id=<?= $br_id ?>&year=<?= $year ?>">ข้อมูลนักศึกษา</a></li>
                            <li class="breadcrumb-item active">เพิ่มข้อมูลนักศึกษา</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> เพิ่มข้อมูลนักศึกษา</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>รหัสนักศึกษา/ชื่อผู้ใช้ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="s_id" id="s_id" class="form-control" placeholder="-กรุณาใส่ชื่อผู้ใช้-" maxlength="10" onkeypress="isInputNumber(event)" required type="text" name="t_user" id="t_user">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>รหัสผ่าน :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3" id="test">
                                                <input name="s_pass" id="s_pass" class="form-control pwd" placeholder="-กรุณาใส่รหัสผ่าน-" onkeypress="isInputPassword(event)" required type="password">
                                                <!-- <span class="input-group-btn">
                                                    <button class="btn btn-default reveal" type="button" style="border-collapse: collapse;border-color: #dedede;"><i class="fa fa-eye-slash"></i></button>
                                                </span> -->
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-2">
                                        <th>คำนำหน้า :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="s_tna" id="s_tna" required placeholder="-กรุณาเลือกคำนำหน้า-" oninvalid="this.setCustomValidity('-กรุณาเลือกคำนำหน้า-')" oninput="setCustomValidity('')">
                                                    <option value="" disabled>-กรุณาเลือก-</option>
                                                    <option value="0" selected>นาย</option>
                                                    <option value="1">นาง</option>
                                                    <option value="2">นางสาว</option>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-5">
                                        <th>ชื่อ :<a style="color:red;">*ภาษาไทย</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="s_fna" id="s_fna" maxlength="25" class="form-control" placeholder="-กรุณาใส่ชื่อ-" onkeypress="isInputCharth(event)" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-5">
                                        <th>นามสกุล :<a style="color:red;">*ภาษาไทย</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="s_lna" id="s_lna" maxlength="25" class="form-control" placeholder="-กรุณาใส่นามสกุล-" onkeypress="isInputCharth(event)" required type="text">
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
                                                <!-- <select class="form-control" name="br_id" id="br_id" placeholder="-กรุณาเลือกแผนก-สาขา-" oninvalid="this.setCustomValidity('-กรุณาเลือกแผนก-สาขา-')" oninput="setCustomValidity('')">
                                                    <option value="0" selected disabled>-กรุณาเลือกแผนก-สาขา-</option>
                                                    <?php foreach ($result_branch as $value) { ?>
                                                        <option value="<?= $value['br_id'] ?>"><?= $value['dp_na'] ?>-<?= $value['br_na'] ?></option>
                                                    <?php } ?>
                                                </select> -->
                                                <input type=hidden name="br_id" id="br_id" value="<?= $br_id ?>">
                                                <input type=hidden name="year" id="year" value="<?= $year ?>">
                                                <input name="br_na" id="br_na" value="<?= $dp_na  ?>-<?= $br_na  ?>" readonly class="form-control" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-4">
                                        <th>กลุ่ม :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="s_group" id="s_group" maxlength="2" class="form-control" placeholder="-กรุณาใส่กลุ่ม-" onkeypress="isInputNumber(event)" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>

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

    </html>
<?php
} else {
    echo "<script> alert('Please Login'); window.location='../../index.php';</script>";
    exit();
}
?>
<script>
    $(document).on("click", ".browse", function() {
        var file = $(this).parents().find(".file");
        file.trigger("click");

    });
    $(document).on("click", ".delect", function() {
        document.getElementById('preview').src = "";
        document.getElementById('preview').style = "display: none;";
        document.getElementById('photo').value = null;
    });
    $('input[type="file"]').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#photo").val(fileName);

        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview").style = "display: block;";
            document.getElementById("preview").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });
</script>
<script>
    $(".reveal").on('click', function() {
        var $pwd = $(".pwd");
        if ($pwd.attr('type') === 'password') {
            $pwd.attr('type', 'text');
            $('#test i').removeClass("fa-eye-slash");
            $('#test i').addClass("fa-eye");
        } else {
            $pwd.attr('type', 'password');
            $('#test i').addClass("fa-eye-slash");
            $('#test i').removeClass("fa-eye");
        }
    });
</script>
<?php include("../script.php"); ?>