<?php
require_once __DIR__ . '/../../connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// *****************************************************************************************************************************
$query1 = "SELECT teacher.*,position.* FROM teacher 
LEFT JOIN position ON teacher.p_id = position.p_id 
where t_user != 'admin' 
ORDER BY position.p_id";
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
            $tablebody .= '<tr style="border:1px solid #000;">
                <td style="border-right:1px solid #000;padding:3px;text-align:center;"  >' . $i . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $row1['t_fna'] . ' ' . $row1['t_lna'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $row1['t_tel'] . '</td>
                <td style="border-right:1px solid #000;padding:3px;text-align:center;">' . $row1['p_na'] . '</td>
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
    <h5 style="text-align:center;font-size:18pt;">วิทยาลัยการอาชีพวิเชียรบุรี<br>รายชื่ออาจารย์ทั้งหมด</h5>';
    $tableh .= '
    <table id="bg-table" width="100%" style="border-collapse: collapse;font-size:16pt;margin-top:4px;">
        <tr style="border:1px solid #000;padding:4px;">
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"> <b>ลำดับ </b></td>
            <td  width="15%" style="border-right:1px solid #000;padding:4px;text-align:center;"width="30%">&nbsp; <b> ชื่อสกุล  </b></td>
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"> <b>เบอร์โทร </b></td>
            <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%"> <b>ตำแหน่ง </b></td>
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
