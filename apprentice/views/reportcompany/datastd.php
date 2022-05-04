<?php
include("../../connect.php");

// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;
$c_id = $_POST['c_id'];
$nr = 0;
$columns = array(
	// datatable column index  => database column name
	0 => 'pe_id',
	1 => 'br_na',
	2 => 'c_na',
	2 => 'pe_semester',
);


// getting total number records without any search
$sql = "SELECT petition.*,student.*,branch.*,company.*,demand.*";
$sql .= " FROM petition ";
$sql .= " LEFT JOIN company ON petition.c_id  = company.c_id  ";
$sql .= " LEFT JOIN demand ON petition.de_id  = demand.de_id  ";
$sql .= " LEFT JOIN student ON petition.s_id  = student.s_id  ";
$sql .= " LEFT JOIN branch ON student.br_id  = branch.br_id  ";
$query = mysqli_query($conn, $sql) or die("data.php: get petition");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT petition.*,student.*,branch.*,company.*,demand.*";
$sql .= " FROM petition ";
$sql .= " LEFT JOIN company ON petition.c_id  = company.c_id  ";
$sql .= " LEFT JOIN demand ON petition.de_id  = demand.de_id  ";
$sql .= " LEFT JOIN student ON petition.s_id  = student.s_id  ";
$sql .= " LEFT JOIN branch ON student.br_id  = branch.br_id ";
$sql .= " where 1=1 and company.c_id = '$c_id'";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND (petition.pe_id LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR petition.pe_semester LIKE '" . $requestData['search']['value'] . "%' ";
	//$sql .= " OR toatl LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR branch.br_na LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_na LIKE '" . $requestData['search']['value'] . "%' )";
}
$sql .= " GROUP BY petition.pe_semester,petition.de_id,company.c_id";
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
	$nestedData[] = $row["pe_semester"];
	$nestedData[] = $row["br_na"];
	$nestedData[] = $row['detail']= '<div align="center">' . "<a target='blank' href=\"studentpdf.php?pe_id=$row[pe_id]&de_id=$row[de_id]&c_id=$row[c_id]&su_term=1\">" . '<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> เทอม1 </i></button>
	' . "<a target='blank' href=\"studentpdf.php?pe_id=$row[pe_id]&de_id=$row[de_id]&c_id=$row[c_id]&su_term=2\">" . '<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> เทอม2 </i></button>';

	$data[] = $nestedData;
}

$json_data = array(
	"draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	"recordsTotal"    => intval($totalData),  // total number of records
	"recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
	"data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
