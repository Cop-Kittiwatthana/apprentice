<?php
include("../../connect.php");
include("status.php");//sql การอัพเดท 
// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;

$columns = array(
	// datatable column index  => database column name
	0 => 'c_id',
	1 => 'c_na',
	2 => 'c_hnum',
	3 => 'c_village',
	4 => 'c_road',
	5 => 'c_status',
	6 => 'district_id',

);


// getting total number records without any search
$sql = "SELECT company.*,districts.*, amphures.*,provinces.*";
$sql .= " FROM company ";
$sql .= " INNER JOIN districts ON company.district_id=districts.district_id ";
$sql .= " INNER JOIN amphures ON districts.amphure_id=amphures.amphure_id ";
$sql .= " INNER JOIN provinces ON amphures.province_id=provinces.province_id ";
$query = mysqli_query($conn, $sql) or die("data.php: get company");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT company.*,districts.*, amphures.*,provinces.*";
$sql .= " FROM company ";
$sql .= " INNER JOIN districts ON company.district_id=districts.district_id ";
$sql .= " INNER JOIN amphures ON districts.amphure_id=amphures.amphure_id ";
$sql .= " INNER JOIN provinces ON amphures.province_id=provinces.province_id ";
$sql .= " where 1=1 ";
if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND ( company.c_id LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_na LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_hnum LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_village LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_road LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR company.c_status LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR districts.district_name_th LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR amphures.amphures_name_th LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR provinces.provinces_name_th LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR districts.zip_code LIKE '" . $requestData['search']['value'] . "%' )";
}
$query = mysqli_query($conn, $sql) or die("data.php: get company");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die("data.php: get company");

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
	$nestedData = array();

	$nestedData[] = $row["c_id"];
	// $nestedData[] = $row["c_na"];
	if($row['c_road'] = "-"){
		$c_road = 'ถนน ' . "$row[c_road]" .'';
	}else{
		$c_road ='';
	}
	
	if ($row['c_hnum'] != null ){
		$nestedData[] =  '<a align="center"><a  data-toggle="modal" data-target="#infoModal' . "$row[c_id]" . '"><p style="color:blue">'." $row[c_na]".'</p></a>
		<div class="modal fade" id="infoModal' . "$row[c_id]" . '" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
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
								สถานประกอบการ : ' . "$row[c_na]" . '<br>
								ที่อยู่ : ' . "$row[c_hnum]" . '&nbsp;หมู่' . "$row[c_village]" . '&nbsp;' . "$c_road" . 
								'&nbsp;ต.' . "$row[district_name_th]" . '&nbsp;อ.' . "$row[amphures_name_th]" . 
								'&nbsp;จ.' . "$row[provinces_name_th]" . '&nbsp;รหัสไปรษณีย์&nbsp;' . "$row[zip_code]" . '<br>
								</div>
							</div>
						</div>
					</div>
				</div>';
	}
	if ($row['c_hnum'] != null && $row['c_village'] != null) {
		$nestedData[] = $row["c_hnum"] . '&nbsp;หมู่' . $row["c_village"] . '&nbsp;' . $row["c_road"] . '&nbsp;ต.' .
			$row["district_name_th"] . '&nbsp;อ.' . $row["amphures_name_th"] . '&nbsp;จ.' . $row["provinces_name_th"];
	}
	$nestedData[] = $row['add'] = '<div align="center">' . "<a href=\"$baseURL/views/staff/index.php?c_id=$row[c_id]\">" . '<button type="button" class="btn btn-info"><i class="fa fas-plus"> จัดการข้อมูลผู้ติดต่อ </i></button>';
	if ($row['c_status'] == '0') {
		$nestedData[] = "<font color='green'>เปิดรับ</font>";
	}
	if ($row['c_status'] == '1') {
		$nestedData[] = "<font color='red'>ไม่เปิดรับ</font>";
	};
	if ($row['c_status'] == '0') {
		$nestedData[] = '<form name="MyForm" method="post" action="data.php" >
		<input type="hidden" name="c_status" value="1">
		<input type="hidden" name="c_id" value="' . " $row[c_id]" . '">
		<button class="btn btn-danger"  name="btnstatus" type="submit" ><i class="fas fa-power-off">&nbsp;ปิด</i></button>
	</form>';
	};
	if ($row['c_status'] == '1') {
		$nestedData[] = '<form name="MyForm" method="post" action="data.php" >
		<input type="hidden" name="c_status" value="0">
		<input type="hidden" name="c_id" value="' . " $row[c_id]" . '">
		<button class="btn btn-success"  name="btnstatus" type="submit" ><i class="fas fa-power-off">&nbsp;เปิด</i></button>
	</form>';
	};
	// if ($row['c_status'] == '1') {
	// 	$nestedData[] = '<button type="button"  id="' . "$row[t_id]" . '"><i class="fas fa-power-off">&nbsp;เปิด</i></button>';
	// };
	$nestedData[] = $row['edit/delect'] =
		'<div align="center">' . "<a href=\"edit.php?c_id=$row[c_id]\">" . '<button type="button" class="btn btn-success"><i class="fas fa-edit"> แก้ไข </i></button></a>&nbsp;' .
		"<a >" . '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal' . "$row[c_id]" . '">
		<i class="fas fa-trash"> ลบ </i></button></div>
		
		<form method="POST" action="sql.php" class="float-center">
			<div class="modal fade" id="exampleModal' . "$row[c_id]" . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-dark" id="exampleModalLabel" >ลบข้อมูลสถานประกอบการ</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<input name="c_id" type="hidden"  value="' . "$row[c_id]" . '" />
							<font class="d-flex justify-content-center " size="6" face="TH SarabunPSK"><p style="color:black">ต้องการลบ&nbsp;</p><p style="color:red">' . "$row[c_na]" .'&nbsp;</p> <p style="color:black">ใช่หรือไม่</p></font>
							<font class="d-flex justify-content-center " size="5" face="TH SarabunPSK"><p style="color:red">*ข้อมูลที่เกี่ยวข้องกับสถานประกอบการนี้จะถูกลบทั้งหมด</p></font>
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

	$data[] = $nestedData;
}

$json_data = array(
	"draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	"recordsTotal"    => intval($totalData),  // total number of records
	"recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
	"data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
