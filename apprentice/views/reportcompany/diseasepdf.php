<?php
require_once __DIR__ . '/../../connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$c_id = $_GET["c_id"];
$pe_semester = $_GET["pe_semester"];
$su_term = $_GET["su_term"];

$query = "SELECT company.c_na,COUNT(DISTINCT branch.br_id)as totalb,COUNT(DISTINCT student.s_id)as totals
FROM petition  
-- LEFT JOIN supervision ON petition.pe_id  = supervision.pe_id 
LEFT JOIN demand ON petition.de_id  = demand.de_id  
LEFT JOIN company ON demand.c_id  = company.c_id 
LEFT JOIN student ON petition.s_id  = student.s_id  
LEFT JOIN branch ON student.br_id  = branch.br_id ";
if ($su_term == 1) {
    $query .=  "where company.c_id = '$c_id' and petition.pe_semester = '$pe_semester' and (petition.pe_term = '1' or petition.pe_term = '3')";
}
if ($su_term == 2) {
    $query .=  "where company.c_id = '$c_id' and petition.pe_semester = '$pe_semester' and petition.pe_term = '2'";
}
$query .=  "ORDER BY student.s_id,branch.br_id";
$result = mysqli_query($conn, $query)
    or die("3. ไม่สามารถประมวลผลคำสั่งได้") . $mysql->error();
while ($row = mysqli_fetch_array($result)) {  // preparing an array
    $c_na = "$row[c_na]";
    $totalb = "$row[totalb]";
    $totals = "$row[totals]";
}
//COUNT(branch.br_id)as totalb,
// *****************************************************************************************************************************
$query1 = "SELECT student.s_id,student.s_fna,student.s_lna,student.s_tel,branch.br_na,student.s_disease,student.s_drug
FROM petition  
-- LEFT JOIN supervision ON petition.pe_id  = supervision.pe_id 
LEFT JOIN demand ON petition.de_id  = demand.de_id  
LEFT JOIN company ON demand.c_id  = company.c_id 
LEFT JOIN student ON petition.s_id  = student.s_id  
LEFT JOIN branch ON student.br_id  = branch.br_id ";
if ($su_term == 1) {
    $query1 .=  "where company.c_id = '$c_id' and petition.pe_semester = '$pe_semester' and  (petition.pe_term = '1' or petition.pe_term = '3')";
}
if ($su_term == 2) {
    $query1 .=  "where company.c_id = '$c_id' and petition.pe_semester = '$pe_semester' and petition.pe_term = '2'";
}
$query1 .=  "GROUP BY student.s_id
ORDER BY student.s_id,branch.br_id";
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
            <td style="border-right:1px solid #000;padding:3px;text-align:center;"  width="15%">' . $row1['s_id'] . '</td>
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
    // $mpdf->SetHTMLHeader('
    // <div style="text-align: right;font-size:16pt;">
    //     {PAGENO}
    // </div>');
    $tableh = '
<h5 style="text-align:center;font-size:16pt;">รายชื่อนักศึกษา ปีการศึกษา ' . $pe_semester . '<br>' . $c_na . '<br>
จำนวนสาขาทั้งหมด ' . $totalb . ' สาขา  จำนวนนักศึกษาทั้งหมด ' . $totals . ' คน<h5>';
    $tableh .= '
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:14pt;">
    <tr style="border:1px solid #000;padding:4px;">
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;"   width="15%"><b>รหัสนักศึกษา</b></td>
        <td  width="15%" style="border-right:1px solid #000;padding:4px;text-align:center;"width="30%"><b>ชื่อสกุล</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;"  width="30%"><b>โรคประจำตัว</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="20%"><b>ยาที่แพ้</b></td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"><b>หมายเหตุ</b></td>
    </tr>
</thead>
  <tbody>';
    $tableend = "</tbody>
</table>";
    // $tableend .= '<br><div style="text-align:right;font-size:16pt;">จำนวนสาขาทั้งหมด ' . $total . ' สาขา</div>
    //     <div style="text-align:right;font-size:16pt;">จำนวนนักศึกษาทั้งหมด ' . $i . ' คน</div>';
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
} else {
    echo "<script> alert('ไม่มีข้อมูล'); window.history.back()</script>";
    exit();
}
