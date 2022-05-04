<?php
require_once __DIR__ . '/../../connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// *****************************************************************************************************************************
$query1 = "SELECT company.*,districts.*, amphures.*,provinces.*,contact_staff.*
FROM company 
LEFT JOIN contact_staff ON company.c_id=contact_staff.c_id 
INNER JOIN districts ON company.district_id=districts.district_id 
INNER JOIN amphures ON districts.amphure_id=amphures.amphure_id 
INNER JOIN provinces ON amphures.province_id=provinces.province_id
GROUP BY company.c_id";
$result1 = mysqli_query($conn, $query1);
if (mysqli_num_rows($result1) > 0) {
    if (mysqli_num_rows($result1) > 0) {
        $i = 1;
        while ($row1 = mysqli_fetch_assoc($result1)) {
            //     $tablebody .= '<tr class="text-dark" style="text-align: center;border:1px">
            //     <td >' . $i . '</td>
            //     <td >' . $row['s_id'] . '</td>
            //     <td >' . $s_tna . '' . $row['s_fna'] . '' . $row['s_lna'] . '</td>
            //     <td ></td>
            //     <td >หมายเหตุ</td>
            //   </tr>';
            if ($row1['cs_tel'] == "") {
                $cs_tel = "-";
            }else{
                $cs_tel = $row1['cs_tel'];
            }
            if ($row1['c_road'] == "-") {
                $address = '' . "$row1[c_hnum]" . '&nbsp;หมู่' . "$row1[c_village]" . '&nbsp;' . "" . 
                '&nbsp;ต.' . "$row1[district_name_th]" . '&nbsp;อ.' . "$row1[amphures_name_th]" . 
                '&nbsp;จ.' . "$row1[provinces_name_th]" . '&nbsp;&nbsp;' . "$row1[zip_code]" . '<br>';
            }else{
                $address = '' . "$row1[c_hnum]" . '&nbsp;หมู่' . "$row1[c_village]" . '&nbsp;' . "$row1[c_road]" . 
                '&nbsp;ต.' . "$row1[district_name_th]" . '&nbsp;อ.' . "$row1[amphures_name_th]" . 
                '&nbsp;จ.' . "$row1[provinces_name_th]" . '&nbsp;&nbsp;' . "$row1[zip_code]" . '<br>';;
            }
            $tablebody .= '<tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;"  >' . $i . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . $row1['c_na'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . $address . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;">' . $cs_tel . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;"></td>
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
    <h5 style="text-align:center;font-size:18pt;">วิทยาลัยการอาชีพวิเชียรบุรี<br>รายชื่อสถานประกอบการทั้งหมด</h5>';
    $tableh .= '
    <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:14pt;margin-top:4px;">
        <tr style="border:1px solid #000;padding:4px;">
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"> <b>ลำดับ </b></td>
            <td  width="15%" style="border-right:1px solid #000;padding:4px;text-align:center;"width="20%">&nbsp; <b> ชื่อสกุล  </b></td>
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"> <b>ที่อยู่ </b></td>
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"> <b>เบอร์โทร </b></td>
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"> <b>หมายเหตุ </b></td>
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
} else {
    echo "<script> alert('ไม่มีข้อมูล'); window.close()</script>";
    exit();
}
