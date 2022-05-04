<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Untitled Document</title>
  <?php include("../../head.php") ?>
</head>

<body>
  <?php
  //**************************************INSERT*********************************************************** */
  include("../../connect.php");
  error_reporting(0);
  if (isset($_POST["btnsave"])) {
    $tmp = explode(".", $_FILES["excel"]["name"]);
    $extension = end($tmp);
    $year = $_POST['year'];
    $br_id = $_POST['br_id'];
    $allowed_extension = array("xls", "xlsx", "csv"); //นามสกุลไฟล์ ที่อนุญาต
    if (in_array($extension, $allowed_extension)) //ตรวจสอบนามสกุลไฟล์
    {
      $file = $_FILES["excel"]["tmp_name"]; // ที่มาของไฟล์ excel
      include("PHPExcel/Classes/PHPExcel/IOFactory.php"); // เพิ่ม PHPExcel Library 
      $objPHPExcel = PHPExcel_IOFactory::load($file); // สร้างวัตถุของไลบรารี PHPExcel โดยใช้วิธี load () และในวิธีการโหลดกำหนดเส้นทางของไฟล์ที่เลือก

      foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
        $highestRow = $worksheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) { //สามารถปรับ $row เพื่อเลือกแถวที่บัทึกลงฐานข้อมูลได้เลย ถ้าไม่ปรับมันจะเอาข้อมูลทั้งหมดที่เห็นในตารางลงฐานข้อมูลนะครับ
          $s_id = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(0, $row)->getValue()); //รหัสนักศึกษา
          $s_tna = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(1, $row)->getValue()); //คำนำหน้า
          $s_fna = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(2, $row)->getValue()); //ชื่อ
          $s_lna = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(3, $row)->getValue()); //นามสกุล
          //$br_id = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(4, $row)->getValue()); //สาขา
          $s_group = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(4, $row)->getValue()); //กลุ่ม
          $s_pass = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(5, $row)->getValue()); //รหัสผ่าน
          if ($s_tna != "") {
            if ($s_tna === "นาย") {
              $s_tna = "0";
            } else if ($s_tna === "นาง") {
              $s_tna = "1";
            } else if ($s_tna === "นางสาว") {
              $s_tna = "2";
            } else {
              echo "<script>Swal.fire({
                type: 'error',
                title: 'กรุณาตรวจสอบคำนำหน้า',
                showConfirmButton: true,
                timer: 1500
                }).then(() => { 
                  window.history.back()
                });
                </script>";
              exit();
            }
          }
          //
          // if ($br_id != "") {
          //   $query1 = "SELECT * FROM branch WHERE br_na ='$br_id'";
          //   $result1 = mysqli_query($conn, $query1);
          //   $total1 = mysqli_num_rows($result1);
          //   if ($total1 == 0) {
          //     echo "<script>Swal.fire({
          //       type: 'error',
          //       title: 'กรุณาตรวจสอบข้อมูลสาขา',
          //       showConfirmButton: true,
          //       timer: 1500
          //       }).then(() => { 
          //        window.history.back()
          //       });
          //       </script>";
          //     exit();
          //   } else {
          //     $row1 = mysqli_fetch_array($result1);
          //     $brid = $row1['br_id'];
          //   }
          // }
          $query = "SELECT * FROM student WHERE s_user='$s_id' or (s_fna ='$s_fna' and s_lna ='$s_lna') and s_id != '$s_id'";
          $result = mysqli_query($conn, $query);
          $total = mysqli_num_rows($result);
          if ($total == 0) {
            $query = "INSERT INTO student (s_id,s_tna,s_fna,s_lna,br_id,s_group,s_user,s_pass) VALUES ('$s_id','$s_tna','$s_fna','$s_lna','$br_id','$s_group','$s_id','$s_pass')";
            $result = mysqli_query($conn, $query);
            $query = "INSERT INTO advisor(s_id,br_id) VALUES ('$s_id','$brid')";
            $result = mysqli_query($conn, $query);
            $i = 0;
            while ($i < 3) {
              $query = "INSERT INTO parent (s_id,pa_status) VALUES ('$s_id','$i')";
              $result = mysqli_query($conn, $query);
              $i++;
            }

            // เช็คข้อมูลอาจารย์ที่ปรึกษา
            $id = substr($s_id, 0, 2);
            $query3 = "SELECT teacher.t_id
            from  student
            LEFT JOIN teacher ON student.t_id = teacher.t_id
            LEFT JOIN branch ON branch.br_id = student.br_id
            WHERE student.t_id != '0' and student.br_id = '$br_id' and student.s_group = '$s_group' and student.s_id LIKE '$id%' GROUP BY student.t_id";
            $result3 = mysqli_query($conn, $query3);
            $row3 = mysqli_fetch_array($result3);
            $total3 = mysqli_num_rows($result3);
            if ($total3 != 0) {
              while ($row1 = mysqli_fetch_array($result1)) {
                $query = "INSERT INTO advisor (s_id,br_id,t_id) VALUES ('$s_id','$br_id','$row3[t_id]')";
                $result = mysqli_query($conn, $query);
              }
              //$note = "เลือกอาจารย์ที่ปรึกษาแล้ว";
            } else {
              $query = "INSERT INTO advisor(s_id,br_id,t_id) VALUES ('$s_id','$br_id','0')";
              $result = mysqli_query($conn, $query);
              //$note = "ยังไม่เลือกอาจารย์ที่ปรึกษา";
            }
            // ////////////////////////////////////////////////////////////////////////////////
            $query = "SELECT SUBSTR(student.s_id,1,2) As id,student.s_sdate,student.s_edate FROM student 
            WHERE student.s_id LIKE '$id%' GROUP BY id ";
            $result = mysqli_query($conn, $query);
            $total = mysqli_num_rows($result);
            while ($row1 = mysqli_fetch_array($result)) {
              $s_sdate = "$row[s_sdate]";
              $s_edate = "$row[s_edate]";
            }
            if ($total != 0) {
              $query = "UPDATE student SET s_sdate ='$s_sdate',s_edate ='$s_edate' WHERE s_id = '$s_id' ";
              $result = mysqli_query($conn, $query);
            }
            // ////////////////////////////////////////////////////////////////////////////////
          }
        }
      }
      if ($year == "" || $year == 0) {
        if ($total != 0) {
          echo "<script>Swal.fire({
            type: 'error',
            title: 'มีข้อมูลซ้ำ',
            showConfirmButton: true,
            timer: 1500
            }).then(() => { 
              window.history.back()
            });
            </script>";
          // 
          exit();
        }
        if ($result) {
          echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
            }).then(() => { 
              window.location = 'indexsub.php'
            });
          </script>";
          //
          exit();
        } else {
          echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลไม่สำเร็จ',
            showConfirmButton: true,
            timer: 1500
            }).then(() => { 
              window.location = 'indexsub.php'
            });
          </script>";
          //window.location = 'index.php?id=$br_id&year=$year'
          exit();
        }
      } else {
        if ($total != 0) {
          echo "<script>Swal.fire({
            type: 'error',
            title: 'มีข้อมูลซ้ำ',
            showConfirmButton: true,
            timer: 1500
            }).then(() => { 
              window.history.back()
            });
            </script>";
          // 
          exit();
        }
        if ($result) {
          echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
            }).then(() => { 
              window.location = 'index.php?id=$br_id&year=$year'
            });
          </script>";
          //
          exit();
        } else {
          echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลไม่สำเร็จ',
            showConfirmButton: true,
            timer: 1500
            }).then(() => { 
              window.location = 'index.php?id=$br_id&year=$year'
            });
          </script>";
          //window.location = 'index.php?id=$br_id&year=$year'
          exit();
        }
      }
    }
  }
  ?>
  <?php include("../../scr.php"); ?>
</body>

</html>