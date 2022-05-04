<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["type"] == '1') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $type = $_SESSION["type"];

    $id = $_GET["id"];
    $s_group = $_GET["s_group"];
    $br_id = $_GET["br_id"];
    $thai_year = date('Y') + 543;

    $query2 = "SELECT teacher.t_id,teacher.t_fna,teacher.t_lna ,branch.br_na 
    FROM student 
    INNER JOIN advisor ON student.s_id  = advisor.s_id
    INNER JOIN teacher ON advisor.t_id = teacher.t_id
    LEFT JOIN branch ON student.br_id = branch.br_id
    WHERE  student.s_group = '$s_group'  and student.br_id= '$br_id' and student.s_id LIKE '$id%'
    GROUP BY advisor.t_id
    ORDER BY advisor.t_id";
    $result2 = mysqli_query($conn, $query2);
    $row2 = mysqli_fetch_array($result2);

    $query1 = "SELECT * FROM teacher WHERE t_user = '$username' and t_pass = '$password'";
    $result1 = mysqli_query($conn, $query1);
    while ($row1 = mysqli_fetch_array($result1)) {
        $t_tna = $row1['t_tna'];
        $t_fna = $row1['t_fna'];
        $t_lna = $row1['t_lna'];
    }
    if ($t_lna == 0) {
        $tlna = "นาย";
    }
    if ($t_lna == 1) {
        $tlna = "นาง";
    }
    if ($t_lna == 2) {
        $tlna = "นางสาว";
    };

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
        <title>ข้อมูลการยื่นเรื่องฝึกงาน</title>

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
                            <li class="breadcrumb-item"><a href="indexpetition.php?t_id=<?= $t_id ?>">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">ข้อมูลการยื่นเรื่องฝึกงาน</li>
                        </ol>
                    </div>
                    <br>
                    <div class="container text-dark " style="width: 80%; height: auto;">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="text-dark" style="text-align:center;font-size:16pt;"><i class="fa fa-file" aria-hidden="true">
                                    </i> รายชื่อนักศึกษา ปีการศึกษา <?= $thai_year ?> <br>
                                    ระดับชั้น ปวส.2/<?= $s_group ?> แผนก <?= $row2['br_na'] ?><br>
                                    ครูที่ปรึกษา <?= $tlna ?><?= $t_fna ?> <?= $t_lna ?>

                                </h4>
                                <br>
                                <table class="table table-bordered " style="border-color: black;" id="data" style="width: 100%;">
                                    <thead>
                                        <tr style="text-align: center;background-color:#DFF3F7;" class="text-dark">
                                            <td width="20%">#</td>
                                            <td width="25%">ชื่อสกุล</td>
                                            <td width="30%">สถานประกอบการ</td>
                                            <td width="30%">สถานะ</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query1 = "SELECT SUBSTR(student.s_id,1,2) As id,student.s_id,student.s_tna,student.s_fna,student.s_lna,company.c_na,petition.pe_status,petition.pe_id
                                                    FROM student 
                                                    LEFT JOIN petition ON petition.s_id  = student.s_id
                                                    LEFT JOIN demand ON petition.de_id  = demand.de_id  
                                                    LEFT JOIN company ON demand.c_id  = company.c_id 
                                                    INNER JOIN advisor ON student.s_id  = advisor.s_id 
                                                    INNER JOIN teacher ON advisor.t_id = teacher.t_id
                                                    WHERE  student.s_group = '$s_group'  and student.br_id= '$br_id' and student.s_id LIKE '$id%'
                                                    GROUP BY student.s_id
                                                    ORDER BY student.s_id";
                                        $result1 = mysqli_query($conn, $query1);
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            if ($row1['s_tna'] == 0) {
                                                $s_tna = "นาย";
                                            }
                                            if ($row1['s_tna'] == 1) {
                                                $s_tna = "นาง";
                                            }
                                            if ($row1['s_tna'] == 2) {
                                                $s_tna = "นางสาว";
                                            };
                                            //
                                            if ($row1['c_na'] == "") {
                                                $c_na = "";
                                            } else {
                                                $c_na = $row1['c_na'];
                                            }; ?>
                                            <tr class="text-dark" style="text-align: center;">
                                                <td><?php echo $row1['s_id']; ?></td>
                                                <td class="name">
                                                    <?php echo $s_tna ?><?php echo $row1['s_fna'] ?>&nbsp;<?php echo $row1['s_lna']; ?>
                                                </td>
                                                <td>
                                                    <a align="center" href="<?= $baseURL; ?>/views/mpdf/indexpdf2.php?s_id=<?= $row1['s_id'] ?>&pe_id=<?= $row1['pe_id'] ?>"><?php echo $c_na ?></a>
                                                </td>

                                                <td><?php
                                                    if ($row1['pe_status'] == "0") {
                                                        echo "<font color='blue'>ส่งคำร้อง</font>";
                                                    }
                                                    if ($row1['pe_status'] == "1") {
                                                        echo "<font color='Orange'>รอตรวจสอบ</font>";
                                                    }
                                                    if ($row1['pe_status'] == "2") {
                                                        echo "<font color='green'>รับเข้าฝึก</font>";
                                                    }
                                                    if ($row1['pe_status'] == "3") {
                                                        echo "<font color='red'>ปฏิเสธรับเข้าฝึก</font>";
                                                    }
                                                    if ($row1['pe_status'] == "4") {
                                                        echo "<font color='red'>ข้อมูลไม่ถูกต้อง</font>";
                                                    }
                                                    if ($row1['pe_status'] == "5") {
                                                        echo "<font color='Orange'>กำลังออกฝึก</font>";
                                                    }
                                                    if ($row1['pe_status'] == "6") {
                                                        echo "<font color='green'>ฝึกงานเสร็จสิ้นเทอม1</font>";
                                                    }
                                                    if ($row1['pe_status'] == "7") {
                                                        echo  "<font color='Orange'>เปลียนสถานที่ฝึกงาน(เทอม2)</font>";
                                                    }
                                                    if ($row1['pe_status'] == "8") {
                                                        echo  "<font color='green'>ฝึกงานเสร็จสิ้นทั้งหมด</font>";
                                                    }
                                                    ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <div class=" d-flex justify-content-center">
                                        <?php if ($total1 != 0) { ?>
                                            <a href="pdfpetition.php?id=<?= $id ?>&br_id=<?= $row['br_id'] ?>&s_group=<?= $row['s_group'] ?>&su_term=1" target='_blank'><button class="btn btn-primary fa fas-plus float-left "><i class="fa fa-print" aria-hidden="true"></i>เทอม 1</button></a>
                                            <?php }
                                        if ($total2 != 0) {
                                            if ($t_id4 != "") { ?>
                                                <a href="pdfpetition.php?id=$row[id]&br_id=$row[br_id]&s_group=$row[s_group]&su_term=2" target='_blank'><button class="btn btn-primary fa fas-plus float-left "><i class="fa fa-print" aria-hidden="true"></i>เทอม 2</button></a>
                                        <?php }
                                        } ?>
                                    </div>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br>
                   

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