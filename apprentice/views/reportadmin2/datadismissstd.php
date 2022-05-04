<?php
//fetch.php
include("../../connect.php");
$column = array("branch.br_na", "student.s_id", "student.s_tna", "student.s_fna", "student.s_lna");

$query = "SELECT student.*,branch.*";
$query .= " FROM petition ";
$query .= " LEFT JOIN student ON petition.s_id  = student.s_id  ";
$query .= " LEFT JOIN branch ON student.br_id  = branch.br_id  ";
$query .= " WHERE petition.pe_status = '11' ";
if (isset($_POST["s_id"])) {
	$query .= " AND student.s_id LIKE '" . $_POST["s_id"] . "%' ";
}
if (isset($_POST["pe_semester"])) {
	$query .= " AND petition.pe_semester LIKE '" . $_POST["pe_semester"] . "%' ";
}
if (isset($_POST["is_branch"])) {
	$query .= " AND branch.br_id = '" . $_POST["is_branch"] . "' ";
}
if (isset($_POST["search"]["value"])) {
	$query .= " AND (student.s_id LIKE '" . $_POST['search']['value'] . "%' ";
	$query .= " OR student.s_tna LIKE '" . $_POST['search']['value'] . "%' ";
	$query .= " OR student.s_fna LIKE '" . $_POST['search']['value'] . "%' ";
	$query .= " OR student.s_lna LIKE '" . $_POST['search']['value'] . "%' ";
	$query .= " OR CONCAT(student.s_fna,'',student.s_lna) LIKE '" . $_POST['search']['value'] . "%' ";
	$query .= " OR CONCAT(student.s_fna,' ',student.s_lna) LIKE '" . $_POST['search']['value'] . "%' ";
	$query .= " OR branch.br_na LIKE '" . $_POST['search']['value'] . "%' )";
}

$query .= " GROUP BY student.s_id";
if (isset($_POST["order"])) {
	$query .= ' ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
	$query .= ' ORDER BY student.s_id DESC ';
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
	$nestedData[] = $row["s_id"];
	if ($row['s_tna'] != null) {
		if ($row['s_tna'] == '0') {
			$s_tna = "นาย";
		}
		if ($row['s_tna'] == '1') {
			$s_tna = "นาง";
		}
		if ($row['s_tna'] == '2') {
			$s_tna = "นางสาว";
		}
	}
	if ($row['s_fna'] != null && $row['s_lna'] != null) {
		$nestedData[] = $s_tna . $row["s_fna"] . '&nbsp;' . $row["s_lna"];
	}
	$nestedData[] = $row["br_na"];
	$nestedData[] = $row['detail'] = '<div align="center">' .
		"<a href=\"detail.php?id=$_POST[s_id]&s_id=$row[s_id]&pe_semester=$_POST[pe_semester]\" >" .
		'<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> รายงาน </i></button>';
	$data[] = $nestedData;
}

function get_all_data($conn)
{
	$query = "SELECT student.*,branch.*";
	$query .= " FROM petition ";
	$query .= " LEFT JOIN student ON petition.s_id  = student.s_id  ";
	$query .= " LEFT JOIN branch ON student.br_id  = branch.br_id  ";
	$query .= " WHERE petition.pe_status = '11' ";
	if (isset($_POST["s_id"])) {
		$query .= " AND student.s_id LIKE '" . $_POST["s_id"] . "%' ";
	}
	if (isset($_POST["pe_semester"])) {
		$query .= " AND petition.pe_semester LIKE '" . $_POST["pe_semester"] . "%' ";
	}
	$query .= " GROUP BY student.s_id ";
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
