<?php
include("../../connect.php");
// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;

$columns = array(
	// datatable column index  => database column name
	0 => 'c_id',
	1 => 'c_na',
	2 => 'c_hnum',
	3 => 'c_village',
	4 => 'c_road',
	5 => 'c_status',
	6 => 'district_id',

);


// getting total number records without any search
$sql = "SELECT company.*,districts.*, amphures.*,provinces.*";
$sql .= " FROM company ";
$sql .= " INNER JOIN districts ON company.district_id=districts.district_id ";
$sql .= " INNER JOIN amphures ON districts.amphure_id=amphures.amphure_id ";
$sql .= " INNER JOIN provinces ON amphures.province_id=provinces.province_id ";
$query = mysqli_query($conn, $sql) or die("datacompany.php: get company");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT company.*,districts.*, amphures.*,provinces.*";
$sql .= " FROM company ";
$sql .= " INNER JOIN districts ON company.district_id=districts.district_id ";
$sql .= " INNER JOIN amphures ON districts.amphure_id=amphures.amphure_id ";
$sql .= " INNER JOIN provinces ON amphures.province_id=provinces.province_id ";
$sql .= " where 1=1 ";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND ( company.c_id LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_na LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_hnum LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_village LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_road LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_status LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR districts.district_name_th LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR amphures.amphures_name_th LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR provinces.provinces_name_th LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR districts.zip_code LIKE '" . $requestData['search']['value'] . "%' )";
}
$query = mysqli_query($conn, $sql) or die("datacompany.php: get company");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die("datacompany.php: get company");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
	$nestedData = array();

	$nestedData[] = $row["c_id"];
	$nestedData[] = $row["c_na"];
	if ($row['c_hnum'] != null && $row['c_village'] != null) {
		$nestedData[] = $row["c_hnum"] . '&nbsp;หมู่' . $row["c_village"] . '&nbsp;' . $row["c_road"] . '&nbsp;ต.' .
			$row["district_name_th"] . '&nbsp;อ.' . $row["amphures_name_th"] . '&nbsp;จ.' . $row["provinces_name_th"];
	}
	if ($row['c_status'] == '0') {
		$nestedData[] = "<font color='green'>เปิดรับ</font>";
	}
	if ($row['c_status'] == '1') {
		$nestedData[] = "<font color='red'>ไม่เปิดรับ</font>";
	};

	$data[] = $nestedData;
}

$json_data = array(
	"draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	"recordsTotal"    => intval($totalData),  // total number of records
	"recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
	"data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
