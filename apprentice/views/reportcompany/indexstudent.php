<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '3') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];

    $pe_id = $_GET["pe_id"];
    $de_id = $_GET["de_id"];
    $c_id = $_GET["c_id"];
    $su_term = $_GET["su_term"];

    $query = "SELECT * FROM company WHERE c_id = '$c_id'";
    $result = mysqli_query($conn, $query)
        or die("3. ไม่สามารถประมวลผลคำสั่งได้") . $mysql->error();
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $c_na = "$row[c_na]";
    }

    $query = "SELECT * FROM petition WHERE pe_id = '$pe_id'";
    $result = mysqli_query($conn, $query)
        or die("3. ไม่สามารถประมวลผลคำสั่งได้") . $mysql->error();
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $pe_semester = "$row[pe_semester]";
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
        <title>ข้อมูลนักศึกษา</title>

        <?php include("../../head.php"); ?>
    </head>

    <body id="page-top">

        <div id="wrapper">
            <?php include("../../sidebar_login.php"); ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php"); ?>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark">รายชื่อนักศึกษา ปีการศึกษา<?= $pe_semester ?> <br><?= $c_na ?></h4>
                    </div>
                    <div class="container text-dark " style="width: 80%; height: auto;">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered " style="border-color: black;" id="data" style="width: 100%;">
                                        <thead>
                                            <tr style="text-align: center;background-color:#DFF3F7;" class="text-dark">
                                                <td width="20%">รหัสนักศึกษา</td>
                                                <td width="25%">ชื่อสกุล</td>
                                                <td width="30%"></td>
                                                <td width="25%">หมายเหตุ</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query1 = "SELECT student.s_id,student.s_fna,student.s_lna,supervision.su_term
                                        FROM petition  
                                        LEFT JOIN supervision ON petition.pe_id  = supervision.pe_id 
                                        LEFT JOIN company ON petition.c_id  = company.c_id  
                                        LEFT JOIN demand ON petition.de_id  = demand.de_id  
                                        LEFT JOIN student ON petition.s_id  = student.s_id  
                                        LEFT JOIN branch ON student.br_id  = branch.br_id 
                                        where company.c_id = '$c_id' and petition.pe_semester = '$pe_semester' and petition.de_id = '$de_id' and supervision.su_term = '$su_term'
                                        GROUP BY student.s_id
                                        ORDER BY student.s_id";
                                            $result = mysqli_query($conn, $query1);
                                            while ($row = mysqli_fetch_array($result)) { ?>
                                                <tr class="text-dark" style="text-align: center;">
                                                    <td width="20%"><?php echo $row['s_id']; ?></td>
                                                    <td width="25%" class="name">
                                                        <?php echo $row['s_fna'] ?>&nbsp;<?php echo $row['s_lna']; ?>
                                                    </td>
                                                    <td width="30%"></td>
                                                    <td width="25%"></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="footer d-flex justify-content-center">
                        <a href="javascript:history.back()"><button class="btn btn-primary btn-lg">กลับ</button></a>
                    </div>
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