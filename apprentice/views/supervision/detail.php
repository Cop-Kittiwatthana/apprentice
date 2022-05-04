<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["type"] == '1') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $type = $_SESSION["type"];

    $c_id = $_GET["c_id"];
    $pe_semester = $_GET["pe_semester"];

    

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

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
                        <h4 class="text-dark"><i class="fa fa-file" aria-hidden="true"></i> รายละเอียดการนิเทศนักศึกษา</h4>
                    </div>
                    <div class="container text-dark " style="width: 80%; height: auto;">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered " style="border-color: black;" id="data" style="width: 100%;">
                                    <thead>
                                        <tr style="text-align: center;background-color:#DFF3F7;" class="text-dark">
                                            <td width="20%">#</td>
                                            <td width="25%">ชื่อสกุล</td>
                                            <td width="25%">หมายเหตุ</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query1 = "SELECT company.*,petition.*,student.*
                                        FROM petition 
                                        LEFT JOIN company ON petition.c_id  = company.c_id  
                                        LEFT JOIN student ON petition.s_id  = student.s_id  
                                        where company.c_id='$c_id' and petition.pe_semester='$pe_semester' and 
                                        (petition.pe_status = 2 OR petition.pe_status = 5 
                                         OR petition.pe_status = 6 OR petition.pe_status = 7 OR petition.pe_status = 8)";
                                        $result = mysqli_query($conn, $query1);
                                        while ($row = mysqli_fetch_array($result)) { ?>
                                            <tr class="text-dark" style="text-align: center;">
                                                <td><?php echo $row['s_id']; ?></td>
                                                <td class="name">
                                                    <?php echo $row['s_fna'] ?>&nbsp;<?php echo $row['s_lna']; ?>
                                                </td>
                                                <td><?php echo "<a href=\"editability.php?pe_id=$pe_id\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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