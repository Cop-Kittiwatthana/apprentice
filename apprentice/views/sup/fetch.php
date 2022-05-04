<?php
//fetch.php

if (isset($_POST['action'])) {
	include("../../connect.php");

	$output = '';

	if ($_POST["action"] == 'company') {
		$id = $_POST["query"];
		$year = $_POST["year"];
		$br_id = $_POST["br_id"];
		if ($id != "reset") {
			$query = "SELECT petition.pe_id,petition.s_id,student.s_fna,student.s_lna,company.c_na
			from petition 
			left join student on petition.s_id = student.s_id
			left JOIN demand ON petition.de_id  = demand.de_id
			left join company ON demand.c_id = company.c_id 
			where (petition.pe_status = '5' or petition.pe_status = '6' )
		
			and petition.pe_semester = '$year' and student.br_id = '$br_id' ";
			if ($id != "all") {
				$query .= " and company.c_id = '$id' ";
				$query .= " GROUP BY petition.s_id ";
				$result = mysqli_query($conn, $query);
				foreach ($result as $row) {
					$output .= '<option value="' . $row["s_id"] . '">' . $row["s_fna"] . '' . $row["s_lna"] . '</option>';
				}
			} else {
				$query .= " GROUP BY petition.s_id ";
				$result = mysqli_query($conn, $query);
				foreach ($result as $row) {
					$output .= '<option value="' . $row["s_id"] . '">' . $row["s_fna"] . '' . $row["s_lna"] . '(' . $row["c_na"] . ')</option>';
				}
			}
		}else{
			$output = "";
		}
	}
	echo $output;
}
