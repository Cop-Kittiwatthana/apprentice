<?php
//fetch.php
include("../../connect.php");
$column = array("petition.pe_semester", "student.s_group", "student.s_id");

$query = "SELECT petition.pe_semester,student.s_group,COUNT(student.s_id) as total,SUBSTR(student.s_id,1,2) As id";
$query .= " FROM student  ";
$query .= " LEFT JOIN branch ON student.br_id  = branch.br_id ";
$query .= " LEFT JOIN petition ON petition.s_id  = student.s_id ";
$query .= " WHERE ";
if (isset($_POST["is_branch"])) {
    $query .= " student.br_id = '" . $_POST["is_branch"] . "' AND ";
}
if (isset($_POST["is_year"])) {
    $query .= " petition.pe_semester = '" . $_POST["is_year"] . "' AND ";
}
if (isset($_POST["search"]["value"])) {
    $query .= '(student.s_group LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR student.s_id LIKE "' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR petition.pe_semester LIKE "%' . $_POST["search"]["value"] . '%") ';
}
if (isset($_POST["order"])) {
    $query .= 'GROUP BY student.s_group ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'GROUP BY student.s_group ORDER BY petition.pe_semester DESC ';
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
    //$nestedData[] = $row["pe_semester"];
    if ($row["pe_semester"] != "") {
        $nestedData[] = $row["pe_semester"];
    } else {
        $nestedData[] = '<font color="red" style="text-align:center;">ยังไม่มีข้อมูล</div></font>';
    }
    $nestedData[] = $row["s_group"];
    $nestedData[] = $row["id"];
    if ($row["pe_semester"] != "") {
        $nestedData[] = $row['detail1'] = '<div align="center">' . "<a href=\"indexstd.php?id=$_POST[is_branch]&s_group=$row[s_group]&pe_semester=$row[pe_semester]&r_term=1\" >" . '<button  type="button" class="btn btn-info"> การฝึกงานครั้งที่1 </i></button></a>
    </div>
    ';
        $nestedData[] = $row['detail2'] = '<div align="center">' . "<a href=\"indexstd.php?id=$_POST[is_branch]&s_group=$row[s_group]&pe_semester=$row[pe_semester]&r_term=2\" >" . '<button type="button" class="btn btn-info"> การฝึกงานครั้งที่2 </i></button></a></div>
    ';
    } else {
        $nestedData[] = $row['detail1'] = '<div align="center">' . "" . '<button disabled type="button" class="btn btn-info"> การฝึกงานครั้งที่1 </i></button></a>
    </div>
    ';
        $nestedData[] = $row['detail2'] = '<div align="center">' . "" . '<button disabled type="button" class="btn btn-info"> การฝึกงานครั้งที่2 </i></button></a></div>
    ';
    }

    // $nestedData[] = $row['detail1'] = '<div align="center">' . "<a href=\"indexstd.php?id=1&n_year=$row[n_year]&n_group=$row[n_group]&br_id=$row[br_id]\" >" . '<button type="button" class="btn btn-info"> เทอม1 </i></button>
    // ' . "<a href=\"pdf.php?id=1&n_year=$row[n_year]&n_group=$row[n_group]&br_id=$row[br_id]\" target='blank'>" . '<button type="button" class="btn btn-info"> ผลประเมิน </i></button>
    // </div>
    // ';
    $data[] = $nestedData;
}

function get_all_data($conn)
{
    $query = "SELECT petition.pe_semester,student.s_group,COUNT(student.s_id) as total,SUBSTR(student.s_id,1,2) As id
    FROM student  
    LEFT JOIN branch ON student.br_id  = branch.br_id
    LEFT JOIN petition ON petition.s_id  = student.s_id  
    WHERE student.br_id = '$_POST[is_branch] '
    GROUP BY student.s_group ORDER BY petition.pe_semester DESC";
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
