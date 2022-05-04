<?php
include("../../connect.php");

// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;
$c_id = $_POST['c_id'];
$nr = 0;
$columns = array(
	// datatable column index  => database column name
	0 => 'pe_id',
	1 => 'c_na',
	2 => 'pe_semester',
);

// getting total number records without any search
$sql = "SELECT company.*,petition.*,COUNT(petition.pe_semester) as total ";
$sql .= " FROM petition ";
$sql .= " LEFT JOIN demand ON petition.de_id  = demand.de_id  
LEFT JOIN company ON demand.c_id  = company.c_id  ";
$query = mysqli_query($conn, $sql) or die("data.php: get data");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT company.*,petition.*,COUNT(petition.pe_semester) as total ";
$sql .= " FROM petition ";
$sql .= " LEFT JOIN demand ON petition.de_id  = demand.de_id  
LEFT JOIN company ON demand.c_id  = company.c_id   ";
$sql .= " where 1=1 and demand.c_id = $c_id and (petition.pe_status = 2 OR petition.pe_status = 5 OR petition.pe_status = 6 OR petition.pe_status = 7 OR petition.pe_status = 8)";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND ( petition.pe_id LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_na LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR petition.pe_semester LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR petition.pe_semester LIKE '" . $requestData['search']['value'] . "%' )";
}
$sql .= " GROUP BY company.c_id";
$query = mysqli_query($conn, $sql) or die("data.php: get data");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die("data.php: get data");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
	$nr++;
	$nestedData = array();

	$nestedData[] = $nr;
	// $nestedData[] = $row["c_na"];
	$nestedData[] = $row["pe_semester"];
	$nestedData[] = $row["total"];
	$nestedData[] = $row['detail'] = '<div align="center">' . "<a href=\"indexstddoc.php?c_id=$row[c_id]&pe_semester=$row[pe_semester]\">" . '<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> รายชื่อนักศึกษา </i></button>';
	$data[] = $nestedData;
}

$json_data = array(
	"draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	"recordsTotal"    => intval($totalData),  // total number of records
	"recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
	"data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
