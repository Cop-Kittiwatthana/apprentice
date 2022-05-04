<?php
include("../../connect.php");

// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;
$nr = 0;
$date = date("Y");
$columns = array(
	// datatable column index  => database column name
	0 => 'pe_id',
	1 => 'pe_date',
	2 => 'pe_semester',
	3 => 'pe_date1',
	4 => 'pe_date2',
	5 => 'pe_status',
	6 => 's_id',
	7 => 'c_id',
	// 10 => 't_fna',

);

// getting total number records without any search
$sql = "SELECT petition.*,student.*,company.*,demand.*";
$sql .= " FROM petition ";
$sql .= " LEFT JOIN student ON student.s_id  = petition.s_id  ";
$sql .= " LEFT JOIN demand ON petition.de_id  = demand.de_id  
LEFT JOIN company ON demand.c_id  = company.c_id   ";
$query = mysqli_query($conn, $sql) or die("data.php: get petition");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT petition.*,student.*,company.*,demand.*";
$sql .= " FROM petition ";
$sql .= " LEFT JOIN student ON student.s_id  = petition.s_id  ";
$sql .= " LEFT JOIN demand ON petition.de_id  = demand.de_id  
LEFT JOIN company ON demand.c_id  = company.c_id   ";
$sql .= " where 1=1 ";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND ( petition.pe_id LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_na LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR petition.pe_date LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR petition.pe_semester LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR petition.pe_date1 LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR petition.pe_date2 LIKE '" . $requestData['search']['value'] . "%' )";
}
$query = mysqli_query($conn, $sql) or die("data.php: get petition");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die("data.php: get petition");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
	$nr++;
	$nestedData = array();

	$nestedData[] = $nr;
	if ($row['s_fna'] != null && $row['s_lna'] != null) {
		$nestedData[] = $row["s_fna"] . '&nbsp;' . $row["s_lna"];
	}
	$nestedData[] = $row["pe_date"];
	//$nestedData[] =$date;
	if ($row['pe_status'] == "0") {
		$nestedData[] = "<font color='Orange'>รอตรวจสอบ</font>";
	}
	if ($row['pe_status'] == "1") {
		$nestedData[] = "<font color='Orange'>ตรวจสอบแล้ว</font>";
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
		$nestedData[] = "<font color='green'>เปลียนสถานที่ฝึกเทอม1 </font>";
	}
	if ($row['pe_status'] == "10") {
		$nestedData[] = "<font color='green'>เปลียนสถานที่ฝึกเทอม2 </font>";
	}
	if ($row['pe_status'] == "8") {
		$nestedData[] = "<font color='green'>ฝึกงานเสร็จสิ้นทั้งหมด </font>";
	}
	if ($row['pe_status'] == "10") {
		$nestedData[] = "<font color='red'>ยกเลิกการฝึก </font>";
	}
	 $nestedData[] = $row['detail']= '<div align="center">' . "<a href=\"editstatus.php?c_id=$row[c_id]&s_id=$row[s_id]\">" . '<button type="button" class="btn btn-success"> จัดการสถานะ </i></button>';
	//  $nestedData[] = $row['detail']= '<div align="center">' . "<a href=\"detail.php?c_id=$c_id&s_id=$row[s_id]\">" . '<button type="button" class="btn btn-info"> ผลการประเมิน </i></button>';


	$data[] = $nestedData;
}

$json_data = array(
	"draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	"recordsTotal"    => intval($totalData),  // total number of records
	"recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
	"data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
