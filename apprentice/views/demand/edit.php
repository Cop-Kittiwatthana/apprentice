<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];

    $de_id = $_GET['de_id'];
    $query = "SELECT demand.*,company.*,department.*,branch.* FROM demand
    INNER JOIN company on  demand.c_id = company.c_id
    INNER JOIN branch on  demand.br_id = branch.br_id
    INNER JOIN department on department.dp_id = branch.dp_id 
    WHERE demand.de_id = '$de_id'";

    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $de_year = "$row[de_year]";
        $de_num = "$row[de_num]";
        $de_Jobdetails = "$row[de_Jobdetails]";
        $de_Welfare = "$row[de_Welfare]";
        $c_id = "$row[c_id]";
        $br_id = "$row[br_id]";
        $dp_id = "$row[dp_id]";
    }

    $query_company = "SELECT * FROM company";
    $result_company = mysqli_query($conn, $query_company);

    $query_branch = "SELECT department.*,branch.* FROM branch 
    INNER JOIN department on department.dp_id = branch.dp_id 
    ORDER BY department.dp_id";
    $result_branch = mysqli_query($conn, $query_branch);


    // for ($i = 0; $i < 3; $i++) {
    //     $test = date('Y', strtotime($i . 'year')) + 543 ;
    //     //echo '<option value=' . $test . '>' . $test . '</option>';
    // }
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
                            <li class="breadcrumb-item"><a href="index.php">ข้อมูลความต้องการ</a></li>
                            <li class="breadcrumb-item active">แก้ไขข้อมูลความต้องการ</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> แก้ไขข้อมูลความต้องการ</h4>
                    </div>

                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <input type=hidden name="de_id" id="de_id" value="<?= $de_id ?>">
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>สถานประกอบการ :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="c_id" id="c_id" required="" placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือกสถานประกอบกา')" oninput="setCustomValidity('')">
                                                    <option value="" disabled>-กรุณาเลือกสถานประกอบการ-</option>
                                                    <?php foreach ($result_company as $value) { ?>
                                                        <option value="<?= $value['c_id'] ?>" <?= $value['c_id'] == $c_id ? 'selected' : '' ?>>
                                                            <?= $value['c_na'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-6">
                                        <th>ต้องการรับนักศึกษาแผนก/สาขา :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="br_id" id="br_id" required="" placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือกแผนก/สาขา')" oninput="setCustomValidity('')">
                                                    <option value="" disabled>-กรุณาเลือกแผนก/สาขา-</option>
                                                    <?php foreach ($result_branch as $value) { ?>
                                                        <option value="<?= $value['br_id'] ?>" <?= $value['br_id'] == $br_id ? 'selected' : '' ?>>
                                                            <?= $value['dp_na'] ?>/<?= $value['br_na'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-8">
                                        <th>จำนวน :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="de_num" id="de_num" value="<?= $de_num ?>" class="form-control" placeholder="-กรุณาใส่จำนวน-" maxlength="3" onkeypress="isInputNumber(event)" required type="text" aria-describedby="basic-de_num">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-de_num">คน</span>
                                                </div>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-4">
                                        <th>ปี พ.ศ.:<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="de_year" id="de_year" required="" placeholder="username" oninvalid="this.setCustomValidity('กรุณาเลือกสถานประกอบกา')" oninput="setCustomValidity('')">
                                                    <option value="" disabled>-กรุณาเลือกปี-</option>
                                                    <?php for ($i = 0; $i < 3; $i++) {
                                                        $de_year = date('Y', strtotime($i . 'year')); ?>
                                                        <option value="<?= $de_year + 543 ?>" <?= $de_year ? 'selected' : '' ?>>
                                                            <?= $de_year + 543 ?></option>
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
                                        <th>รายละเอียดงาน :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <textarea name="de_Jobdetails" autofocus value="<?= $de_Jobdetails ?>" id="de_Jobdetails" class="form-control" placeholder="-กรุณาใส่รายละเอียดงาน-" type="text" require><?= $de_Jobdetails ?></textarea>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>สวัสดิการ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <textarea name="de_Welfare" id="de_Welfare" value="<?= $de_Welfare ?>" class="form-control" placeholder="-กรุณาใส่สวัสดิการ-" type="text"></textarea>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
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
        <script type="text/javascript">
            $('textarea').each(function() {
                this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;');
            }).on('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
                console.log(this.scrollHeight);
            });
        </script>
    </body>

    </html>
<?php
} else {
    echo ("<script> alert('please login'); window.location='../../index.php';</script>");
    exit();
}
?>