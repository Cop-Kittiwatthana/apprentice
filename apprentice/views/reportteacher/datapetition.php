<?php
//fetch.php
include("../../connect.php");
$column = array("id", "s_group", "br_na");

$query = "SELECT student.*,branch.*,SUBSTR(student.s_id,1,2) As id,COUNT(student.s_id)as total";
$query .= " FROM student  ";
$query .= " LEFT JOIN advisor ON student.s_id  = advisor.s_id  ";
$query .= " LEFT JOIN teacher ON advisor.t_id  = teacher.t_id  ";
$query .= " LEFT JOIN branch ON student.br_id  = branch.br_id  ";
$query .= " WHERE ";
if (isset($_POST["t_id"])) {
	$query .= "advisor.t_id = '" . $_POST["t_id"] . "' AND ";
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
	$nestedData[] = $row["br_na"];
	$nestedData[] = $row["s_group"];
	$nestedData[] = $row["total"];
	$nestedData[] = $row['detail'] = '<div align="center">' . "<a href=\"detailstudent.php?id=$row[id]&br_id=$row[br_id]&s_group=$row[s_group]\">" . '<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> รายชื่อนักศึกษา </i></button>';
	$data[] = $nestedData;
}

function get_all_data($conn)
{
	$query = " SELECT student.*,branch.*,SUBSTR(student.s_id,1,2) As id,COUNT(student.s_id)as total";
	$query .= " FROM student  ";
	$query .= " LEFT JOIN advisor ON student.s_id  = advisor.s_id  ";
	$query .= " LEFT JOIN teacher ON advisor.t_id  = teacher.t_id  ";
	$query .= " LEFT JOIN branch ON student.br_id  = branch.br_id  ";
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
