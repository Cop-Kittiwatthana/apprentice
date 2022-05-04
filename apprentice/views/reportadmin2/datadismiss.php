<?php
//fetch.php
include("../../connect.php");
$column = array("s_id");

$query = "SELECT SUBSTR(student.s_id,1,2) As id,student.*,petition.*";
$query .= " FROM petition ";
$query .= " LEFT JOIN student ON petition.s_id  = student.s_id  ";
$query .= " WHERE petition.pe_status = '11' ";
if (isset($_POST["search"]["value"])) {
	$query .= " AND (student.s_id LIKE '" . $_POST['search']['value'] . "%' )";
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
	$nestedData[] = $row["pe_semester"];
	$nestedData[] = $row['detail'] = '<div align="center">' . "<a href=\"indexdismissstd.php?id=$row[id]&pe_semester=$row[pe_semester]\" >" .
		'<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> รายชื่อนักศึกษา </i></button>';

	$data[] = $nestedData;
}

function get_all_data($conn)
{
	$query = "SELECT SUBSTR(student.s_id,1,2) As id,student.*,petition.*";
	$query .= " FROM petition ";
	$query .= " LEFT JOIN student ON petition.s_id  = student.s_id  ";
	$query .= " WHERE petition.pe_status = '11' ";
	$query .= " GROUP BY id ";
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
