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
$dp_id = $_POST['dp_id'];

$columns = array(
	// datatable column index  => database column name
	0 => 'br_id',
	1 => 'br_na',
	2 => 'dp_id',
);


// getting total number records without any search
$sql = "SELECT *";
$sql .= " FROM branch ";
$query = mysqli_query($conn, $sql) or die("position-data.php: get position");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT *";
$sql .= " FROM branch ";
$sql .= " where 1=1 and dp_id = $dp_id ";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND (br_id LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR br_na LIKE '" . $requestData['search']['value'] . "%' )";
}
$query = mysqli_query($conn, $sql) or die("department-data.php: get department");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die("department-data.php: get department");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
	$nestedData = array();

	$nestedData[] = $row["br_id"];
	$nestedData[] = $row["br_na"];
	$nestedData[] = $row['edit/delect'] =
		'<div align="center">' . "<a href=\"edit.php?dp_id=$dp_id&br_id=$row[br_id]\">" . '<button type="button" class="btn btn-success"><i class="fas fa-edit"> ??????????????? </i></button></a>&nbsp;' .
		"<a >" . '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal' . "$row[br_id]" . '">
		<i class="fas fa-trash"> ?????? </i></button></div>
		
		<form method="POST" action="sql.php" class="float-center">
			<div class="modal fade" id="exampleModal' . "$row[br_id]" . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="exampleModalLabel" >????????????????????????????????????</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<input name="br_id" type="hidden"  value="' . "$row[br_id]" . '" />
							<input name="dp_id" type="hidden"  value="' . "$row[dp_id]" . '" />
							<font class="d-flex justify-content-center " size="6" face="TH SarabunPSK"><p style="color:black">???????????????????????????&nbsp;</p><p style="color:red">' . "$row[br_na]" . '&nbsp;</p> <p style="color:black">??????????????????????????????</p></font>
						</div>
						<div class="modal-footer justify-content-center">
							<button type="submit" class="btn btn-danger" name="btndelect" > ?????? </button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">??????????????????</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		';

	$data[] = $nestedData;
}

$json_data = array(
	"draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	"recordsTotal"    => intval($totalData),  // total number of records
	"recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
	"data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
