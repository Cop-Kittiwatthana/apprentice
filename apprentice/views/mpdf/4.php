<?php
require_once __DIR__ . '/../../connect.php';
$s_id = $_GET['s_id'];
$query1 = "SELECT * FROM  student  
LEFT JOIN branch ON student.br_id = branch.br_id
LEFT JOIN department ON branch.dp_id = department.dp_id
LEFT JOIN petition ON student.s_id = petition.s_id
LEFT JOIN demand ON petition.de_id  = demand.de_id 
LEFT JOIN company ON demand.c_id  = company.c_id 
LEFT JOIN districts ON company.district_id = districts.district_id
LEFT JOIN amphures ON districts.amphure_id = amphures.amphure_id
LEFT JOIN provinces ON amphures.province_id = provinces.province_id
LEFT JOIN contact_staff ON company.c_id = contact_staff.c_id
LEFT JOIN parent ON student.s_id = parent.s_id
WHERE student.s_id = '$s_id'";
$result1 = mysqli_query($conn, $query1)
	or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
while ($row1 = mysqli_fetch_array($result1)) {  // preparing an array
	$s_tna = "$row1[s_tna]";
	$s_fna = "$row1[s_fna]";
	$s_lna = "$row1[s_lna]";
	$s_pass = "$row1[s_pass]";
	$br_id = "$row1[br_id]";
	$n_group = "$row1[n_group]";
	$br_na = "$row1[br_na]";
	$dp_na = "$row1[dp_na]";
	$s_points = "$row1[s_points]";
	$n_year = "$row1[n_year]";
	$pe_date1 = "$row1[pe_date1]";
	$pe_date2 = "$row1[pe_date2]";
	$c_na = "$row1[c_na]";
	$c_hnum = "$row1[c_hnum]";
	$c_road = "$row1[c_road]";
	$c_village = "$row1[c_village]";
	$district_name_th = "$row1[district_name_th]";
	$amphures_name_th = "$row1[amphures_name_th]";
	$provinces_name_th = "$row1[provinces_name_th]";
	$zip_code = "$row1[zip_code]";
	$cs_tel = "$row1[cs_tel]";
	$s_bdate = "$row1[s_bdate]";
	$s_age = "$row1[s_age]";
	$s_height = "$row1[s_height]";
	$s_weight = "$row1[s_weight]";
	$s_nation = "$row1[s_nation]";
	$s_race = "$row1[s_race]";
	$s_cult = "$row1[s_cult]";
	$s_disease = "$row1[s_disease]";
	$s_drug = "$row1[s_drug]";
	$s_lbood = "$row1[s_lbood]";
	$s_ftel = "$row1[s_ftel]";
	$s_No1 = "$row1[s_No1]";
	$s_village1 = "$row1[s_village1]";
	$s_road1 = "$row1[s_road1]";
	$s_No2 = "$row1[s_No2]";
	$s_village2 = "$row1[s_village2]";
	$s_road2 = "$row1[s_road2]";
	$s_frina = "$row1[s_frina]";
	$s_friadd = "$row1[s_friadd]";
	$s_ftel = "$row1[s_ftel]";
	$pa_fna = "$row1[pa_fna]";
	$pa_lna = "$row1[pa_lna]";
	$pa_age = "$row1[pa_age]";
	$pa_career = "$row1[pa_career]";
	$pa_add = "$row1[pa_add]";

}

$query = "SELECT  position. p_na,teacher. t_id,teacher. t_tna, teacher. t_fna, teacher. t_lna FROM teacher
LEFT JOIN  position
ON teacher. p_id = position .p_id
WHERE position. p_na = 'ผู้อำนวยการ'";
$result = mysqli_query($conn, $query)
	or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
while ($row = mysqli_fetch_array($result)) {  // preparing an array
	$t_tna = "$row[t_tna]";
	$t_fna = "$row[t_fna]";
	$t_lna = "$row[t_lna]";
	$t_pass = "$row[t_pass]";
	$br_id = "$row[br_id]";
}
?>

<?php
if ($s_tna == '0') {
    $s_tna = "นาย";
}
if ($s_tna == '1') {
    $s_tna = "นาง";
}
if ($s_tna == '2') {
    $s_tna = "นางสาว";
}
$d = substr($pe_date, 0, 2);
$m = substr($pe_date, 3, 2);
$y = substr($pe_date, 6);
if($m != 0){
    if($m = "01"){
        $m = "มกราคม";
    }
    if($m = "02"){
        $m = "กุมภาพันธ์";
    }
    if($m = "03"){
        $m = "มีนาคม";
    }
    if($m = "04"){
        $m = "เมษายน";
    }
    if($m = "05"){
        $m = "พฤษภาคม";
    }
    if($m = "06"){
        $m = "มิถุนายน";
    }
    if($m = "07"){
        $m = "กรกฎาคม";
    }
    if($m = "08"){
        $m = "สิงหาคม";
    }
    if($m = "09"){
        $m = "กันยายน";
    }
    if($m = "010"){
        $m = "ตุลาคม";
    }
    if($m = "11"){
        $m = "พฤศจิกายน";
    }
    if($m = "12"){
        $m = "ธันวาคม";
    }
}
if ($s_lbood == '0') {
	$lbood = "A";
}
if ($s_lbood == '1') {
	$lbood = "B";
}
if ($s_lbood == '3') {
	$lbood = "AB";
}
if ($s_lbood == '4') {
	$lbood = "O";
}
require_once __DIR__ . '/../../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
	'default_font_size' => 16,
	'default_font' => 'sarabun'
]);

$html .='<div style="color:black;position:absolute;left:385px;top:184px;"> '.$c_na.'   </div>';
$html .='<div style="color:black;position:absolute;left:320px;top:257px;"> '.$c_na.'   </div>';
$html .='<div style="color:black;position:absolute;left:280px;top:266px"> '.$p_id.' </div>';
$html .='<div style="color:black;position:absolute;left:160px;top:306px"> ' . $s_tna . '' . $s_fna . ' ' . $s_lna . ' </div>';
$html .='<div style="color:black;position:absolute;left:650px;top:306px"> '.$s_age.' &nbsp; </div>';
$html .='<div style="color:black;position:absolute;left:230px;top:330px;"> ' . $s_No2 . ' &nbsp; </div>';
$html .='<div style="color:black;position:absolute;left:350px;top:330px;"> ' . $s_road2. ' &nbsp; </div>';
$html .='<div style="color:black;position:absolute;left:560px;top:330px;"> ' . $district_name_th . ' &nbsp; </div>';
$html .='<div style="color:black;position:absolute;left:150px;top:354px;"> ' . $amphures_name_th . ' &nbsp; </div>';
$html .='<div style="color:black;position:absolute;left:340px;top:354px;"> ' . $provinces_name_th . ' &nbsp; </div>';
$html .='<div style="color:black;position:absolute;left:570px;top:354px;"> ' . $zip_code . ' &nbsp; </div>';
$html .='<div style="color:black;position:absolute;left:600px;top:318px">  </div>';
//$mpdf->SetImportUse(); // only with mPDF <8.0
$mpdf->SetDocTemplate('M4.pdf', true); //เรียกใช้ Template
$mpdf->WriteHTML($html);

$mpdf->AddPage();
$file = 'M4.pdf'; // HERE IS THE SECOND PDF WHICH I WANT TO MERGE WITH THE CURRENT ONE
$pagecount = $mpdf->SetSourceFile($file);
$tplId = $mpdf->ImportPage($pagecount);
// $html2 .='<div style="color:black;position:absolute;left:125px;top:310px"> ' . $s_tna . ' ' . $s_fna . ' ' . $s_lna . ' </div>';
$html2 .='<div style="color:black;position:absolute;left:150px;top:552px"> ' . $s_tna . '' . $s_fna . ' ' . $s_lna . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:600px;top:318px">  </div>';
//$mpdf->SetImportUse(); // only with mPDF <8.0
$mpdf->WriteHTML($html2);

$mpdf->Output();
echo "<script> window.location = 'showprintadmin.php'; </script>";
?>
