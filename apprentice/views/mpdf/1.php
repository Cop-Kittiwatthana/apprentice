<?php
require_once __DIR__ . '/../../connect.php';
$s_id = $_GET['s_id'];
$pe_id = $_GET['pe_id'];
$query1 = "SELECT * FROM  student  
LEFT JOIN advisor ON student.s_id = advisor.s_id
LEFT JOIN teacher ON advisor.t_id = teacher.t_id
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
WHERE student.s_id = '$s_id' and petition.pe_id = '$pe_id'";
$result1 = mysqli_query($conn, $query1) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
while ($row1 = mysqli_fetch_array($result1)) {  // preparing an array
    $s_tna = "$row1[s_tna]";
    $s_fna = "$row1[s_fna]";
    $s_lna = "$row1[s_lna]";
    $s_pass = "$row1[s_pass]";
    $br_id = "$row1[br_id]";
    $s_group = "$row1[s_group]";
    $br_na = "$row1[br_na]";
    $dp_na = "$row1[dp_na]";
    $s_points = "$row1[s_points]";
    $pe_semester = "$row1[pe_semester]";
    $pe_date = "$row1[pe_date]";
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
    $s_ability1 = "$row1[s_ability1]";
    $s_ability2 = "$row1[s_ability2]";
    $s_ability3 = "$row1[s_ability3]";
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
    $t_tna1 = "$row1[t_tna]";
    $t_fna1 = "$row1[t_fna]";
    $t_lna1 = "$row1[t_lna]";
}
//ที่อยู่ปัจจุบัน
$query4 = "SELECT student.*,districts.*, amphures.*, provinces.* FROM student 
INNER JOIN districts ON student.district_id2 = districts.district_id 
INNER JOIN amphures ON districts.amphure_id = amphures.amphure_id
INNER JOIN provinces ON amphures.province_id = provinces.province_id
WHERE student.s_id = '$s_id'";
$result4 = mysqli_query($conn, $query4)
    or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
while ($row4 = mysqli_fetch_array($result4)) {  // preparing an array
    $district_name_th4 = "$row4[district_name_th]";
    $amphures_name_th4 = "$row4[amphures_name_th]";
    $provinces_name_th4 = "$row4[provinces_name_th]";
    $zip_code4 = $row4['zip_code'];
}
//ที่อยู่เพื่อน
$query5 = "SELECT student.*,districts.*, amphures.*, provinces.* FROM student 
INNER JOIN districts ON student.district_id3 = districts.district_id 
INNER JOIN amphures ON districts.amphure_id = amphures.amphure_id
INNER JOIN provinces ON amphures.province_id = provinces.province_id
WHERE student.s_id = '$s_id'";
$result5 = mysqli_query($conn, $query5)
    or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
while ($row5 = mysqli_fetch_array($result5)) {  // preparing an array
    $district_name_th5 = "$row5[district_name_th]";
    $amphures_name_th5 = "$row5[amphures_name_th]";
    $provinces_name_th5 = "$row5[provinces_name_th]";
    $zip_code5 = $row5['zip_code'];
}

$query = "SELECT  position. p_na,teacher. t_id,teacher. t_tna, teacher. t_fna, teacher. t_lna FROM teacher
LEFT JOIN  position ON teacher.p_id = position.p_id
WHERE position.p_na = 'ผู้อำนวยการ'";
$result = mysqli_query($conn, $query) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
while ($row = mysqli_fetch_array($result)) {  // preparing an array
    $t_tna = "$row[t_tna]";
    $t_fna = "$row[t_fna]";
    $t_lna = "$row[t_lna]";
    $t_pass = "$row[t_pass]";
    $br_id = "$row[br_id]";
}
//พ่อ
$query = "SELECT student.*,parent.*,districts.*, amphures.*, provinces.* FROM student
    LEFT JOIN parent on  student.s_id = parent.s_id
    LEFT JOIN districts ON parent.district_id = districts.district_id 
    LEFT JOIN amphures ON districts.amphure_id = amphures.amphure_id
    LEFT JOIN provinces ON amphures.province_id = provinces.province_id
    WHERE student.s_id = '$s_id' and parent.pa_status = 1";
$result = mysqli_query($conn, $query) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
while ($row = mysqli_fetch_array($result)) {
    $s_na1 = "$row[s_fna]&nbsp;$row[s_lna]";
    $pa_tna1 = "$row[pa_tna]";
    $pa_fna1 = "$row[pa_fna]";
    $pa_lna1 = "$row[pa_lna]";
    $pa_age1 = "$row[pa_age]";
    $pa_career1 = "$row[pa_career]";
    $pa_relations1 = "$row[pa_relations]";
    $pa_status1 = "$row[pa_status]";
    $pa_tel1 = "$row[pa_tel]";
    $pa_add1 = "$row[pa_add]";
    $district_name_th1 = "$row[district_name_th]";
    $amphures_name_th1 = $row['amphures_name_th'];
    $provinces_name_th1 = $row['provinces_name_th'];
    $zip_code1 = $row['zip_code'];
}
//แม่
$query2 = "SELECT student.*,parent.*,districts.*, amphures.*, provinces.* FROM student
    LEFT JOIN parent on  student.s_id = parent.s_id
    LEFT JOIN districts ON parent.district_id = districts.district_id 
    LEFT JOIN amphures ON districts.amphure_id = amphures.amphure_id
    LEFT JOIN provinces ON amphures.province_id = provinces.province_id
    WHERE student.s_id = '$s_id' and parent.pa_status = 2";
$result2 = mysqli_query($conn, $query2) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
while ($row2 = mysqli_fetch_array($result2)) {  // preparing an array
    $pa_tna2 = "$row2[pa_tna]";
    $pa_fna2 = "$row2[pa_fna]";
    $pa_lna2 = "$row2[pa_lna]";
    $pa_age2 = "$row2[pa_age]";
    $pa_career2 = "$row2[pa_career]";
    $pa_relations2 = "$row2[pa_relations]";
    $pa_status2 = "$row2[pa_status]";
    $pa_tel2 = "$row2[pa_tel]";
    $pa_add2 = "$row2[pa_add]";
    $district_id2 = $row2['district_id'];
    $district_name_th2 = "$row2[district_name_th]";
    $amphure_id2 = $row2['amphure_id'];
    $amphures_name_th2 = $row2['amphures_name_th'];
    $province_id2 = $row2['province_id'];
    $provinces_name_th2 = $row2['provinces_name_th'];
    $zip_code2 = $row2['zip_code'];
}
//ผูเปกครอง
$query3 = "SELECT student.*,parent.*,districts.*, amphures.*, provinces.* FROM student
    LEFT JOIN parent on  student.s_id = parent.s_id
    LEFT JOIN districts ON parent.district_id = districts.district_id 
    LEFT JOIN amphures ON districts.amphure_id = amphures.amphure_id
    LEFT JOIN provinces ON amphures.province_id = provinces.province_id
    WHERE student.s_id = '$s_id' and parent.pa_status = 0";
$result3 = mysqli_query($conn, $query3) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
while ($row3 = mysqli_fetch_array($result3)) {  // preparing an array
    $pa_tna3 = "$row3[pa_tna]";
    $pa_fna3 = "$row3[pa_fna]";
    $pa_lna3 = "$row3[pa_lna]";
    $pa_age3 = "$row3[pa_age]";
    $pa_career3 = "$row3[pa_career]";
    $pa_relations3 = "$row3[pa_relations]";
    $pa_status3 = "$row3[pa_status]";
    $pa_tel3 = "$row3[pa_tel]";
    $pa_add3 = "$row3[pa_add]";
    $district_id3 = $row3['district_id'];
    $district_name_th3 = "$row3[district_name_th]";
    $amphure_id3 = $row3['amphure_id'];
    $amphures_name_th3 = $row3['amphures_name_th'];
    $province_id3 = $row3['province_id'];
    $provinces_name_th3 = $row3['provinces_name_th'];
    $zip_code3 = $row3['zip_code'];
}
?>

<?php
if ($s_tna == '0' || $pa_tna1 == '0' || $pa_tna2 == '0' || $pa_tna3 == '0') {
    $s_tna = "นาย";
    $pa_tna1 = "นาย";
    $pa_tna2 = "นาย";
    $pa_tna3 = "นาย";
}
if ($s_tna == '1' || $pa_tna1 == '1' || $pa_tna2 == '1' || $pa_tna3 == '1') {
    $s_tna = "นาง";
    $pa_tna1 = "นาง";
    $pa_tna2 = "นาง";
    $pa_tna3 = "นาง";
}
if ($s_tna == '2' || $pa_tna1 == '2' || $pa_tna2 == '2' || $pa_tna3 == '2') {
    $s_tna = "นางสาว";
    $pa_tna1 = "นางสาว";
    $pa_tna2 = "นางสาว";
    $pa_tna3 = "นางสาว";
}
$d = substr($pe_date, 0, 2);
$m = substr($pe_date, 3, 2);
$y = substr($pe_date, 6);
if ($m != '0') {
    if ($m == "01") {
        $m = "มกราคม";
    }
    if ($m == "02") {
        $m = "กุมภาพันธ์";
    }
    if ($m == "03") {
        $m = "มีนาคม";
    }
    if ($m == "04") {
        $m = "เมษายน";
    }
    if ($m == "05") {
        $m = "พฤษภาคม";
    }
    if ($m == "06") {
        $m = "มิถุนายน";
    }
    if ($m == "07") {
        $m = "กรกฎาคม";
    }
    if ($m == "08") {
        $m = "สิงหาคม";
    }
    if ($m == "09") {
        $m = "กันยายน";
    }
    if ($m == "010") {
        $m = "ตุลาคม";
    }
    if ($m == "11") {
        $m = "พฤศจิกายน";
    }
    if ($m == "12") {
        $m = "ธันวาคม";
    }
}
if ($s_lbood == '0') {
    $lbood = "A";
}
if ($s_lbood == '1') {
    $lbood = "B";
}
if ($s_lbood == '2') {
    $lbood = "AB";
}
if ($s_lbood == '3') {
    $lbood = "O";
}
require_once __DIR__ . '/../../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
    'default_font_size' => 15,
    'default_font' => 'sarabun'
]);

$html = '<div style="color:black;position:absolute;left:550px;top:125px;"> วิทยาลัยการอาชีพวิเชียรบุรี </div>';
$html .= '<div style="color:black;position:absolute;left:485px;top:150px;"> 100 ม.5 ต.สระประดู่ อ.วิเชียรบุรี จ.เพชรบูรณ์ </div>';
$html .= '<div style="color:black;position:absolute;left:425px;top:174px;"> ' . $d . '&nbsp;   </div>';
$html .= '<div style="color:black;position:absolute;left:510px;top:174px;"> ' . $m . '&nbsp; </div>';
$html .= '<div style="color:black;position:absolute;left:670px;top:174px;"> ' . $y . '&nbsp; </div>';
$html .= '<div style="color:black;position:absolute;left:270px;top:270px"> ' . $t_fna . ' ' . $t_lna . ' </div>';
$html .= '<div style="color:black;position:absolute;left:249px;top:320px"> ' . $s_tna . '' . $s_fna . '  ' . $s_lna . '</div>';
$html .= '<div style="color:black;position:absolute;left:242px;top:344px"> ' . $s_id . ' </div>';
$html .= '<div style="color:black;position:absolute;left:575px;top:350px;"> <img src="tick.png" width="25%" height="auto"/> </div>';
$html .= '<div style="color:black;position:absolute;left:660px;top:345px;"> 2 </div>';
$html .= '<div style="color:black;position:absolute;left:710px;top:345px;"> ' . $s_group . '</div>';
$html .= '<div style="color:black;position:absolute;left:180px;top:368px;"> ' . $br_na . ' </div>';
$html .= '<div style="color:black;position:absolute;left:480px;top:368px;"> ' . $dp_na . ' </div>';
$html .= '<div style="color:black;position:absolute;left:242px;top:391px;"> ' . $s_points . ' </div>';
$html .= '<div style="color:black;position:absolute;left:510px;top:391px;"> 1 </div>';
$html .= '<div style="color:black;position:absolute;left:545px;top:391px;"> ' . $pe_semester . ' </div>';
$html .= '<div style="color:black;position:absolute;left:665px;top:391px;"> 2 </div>';
$html .= '<div style="color:black;position:absolute;left:694px;top:391px;"> ' . $pe_semester . ' </div>';
$html .= '<div style="color:black;position:absolute;left:215px;top:415px;"> ' . $pe_date1 . ' </div>';
$html .= '<div style="color:black;position:absolute;left:450px;top:415px;"> ' . $pe_date2 . ' </div>';
$html .= '<div style="color:black;position:absolute;left:280px;top:450px;"> ' . $c_na . ' </div>';
$html .= '<div style="color:black;position:absolute;left:150px;top:475px; width: 100%;"> ' . $c_hnum . ' </div>';
$html .= '<div style="color:black;position:absolute;left:250px;top:475px;"> ' . $c_road . ' </div>';
$html .= '<div style="color:black;position:absolute;left:515px;top:475px;"> ' . $district_name_th . ' </div>';
$html .= '<div style="color:black;position:absolute;left:150px;top:500px; width: 100%;"> ' . $amphures_name_th . ' </div>';
$html .= '<div style="color:black;position:absolute;left:380px;top:500px; width: 100%;"> ' . $provinces_name_th . ' </div>';
$html .= '<div style="color:black;position:absolute;left:630px;top:500px;"> ' . $zip_code . ' </div>';
$html .= '<div style="color:black;position:absolute;left:150px;top:525px;"> ' . $cs_tel . ' </div>';

//$mpdf->SetImportUse(); // only with mPDF <8.0
$mpdf->SetDocTemplate('M1.pdf', true); //เรียกใช้ Template
$mpdf->WriteHTML($html);

$mpdf->AddPage();
$file = 'M1.pdf'; // HERE IS THE SECOND PDF WHICH I WANT TO MERGE WITH THE CURRENT ONE
$pagecount = $mpdf->SetSourceFile($file);
$tplId = $mpdf->ImportPage($pagecount);
$html2 = '<div style="color:black;position:absolute;left:230px;top:125px;"> ' . $s_tna . '' . $s_fna . '  ' . $s_lna . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:180px;top:150px;"> ปวส.2 </div>';
$html2 .= '<div style="color:black;position:absolute;left:270px;top:150px;"> ' . $s_group . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:385px;top:150px;"> ' . $s_id . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:600px;top:150px;"> ' . $s_bdate . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:190px;top:175px" width: 100px;> ' . $s_age . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:270px;top:175px"> ' . $s_height . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:435px;top:175px"> ' . $s_weight . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:565px;top:175px;"> ' . $s_nation . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:685px;top:175px;"> ' . $s_race . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:210px;top:200px;"> ' . $s_cult . ' &nbsp;</div>';
$html2 .= '<div style="color:black;position:absolute;left:345px;top:200px;"> ' . $s_disease . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:210px;top:223px;"> ' . $s_drug . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:685px;top:223px;"> ' . $lbood . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:260px;top:245px;"> ' . $s_ftel . ' &nbsp;</div>';
$html2 .= '<div style="color:black;position:absolute;left:195px;top:295px;"> ' . $s_No1 . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:230px;top:295px;"> หมู่ที่ ' . $s_village1 . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:335px;top:295px;"> ' . $s_road1 . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:575px;top:295px;"> ' . $district_name_th . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:210px;top:320px;"> ' . $amphures_name_th . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:415px;top:320px;"> ' . $provinces_name_th . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:650px;top:320px;"> ' . $zip_code . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:195px;top:365px;"> ' . $s_No2 . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:230px;top:365px;"> หมู่ที่ ' . $s_village2 . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:335px;top:365px;"> ' . $s_road2 . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:575px;top:365px;"> ' . $district_name_th4 . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:210px;top:391px;"> ' . $amphures_name_th4 . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:415px;top:391px;"> ' . $provinces_name_th4 . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:650px;top:391px;"> ' . $zip_code4 . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:250px;top:415px;"> ' . $s_frina . ' &nbsp;</div>';
$html2 .= '<div style="color:black;position:absolute;left:220px;top:438px;"> ' . $s_friadd . '&nbsp;&nbsp;ต.' . $district_name_th5 . '&nbsp;อ.' . $amphures_name_th5 . '&nbsp;จ.' . $provinces_name_th5 . '&nbsp;' . $zip_code5 . '</div>';
$html2 .= '<div style="color:black;position:absolute;left:220px;top:464px;"> ' . $pa_tna1 . '' . $pa_fna1 . ' ' . $pa_lna1 . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:680px;top:464px;"> ' . $pa_age1 . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:210px;top:488px;"> ' . $pa_career1 . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:220px;top:510px;"> ' . $pa_add1 . '&nbsp;&nbsp;ต.' . $district_name_th1 . '&nbsp;อ.' . $amphures_name_th1 . '&nbsp;จ.' . $provinces_name_th1 . '&nbsp;' . $zip_code1 . '</div>';
$html2 .= '<div style="color:black;position:absolute;left:220px;top:535px;"> ' . $pa_tna2 . '' . $pa_fna2 . ' ' . $pa_lna2 . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:680px;top:535px;"> ' . $pa_age2 . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:210px;top:558px;"> ' . $pa_career2 . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:225px;top:585px;"> ' . $pa_add2 . '&nbsp;&nbsp;ต.' . $district_name_th2 . '&nbsp;อ.' . $amphures_name_th2 . '&nbsp;จ.' . $provinces_name_th2 . '&nbsp;' . $zip_code2 . '</div>';
$html2 .= '<div style="color:black;position:absolute;left:220px;top:633px;"> ' . $pa_tna3 . '' . $pa_fna3 . ' ' . $pa_lna3 . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:680px;top:633px;"> ' . $pa_relations3 . ' &nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:210px;top:657px;"> ' . $pa_add3 . '&nbsp;&nbsp;ต.' . $district_name_th3 . '&nbsp;อ.' . $amphures_name_th3 . '&nbsp;จ.' . $provinces_name_th3 . '&nbsp;' . $zip_code3 . '</div>';
$html2 .= '<div style="color:black;position:absolute;left:230px;top:680px;"> ' . $pa_tel3 . ' &nbsp;</div>';
$html2 .= '<div style="color:black;position:absolute;left:390px;top:705px;"> ' . $s_points . ' &nbsp;</div>';
$html2 .= '<div style="color:black;position:absolute;left:320px;top:728px;"> ' . $s_ability1 . ' &nbsp;</div>';
$html2 .= '<div style="color:black;position:absolute;left:320px;top:753px;"> ' . $s_ability2 . ' &nbsp;</div>';
$html2 .= '<div style="color:black;position:absolute;left:320px;top:775px;"> ' . $s_ability3 . ' &nbsp;</div>';
$html2 .= '<div style="color:black;position:absolute;left:240px;top:825px;"> ' . $pa_tna3 . '' . $pa_fna3 . ' ' . $pa_lna3 . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:220px;top:850px;"> ' . $pa_career3 . '&nbsp; </div>';
$html2 .= '<div style="color:black;position:absolute;left:560px;top:850px;"> ' . $pa_tel3 . ' &nbsp;</div>';
$html2 .= '<div style="color:black;position:absolute;left:240px;top:873px;"> ' . $pa_add3 . '&nbsp;&nbsp;ต.' . $district_name_th . '&nbsp;อ.' . $amphures_name_th . '&nbsp;จ.' . $provinces_name_th . '&nbsp;' . $zip_code . '</div>';
$html2 .= '<div style="color:black;position:absolute;left:250px;top:898px;"> ' . $t_fna1 . ' ' . $t_lna1 . ' </div>';
$html2 .= '<div style="color:black;position:absolute;left:600px;top:318px">  </div>';
//$mpdf->SetImportUse(); // only with mPDF <8.0
$mpdf->WriteHTML($html2);

//  $mpdf->AddPage();
//  $file = 'MD1.pdf'; // HERE IS THE SECOND PDF WHICH I WANT TO MERGE WITH THE CURRENT ONE
//  $pagecount = $mpdf->SetSourceFile($file);
//  $tplId = $mpdf->ImportPage($pagecount);
//  $html3  = '<div style="color:black;position:absolute;left:380px;top:692px;"> ' . $c_na . ' </div>';
//  $html3 .= '<div style="color:black;position:absolute;left:180px;top:716px;"> ' . $c_hnum . ' &nbsp; </div>';
//  $html3 .= '<div style="color:black;position:absolute;left:310px;top:716px;"> - </div>';
//  $html3 .= '<div style="color:black;position:absolute;left:475px;top:716px;"> - </div>';
//  $html3 .= '<div style="color:black;position:absolute;left:625px;top:716px;"> ' . $c_road . ' </div>';
//  $html3 .= '<div style="color:black;position:absolute;left:170px;top:740px"> ' . $district_name_th . ' </div>';
//  $html3 .= '<div style="color:black;position:absolute;left:380px;top:740px"> ' . $amphures_name_th . ' &nbsp; </div>';
//  $html3 .= '<div style="color:black;position:absolute;left:590px;top:740px"> ' . $provinces_name_th . ' &nbsp;  </div>';
//  $html3 .= '<div style="color:black;position:absolute;left:390px;top:764px;"> ' . $cs_tel . ' </div>';
//  $html3 .= '<div style="color:black;position:absolute;left:600px;top:318px">  </div>';
//  //$mpdf->SetImportUse(); // only with mPDF <8.0
//  $mpdf->WriteHTML($html3);

$mpdf->Output();
echo "<script> window.location = 'showprintadmin.php'; </script>";
?>