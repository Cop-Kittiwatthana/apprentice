<?php
include("../../connect.php");

// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;
$c_id = $_POST['c_id'];

$columns = array(
	// datatable column index  => database column name
	0 => 'cs_id',
	1 => 'cs_tna',
	2 => 'cs_na',
	3 => 'cs_department',
	4 => 'cs_position',
	5 => 'cs_tel',
	6 => 'cs_mail',
	7 => 'cs_fax',
	8 => 'cs_date',
	9 => 'c_id',
	// 10 => 't_fna',

);


// getting total number records without any search
$sql = "SELECT contact_staff.*,company.*";
$sql .= " FROM contact_staff ";
$sql .= " LEFT JOIN company ON company.c_id  = contact_staff.c_id  ";
$sql .= " where 1=1 and contact_staff.c_id = $c_id ";
$query = mysqli_query($conn, $sql) or die("data.php: get contact_staff");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT contact_staff.*,company.*";
$sql .= " FROM contact_staff ";
$sql .= " LEFT JOIN company ON company.c_id  = contact_staff.c_id  ";
//$sql .= " where 1=1";
$sql .= " where 1=1 and contact_staff.c_id = $c_id ";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND ( contact_staff.cs_id LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR contact_staff.cs_tna LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR contact_staff.cs_na LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR contact_staff.cs_department LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR contact_staff.cs_position LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR contact_staff.cs_tel LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR contact_staff.cs_mail LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR contact_staff.cs_fax LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR contact_staff.cs_date LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_na LIKE '" . $requestData['search']['value'] . "%' )";
}
$query = mysqli_query($conn, $sql) or die("data.php: get contact_staff");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die("data.php: get contact_staff");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
	$nestedData = array();

	$nestedData[] = $row["cs_id"];
	if ($row['cs_tna'] != null) {
		if ($row['cs_tna'] == '0') {
			$nestedData[] = "นาย";
		}
		if ($row['cs_tna'] == '1') {
			$nestedData[] = "นาง";
		}
		if ($row['cs_tna'] == '2') {
			$nestedData[] = "นางสาว";
		}
	}else{
		$nestedData[] = "";
	}
	$nestedData[] = $row["cs_na"];
	$nestedData[] = $row["cs_tel"];
	$nestedData[] = $row['detail']= '<div align="center">' . "<a href=\"detail.php?c_id=$c_id&cs_id=$row[cs_id]\">" . '<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> รายละเอียด </i></button>';
	$nestedData[] = $row['edit/delect'] = 
		'<div align="center">' . "<a href=\"edit.php?c_id=$c_id&cs_id=$row[cs_id]\">" . '<button type="button" class="btn btn-success"><i class="fas fa-edit"> แก้ไข </i></button>&nbsp;' .
		"<a >" . '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal' . "$row[cs_id]" . '">
		<i class="fas fa-trash"> ลบ </i></button></div>
		
		<form method="POST" action="sql.php" class="float-center">
			<div class="modal fade" id="exampleModal' . "$row[cs_id]" . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="exampleModalLabel" >ลบข้อมูลผู้ติดต่อ</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<input name="cs_id" type="hidden"  value="' . "$row[cs_id]" . '" />
							<input name="c_id" type="hidden"  value="' . "$row[c_id]" . '" />
							<font class="d-flex justify-content-center " size="6" face="TH SarabunPSK"><p style="color:black">ต้องการลบ&nbsp;</p><p style="color:red">'. "$row[cs_na]". '&nbsp;</p> <p style="color:black">ใช่หรือไม่</p></font>
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
