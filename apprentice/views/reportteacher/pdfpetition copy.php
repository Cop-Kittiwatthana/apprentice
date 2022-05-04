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

$query2 = "SELECT teacher.t_id,teacher.t_fna,teacher.t_lna ,branch.br_na FROM student 
INNER JOIN teacher ON student.t_id = teacher.t_id
LEFT JOIN branch ON student.br_id = branch.br_id
WHERE  student.s_group = '$s_group'  and student.br_id= '$br_id' and student.s_id LIKE '$id%'
GROUP BY student.t_id
ORDER BY student.t_id";
$result2 = mysqli_query($conn, $query2);
$row2 = mysqli_fetch_array($result2);


// *****************************************************************************************************************************



$query1 = "SELECT student.s_id,student.s_tna,student.s_fna,student.s_lna,company.c_na
FROM student 
LEFT JOIN petition ON petition.s_id  = student.s_id
LEFT JOIN demand ON petition.de_id  = demand.de_id  
LEFT JOIN company ON demand.c_id  = company.c_id  
INNER JOIN teacher ON student.t_id = teacher.t_id
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
        //
        if ($row1['c_na'] == "") {
            $c_na = "";
        } else {
            $c_na = $row1['c_na'];
        };

        $tablebody .= '<tr style="border:1px solid #000;">
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"><a target="_blank" href='."$baseURL/views/mpdf/1.php?s_id=$row1[s_id]".'>' . $row1['s_id'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;">' . $s_tna . '' . $row1['s_fna'] . ' ' . $row1['s_lna'] . '</td>
            <td style="border-right:1px solid #000;padding:3px;">' . $c_na . '</td>
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
if ($row2['t_tna'] == 0) {
    $t_tna = "นาย";
}
if ($row2['t_tna'] == 1) {
    $t_tna = "นาง";
}
if ($row2['t_tna'] == 2) {
    $t_tna = "นางสาว";
};
$tableh = '
<h5 style="text-align:center;font-size:16pt;">รายชื่อนักศึกษา ปีการศึกษา ' . $thai_year . '<br>
ระดับชั้น ปวส.2/' . $s_group . ' แผนก' . $row2['br_na'] . '<br>
ครูที่ปรึกษา' . ' ' . $t_tna . '' . $row2['t_fna'] . ' ' . $row2['t_lna'] . '<h5>';

$tableh .= '
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:14pt;">
    <tr style="border:1px solid #000;padding:4px;">
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;"   width="15%"><b>รหัสนักศึกษา</b></td>
        <td  width="15%" style="border-right:1px solid #000;padding:4px;text-align:center;"width="30%"><b> ชื่อสกุล </b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;"  width="30%"><b>สถานประกอบการ</b></td>
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
