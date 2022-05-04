<?php
/* Database connection start */
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "test2";
// $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
// mysqli_set_charset($conn, "utf8");
/* Database connection end */
include("../../connect.php");

// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;

$columns = array(
	// datatable column index  => database column name
	0 => 'n_id',
	1 => 'n_na',
	2 => 'n_detail',
	3 => 'n_pic',
	4 => 'n_file',
	5 => 't_tna',
	6 => 't_fna',
	7 => 't_fna',
	7 => 'n_date',

);


// getting total number records without any search
$sql = "SELECT teacher.*,news.*";
$sql .= " FROM news ";
$sql .= " LEFT JOIN teacher ON teacher.t_id = news.t_id ";
$query = mysqli_query($conn, $sql) or die("news-data.php: get news");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT teacher.*,news.*";
$sql .= " FROM news ";
$sql .= " LEFT JOIN teacher ON teacher.t_id = news.t_id ";
$sql .= " where 1=1 ";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND ( news.n_id LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR news.n_na LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR news.n_date LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR news.n_detail LIKE '" . $requestData['search']['value'] . "%' )";
}
$query = mysqli_query($conn, $sql) or die("news-data.php: get news");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die("news-data.php: get news");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
	$nestedData = array();

	$nestedData[] = $row["n_na"];
	$nestedData[] = $row["n_date"];
	$nestedData[] = $row['edit/delect'] ='<input name="r_ework" id="r_ework" maxlength="2" class="form-control" placeholder="-กรุณาใส่คะแนน-" onkeypress="isInputNumber(event)" type="text" required>';

	$data[] = $nestedData;
}

$json_data = array(
	"draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	"recordsTotal"    => intval($totalData),  // total number of records
	"recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
	"data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
