<?php
include("../../connect.php");

// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;
$c_id = $_POST['c_id'];

$columns = array(
	// datatable column index  => database column name
	0 => 'de_id',
	1 => 'de_year',
	2 => 'de_num',
	3 => 'de_Jobdetails',
	4 => 'de_Welfare',
	5 => 'c_id',
	6 => 'br_id',

);


// getting total number records without any search
$sql = "SELECT demand.*,company.*,branch.*";
$sql .= " FROM demand ";
$sql .= " LEFT JOIN company ON company.c_id  = demand.c_id  ";
$sql .= " LEFT JOIN branch ON branch.br_id  = demand.br_id  ";
$query = mysqli_query($conn, $sql) or die("data.php: get demand");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT demand.*,company.*,branch.*";
$sql .= " FROM demand ";
$sql .= " LEFT JOIN company ON company.c_id  = demand.c_id  ";
$sql .= " LEFT JOIN branch ON branch.br_id  = demand.br_id  ";
$sql .= " where 1=1";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND ( demand.de_id LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR demand.de_year LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR demand.de_num LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR demand.cs_department LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR demand.cs_position LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR demand.cs_tel LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR demand.cs_mail LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR branch.br_na LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_na LIKE '" . $requestData['search']['value'] . "%' )";
}
$query = mysqli_query($conn, $sql) or die("data.php: get demand");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die("data.php: get demand");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
	$nestedData = array();

	$nestedData[] = $row["de_id"];
	$nestedData[] = $row["c_na"];
	$nestedData[] = $row["br_na"];
	$nestedData[] = $row["de_num"];
	$nestedData[] = $row["de_year"];
	$nestedData[] = $row['detail']= '<div align="center">' . "<a href=\"detail.php?de_id=$row[de_id]\">" . '<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> รายละเอียด </i></button>';
	$nestedData[] = $row['edit/delect'] = 
		'<div align="center">' . "<a href=\"edit.php?de_id=$row[de_id]\">" . '<button type="button" class="btn btn-success"><i class="fas fa-edit"> แก้ไข </i></button></a>&nbsp;' .
		"<a >" . '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal' . "$row[de_id]" . '">
		<i class="fas fa-trash"> ลบ </i></button></div>
		
		<form method="POST" action="sql.php" class="float-center">
			<div class="modal fade" id="exampleModal' . "$row[de_id]" . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="exampleModalLabel" >ลบข้อมูลความต้องการ</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<input name="de_id" type="hidden"  value="' . "$row[de_id]" . '" />
							<font class="d-flex justify-content-center " size="6" face="TH SarabunPSK"><p style="color:black">ต้องการลบ ความต้องการนี้ ใช่หรือไม่</p></font>
						</div>
						<div class="modal-footer justify-content-center">
							<button type="submit" class="btn btn-danger" name="btndelect" > ลบ </button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
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
