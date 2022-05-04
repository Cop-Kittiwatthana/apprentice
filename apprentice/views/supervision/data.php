<?php
include("../../connect.php");

// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;
$t_id = '9';
$nr = 0;
$columns = array(
	// datatable column index  => database column name
	0 => 's_id',
	1 => 's_fna',
	2 => 's_lna',
	3 => 'c_na',
	4 => 'pe_semester',
);

$query2 = "SELECT supervision.su_term,supervision.su_no,supervision.t_id
    FROM petition 
    INNER JOIN supervision ON petition.pe_id  = supervision.pe_id
    WHERE petition.s_id = '$s_id' ORDER BY supervision.su_no";
$result2 = mysqli_query($conn, $query2) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
while ($row2 = mysqli_fetch_array($result2)) {
	$num[] = $row2;
}



// getting total number records without any search
$sql = "SELECT student.s_id,student.s_fna,student.s_lna,company.c_na,petition.pe_semester ";
$sql .= " FROM supervision  ";
$sql .= " LEFT JOIN petition ON supervision.pe_id  = petition.pe_id ";
$sql .= " LEFT JOIN sup_instructor ON petition.s_id  = sup_instructor.s_id ";
$sql .= " LEFT JOIN student ON petition.s_id  = student.s_id ";
$sql .= " LEFT JOIN demand ON petition.de_id  = demand.de_id ";
$sql .= " LEFT JOIN branch ON demand.br_id  = branch.br_id  ";
$sql .= " LEFT JOIN company ON demand.c_id  = company.c_id  ";
$sql .= " LEFT JOIN teacher ON supervision.t_id  = teacher.t_id  ";
$sql .= " GROUP BY student.s_id";
$query = mysqli_query($conn, $sql) or die("data.php: get supervision");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT student.s_id,student.s_fna,student.s_lna,company.c_na,petition.pe_semester ";
$sql .= " FROM supervision  ";
$sql .= " LEFT JOIN petition ON supervision.pe_id  = petition.pe_id ";
$sql .= " LEFT JOIN sup_instructor ON petition.s_id  = sup_instructor.s_id ";
$sql .= " LEFT JOIN student ON petition.s_id  = student.s_id ";
$sql .= " LEFT JOIN demand ON petition.de_id  = demand.de_id ";
$sql .= " LEFT JOIN branch ON demand.br_id  = branch.br_id  ";
$sql .= " LEFT JOIN company ON demand.c_id  = company.c_id  ";
$sql .= " LEFT JOIN teacher ON supervision.t_id  = teacher.t_id  ";
$sql .= " where 1=1 and sup_instructor.t_id = '$t_id' ";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND ( student.s_id LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR CONCAT(student.s_fna,'',student.s_lna) LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR CONCAT(student.s_fna,' ',student.s_lna) LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_na LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR petition.pe_semester LIKE '" . $requestData['search']['value'] . "%' )";
	$sql .= " OR petition.pe_semester LIKE '" . $requestData['search']['value'] . "%' )";
}
$sql .= " GROUP BY student.s_id";
$query = mysqli_query($conn, $sql) or die("data.php: get supervision");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die("data.php: get supervision");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
	$nr++;
	$nestedData = array();
	$query2 = "SELECT supervision.su_term,supervision.su_no,supervision.t_id
    FROM petition 
    INNER JOIN supervision ON petition.pe_id  = supervision.pe_id
    WHERE petition.s_id = $row[s_id] ORDER BY supervision.su_no";
	$result2 = mysqli_query($conn, $query2) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
	$num = array();
	while ($row2 = mysqli_fetch_array($result2)) {
		$num[] = $row2;
	}
	$su_term1 = $num[0]['su_term'];
	$su_term2 = $num[3]['su_term'];
	$su_no1 = $num[0]['su_no'];
	$su_no2 = $num[1]['su_no'];
	$su_no3 = $num[2]['su_no'];
	$su_no4 = $num[3]['su_no'];
	$su_no5 = $num[4]['su_no'];
	$su_no6 = $num[5]['su_no'];
	$t_id1 = $num[0]['t_id'];
	$t_id2 = $num[1]['t_id'];
	$t_id3 = $num[2]['t_id'];
	$t_id4 = $num[3]['t_id'];
	$t_id5 = $num[4]['t_id'];
	$t_id6 = $num[5]['t_id'];
	//เทอม1
	if (($su_no1 == 1 && $t_id1 == "") && ($su_no2 == 2 && $t_id2 == "") && ($su_no3 == 3 && $t_id3 == "")) {
		$su_term = $su_term1;
		$su_no = $su_no1;
	}
	if (($su_no1 == 1 && $t_id1 != "") && ($su_no2 == 2 && $t_id2 == "") && ($su_no3 == 3 && $t_id3 == "")) {
		$su_term = $su_term1;
		$su_no = $su_no2;
	}
	if (($su_no1 == 1 && $t_id1 != "") && ($su_no2 == 2 && $t_id2 != "") && ($su_no3 == 3 && $t_id3 == "")) {
		$su_term = $su_term1;
		$su_no = $su_no3;
	}
	//เทอม2
	if (($t_id1 != "") && ($t_id2 != "") && ($t_id3 != "") && ($su_no4 == 4 && $t_id4 == "") && ($su_no5 == 5 && $t_id5 == "") && ($su_no6 == 6 && $t_id6 == "")) {
		$su_term = $su_term2;
		$su_no = $su_no4;
	}
	if (($su_no4 == 4 && $t_id4 != "") && ($su_no5 == 5 && $t_id5 == "") && ($su_no6 == 6 && $t_id6 == "")) {
		$su_term = $su_term2;
		$su_no = $su_no5;
	}
	if (($su_no4 == 4 && $t_id4 != "") && ($su_no5 == 5 && $t_id5 != "") && ($su_no6 == 6 && $t_id6 == "")) {
		$su_term = $su_term2;
		$su_no = $su_no6;
	}
	$nestedData[] = $row["s_id"];
	if ($row["s_fna"] != null && $row["s_lna"] != null) {
		$nestedData[] = $row["s_fna"] . '&nbsp;' . $row["s_lna"];
	}
	$nestedData[] = $row["c_na"];
	$nestedData[] = $row["pe_semester"];
	$nestedData[] = $su_term.'/'.$su_no;
	$nestedData[] = $row['detail'] = '<div align="center">' . "<a href=\"indexstdsup.php?s_id=$row[s_id]\">" . '<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> นิเทศนักศึกษา </i></button>';
	$data[] = $nestedData;
}

$json_data = array(
	"draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	"recordsTotal"    => intval($totalData),  // total number of records
	"recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
	"data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
