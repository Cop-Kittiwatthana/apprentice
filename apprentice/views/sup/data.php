<?php
include("../../connect.php");

// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;
$nr = 0;
$columns = array(
	// datatable column index  => database column name
	0 => 'num',
	1 => 'c_na',
	2 => 'pe_semester',
);

$sql = "SELECT demand.de_id,company.c_id,company.c_na,petition.pe_semester,branch.br_na,COUNT(DISTINCT sup_instructor.pe_id) AS total  ";
$sql .= " FROM sup_instructor   ";
$sql .= " LEFT JOIN petition ON sup_instructor.pe_id  = petition.pe_id  ";
$sql .= " LEFT JOIN demand ON petition.de_id  = demand.de_id ";
$sql .= " LEFT JOIN branch ON demand.br_id  = branch.br_id  ";
$sql .= " LEFT JOIN company ON demand.c_id  = company.c_id  ";
$sql .= " LEFT JOIN teacher ON sup_instructor.t_id  = teacher.t_id ";
$sql .= " GROUP BY branch.br_id";
$query = mysqli_query($conn, $sql) or die("data.php: get sup");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT demand.de_id,company.c_id,company.c_na,petition.pe_semester,branch.br_na,COUNT(DISTINCT sup_instructor.pe_id) AS total  ";
$sql .= " FROM sup_instructor   ";
$sql .= " LEFT JOIN petition ON sup_instructor.pe_id  = petition.pe_id  ";
$sql .= " LEFT JOIN demand ON petition.de_id  = demand.de_id ";
$sql .= " LEFT JOIN branch ON demand.br_id  = branch.br_id  ";
$sql .= " LEFT JOIN company ON demand.c_id  = company.c_id  ";
$sql .= " LEFT JOIN teacher ON sup_instructor.t_id  = teacher.t_id ";
$sql .= " WHERE 1=1 ";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND ( sup_instructor.num LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_na LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR branch.br_na LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR petition.pe_semester LIKE '" . $requestData['search']['value'] . "%' )";
}
$sql .= " GROUP BY branch.br_id";
$query = mysqli_query($conn, $sql) or die("data.php: get sup");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die("data.php: get sup");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
	$nr++;
	$nestedData = array();

	$nestedData[] = $nr;
	$nestedData[] = $row["c_na"];
	$nestedData[] = $row["pe_semester"];
	$nestedData[] = $row["br_na"];
	$nestedData[] = $row["total"];
	//$nestedData[] = $row['detail'] = '<div align="center">' . "<a href=\"add.php?de_id=$row[de_id]&c_id=$row[c_id]&su_term=1\">" . '<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> จัดการอาจารย์ที่ปรึกษา </i></button></a>';
	 $nestedData[] = $row['detail'] = '<div align="center">' . "<a href=\"edit.php?de_id=$row[de_id]&c_id=$row[c_id]&su_term=1\">" . '<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> เทอม1 </i></button></a>'.
	 "<a href=\"add.php?de_id=$row[de_id]&c_id=$row[c_id]&su_term=2\">" . '&nbsp;<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> เทอม2 </i></button></a>';
	
	$data[] = $nestedData;
}

$json_data = array(
	"draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	"recordsTotal"    => intval($totalData),  // total number of records
	"recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
	"data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
