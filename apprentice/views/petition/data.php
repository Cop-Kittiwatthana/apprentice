<?php
include("../../connect.php");

// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;
$s_id = $_POST['s_id'];
$nr = 0;
$columns = array(
	// datatable column index  => database column name
	0 => 'pe_id',
	1 => 'pe_date',
	2 => 'pe_semester',
	3 => 'pe_date1',
	4 => 'pe_date2',
	5 => 'pe_status',
	6 => 's_id',
	7 => 'c_id',
	// 10 => 't_fna',

);


// getting total number records without any search
$sql = "SELECT petition.*,student.*,company.*,demand.*";
$sql .= " FROM petition ";
$sql .= " LEFT JOIN student ON student.s_id  = petition.s_id  ";
$sql .= " LEFT JOIN demand ON petition.de_id  = demand.de_id 
LEFT JOIN company ON demand.c_id  = company.c_id   ";
$query = mysqli_query($conn, $sql) or die("data.php: get petition");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT petition.*,student.*,company.*,demand.*";
$sql .= " FROM petition ";
$sql .= " LEFT JOIN student ON student.s_id  = petition.s_id  ";
$sql .= " LEFT JOIN demand ON petition.de_id  = demand.de_id 
LEFT JOIN company ON demand.c_id  = company.c_id  ";
$sql .= " where 1=1 and petition.s_id = '$s_id' ";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND ( petition.pe_id LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_na LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR petition.pe_date LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR petition.pe_semester LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR petition.pe_date1 LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR petition.pe_date2 LIKE '" . $requestData['search']['value'] . "%' )";
}
$query = mysqli_query($conn, $sql) or die("data.php: get petition");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die("data.php: get petition");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
	$nr++;
	$nestedData = array();

	$nestedData[] = $row["pe_id"];
	$nestedData[] = $row["c_na"];
	$nestedData[] = $row["pe_date"];
	if ($row['pe_status'] == "0") {
		$nestedData[] = "<font color='blue'>ส่งคำร้อง</font>";
	}
	if ($row['pe_status'] == "1") {
		$nestedData[] = "<font color='Orange'>รอตรวจสอบ</font>";
	}
	if ($row['pe_status'] == "2") {
		$nestedData[] = "<font color='green'>รับเข้าฝึก</font>";
	}
	if ($row['pe_status'] == "3") {
		$nestedData[] = "<font color='red'>ปฏิเสธรับเข้าฝึก</font>";
	}
	if ($row['pe_status'] == "4") {
		$nestedData[] = "<font color='red'>ข้อมูลไม่ถูกต้อง</font>" .
			'<a align="center"><a  data-toggle="modal" data-target="#infoModal' . "$row[pe_id]" . '"><i class="fas fa-exclamation-circle"></i></a>
		<div class="modal fade" id="infoModal' . "$row[pe_id]" . '" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title text-dark" id="infoModalLabel" >รายละเอียด</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<dic style="color:black;align:center;">
								กรุณาตรวจสอบข้อมูล : <br><p style="color:red">' . "$row[note]" . '</p><br>
								</div>
							</div>
						</div>
					</div>
				</div>';
	}
	if ($row['pe_status'] == "5") {
		$nestedData[] = "<font color='Orange'>กำลังออกฝึก</font>";
	}
	if ($row['pe_status'] == "6") {
		$nestedData[] = "<font color='green'>ฝึกงานเสร็จสิ้นเทอม1</font>";
	}
	if ($row['pe_status'] == "10") {
		$nestedData[] = "<font color='Red'>เปลียนสถานที่ฝึกงาน(เทอม2)</font>";
	}
	if ($row['pe_status'] == "7") {
		$nestedData[] = "<font color='Red'>เปลียนสถานที่ฝึกงาน(เทอม1)</font>";
	}
	if ($row['pe_status'] == "8") {
		$nestedData[] = "<font color='green'>ฝึกงานเสร็จสิ้นทั้งหมด</font>";
	}
	if ($row['pe_status'] == "11") {
		$nestedData[] = "<font color='Red'>ยกเลิกการฝึก</font>";
	}
	if ($row['s_status'] == "2") {
		if ($row['pe_status'] == "0" ||  $row['pe_status'] == "4") {
			$nestedData[] = $row['edit/delect'] =
				'<div align="center">' . "<a href=\"edit.php?s_id=$s_id&pe_id=$row[pe_id]&c_id=$row[c_id]&de_id=$row[de_id]\">" . '<button  type="button" class="btn btn-success"><i class="fas fa-edit"> แก้ไข </i></button></a>&nbsp;' .
				"<a >" . '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal' . "$row[pe_id]" . '">
		<i class="fas fa-trash"> ลบ </i></button></a></div>
		
		<form method="POST" action="sql.php" class="float-center">
			<div class="modal fade" id="exampleModal' . "$row[pe_id]" . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="exampleModalLabel" >ลบข้อมูลการยื่นเรื่อง</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<input name="pe_id" type="hidden"  value="' . "$row[pe_id]" . '" />
							<input name="s_id" type="hidden"  value="' . "$row[s_id]" . '" />
							<font class="d-flex justify-content-center " size="6" face="TH SarabunPSK"><p style="color:black">ต้องการลบ&nbsp;</p><p style="color:red">' . "$row[pe_id]" . '&nbsp;</p> <p style="color:black">ใช่หรือไม่</p></font>
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
		}

		if ($row['pe_status'] == "1" || $row['pe_status'] == "2" || $row['pe_status'] == "5" || $row['pe_status'] == "6" || $row['pe_status'] == "8") {
			$nestedData[] = $row['edit/delect'] =
				'<div align="center"><button disabled  type="button" class="btn btn-success"><i class="fas fa-edit"> แก้ไข </i></button></a>&nbsp;' .
				"<a >" . '<button disabled type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal' . "$row[pe_id]" . '">
		<i class="fas fa-trash"> ลบ </i></button></a></div>
		';
		}
		if ($row['pe_status'] == "7") {
			$query2 = "SELECT petition.* FROM petition WHERE s_id='$s_id' and (pe_status != '7')";
			$result2 = mysqli_query($conn, $query2);
			$total2 = mysqli_num_rows($result2);
			if ($total2 != 0) {
				$nestedData[] = $row['edit/delect'] =
					'<div align="center">' . "<a>" . '<button disabled type="button" class="btn btn-success"><i class="fas fa-edit"> ยื่นคำร้องที่ฝึกใหม่ </i></button></a>&nbsp;' .
					"<a >";
			} else {
				$nestedData[] = $row['edit/delect'] =
					'<div align="center">' . "<a href=\"indexcompany.php?s_id=$s_id\">" . '<button  type="button" class="btn btn-success"><i class="fas fa-edit"> ยื่นคำร้องที่ฝึกใหม่ </i></button></a>&nbsp;' .
					"<a >";
			}
		}
		if ($row['pe_status'] == "10") {
			$query3 = "SELECT petition.* FROM petition WHERE s_id='$s_id' and (pe_status != '7' and pe_status != '10')";
			$result3 = mysqli_query($conn, $query3);
			$total3 = mysqli_num_rows($result3);
			if ($total3 != 0) {
				$nestedData[] = $row['edit/delect'] =
					'<div align="center">' . "<a>" . '<button disabled type="button" class="btn btn-success"><i class="fas fa-edit"> ยื่นคำร้องที่ฝึกใหม่ </i></button></a>&nbsp;' .
					"<a >";
			} else {
				$nestedData[] = $row['edit/delect'] =
					'<div align="center">' . "<a href=\"indexcompany.php?s_id=$s_id\">" . '<button  type="button" class="btn btn-success"><i class="fas fa-edit"> ยื่นคำร้องที่ฝึกใหม่ </i></button></a>&nbsp;' .
					"<a >";
			}
		}
		if ($row['pe_status'] == "11") {
			$query3 = "SELECT petition.* FROM petition WHERE s_id='$s_id' and (pe_status != '7' and pe_status != '10' and pe_status != '11')";
			$result3 = mysqli_query($conn, $query3);
			$total3 = mysqli_num_rows($result3);
			if ($total3 != 0) {
				$nestedData[] = $row['edit/delect'] =
					'<div align="center">' . "<a>" . '<button disabled type="button" class="btn btn-success"><i class="fas fa-edit"> ยื่นคำร้องที่ฝึกใหม่ </i></button></a>&nbsp;' .
					"<a >";
			} else {
				$nestedData[] = $row['edit/delect'] =
					'<div align="center">' . "<a href=\"indexcompany.php?s_id=$s_id\">" . '<button  type="button" class="btn btn-success"><i class="fas fa-edit"> ยื่นคำร้องที่ฝึกใหม่ </i></button></a>&nbsp;' .
					"<a >";
			}
		}
		if ($row['pe_status'] == "3") {
			$nestedData[] = $row['edit/delect'] =
				'<div align="center"> <button disabled type="button" class="btn btn-success"><i class="fas fa-edit"> แก้ไข </i></button></a>&nbsp;' .
				"<a >" . '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal' . "$row[pe_id]" . '">
		<i class="fas fa-trash"> ลบ </i></button></div>
		
		<form method="POST" action="sql.php" class="float-center">
			<div class="modal fade" id="exampleModal' . "$row[pe_id]" . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="exampleModalLabel" >ลบข้อมูลการยื่นเรื่อง</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<input name="pe_id" type="hidden"  value="' . "$row[pe_id]" . '" />
							<input name="s_id" type="hidden"  value="' . "$row[s_id]" . '" />
							<font class="d-flex justify-content-center " size="6" face="TH SarabunPSK"><p style="color:black">ต้องการลบ&nbsp;</p><p style="color:red">รหัสคำร้อง' . "$row[pe_id]" . '&nbsp;</p> <p style="color:black">ใช่หรือไม่</p></font>
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
		}
	} else {
		$nestedData[] = $row['edit/delect'] =
					'<div align="center">' . "<a>" . '<button disabled type="button" class="btn btn-success"><i class="fas fa-edit">ยังไม่เปิดให้ลงทะเบียนหรือแก้ไขข้อมูล</i></button></a>' .
					"<a >";
	}
	$data[] = $nestedData;
}

$json_data = array(
	"draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	"recordsTotal"    => intval($totalData),  // total number of records
	"recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
	"data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
