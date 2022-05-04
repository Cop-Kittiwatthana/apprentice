<?php
//fetch.php
include("../../connect.php");
$column = array("company.c_id", "company.c_na", "petition.pe_semester");

$query = "SELECT company.*,petition.pe_semester,COUNT(student.s_id)as total";
$query .= " FROM petition ";
$query .= " LEFT JOIN demand ON petition.de_id  = demand.de_id  ";
$query .= " LEFT JOIN company ON demand.c_id  = company.c_id  ";
$query .= " LEFT JOIN student ON petition.s_id  = student.s_id  ";
$query .= " LEFT JOIN branch ON student.br_id  = branch.br_id  ";
$query .= " WHERE ";
if (isset($_POST["is_year"])) {
	$query .= " petition.pe_semester = '" . $_POST["is_year"] . "' AND ";
	$date = $_POST["is_year"];
}else{
	$date = date("Y", strtotime($Result["order_sent"] . "+543 year"));
	$query .= " petition.pe_semester = '" . $date . "' AND ";
	
}
if (isset($_POST["search"]["value"])) {
	$query .= '(company.c_id LIKE "' . $_POST["search"]["value"] . '%" ';
	$query .= 'OR company.c_na LIKE "' . $_POST["search"]["value"] . '%" ';
	$query .= 'OR petition.pe_semester LIKE "' . $_POST["search"]["value"] . '%") ';
}
if (isset($_POST["order"])) {
	$query .= 'GROUP BY company.c_id ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
	$query .= 'GROUP BY company.c_id ORDER BY company.c_id ASC ';
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
	$nestedData[] = $row["c_id"];
	$nestedData[] = $row["c_na"];
	if ($row["pe_semester"] != "") {
		$nestedData[] = $row["pe_semester"];
	} else {
		$nestedData[] = '<font color="red" style="text-align:center;">ยังไม่มีข้อมูล</div></font>';
	}
	$nestedData[] = $row['detail'] = '<div align="center">' . "<a target='_blank' href=\"studentpdf.php?c_id=$row[c_id]&pe_semester=$date&su_term=1\">" . '<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> เทอม1 </i></button></a>
	' . "<a target='_blank' href=\"studentpdf.php?c_id=$row[c_id]&pe_semester=$date&su_term=2\">" . '<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> เทอม2 </i></button>';
	$data[] = $nestedData;
}

function get_all_data($conn)
{
	$query = "SELECT company.c_na,petition.pe_semester,COUNT(student.s_id)as total
	FROM petition 
	LEFT JOIN demand ON petition.de_id  = demand.de_id  
	LEFT JOIN company ON demand.c_id  = company.c_id  
	LEFT JOIN student ON petition.s_id  = student.s_id  
	LEFT JOIN branch ON student.br_id  = branch.br_id
	GROUP by company.c_id";
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
