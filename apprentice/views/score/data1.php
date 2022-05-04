<?php
//fetch.php
include("../../connect.php");
$column = array("student.s_id ", "student.s_fna", "student.s_lna", "branch.br_na", "advisor.n_group", "advisor.n_year");

$query = "SELECT advisor.*,branch.*,student.*,COUNT(student.s_id) as total";
$query .= " FROM advisor  ";
$query .= " LEFT JOIN student ON advisor.s_id  = student.s_id  ";
$query .= " LEFT JOIN branch ON student.br_id  = branch.br_id";
$query .= " WHERE ";
if (isset($_POST["is_branch"]) ) {
	$query .= "student.br_id = '" . $_POST["is_branch"] . "' AND ";
}
if (isset($_POST["search"]["value"])) {
	$query .= '(student.s_id LIKE "%' . $_POST["search"]["value"] . '%" ';
	$query .= 'OR advisor.n_group LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR advisor.n_year LIKE "%' . $_POST["search"]["value"] . '%" ';
	$query .= 'OR branch.br_na LIKE "%' . $_POST["search"]["value"] . '%") ';
}
if (isset($_POST["order"])) {
    $query .= 'GROUP BY advisor.n_group ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'GROUP BY advisor.n_group ORDER BY advisor.n_year DESC ';
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
    $nestedData[] = $nr;
    $nestedData[] = $row["n_year"];
    $nestedData[] = $row["n_group"];
	$nestedData[] = $row["br_na"];
	$nestedData[] = $row['detail1'] = '<div align="center">' . "<a href=\"indexstd.php?id=1&n_year=$row[n_year]&n_group=$row[n_group]&br_id=$row[br_id]\" >" . '<button type="button" class="btn btn-info"> เทอม1 </i></button>
    ' . "<a href=\"pdf.php?id=1&n_year=$row[n_year]&n_group=$row[n_group]&br_id=$row[br_id]\" target='blank'>" . '<button type="button" class="btn btn-info"> ผลประเมิน </i></button>
    </div>
    ';
    $nestedData[] = $row['detail2'] = '<div align="center">' . "<a href=\"indexstd.php?id=2&n_year=$row[n_year]&n_group=$row[n_group]&br_id=$row[br_id]\">" . '<button type="button" class="btn btn-info"> เทอม2 </i></button>
    ' . "<a href=\"pdf.php?id=2&n_year=$row[n_year]&n_group=$row[n_group]&br_id=$row[br_id]\" target='blank'>" . '<button type="button" class="btn btn-info"> ผลประเมิน </i></button>
    </div>
    ';
    $data[] = $nestedData;
}

function get_all_data($conn)
{
    $query = "SELECT * FROM advisor";
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
