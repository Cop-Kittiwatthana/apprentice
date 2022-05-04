<?php
include("../../connect.php");

// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;
$t_id = $_POST['t_id'];

$nr = 0;
$columns = array(
	// datatable column index  => database column name
	0 => 'num',
	1 => 'n_group',
	2 => 'n_year',
);


// getting total number records without any search
$sql = "SELECT advisor.*,teacher.* ";
$sql .= " FROM advisor ";
$sql .= " LEFT JOIN student ON advisor.s_id  = student.s_id  ";
$sql .= " LEFT JOIN teacher ON advisor.t_id  = teacher.t_id  ";
$query = mysqli_query($conn, $sql) or die("data.php: get advisor");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT advisor.*,teacher.* ";
$sql .= " FROM advisor ";
$sql .= " LEFT JOIN student ON advisor.s_id  = student.s_id  ";
$sql .= " LEFT JOIN teacher ON advisor.t_id  = teacher.t_id  ";
$sql .= " where 1=1 and advisor.t_id = '$t_id' ";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND ( advisor.num LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR advisor.n_group LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR advisor.n_year LIKE '" . $requestData['search']['value'] . "%' )";
}
$sql .= " GROUP BY advisor.n_group,advisor.n_year ";
$query = mysqli_query($conn, $sql) or die("data.php: get advisor");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die("data.php: get advisor");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
	$nr++;
	$nestedData = array();

	$nestedData[] = $nr;
	$nestedData[] = $row["n_group"];
	$nestedData[] = $row["n_year"];
	$nestedData[] = $row['detail'] = '<div align="center">' . "<a href=\"detailstudent.php?t_id=$row[t_id]&n_group=$row[n_group]&n_year=$row[n_year]\">" . '<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> รายชื่อนักศึกษา </i></button>';
	$data[] = $nestedData;
}

$json_data = array(
	"draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	"recordsTotal"    => intval($totalData),  // total number of records
	"recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
	"data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
