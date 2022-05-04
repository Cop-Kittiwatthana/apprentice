<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];

    //$c_id = $_GET['c_id'];
    $dn_id = $_GET['dn_id'];
    $pe_id = $_GET['pe_id'];
    $query = "SELECT documents.*,petition.*,company.*
    FROM documents 
    left join petition on petition.pe_id = documents.pe_id
    LEFT JOIN demand ON petition.de_id  = demand.de_id 
    LEFT JOIN company ON demand.c_id  = company.c_id 
    where 1=1 and documents.dn_id = '$dn_id'";
    $result = mysqli_query($conn, $query)
        or die("3. ไม่สามารถประมวลผลคำสั่งได้") . $mysql->error();
    $data = array();
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $dn_name = "$row[dn_name]";
        $dn_date = "$row[dn_date]";
        $dn_file = "$row[dn_file]";
        $pe_semester = "$row[pe_semester]";
    }

    $query1 = "SELECT petition.*,company.*
    FROM petition 
    LEFT JOIN demand ON petition.de_id  = demand.de_id 
    LEFT JOIN company ON demand.c_id  = company.c_id 
    where petition.pe_id = '$pe_id'";
    $result1 = mysqli_query($conn, $query1)
        or die("3. ไม่สามารถประมวลผลคำสั่งได้") . $mysql->error();
    while ($row1 = mysqli_fetch_array($result1)) {  // preparing an array
        $c_id = "$row1[c_id]";
        $c_na = "$row1[c_na]";
        $s_id = "$row1[s_id]";
    }


    $date = date("d-m-Y", strtotime($Result["order_sent"] . "+543 year"));

    if ($_GET['dn_name'] == "1") {
        $dn_name = "คำร้องขอฝึกงานในสถานประกอบการ";
    }
    if ($_GET['dn_name'] == "2") {
        $dn_name = "หนังสืออนุญาติผู้ปกครอง";
    }
    if ($_GET['dn_name'] == "3") {
        $dn_name = "สัญญาการฝึกอาชีพ(ผู้ฝึกสอนกับนักศึกษา)";
    }
    if ($_GET['dn_name'] == "4") {
        $dn_name = "สัญญาการฝึกอาชีพ(สถานประกอบการกับนักศึกษา)";
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
        <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/brand.png">
        <title>ข้อมูลเอกสาร</title>

        <?php include("../../head.php"); ?>
        <style>
            .file {
                visibility: hidden;
                position: absolute;
            }

            .file-field {
                visibility: hidden;
                position: absolute;
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
                            <li class="breadcrumb-item"><a href="index.php">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="indexstd.php?c_id=<?= $c_id ?>&pe_semester=<?= $pe_semester ?>">รายชื่อนักศึกษาฝึกงาน</a></li>
                            <li class="breadcrumb-item"><a href="indexstddoc.php?pe_id=<?= $pe_id ?>&s_id=<?= $s_id ?>&c_id=<?= $c_id ?>&pe_semester=<?= $pe_semester ?>">จัดการเอกสารฝึกงาน</a></li>
                            <li class="breadcrumb-item active">เพิ่มเอกสารฝึกงาน</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> เพิ่มข้อมูลเอกสาร</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>สถานประกอบการ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input type=hidden name="dn_file" id="dn_file" value="<?= $dn_file ?>">
                                                <input type=hidden name="dn_id" id="dn_id" value="<?= $dn_id ?>">
                                                <input type=hidden name="pe_id" id="pe_id" value="<?= $pe_id ?>">
                                                <input type=hidden name="dn_name" id="dn_name" value="<?= $dn_name ?>">
                                                <input type=hidden name="s_id" id="s_id" value="<?= $s_id ?>">
                                                <input class="form-control" readonly type="text" id="c_na" name="c_na" value="<?= $c_na ?>" require />
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-6">
                                        <th>วันที่ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input class="form-control" readonly type="text" size="10" id="dn_date" name="dn_date" value="<?= $date ?>" require />
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>เอกสาร :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input class="form-control" readonly type="text" id="dn_name" name="dn_name" value="<?= $dn_name ?>" require />
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>ไฟล์ :<a style="color:red;">*กรุณาระบุชื่อเอกสารให้ชัดเจน</a></th>
                                        <td>
                                            <div class="form-group mb-3">
                                                <input type="file" name="file" class="file" accept=".pdf, .doc, .docx, .zip">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" disabled placeholder="Upload File" id="file" value="<?= $dn_file ?>">
                                                    <div class="input-group-append">
                                                        <button type="button" class="browsefile btn btn-primary">เพิ่มไฟล์...</button>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <button type="button" class="delectfile btn btn-danger">ลบ...</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <div class="footer d-flex justify-content-center">
                                <button class="btn btn-success btn-lg" type="submit" name="btnedit" id="btnedit" value="บันทึก">บันทึก</button>&nbsp;
                                <button class="btn btn-danger btn-lg" type="reset" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button>
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
    echo ("<script> alert('please login'); window.location='../../index.php';</script>");
    exit();
}
?>
<script>
    i = 0;
    $(document).on("click", ".browsefile", function() {
        var file = $(this).parents().find(".file");
        file.trigger("click");
    });
    $(document).on("click", ".delectfile", function() {
        document.getElementById('file').value = null;
    });
    $('input[name="file"]').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file").val(fileName);
    });
</script>
<?php include("../script.php"); ?>