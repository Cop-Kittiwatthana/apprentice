<?php
//fetch.php
include("../../connect.php");
$column = array("branch.br_na", "student.s_id", "student.s_group");

$query = "SELECT student.*,branch.*,SUBSTR(student.s_id,1,2) As id,COUNT(student.s_id)as total";
$query .= " FROM advisor ";
$query .= " LEFT JOIN student ON advisor.s_id  = student.s_id  ";
$query .= " LEFT JOIN teacher ON advisor.t_id  = teacher.t_id  ";
$query .= " LEFT JOIN branch ON student.br_id  = branch.br_id  ";
$query .= " WHERE 1 AND advisor.t_id != '0' ";
if (isset($_POST["is_branch"])) {
	$query .= " AND branch.br_id = '" . $_POST["is_branch"] . "' ";
}
if (isset($_POST["search"]["value"])) {
	$query .= ' AND (branch.br_na LIKE "%' . $_POST["search"]["value"] . '%" ';
	$query .= 'OR student.s_id LIKE "' . $_POST["search"]["value"] . '%" ';
	$query .= 'OR student.s_group LIKE "%' . $_POST["search"]["value"] . '%") ';
}

$query .= " GROUP BY student.s_group,id,student.br_id";
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
$nr = 0;
while ($row = mysqli_fetch_array($result)) {
	$nr++;
	$nestedData = array();
	$nestedData[] = $row["br_na"];
	$nestedData[] = $row["id"];
	$nestedData[] = $row["s_group"];
	if ($row["t_id"] == "0") {
		$nestedData[] = '<font color="red" style="text-align:center;"><div align="center">ยังไม่มีอาจารย์ที่ปรึกษา</div></font>';
	} else {
		$nestedData[] = $row['detail'] = '<div align="center">' . "<a href=\"indexpdfstudent.php?id=$row[id]&br_id=$row[br_id]&s_group=$row[s_group]\" >" . '<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> รายชื่อนักศึกษา </i></button>';
	}

	$data[] = $nestedData;
}

function get_all_data($conn)
{
	$query = " SELECT student.*,branch.*,SUBSTR(student.s_id,1,2) As id,COUNT(student.s_id)as total";
	$query .= " FROM advisor ";
	$query .= " LEFT JOIN student ON advisor.s_id  = student.s_id  ";
	$query .= " LEFT JOIN teacher ON advisor.t_id  = teacher.t_id  ";
	$query .= " LEFT JOIN branch ON student.br_id  = branch.br_id  ";
	$query .= " WHERE 1 ";
	$query .= " GROUP BY student.s_group,id,student.br_id ";
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
