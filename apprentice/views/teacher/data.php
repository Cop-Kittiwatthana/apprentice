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
$t_type = $_POST['t_type'];
$columns = array(
	// datatable column index  => database column name
	0 => 't_id',
	1 => 't_tna',
	2 => 't_fna',
	3 => 't_lna',
	4 => 'p_na',
	5 => 'type',
	// 8 => 't_fna',
	// 9 => 't_fna',
	// 10 => 't_fna',

);


// getting total number records without any search
$sql = "SELECT teacher.*,position.*";
$sql .= " FROM teacher ";
$sql .= " LEFT JOIN position ON teacher.p_id = position.p_id ";
$query = mysqli_query($conn, $sql) or die("provinces-data.php: get provinces");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT teacher.*,position.*";
$sql .= " FROM teacher ";
$sql .= " LEFT JOIN position ON teacher.p_id = position.p_id ";
$sql .= " where 1=1 ";

if ($t_type == "0") {

}else{
    $sql .= "AND teacher.type = '" . $t_type . "'";
}
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND ( teacher.t_id LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR teacher.t_tna LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR teacher.t_fna LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR teacher.t_lna LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR teacher.type LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR position.p_na LIKE '" . $requestData['search']['value'] . "%' )";
}
$query = mysqli_query($conn, $sql) or die("provinces-data.php: get provinces");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die("provinces-data.php: get provinces");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
	$nestedData = array();

	$nestedData[] = $row["t_id"];
	if ($row['t_tna'] != null) {
		if ($row['t_tna'] == '0') {
			$nestedData[] = "นาย";
		}
		if ($row['t_tna'] == '1') {
			$nestedData[] = "นาง";
		}
		if ($row['t_tna'] == '2') {
			$nestedData[] = "นางสาว";
		}
	}
	if ($row['t_fna'] != null && $row['t_lna'] != null) {
		$nestedData[] = $row["t_fna"] . '&nbsp;' . $row["t_lna"];
	}
	if ($row['p_na'] == '') {
		$nestedData[] = "<font color='red'>ยังไม่เลือกตำแหน่ง</font>";
	} else {
		$nestedData[] = $row["p_na"];
	}
	if ($row['type'] == '0') {
		$nestedData[] = "ผู้ดูแลระบบ";
	}
	if ($row['type'] == '1') {
		$nestedData[] = "อาจารย์";
	}
	if ($row['t_id'] == '1') {
		$nestedData[] = $row['edit/delect'];
	}else{
	$nestedData[] = $row['edit/delect'] =
		'<div align="center">' . "<a href=\"edit.php?t_id=$row[t_id]\">" . '<button type="button" class="btn btn-success"><i class="fas fa-edit"> แก้ไข </i></button>&nbsp;' .
		"<a >" . '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal' . "$row[t_id]" . '">
		<i class="fas fa-trash"> ลบ </i></button></div>
		
		<form method="POST" action="sql.php" class="float-center">
			<div class="modal fade" id="exampleModal' . "$row[t_id]" . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="exampleModalLabel" >ลบข้อมูลอาจารย์</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<input name="t_id" type="hidden"  value="' . "$row[t_id]" . '" />
							<font class="d-flex justify-content-center " size="6" face="TH SarabunPSK"><p style="color:black">ต้องการลบ&nbsp;</p><p style="color:red">'. "$row[t_fna]" . "$row[t_lna]" . '&nbsp;</p> <p style="color:black">ใช่หรือไม่</p></font>
						</div>
						<div class="modal-footer justify-content-center">
							<button type="submit" class="btn btn-danger" name="btndelect" > ลบ </button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		';}

	$data[] = $nestedData;
}

$json_data = array(
	"draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	"recordsTotal"    => intval($totalData),  // total number of records
	"recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
	"data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
