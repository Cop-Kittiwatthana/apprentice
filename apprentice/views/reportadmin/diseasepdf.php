<?php
require_once __DIR__ . '/../../connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_GET["id"];
$s_group = $_GET["s_group"];
$br_id = $_GET["br_id"];
$thai_year = date('Y') + 543;

$query2 = "SELECT teacher.t_id,teacher.t_fna,teacher.t_lna ,branch.br_na 
FROM advisor 
INNER JOIN student ON advisor.s_id  = student.s_id  
INNER JOIN teacher ON advisor.t_id  = teacher.t_id  
LEFT JOIN branch ON student.br_id = branch.br_id
WHERE  student.s_group = '$s_group'  and student.br_id= '$br_id' and student.s_id LIKE '$id%'
GROUP BY advisor.t_id
ORDER BY advisor.t_id";
$result2 = mysqli_query($conn, $query2);
$result3 = mysqli_query($conn, $query2);
$row2 = mysqli_fetch_array($result2);




// *****************************************************************************************************************************



$query1 = "SELECT student.s_id,student.s_tna,student.s_fna,student.s_lna,student.s_tel,student.s_disease,student.s_drug
FROM advisor 
INNER JOIN student ON advisor.s_id  = student.s_id  
INNER JOIN teacher ON advisor.t_id  = teacher.t_id 
WHERE  student.s_group = '$s_group'  and student.br_id= '$br_id' and student.s_id LIKE '$id%'
GROUP BY student.s_id
ORDER BY student.s_id";
$result1 = mysqli_query($conn, $query1);
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
        //     $tablebody .= '<tr class="text-dark" style="text-align: center;border:1px">
        //     <td >' . $i . '</td>
        //     <td >' . $row['s_id'] . '</td>
        //     <td >' . $s_tna . '' . $row['s_fna'] . '' . $row['s_lna'] . '</td>
        //     <td ></td>
        //     <td >หมายเหตุ</td>
        //   </tr>';
        $tablebody .= '<tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;" width="15%">' . $row1['s_id'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" width="30%">' . $s_tna . '' . $row1['s_fna'] . ' ' . $row1['s_lna'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" width="30%">' . $row1['s_disease'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" width="20%">' . $row1['s_drug'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;" width="10%"></td>
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
ระดับชั้น ปวส.2/' . $s_group . ' แผนก' . $row2['br_na'] . '<br>
ครูที่ปรึกษา';

while ($row = mysqli_fetch_array($result3)) {
    if ($row['t_tna'] == 0) {
        $t_tna = "นาย";
    }
    if ($row['t_tna'] == 1) {
        $t_tna = "นาง";
    }
    if ($row['t_tna'] == 2) {
        $t_tna = "นางสาว";
    };
    $tableh .= ' ' . $t_tna . '' . $row['t_fna'] . ' ' . $row['t_lna'] . '';
}
'<h5>';
$tableh .= '<br><br>';
$tableh .= '
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16pt;">
    <tr style="border:1px solid #000;padding:4px;">
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;"   width="15%"><b>รหัสนักศึกษา</b></td>
        <td  width="15%" style="border-right:1px solid #000;padding:4px;text-align:center;"width="30%"><b> ชื่อสกุล </b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;"  width="30%"><b>โรคประจำตัว</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="20%"><b>ยาที่แพ้</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>หมายเหตุ</b></td>
    </tr>

</thead>
  <tbody>';

$tableend = "</tbody>
</table>";
$mpdf->WriteHTML($tableh);
$mpdf->WriteHTML($tablebody);
$mpdf->WriteHTML($tableend);
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
