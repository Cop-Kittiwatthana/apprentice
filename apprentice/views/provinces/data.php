<?php
//fetch.php
include("../../connect.php");
$column = array("provinces.province_id ", "provinces.provinces_name_th", "provinces.geo_id");

$query = "SELECT provinces.*";
$query .= " FROM provinces ";
$query .= " WHERE ";
if ($_POST["is_geo"] != "") {
	$query .= "provinces.geo_id = '" . $_POST["is_geo"] . "' AND ";
}
if (isset($_POST["search"]["value"])) {
	$query .= '(provinces.province_id LIKE "%' . $_POST["search"]["value"] . '%" ';
	$query .= 'OR provinces.provinces_name_th LIKE "%' . $_POST["search"]["value"] . '%") ';
}

if (isset($_POST["order"])) {
	$query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
	$query .= 'ORDER BY provinces.province_id ASC ';
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
	$nestedData[] = $row["province_id"];
	$nestedData[] = $row["provinces_name_th"];
	if ($row['geo_id'] == "1") {
		$nestedData[] = "ภาคเหนือ";
	}
	if ($row['geo_id'] == "2") {
		$nestedData[] = "ภาคกลาง";
	}
	if ($row['geo_id'] == "3") {
		$nestedData[] = "ภาคตะวันออกเฉียงเหนือ";
	}
	if ($row['geo_id'] == "4") {
		$nestedData[] = "ภาคตะวันตก";
	}
	if ($row['geo_id'] == "5") {
		$nestedData[] = "ภาคตะวันออก";
	}
	if ($row['geo_id'] == "6") {
		$nestedData[] = "ภาคใต้";
	}

	$nestedData[] = $row['edit/delect'] =
		'<div align="center">' . "<a href=\"edit.php?province_id=$row[province_id]\">" . '<button type="button" class="btn btn-success"><i class="fas fa-edit"> แก้ไข </i></button></a>&nbsp;' .
		"<a >" . '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal' . "$row[province_id]" . '">
	<i class="fas fa-trash"> ลบ </i></button></div>
	
	<form method="POST" action="sql.php" class="float-center">
		<div class="modal fade" id="exampleModal' . "$row[province_id]" . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-dark" id="exampleModalLabel" >ลบข้อมูลจังหวัด</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<input name="province_id" type="hidden"  value="' . "$row[province_id]" . '" />
						<font class="d-flex justify-content-center " size="6" face="TH SarabunPSK"><p style="color:black">ต้องการลบ&nbsp;</p><p style="color:red">' . "$row[provinces_name_th]" . '&nbsp;</p> <p style="color:black">ใช่หรือไม่</p></font>
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
	$query = "SELECT provinces.* FROM provinces ";
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
