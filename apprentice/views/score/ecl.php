<?php
/*กำหนด username password และ database name ของ mysql */
include("../../connect.php");

/*สร้างปุ่มสำหรับ Download ไฟล์ excel โดยกำหนดว่าเมื่อกดปุ่ม Downlaod แล้วจะทำงานที่ javascript function ชื่อว่า ExcelReport()*/
//echo "<a href='#' id='download_link' onClick='javascript:ExcelReport();''>Download</a>";

"<table id='myTable'>";
"<tr>";
"<td>รหัสนักศึกษา</td>";
"<td>ชื่อ-สกุล</td>";
"</tr>";
/*นำข้อมูลจากตาราง food มาแสดง*/
$sql = "SELECT * FROM student";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) { {
        "<tr>";
        "<td>$row[s_id]</td>";
        "<td>$row[s_fna]</td>";
        "<td>$row[s_lna]</td>";
        "</tr>";
    }
}
"</table>";

$conn->close();


?>
<!-- เรียกใช้ javascript สำหรับ export ไฟล์ excel  -->
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script src="https://unpkg.com/file-saver@1.3.3/FileSaver.js"></script>

<script>
    function ExcelReport() //function สำหรับสร้าง ไฟล์ excel จากตาราง
    {
        var sheet_name = "excel_sheet"; /* กำหหนดชื่อ sheet ให้กับ excel โดยต้องไม่เกิน 31 ตัวอักษร */
        var elt = document.getElementById('myTable'); /*กำหนดสร้างไฟล์ excel จาก table element ที่มี id ชื่อว่า myTable*/

        /*------สร้างไฟล์ excel------*/
        var wb = XLSX.utils.table_to_book(elt, {
            sheet: sheet_name
        });
        XLSX.writeFile(wb, 'report.xlsx'); //Download ไฟล์ excel จากตาราง html โดยใช้ชื่อว่า report.xlsx
    }
</script>
<style type="text/css">
    table {
        border-collapse: collapse;
        width: 40%;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }
</style>