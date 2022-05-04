<?php
require_once __DIR__ . '/../../connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$s_id = $_GET['s_id'];
$su_term = $_GET['su_term'];
$query = "SELECT * 
FROM supervision 
LEFT JOIN petition on petition.pe_id = supervision.pe_id
LEFT JOIN student on petition.s_id = student.s_id
LEFT JOIN branch on student.br_id = branch.br_id
WHERE petition.s_id = '$s_id'
GROUP BY student.s_id";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $s_id = $row['s_id'];
    $s_tna = $row['s_tna'];
    $s_fna = $row['s_fna'];
    $s_lna = $row['s_lna'];
    $s_group  = $row['s_group'];
    $pe_semester  = $row['pe_semester'];
    $br_na  = $row['br_na'];
    if ($s_tna == 0) {
        $s_tna = "นาย";
    }
    if ($s_tna == 1) {
        $s_tna = "นาง";
    }
    if ($s_tna == 2) {
        $s_tna = "นางสาว";
    };
}
// *****************************************************************************************************************************
$query1 = "SELECT student.*,petition.*,results.*
FROM student 
LEFT JOIN petition ON petition.s_id  = student.s_id  
LEFT JOIN results ON results.pe_id  = petition.pe_id 
where petition.s_id='$s_id' and results.r_term='$su_term'";
$result1 = mysqli_query($conn, $query1);
if (mysqli_num_rows($result1) > 0) {
    if (mysqli_num_rows($result1) > 0) {
        $i = 1;
        while ($row1 = mysqli_fetch_assoc($result1)) {
            if ($row1['s_tna'] == 0) {
                $s_tna = "นาย";
            }
            if ($row1['s_tna'] == 1) {
                $s_tna = "นาง";
            }
            if ($row1['s_tna'] == 2) {
                $s_tna = "นางสาว";
            };
            $tablebody .= '<tr style="border:1px solid #000;">
                
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $row1['s_id'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;">' . $s_tna . '' . $row1['s_fna'] . ' ' . $row1['s_lna'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $row1['r_ecompany'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $row1['r_ework'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $row1['r_esupervision'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $row1['sum'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $row1['grade'] . '</td>
                </tr>';
            $i++;
        }
    }

    mysqli_close($conn);

    $mpdf = new \Mpdf\Mpdf([
        'default_font_size' => 16,
        'default_font' => 'sarabun'
    ]);

    $tableh = '
<h5 style="text-align:center">รายงานการนิเทศนักศึกษา ปีการศึกษา ' . $su_term . '/' . $pe_semester . '<br>
                            ระดับชั้น ปวส.2/' . $s_group . ' แผนก' . $br_na . '<br>
                            ' . $s_tna . '' . $s_fna . ' ' . $s_lna . '</h5>';
    $tableh .= '
    <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16pt;margin-top:8px;">
        <tr style="border:1px solid #000;padding:4px;">
            
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="15%"><b>รหัสนักศึกษา</b></td>
            <td  width="15%" style="border-right:1px solid #000;padding:4px;text-align:center;"width="30%"><b>ชื่อสกุล</b> </td>
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="20%"><b>คะแนนจาก<br>สถานประกอบการ</b></td>
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>คะแนนจาก<br>สมุดบันทึก</b></td>
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>คะแนนจาก<br>การนิเทศ</b></td>
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>รวม</b></td>
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>เกรด</b></td>
        </tr>
    
    </thead>
      <tbody>';

    $tableend = "</tbody>
    </table>";
    $mpdf->WriteHTML($tableh);
    $mpdf->WriteHTML($tablebody);
    $mpdf->WriteHTML($tableend);
    $mpdf->Output();
} else {
    echo "<script> alert('ไม่มีข้อมูล'); window.close()</script>";
    exit();
}
