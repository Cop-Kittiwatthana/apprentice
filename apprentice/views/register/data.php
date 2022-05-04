<?php
//fetch.php
include("../../connect.php");
$column = array("s_id", "s_sdate", "s_edate");

$query = "SELECT SUBSTR(student.s_id,1,2) As id,student.*";
$query .= " FROM student ";
$query .= " WHERE ";
if (isset($_POST["search"]["value"])) {
	$query .= " ( s_id LIKE '" . $_POST['search']['value'] . "%' ";
	//$query .= " OR id = '" . $_POST['search']['value'] . "' ";
	$query .= " OR s_sdate LIKE '" . $_POST['search']['value'] . "%' ";
	$query .= " OR s_edate LIKE '" . $_POST['search']['value'] . "%' )";
}
$query .= " GROUP BY id ";
if (isset($_POST["order"])) {
	$query .= ' ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
	$query .= ' ORDER BY id DESC ';
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
	if ($row['s_sdate'] != null) {
		$nestedData[] = $row["s_sdate"];
	}else{
		$nestedData[] = "<font color='red'>กรุณากำหนดวัน</font>";
	}
	if ($row['s_edate'] != null) {
		$nestedData[] = $row["s_edate"];
	}else{
		$nestedData[] = "<font color='red'>กรุณากำหนดวัน</font>";
	}
	// $nestedData[] = $row["s_sdate"];
	// $nestedData[] = $row["s_edate"];
	$nestedData[] = $row['edit/delect'] =
		'<div align="center">' . "<a href=\"edit.php?id=$row[id]\">" . 
		'<button type="button" class="btn btn-success"><i class="fas fa-edit"> จัดการระยะเวลาการยื่นเรื่องฝึกงาน </i></button>';

	$data[] = $nestedData;
}

function get_all_data($conn)
{
	$query = "SELECT SUBSTR(student.s_id,1,2) As id,student.*";
	$query .= " FROM student ";
	$query .= " WHERE 1 ";
	
	$query .= " GROUP BY id ";
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
