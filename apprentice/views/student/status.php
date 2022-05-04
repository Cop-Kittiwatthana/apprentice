<?php
include("../../connect.php");
if (isset($_POST['btnstatus'])) {
    $s_id = $_POST['s_id'];
    $s_status = $_POST['s_status'];
    $id = $_POST['id'];
    $year = $_POST['year'];
    if ($s_status == 1 || $s_status == null) {
        $query = "UPDATE student set s_status='1' WHERE s_id = '$s_id'";
        mysqli_query($conn, $query);
        echo "<script language='javascript'>window.location = 'index.php?id=".$id."&year=".$year."';</script>";
    }
    if ($s_status == 2) {
        $query = "UPDATE student set s_status='2' WHERE s_id = '$s_id'";
        mysqli_query($conn, $query);
        echo "<script language='javascript'>window.location = 'index.php?id=".$id."&year=".$year."';</script>";
    }
}
if (isset($_POST['btnstatus2'])) {
    $id = $_POST['id'];
    $year = $_POST['year'];
    $sql = "SELECT student.*,department.*,branch.*
    FROM student 
    LEFT JOIN branch ON student.br_id  = branch.br_id  
    LEFT JOIN department ON branch.dp_id = department.dp_id 
    where student.br_id = '$id' AND  student.s_id LIKE '$year%'  ";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $query = "UPDATE student set s_status='2' WHERE s_id = '$row[s_id]'";
        mysqli_query($conn, $query);
    }
    echo "<script language='javascript'>window.location = 'index.php?id=".$id."&year=".$year."';</script>";
}
if (isset($_POST['btnstatus1'])) {
    $id = $_POST['id'];
    $year = $_POST['year'];
    $sql = "SELECT student.*,department.*,branch.*
    FROM student 
    LEFT JOIN branch ON student.br_id  = branch.br_id  
    LEFT JOIN department ON branch.dp_id = department.dp_id 
    where student.br_id = '$id' AND  student.s_id LIKE '$year%'  ";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $query = "UPDATE student set s_status='1' WHERE s_id = '$row[s_id]'";
        mysqli_query($conn, $query);
    }
    echo "<script language='javascript'>window.location = 'index.php?id=".$id."&year=".$year."';</script>";
}
