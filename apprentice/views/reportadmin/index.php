<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];

    if ($username == 'admin' && $password == '1234') {
        $t_type = 0;
    } else {
        $t_type = 1;
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
        <title>ข้อมูลข่าวสาร</title>
        <?php include("../../head.php") ?>
    </head>

    <body id="page-top">
        <div id="wrapper">
            <?php include("../../sidebar_login.php") ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php") ?>
                    <div class="container-fluid">
                        <!-- <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="../../indexnews.php">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">ข้อมูลข่าวสาร</li>
                        </ol> -->
                        <div class="card shadow mb-4">
                            <?php
                            require_once __DIR__ . '/../../connect.php';
                            require_once __DIR__ . '/../../vendor/autoload.php';
                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }

                            // *****************************************************************************************************************************
                            $query1 = "SELECT teacher.*,position.* FROM teacher 
                            LEFT JOIN position ON teacher.p_id = position.p_id 
                            where t_user != 'admin' 
                            ORDER BY position.p_id";
                            $result1 = mysqli_query($conn, $query1);
                            if (mysqli_num_rows($result1) > 0) {
                                if (mysqli_num_rows($result1) > 0) {
                                    $i = 1;
                                    while ($row1 = mysqli_fetch_assoc($result1)) {

                                        $tablebody .= '<tr style="border:1px solid #000;">
                                        <td style="border-right:1px solid #000;padding:3px;text-align:center;"  >' . $i . '</td>
                                        <td style="border-right:1px solid #000;padding:3px;text-align:LEFT;">' . $row1['t_fna'] . ' ' . $row1['t_lna'] . '</td>
                                        <td style="border-right:1px solid #000;padding:3px;text-align:LEFT;"> ' . $row1['t_tel'] . ' </td>
                                        <td style="border-right:1px solid #000;padding:3px;text-align:LEFT;">' . $row1['p_na'] . '</td>
                                        </tr>';
                                        $i++;
                                    }
                                }

                                mysqli_close($conn);

                                $mpdf = new \Mpdf\Mpdf([
                                    'default_font_size' => 16,
                                    'default_font' => 'sarabun'
                                ]);
                                // $mpdf->SetHTMLHeader('
                                // <div style="text-align: right;font-size:16pt;">
                                //     {PAGENO}
                                // </div>');
                                $tableh = '
                                <h5 style="text-align:center;font-size:18pt;">วิทยาลัยการอาชีพวิเชียรบุรี<br>รายชื่ออาจารย์ทั้งหมด</h5>';
                                $tableh .= '
                                <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16pt;margin-top:4px;">
                                    <tr style="border:1px solid #000;padding:4px;">
                                        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"> <b>ลำดับ </b></td>
                                        <td  width="15%" style="border-right:1px solid #000;padding:4px;text-align:center;"width="30%">&nbsp; <b> ชื่อสกุล  </b></td>
                                        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="15%"> <b>เบอร์โทร </b></td>
                                        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="15%"> <b>ตำแหน่ง </b></td>
                                    </tr>
                                
                                </thead>
                                <tbody>';

                                $tableend = "</tbody></table>";
                                $mpdf->WriteHTML($tableh);
                                $mpdf->WriteHTML($tablebody);
                                $mpdf->WriteHTML($tableend);

                                //$mpdf->SetFooter('First section footer');
                                $_month_name = array(
                                    "01" => "มกราคม",  "02" => "กุมภาพันธ์",  "03" => "มีนาคม",
                                    "04" => "เมษายน",  "05" => "พฤษภาคม",  "06" => "มิถุนายน",
                                    "07" => "กรกฎาคม",  "08" => "สิงหาคม",  "09" => "กันยายน",
                                    "10" => "ตุลาคม", "11" => "พฤศจิกายน",  "12" => "ธันวาคม"
                                );

                                $vardate = date('Y-m-d');
                                $yy = date('Y');
                                $mm = date('m');
                                $dd = date('d');
                                if ($dd < 10) {
                                    $dd = substr($dd, 1, 2);
                                }
                                $date = "วันที่ " . $dd . " เดือน " . $_month_name[$mm] . " พ.ศ. " . $yy += 543;

                                $mpdf->SetHTMLFooter('
                                <div style="text-align:right;font-size:12pt;">
                                ' . $date . '
                                </div>');
                                $mpdf->Output();
                            } else {
                                echo "<script> alert('ไม่มีข้อมูล'); window.close()</script>";
                                exit();
                            } ?>

                        </div>
                    </div>
                </div>
                <?php include("../../footer.php") ?>
            </div>
        </div>
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <?php include("../../logoutmenu.php"); ?>
    </body>

    </html>
<?php
} else {
    echo ("<script> alert('please login'); window.location='../../index.php';</script>");
    exit();
}
?>