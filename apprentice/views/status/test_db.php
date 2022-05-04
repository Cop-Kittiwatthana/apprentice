<?php
//fetch.php
include("../../connect.php");
$column = array("petition.pe_id ", "student.s_fna", "student.s_lna", "petition.pe_date", "petition.pe_status");
$pe_semester = $_POST["pe_semester"];
// $query = "
//  SELECT * FROM petition 
//  INNER JOIN student ON student.s_id = petition.s_id 
// ";
$query = "SELECT petition.*,student.*,company.*,demand.*,branch.*";
$query .= " FROM petition ";
$query .= " LEFT JOIN student ON student.s_id  = petition.s_id  ";
$query .= " LEFT JOIN branch ON branch.br_id  = student.br_id  ";
$query .= " LEFT JOIN company ON company.c_id  = petition.c_id  ";
$query .= " LEFT JOIN demand on demand.de_id = petition.de_id  ";
$query .= " WHERE ";
if (isset($_POST["status"])) {
    $query .= "petition.pe_status = '" . $_POST["status"] . "' AND ";
}
if ($pe_semester != "1") {
    $query .= "petition.pe_semester = '" . $_POST["pe_semester"] . "' AND ";
}
if (isset($_POST["is_year"])) {
    $query .= "student.br_id = '" . $_POST["is_year"] . "' AND ";
}
if (isset($_POST["search"]["value"])) {
    $query .= '(petition.pe_id LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR petition.pe_date LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR CONCAT(student.s_fna," ",student.s_lna) LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR CONCAT(student.s_fna," ",student.s_lna) LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR petition.pe_status LIKE "%' . $_POST["search"]["value"] . '%") ';
}

if (isset($_POST["order"])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY petition.pe_id DESC ';
}
$query1 = '';

if ($_POST["length"] != 1) {
    $query1 .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($conn, $query));

$result = mysqli_query($conn, $query . $query1);

$data = array();
$nr = 0;
while ($row = mysqli_fetch_array($result)) {
    $nr++;
    $nestedData = array();
    $nestedData[] = $nr;
    if ($row["s_fna"] != null && $row["s_lna"] != null) {
        $nestedData[] = $row["s_fna"] . '&nbsp;' . $row["s_lna"];
    }
    $nestedData[] = $row["pe_date"];
    $nestedData[] = $row["pe_semester"];
    $nestedData[] = $row["br_na"];
    //  $sub_array[] = $row["pe_status"];
    if ($row['pe_status'] == "0") {
        $nestedData[] = "<font color='Orange'>รอตรวจสอบ</font>";
    }
    if ($row['pe_status'] == "1") {
        $nestedData[] = "<font color='green'>ตรวจสอบแล้ว</font>";
    }
    if ($row['pe_status'] == "2") {
        $nestedData[] = "<font color='green'>รับเข้าฝึก</font>";
    }
    if ($row['pe_status'] == "3") {
        $nestedData[] = "<font color='red'>ปฏิเสธรับเข้าฝึก</font>";
    }
    if ($row['pe_status'] == "4") {
        $nestedData[] = "<font color='red'>ข้อมูลไม่ถูกต้อง	</font>";
    }
    if ($row['pe_status'] == "5") {
        $nestedData[] = "<font color='Orange'>กำลังออกฝึก </font>";
    }
    if ($row['pe_status'] == "6") {
        $nestedData[] = "<font color='green'>ฝึกงานเสร็จสิ้นเทอม1 </font>";
    }
    if ($row['pe_status'] == "7") {
        $nestedData[] = "<font color='green'>เปลียนสถานที่ฝึกงาน </font>";
    }
    if ($row['pe_status'] == "8") {
        $nestedData[] = "<font color='green'>ฝึกงานเสร็จสิ้นทั้งหมด </font>";
    }
    $nestedData[] = $row['detail']= '<div align="center">' . "<a href=\"editstatus.php?c_id=$row[c_id]&s_id=$row[s_id]\">" . '<button type="button" class="btn btn-success"> จัดการสถานะ </i></button>';
    //$nestedData[] = $row['detail2']= '<div align="center">' . "<a href=\"detail.php?c_id=$row[c_id]&s_id=$row[s_id]\">" . '<button type="button" class="btn btn-info"> ผลการประเมิน </i></button>';

    $data[] = $nestedData;
}

function get_all_data($conn)
{
    $query = "SELECT * FROM petition";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result);
}

$output = array(
    "draw"    => intval($_POST["draw"]),
    "recordsTotal"  =>  get_all_data($conn),
    "recordsFiltered" => $number_filter_row,
    "data"    => $data
);

echo json_encode($output);
