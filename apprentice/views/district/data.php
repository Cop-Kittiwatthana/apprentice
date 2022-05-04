<?php
 include("../../connect.php");


// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;


$columns = array(
	// datatable column index  => database column name
	0 => 'district_id',
	1 => 'district_name_th',
	2 => 'amphures_name_th',
	3 => 'provinces_name_th',
	4 => 'zip_code'
);


// getting total number records without any search
$sql = "SELECT districts.*, amphures.*,provinces.*";
$sql .= " FROM districts ";
$sql .= " INNER JOIN amphures ON districts.amphure_id=amphures.amphure_id ";
$sql .= " INNER JOIN provinces ON amphures.province_id=provinces.province_id ";
$query = mysqli_query($conn, $sql) or die("districts-data.php: get districts");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT districts.*, amphures.*,provinces.*";
$sql .= " FROM districts ";
$sql .= " INNER JOIN amphures ON districts.amphure_id=amphures.amphure_id ";
$sql .= " INNER JOIN provinces ON amphures.province_id=provinces.province_id ";
$sql .= " where 1=1 ";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND ( districts.district_id LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR districts.district_name_th LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR amphures.amphures_name_th LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR provinces.provinces_name_th LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR districts.zip_code LIKE '" . $requestData['search']['value'] . "%' )";
}
$query = mysqli_query($conn, $sql) or die("districts-data.php: get districts");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die("districts-data.php: get districts");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
	$nestedData = array();

	$nestedData[] = $row["district_id"];
	$nestedData[] = $row["district_name_th"];
	$nestedData[] = $row["amphures_name_th"];
	$nestedData[] = $row["provinces_name_th"];
	$nestedData[] = $row['zip_code']= "<td align='center' bgcolor='#F8F8FF'>$row[zip_code]</td>";
	//$nestedData[] = $row['edit'] = "<a href=\"edit.php?district_id=$row[district_id]\">" . '<div align="center"><button type="button" class="btn btn-success"><i class="fas fa-edit"> แก้ไข </i></button></div>';
	//$nestedData[] = $row['parish_id']='<a ><button type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>';
	$nestedData[] = $row['edit/delect'] =
		'<div align="center">' . "<a href=\"edit.php?district_id=$row[district_id]\">" . '<button type="button" class="btn btn-success"><i class="fas fa-edit"> แก้ไข </i></button></a>&nbsp;' .
		"<a >" . '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal' . "$row[district_id]" . '">
		<i class="fas fa-trash"> ลบ </i></button></div>
		
		<form method="POST" action="sql.php" class="float-center">
			<div class="modal fade" id="exampleModal' . "$row[district_id]" . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="exampleModalLabel" >ลบข้อมูลตำบล</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
						<input name="district_id" type="hidden"  value="' . "$row[district_id]" . '" />
							<font class="d-flex justify-content-center " size="6" face="TH SarabunPSK"><p style="color:black">ต้องการลบ&nbsp;</p><p style="color:red">' . "$row[district_name_th]" . '&nbsp;</p> <p style="color:black">ใช่หรือไม่</p></font>
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
