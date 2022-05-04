<?php
require_once __DIR__ . '/../../connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$r_term = $_GET["r_term"];
$s_group = $_GET["s_group"];
$pe_semester = $_GET["pe_semester"];
$br_id = $_GET["br_id"];
$id = $_GET["id"];



$query = "SELECT teacher.t_id,teacher.t_fna,teacher.t_lna 
            FROM student 
            INNER JOIN teacher ON student.t_id = teacher.t_id
            LEFT JOIN branch ON student.br_id = branch.br_id
            WHERE  student.s_group='$s_group'  and student.s_id LIKE '$id%' and student.br_id='$br_id'
            GROUP BY student.t_id
            ORDER BY student.t_id";
$result = mysqli_query($conn, $query);
// *****************************************************************************************************************************
$query1 = "SELECT branch.*,student.*,petition.*,results.*
            FROM student 
            LEFT JOIN branch ON student.br_id  = branch.br_id
            LEFT JOIN petition ON petition.s_id  = student.s_id  
            LEFT JOIN results ON results.pe_id  = petition.pe_id 
            where petition.pe_semester='$pe_semester' and student.s_group='$s_group' and results.r_term='$r_term' and branch.br_id='$br_id'
            Order by student.s_id";
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
                <td style="border-right:1px solid #000;padding:3px;text-align:center;"  >' . $i . '</td>
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
    <h5 style="text-align:center;font-size:16pt;">รายชื่อนักศึกษา ปีการศึกษา ' . $n_year . '<br>
    ระดับชั้น ปวส.2/' . $n_group . ' แผนก' . $row2['br_na'] . '<br>
    ครูที่ปรึกษา';
    while ($row = mysqli_fetch_array($result)) {
        if ($row['t_tna'] == 0) {
            $t_tna = "นาย";
        }
        if ($row['t_tna'] == 1) {
            $t_tna = "นาง";
        }
        if ($row['t_tna'] == 2) {
            $t_tna = "นางสาว";
        };
        $tableh .= ' ' . $t_tna . '' . $row['t_fna'] . ' ' . $row['t_lna'] . '<h5>';
    }
    $tableh .= '
    <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16pt;margin-top:8px;">
        <tr style="border:1px solid #000;padding:4px;">
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>ลำดับ</b></td>
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
