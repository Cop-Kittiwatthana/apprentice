<?php
//fetch.php
include("../../connect.php");
$column = array("student.s_id ", "student.s_fna", "student.s_lna", "company.c_na");

// #GROUP BY 
$query = "SELECT company.c_na,student.s_id,student.s_fna,student.s_lna,petition.*,supervision.su_no,SUBSTR(student.s_id,1,2) As id";
$query .= " FROM supervision ";
$query .= " LEFT JOIN petition ON supervision.pe_id  = petition.pe_id ";
$query .= " LEFT JOIN student ON student.s_id  = petition.s_id ";
$query .= " LEFT JOIN demand ON petition.de_id  = demand.de_id ";
$query .= " LEFT JOIN branch ON demand.br_id  = branch.br_id ";
$query .= " LEFT JOIN company ON demand.c_id  = company.c_id ";
$query .= " WHERE petition.pe_status >= '5' and branch.br_id = '" . $_POST["br_id"] . "' ";
if (isset($_POST["year"])) {
    $query .= " and petition.pe_semester  = '" . $_POST["year"] . "' ";
}
if (isset($_POST["is_company"])) {
    $query .= " and company.c_id  = '" . $_POST["is_company"] . "' ";
}
if (isset($_POST["search"]["value"])) {
    $query .= ' AND (student.s_id LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR CONCAT(student.s_fna," ",student.s_lna) LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR CONCAT(student.s_fna," ",student.s_lna) LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR company.c_na LIKE "%' . $_POST["search"]["value"] . '%") ';
}
$query .= " GROUP BY student.s_id ";
if (isset($_POST["order"])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY id DESC ';
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
    $query2 = "SELECT supervision.su_term,supervision.su_no,supervision.t_id,company.c_na
    FROM petition 
    INNER JOIN supervision ON petition.pe_id  = supervision.pe_id
    LEFT JOIN demand ON petition.de_id  = demand.de_id
    LEFT JOIN company ON demand.c_id  = company.c_id
    WHERE petition.s_id = '$row[s_id]' ORDER BY supervision.su_no ASC";
    $result2 = mysqli_query($conn, $query2) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    $num = array();
    while ($row2 = mysqli_fetch_array($result2)) {
        $num[] = $row2;
    }
    $su_term1 = $num[0]['su_term'];
    $su_term2 = $num[3]['su_term'];
    $c_na1 = $num[2]['c_na'];
    $c_na2 = $num[5]['c_na'];
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

    $nestedData[] =  $row["s_id"];
    if ($row["s_fna"] != null && $row["s_lna"] != null) {
        $nestedData[] = $row["s_fna"] . '&nbsp;' . $row["s_lna"];
    }
    if ($su_term1 != "" && $su_term2 == "") {
        $nestedData[] = $c_na1;
    }
    if ($su_term2 != "") {
        $nestedData[] = $c_na2;
    }
    if ($pe_status != 10) {
        if (($t_id1 == "" || $t_id2 == "" || $t_id3 == "") && $pe_status != 10) {
            $nestedData[] = $row['detail'] = '<div align="center">' . "<a href=\"edit.php?s_id=$row[s_id]&su_term=$su_term1&year=$row[pe_semester]\">" . '<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> จัดการอาจารย์นิเทศ </i></button></a>';
        }
        if (($t_id1 != "" || $t_id2 != "" || $t_id3 != "") && $su_term2 == "") {
            $nestedData[] = $row['detail'] = '<div align="center">' . "" . '<button disabled type="button" class="btn btn-info"><i class="fas fa-info-circle"> จัดการอาจารย์นิเทศ </i></button></a>';
        }
        if (($t_id4 == "" || $t_id5 == "" || $t_id6 == "") && $pe_status != 10) {
            $nestedData[] = $row['detail'] = '<div align="center">' . "<a href=\"edit.php?s_id=$row[s_id]&su_term=$su_term2&year=$row[pe_semester]\">" . '<button type="button" class="btn btn-info"><i class="fas fa-info-circle"> จัดการอาจารย์นิเทศ </i></button></a>';
        } else {
            $nestedData[] = $row['detail'] = '<div align="center">' . "" . '<button disabled type="button" class="btn btn-info"><i class="fas fa-info-circle"> จัดการอาจารย์นิเทศ </i></button></a>';
        }
    } else {
        $nestedData[] = "<font color='red'>ยกเลิกการฝึก </font>";
    }



    $data[] = $nestedData;
}

function get_all_data($conn)
{
    $query = "SELECT company.c_na,student.s_id,student.s_fna,student.s_lna,supervision.su_no";
    $query .= " FROM supervision ";
    $query .= " LEFT JOIN petition ON supervision.pe_id  = petition.pe_id ";
    $query .= " LEFT JOIN student ON student.s_id  = petition.s_id ";
    $query .= " LEFT JOIN demand ON petition.de_id  = demand.de_id ";
    $query .= " LEFT JOIN branch ON demand.br_id  = branch.br_id ";
    $query .= " LEFT JOIN company ON demand.c_id  = company.c_id ";
    $query .= " WHERE petition.pe_status >= '5' and branch.br_id = $_POST[br_id]  ";
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
