<?php
//fetch.php
include("../../connect.php");
$column = array("id", "s_group", "br_na");

$query = "SELECT advisor.*,student.*,branch.*,SUBSTR(student.s_id,1,2) As id,COUNT(student.s_id)as total";
$query .= " FROM student  ";
$query .= " LEFT JOIN advisor ON student.s_id  = advisor.s_id   ";
$query .= " LEFT JOIN teacher ON advisor.t_id  = teacher.t_id   ";
$query .= " LEFT JOIN branch ON student.br_id  = branch.br_id   ";
$query .= " WHERE ";
if (isset($_POST["br_id"])) {
	$query .= "student.br_id = '" . $_POST["br_id"] . "' AND ";
}
if (isset($_POST["is_year"])) {
	$query .= "student.s_id LIKE '" . $_POST["is_year"] . "%' AND ";
}
if (isset($_POST["search"]["value"])) {
	$query .= " ( student.s_id LIKE '" . $_POST['search']['value'] . "%' ";
	$query .= " OR student.s_group LIKE '" . $_POST['search']['value'] . "%' ";
	$query .= " OR branch.br_na LIKE '" . $_POST['search']['value'] . "%' )";
}
$query .= " GROUP BY student.s_group,id,student.br_id ";
if (isset($_POST["order"])) {
	$query .= ' ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
	$query .= ' ORDER BY id DESC,branch.br_id DESC ';
}
$query1 = '';

if ($_POST["length"] != 1) {
	$query1 .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($conn, $query));

$result = mysqli_query($conn, $query . $query1);

$data = array();

while ($row = mysqli_fetch_array($result)) {
	$nestedData = array();

	$nestedData[] = $row["id"];
	$nestedData[] = $row["s_group"];
	//$nestedData[] = $row["br_na"];
	if ($row["t_id"] == "0") {
		$nestedData[] = '<font color="red" style="text-align:center;"><div align="center">ยังไม่มีอาจารย์ที่ปรึกษา</div></font>';
	} else {
		$nestedData[] = $row['detail'] = '<div align="center">' . "<a href=\"indexpdf.php?id=$row[id]&br_id=$row[br_id]&s_group=$row[s_group]\">" . '<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> รายชื่อนักศึกษา </i></button>';
	}
	$nestedData[] = $row['edit/delect'] =
		'<div align="center">' . "<a href=\"edit.php?id=$row[id]&br_id=$row[br_id]&s_group=$row[s_group]\">" . '<button type="button" class="btn btn-success"><i class="fas fa-edit"> จัดการอาจารย์ที่ปรึกษา </i></button></a></div>';

	// $nestedData[] = $row['edit/delect'] =
	// 	'<div align="center">' . "<a href=\"edit.php?id=$row[id]&br_id=$row[br_id]&s_group=$row[s_group]\">" . '<button type="button" class="btn btn-success"><i class="fas fa-edit"> จัดการอาจารย์ที่ปรึกษา </i></button></a>&nbsp;' .
	// 	"<a >" . '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal' . "$row[num]" . '">
	// 	<i class="fas fa-trash"> ลบ </i></button></div>

	// 	<form method="POST" action="sql.php" class="float-center">
	// 		<div class="modal fade" id="exampleModal' . "$row[num]" . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	// 			<div class="modal-dialog" role="document">
	// 				<div class="modal-content">
	// 					<div class="modal-header">
	// 						<h5 class="modal-title text-dark" id="exampleModalLabel" >ลบข้อมูลนักศึกษา</h5>
	// 						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	// 							<span aria-hidden="true">&times;</span>
	// 						</button>
	// 					</div>
	// 					<div class="modal-body">
	// 						<input name="br_id" type="hidden"  value="' . "$row[br_id]" . '" />
	// 						<font class="d-flex justify-content-center " size="6" face="TH SarabunPSK"><p style="color:black">ต้องการลบ&nbsp;</p><p style="color:red">' . "$row[cs_na]" . '&nbsp;</p> <p style="color:black">ใช่หรือไม่</p></font>
	// 					</div>
	// 					<div class="modal-footer justify-content-center">
	// 						<button type="submit" class="btn btn-danger" name="btndelect" > ลบ </button>
	// 						<button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
	// 					</div>
	// 				</div>
	// 			</div>
	// 		</div>
	// 	</form>
	// 	';
	$data[] = $nestedData;
}

function get_all_data($conn)
{
	$query = "SELECT student.*,branch.*,SUBSTR(student.s_id,1,2) As id,COUNT(student.s_id)as total";
	$query .= " FROM student  ";
	$query .= " LEFT JOIN advisor ON student.s_id  = advisor.s_id   ";
	$query .= " LEFT JOIN teacher ON advisor.t_id  = teacher.t_id   ";
	$query .= " LEFT JOIN branch ON student.br_id  = branch.br_id   ";
	$query .= " WHERE 1 ";
	if (isset($_POST["br_id"])) {
		$query .= " and student.br_id = '" . $_POST["br_id"] . "' ";
	}
	$query .= " GROUP BY student.s_group,id,student.br_id ";
	//$query = "SELECT * FROM student";
	$result = mysqli_query($conn, $query);
	return mysqli_num_rows($result);
}

$output = array(
	"draw"    => intval($_POST["draw"]),
	"recordsTotal"  =>  get_all_data($conn),
	"recordsFiltered" => $number_filter_row,
	"data"    => $data
);

echo json_encode($output);
