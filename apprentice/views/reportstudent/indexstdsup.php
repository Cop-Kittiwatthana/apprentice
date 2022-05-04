<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $pe_id = $_GET["pe_id"];
    $s_id = $_GET["s_id"];

    $query = "SELECT company.*,petition.*,student.*
    FROM petition 
    LEFT JOIN company ON petition.c_id  = company.c_id 
    LEFT JOIN student ON petition.s_id  = student.s_id  
    where petition.pe_id='$pe_id' and petition.s_id='$s_id'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $c_id = "$row[c_id]";
        $c_na = "$row[c_na]";
        $s_tna = "$row[s_tna]";
        $s_fna = "$row[s_fna]";
        $s_lna = "$row[s_lna]";
        $pe_semester = "$row[pe_semester]";
    }
    if ($s_tna == 0) {
        $s_tna = "นาย";
    }
    if ($s_tna == 1) {
        $s_tna = "นาง";
    }
    if ($s_tna == 2) {
        $s_tna = "นางสาว";
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
        <title>ข้อมูลการนิเทศ</title>
        <?php include("../../head.php") ?>
    </head>

    <body id="page-top">
        <div id="wrapper">
            <?php include("../../sidebar_login.php") ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php") ?>
                    <div class="container-fluid">
                        <div class="card shadow mb-4">

                            <div class="card-body">
                                <h6 class="m-0 font-weight-bold text-dark" style="text-align: center;">
                                    <font size="6" face="TH SarabunPSK"> บันทึกนิเทศนักศึกษา</font>
                                </h6>
                                <h6 class="m-0 font-weight-bold text-dark" style="text-align: center;">
                                    <font size="6" face="TH SarabunPSK"> <?= $s_tna . '&nbsp;' . $s_fna . '&nbsp;' . $s_lna ?> สถานประกอบการ<?= $c_na ?></font>
                                    
                                </h6>
                                
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered " id="data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #f8f9fc;text-align: center;">ครั้งที่</th>
                                                <th style="background-color: #f8f9fc;text-align: center;">เทอม</th>
                                                <th style="background-color: #f8f9fc;text-align: center;" width="50%">ข้อเสนอแนะ</th>
                                                <th style="background-color: #f8f9fc;text-align: center;">คะแนน</th>
                                                <th style="background-color: #f8f9fc;text-align:center;" width="200"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query1 = "SELECT * FROM supervision WHERE pe_id = '$pe_id'";
                                            $result1 = mysqli_query($conn, $query1);
                                            while ($row1 = mysqli_fetch_array($result1)) { ?>
                                                <tr class="text-dark" style="text-align: center;">
                                                    <td><?php echo $row1['su_no']; ?></td>
                                                    <td><?php echo $row1['su_term']; ?> </td>
                                                    <td class="name">
                                                        <?php if ($row1['su_suggestion'] == "") {
                                                            echo "<p style='color:red;'>ยังไม่ได้ประเมิน</p>";
                                                        } else {
                                                            echo "<p style='text-align: left;'>$row1[su_suggestion]</p>";
                                                        }  ?>
                                                    </td>
                                                    <td class="name">
                                                        <?php if ($row1['su_score'] == "") {
                                                            echo "<p style='color:red;'>ไม่มีคะแนน</p>";
                                                        } else {
                                                            echo $row1['su_score'];
                                                        }  ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($row1['t_id'] == "") {
                                                            echo "<a href=\"editstusup.php?pe_id=$pe_id&su_no=$row1[su_no]&c_id=$c_id&pe_semester=$pe_semester\">" ?><button type="button" class="btn btn-warning btn-sm fa fa-edit text-dark"><span style="color:black;">ประเมิน</span></button></a>
                                                         <?php }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php }
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php $query1 = "SELECT * FROM supervision WHERE pe_id = '$pe_id'";
                                            $result1 = mysqli_query($conn, $query1);
                                            $row = mysqli_fetch_array($result1); ?>
                                    <a href="pdf.php?pe_id=<?= $pe_id ?>&su_term=1"><button class="btn btn-primary fa fas-plus float-left "><i class="fa fa-print" aria-hidden="true"></i>เทอม 1</button></a>
                                    <a href="pdf.php?pe_id=<?= $pe_id ?>&su_term=2"><button class="btn btn-primary fa fas-plus float-left "><i class="fa fa-print" aria-hidden="true"></i>เทอม 2</button></a>
                                </div>
                            </div>
                            
                        </div>
                        <div class="footer d-flex justify-content-center">
                                <a href="javascript:history.back()"><button class="btn btn-primary btn-lg">กลับ</button></a>
                            </div>
                            <br>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->
                <!-- Footer -->
                <?php include("../../footer.php") ?>
                <!-- End of Footer -->
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
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