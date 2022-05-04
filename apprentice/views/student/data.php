<?php
include("../../connect.php");
include("status.php");//sql การอัพเดท
// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;
$year = $_POST["year"];
$br_id = $_POST["br_id"];
$columns = array(
	// datatable column index  => database column name
	0 => 's_id',
	1 => 's_tna',
	2 => 's_fna',
	3 => 's_lna',
	4 => 'dp_na',
	5 => 'br_na',


);


// getting total number records without any search
$sql = "SELECT student.*,department.*,branch.*";
$sql .= " FROM student ";
$sql .= " LEFT JOIN branch ON student.br_id  = branch.br_id  ";
$sql .= " LEFT JOIN department ON branch.dp_id = department.dp_id ";
$sql .= " where student.s_id LIKE '" . $_POST["year"] . "%' and student.br_id = '" . $_POST["br_id"] . "' ";
$query = mysqli_query($conn, $sql) or die("data.php: get student");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT student.*,department.*,branch.*";
$sql .= " FROM student ";
$sql .= " LEFT JOIN branch ON student.br_id  = branch.br_id  ";
$sql .= " LEFT JOIN department ON branch.dp_id = department.dp_id ";
$sql .= " where 1=1 ";
if (isset($_POST["br_id"])) {
	$sql .= " AND  student.br_id = '" . $_POST["br_id"] . "'  ";
}
if (isset($_POST["year"])) {
	$sql .= " AND  student.s_id LIKE '" . $_POST["year"] . "%'  ";
}
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND ( student.s_id LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR student.s_tna LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR student.s_fna LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR student.s_lna LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= "OR CONCAT(student.s_fna,'',student.s_lna) LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= "OR CONCAT(student.s_fna,' ',student.s_lna) LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR department.dp_na LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR branch.br_na LIKE '" . $requestData['search']['value'] . "%' )";
}
$query = mysqli_query($conn, $sql) or die("data.php: get student");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
if (isset($_POST["order"])) {
	$sql .= "ORDER BY " . $columns[$_POST['order'][0]['column']] . "   " . $_POST['order'][0]['dir'] . "  LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "   ";
} else {
	$sql .= " ORDER BY student.s_id DESC" . "  LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "   ";
}
//$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
$query = mysqli_query($conn, $sql) or die("data.php: get student");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
	$nestedData = array();


	$nestedData[] =  $row['s_id'];
	if ($row['s_tna'] != null) {
		if ($row['s_tna'] == '0') {
			$nestedData[] = "นาย";
		}
		if ($row['s_tna'] == '1') {
			$nestedData[] = "นาง";
		}
		if ($row['s_tna'] == '2') {
			$nestedData[] = "นางสาว";
		}
	} else {
		$nestedData[] = "ยังไม่มีข้อมูล";
	}
	if ($row['s_fna'] != null && $row['s_lna'] != null) {
		$nestedData[] = $row["s_fna"] . '&nbsp;' . $row["s_lna"];
	} else {
		$nestedData[] = "ยังไม่มีข้อมูล";
	}
	// if ($row['s_status'] == null || $row['s_status'] == '1') {
	// 	$nestedData[] = "ปิด";
	// }
	// if ($row['s_status'] == '2') {
	// 	$nestedData[] = "เปิด";
	// }
	// if ($row['s_status'] == '2') {
	// 	$nestedData[] = '<form name="MyForm" method="post" action="data.php" >
	// 	<input type="hidden" name="id" value="' . "$br_id" . '">
	// 	<input type="hidden" name="year" value="' . "$year" . '">
	// 	<input type="hidden" name="s_status" value="1">
	// 	<input type="hidden" name="s_id" value="' . "$row[s_id]" . '">
	// 	<font color="green">เปิดลงทะเบียน</font><button class="btn btn-danger"  name="btnstatus" type="submit" ><i class="fas fa-power-off">&nbsp;ปิด</i></button>
	// </form>';
	// };
	// if ($row['s_status'] == '1' || $row['s_status'] == null) {
	// 	$nestedData[] = '<form name="MyForm" method="post" action="data.php" >
	// 	<input type="hidden" name="id" value="' . "$br_id" . '">
	// 	<input type="hidden" name="year" value="' . "$year" . '">
	// 	<input type="hidden" name="s_status" value="2">
	// 	<input type="hidden" name="s_id" value="' . "$row[s_id]" . '">
	// 	<font color="red">ปิดลงทะเบียน</font><button class="btn btn-success"  name="btnstatus" type="submit" ><i class="fas fa-power-off">&nbsp;เปิด</i></button>
	// </form>';
	// };
	$nestedData[] = $row['edit/delect'] =
		'<div align="center">' . "<a href=\"edit.php?s_id=$row[s_id]&br_id=$_POST[br_id]&year=$_POST[year]\">" . '<button type="button" class="btn btn-success"><i class="fas fa-edit"> แก้ไข </i></button></a>&nbsp;' .
		"<a >" . '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal' . "$row[s_id]" . '">
		<i class="fas fa-trash"> ลบ </i></button></div>
		
		<form method="POST" action="sql.php" class="float-center">
			<div class="modal fade" id="exampleModal' . "$row[s_id]" . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="exampleModalLabel" >ลบข้อมูลนักศึกษา</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<input name="br_id" type="hidden"  value="' . "$_POST[br_id]" . '" />
							<input name="year" type="hidden"  value="' . "$_POST[year]" . '" />
							<input name="s_id" type="hidden"  value="' . "$row[s_id]" . '" />
							<font class="d-flex justify-content-center " size="6" face="TH SarabunPSK"><p style="color:black">ต้องการลบ&nbsp;</p><p style="color:red">' . "$row[s_fna]" . '&nbsp;' . "$row[s_lna]" . '&nbsp;</p> <p style="color:black">ใช่หรือไม่</p></font>
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
