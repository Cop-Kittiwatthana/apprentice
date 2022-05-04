<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $id = $_GET['id'];
    $query = "SELECT * FROM notify  WHERE id = '$id'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) { 
        $name = "$row[name]";
        $token = "$row[token]";
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
        <title>ข้อมูลแจ้งเตือนไลน์</title>

        <?php include("../../head.php"); ?>
    </head>

    <body id="page-top">

        <div id="wrapper">
            <?php include("../../sidebar_login.php"); ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php"); ?>
                    <div class="container-fluid">
                    <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">ข้อมูลแจ้งเตือนไลน์</a></li>
                            <li class="breadcrumb-item active">แก้ไขแจ้งเตือนไลน์</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> แก้ไขแจ้งเตือนไลน์</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                        <input type=hidden name="id" id="id" value="<?= $id ?>">
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>ชื่อกลุ่ม :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="name" id="name" value="<?= $name ?>" class="form-control" placeholder="-กรุณาใส่ชื่อกลุ่ม-" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>Token:<a style="color:red;"> ใส่ Token หากต้องการให้แจ้งเตือน line </a><a href="../../docs/Line-Token.pdf" target="_blank">ดาวน์โหลดตัวอย่าง</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="token" id="token"  value="<?= $token ?>" class="form-control" placeholder="-กรุณาใส่Token line notify-" required type="text">
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
    </body>

    </html>
<?php
} else {
    echo ("<script> alert('please login'); window.location='../../index.php';</script>");
    exit();
}
?>