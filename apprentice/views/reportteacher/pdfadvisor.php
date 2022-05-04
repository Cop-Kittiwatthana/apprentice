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
FROM student  
LEFT JOIN advisor ON student.s_id  = advisor.s_id   
LEFT JOIN teacher ON advisor.t_id  = teacher.t_id   
LEFT JOIN branch ON student.br_id  = branch.br_id  
WHERE  student.s_group = '$s_group'  and student.br_id= '$br_id' and student.s_id LIKE '$id%'
GROUP BY advisor.t_id
ORDER BY advisor.t_id DESC";
$result2 = mysqli_query($conn, $query2);
$row2 = mysqli_fetch_array($result2);
$result3 = mysqli_query($conn, $query2);



// *****************************************************************************************************************************



$query1 = "SELECT student.s_id,student.s_tna,student.s_fna,student.s_lna 
FROM student  
LEFT JOIN advisor ON student.s_id  = advisor.s_id   
LEFT JOIN teacher ON advisor.t_id  = teacher.t_id   
LEFT JOIN branch ON student.br_id  = branch.br_id  
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
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"  >' . $i . '</td>
            <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $row1['s_id'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;">' . $s_tna . '' . $row1['s_fna'] . ' ' . $row1['s_lna'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;"></td>
            <td style="border-right:1px solid #000;padding:3px;"></td>
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
    <h5 style="text-align:center;font-size:16pt;">รายชื่อนักศึกษา ปีการศึกษา ' . $thai_year . '<br>
    ระดับชั้น ปวส.2/' . $s_group . ' แผนก' . $row2['br_na'] . '<br>
    ครูที่ปรึกษา';

while ($row3 = mysqli_fetch_array($result3)) {
    if ($row3['t_tna'] == 0) {
        $t_tna = "นาย";
    }
    if ($row3['t_tna'] == 1) {
        $t_tna = "นาง";
    }
    if ($row3['t_tna'] == 2) {
        $t_tna = "นางสาว";
    };
    $tableh .= ' ' . $t_tna . '' . $row3['t_fna'] . ' ' . $row3['t_lna'] . '';
};
$tableh .= '<h5><br>';
$tableh .= '
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16pt;">
    <tr style="border:1px solid #000;padding:4px;">
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;"   width="10%"><b>ลำดับ</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;"   width="15%"><b>รหัสนักศึกษา</b></td>
        <td  width="15%" style="border-right:1px solid #000;padding:4px;text-align:center;"width="30%"><b> ชื่อสกุล </b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;"  width="30%"></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="20%"><b>หมายเหตุ</b></td>
    </tr>

</thead>
  <tbody>';

$tableend = "</tbody>
</table>";
$mpdf->WriteHTML($tableh);
$mpdf->WriteHTML($tablebody);
$mpdf->WriteHTML($tableend);
$mpdf->Output();
