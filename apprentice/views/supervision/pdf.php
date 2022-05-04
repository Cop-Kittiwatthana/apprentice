<?php
require_once __DIR__ . '/../../connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$pe_id = $_GET['pe_id'];
$su_term = $_GET['su_term'];
$query = "SELECT * 
FROM supervision 
LEFT JOIN petition on petition.pe_id = supervision.pe_id
LEFT JOIN student on petition.s_id = student.s_id
LEFT JOIN branch on student.br_id = branch.br_id
WHERE supervision.pe_id = '$pe_id'
GROUP BY student.s_id";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $s_id = $row['s_id'];
    $s_tna = $row['s_tna'];
    $s_fna = $row['s_fna'];
    $s_lna = $row['s_lna'];
    $pe_semester  = $row['pe_semester'];
    $s_group  = $row['s_group'];
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
$query1 = "SELECT supervision.* FROM supervision 
LEFT JOIN petition ON supervision.pe_id  = petition.pe_id
WHERE petition.s_id = '$s_id' and supervision.su_term = '$su_term' order by supervision.su_no";
$result1 = mysqli_query($conn, $query1);
if (mysqli_num_rows($result1) > 0) {
    if (mysqli_num_rows($result1) > 0) {
        $i = 1;
        while ($row1 = mysqli_fetch_assoc($result1)) {
            if($row1['su_suggestion'] == ""){
                $su_suggestion = '<td style="border-right:1px solid #000;padding:3px;text-align:center;">ยังไม่ได้ประเมิน</td>';
            }else{
                $su_suggestion = '<td style="border-right:1px solid #000;padding:3px;text-align:left;">' . $row1['su_suggestion'] . '</td>';
            }
            if($row1['su_score'] == ""){
                $su_score = '<td style="border-right:1px solid #000;padding:3px;text-align:center;">0</td>';
            }else{
                $su_score = '<td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $row1['su_score'] . '</td>';
            }
            $tablebody .= '<tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;"  >' . $i . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $row1['su_term'] . '/' . $i  . '</td>
                '. $su_suggestion .'
                '. $su_score .'
                </tr>';
            $i++;
        }
        $sql = "SELECT sum(supervision.su_score) as sum FROM supervision 
        LEFT JOIN petition ON supervision.pe_id  = petition.pe_id
        WHERE petition.s_id = '$s_id' and supervision.su_term = '$su_term' order by supervision.su_no";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $total = round($row['sum'] / 7.5);
        if($row['sum'] == ""){
            $sum = '0';
        }else{
            $sum = $row['sum'];
        }
        $tablebody .= '<tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3" >คะแนนรวม</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $sum . '</td>
                </tr>
                <tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" colspan="3" >คะแนนเฉลี่ย</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $total . '</td>
                </tr>';
    }

    mysqli_close($conn);

    $mpdf = new \Mpdf\Mpdf([
        'default_font_size' => 16,
        'default_font' => 'sarabun'
    ]);
    $tablehe = '
<h5 style="text-align:center">รายงานการนิเทศนักศึกษา ปีการศึกษา ' . $pe_semester . '<br>
                            ระดับชั้น ปวส.2/' . $s_group . ' แผนก' . $br_na . '<br>
                            ' . $s_tna . '' . $s_fna . ' ' . $s_lna . '</h5>';
    $tableh .= '
    <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:14pt;margin-top:4px;">
        <tr style="border:1px solid #000;padding:4px;">
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"> <b>ลำดับ </b></td>
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="15%"> <b>เทอม/ครั้ง</b></td>
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="65%"> <b>ข้อเสนอแนะ </b></td>
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"> <b>คะแนน(20) </b></td>
        </tr>
    </thead>
      <tbody>';
    $tableend = "</tbody>
    </table>";
    // ****************************************************************************************************************

    $mpdf->WriteHTML($tablehe);
    $mpdf->WriteHTML($tableh);
    $mpdf->WriteHTML($tablebody);
    $mpdf->WriteHTML($tableend);
    $mpdf->Output();
} else {
    echo "<script> alert('ไม่มีข้อมูล'); window.history.back()</script>";
    exit();
}
