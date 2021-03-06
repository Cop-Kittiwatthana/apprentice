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
$s_id = $_POST['s_id'];
$nr = 0;
$columns = array(
	// datatable column index  => database column name
	0 => 'pf_id ',
	1 => 'pf_na',
	2 => 'pf_file',
	3 => 's_id ',
);


// getting total number records without any search
$sql = "SELECT portfolio.*";
$sql .= " FROM portfolio ";
$query = mysqli_query($conn, $sql) or die("data.php: get portfolio");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT portfolio.*";
$sql .= " FROM portfolio ";
$sql .= " where 1=1 and portfolio.s_id = '$s_id' ";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND ( portfolio.pf_id LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR portfolio.pf_na LIKE '" . $requestData['search']['value'] . "%' )";
}
$query = mysqli_query($conn, $sql) or die("data.php: get portfolio");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die("data.php: get portfolio");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
	$nr++;
	$nestedData = array();

	$nestedData[] = $nr;
	$nestedData[] = $row["pf_na"];
	if($row["pf_file"] != ""){
		$nestedData[] =  '<a href=../../picture/' . "$row[pf_file]" . ' target="_blank"><img src="../../picture/' . "$row[pf_file]" . '" width="100" height="auto" border="0" /></a>';
	}else{
		$nestedData[] =  '<a ><img src="../../icon/noimg1.png" width="100" height="auto" border="0" /></a>';
	}
	$nestedData[] = $row['edit/delect'] =
		'<div align="center">' . "<a href=\"edit.php?pf_id=$row[pf_id]\">" . '<button type="button" class="btn btn-success"><i class="fas fa-edit"> ??????????????? </i></button></a>&nbsp;' .
		"<a >" . '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal' . "$row[pf_id]" . '">
		<i class="fas fa-trash"> ?????? </i></button></a></div>
		
		<form method="POST" action="sql.php" class="float-center">
			<div class="modal fade" id="exampleModal' . "$row[pf_id]" . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="exampleModalLabel" >???????????????????????????????????????????????????????????????</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<input name="pf_id" type="hidden"  value="' . "$row[pf_id]" . '" />
							<input name="pf_file" type="hidden"  value="' . "$row[pf_file]" . '" />
							<font class="d-flex justify-content-center " size="6" face="TH SarabunPSK"><p style="color:black">???????????????????????????&nbsp;<p style="color:black">??????????????????????????????</p></font>
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
