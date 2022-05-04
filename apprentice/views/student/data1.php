
<?php
//fetch.php
include("../../connect.php");
$column = array("student.s_id ", "student.s_tna","student.s_fna", "student.s_lna", "department.dp_na", "branch.br_na");

$query = "SELECT student.*,department.*,branch.*";
$query .= " FROM student ";
$query .= " LEFT JOIN branch ON student.br_id  = branch.br_id  ";
$query .= " LEFT JOIN department ON branch.dp_id = department.dp_id ";
$query .= " where ";

if (isset($_POST["search"]["value"])) {
    $query .= " ( student.s_id LIKE '" . $requestData['search']['value'] . "%' ";
	$query .= " OR student.s_tna LIKE '" . $requestData['search']['value'] . "%' ";
	$query .= " OR student.s_fna LIKE '" . $requestData['search']['value'] . "%' ";
	$query .= " OR student.s_lna LIKE '" . $requestData['search']['value'] . "%' ";
	$query .= " OR department.dp_na LIKE '" . $requestData['search']['value'] . "%' ";
	$query .= " OR branch.br_na LIKE '" . $requestData['search']['value'] . "%' )";
}

if (isset($_POST["order"])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= "ORDER BY student.s_id DESC ";
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
	}else{
		$nestedData[] = "ยังไม่มีข้อมูล";
	}
	if ($row['s_fna'] != null && $row['s_lna'] != null) {
		$nestedData[] = $row["s_fna"] . '&nbsp;' . $row["s_lna"];
	}else{
		$nestedData[] = "ยังไม่มีข้อมูล";
	}
	if ($row['br_id'] != null ) {
		$nestedData[] = $row["dp_na"];
	}else{
		$nestedData[] = "ยังไม่มีข้อมูล";
	}
	if ($row['br_id'] != null ) {
		$nestedData[] = $row["br_na"];
	}else{
		$nestedData[] = "ยังไม่มีข้อมูล";
	}
	$nestedData[] = $row['edit/delect'] =
		'<div align="center">' . "<a href=\"edit.php?s_id=$row[s_id]\">" . '<button type="button" class="btn btn-success"><i class="fas fa-edit"> แก้ไข </i></button>&nbsp;' .
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
							<input name="s_id" type="hidden"  value="' . "$row[s_id]" . '" />
							<font class="d-flex justify-content-center " size="6" face="TH SarabunPSK"><p style="color:black">ต้องการลบ&nbsp;</p><p style="color:red">'. "$row[s_fna]" . '&nbsp;' . "$row[s_lna]" . '&nbsp;</p> <p style="color:black">ใช่หรือไม่</p></font>
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

function get_all_data($conn)
{
    $query = "SELECT * FROM student";
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
