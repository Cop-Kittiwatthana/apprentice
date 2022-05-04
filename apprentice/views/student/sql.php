<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Untitled Document</title>
  <?php include("../../head.php") ?>
</head>

<body>
  <?php
  include("../../connect.php");
  //**************************************INSERT*********************************************************** */
  error_reporting(0);
  if (isset($_POST['btnsave'])) {
    $s_id = $_POST['s_id']; //ห้ามซ้ำ
    $s_tna = $_POST['s_tna'];
    $s_fna = $_POST['s_fna'];
    $s_lna = $_POST['s_lna'];
    $br_id = $_POST['br_id'];
    $year = $_POST['year'];
    $s_group = $_POST['s_group'];
    $s_user = $_POST['s_id'];
    $s_pass = $_POST['s_pass'];

    if ((empty($s_id)) || (empty($s_fna)) || (empty($s_lna)) || (empty($s_group)) || (empty($s_user)) || (empty($s_pass))) {
      $msg = "";
      if (!$s_id) $msg = $msg . " รหัสนักศึกษา";
      if (!$s_fna) $msg = $msg . " ชื่อ";
      if (!$s_lna) $msg = $msg . " นามสกุล";
      if (!$s_group) $msg = $msg . " กลุ่ม";
      if (!$s_user) $msg = $msg . " Username";
      if (!$s_pass) $msg = $msg . " Password";
      echo "<script>Swal.fire({
			type: 'error',
			title: 'กรุณาใส่{$msg}',
			showConfirmButton: true,
			timer: 1500
		  }).then(() => { 
			 window.history.back()
			});
		  </script>";
    }
    if ((empty($br_id))) {
      $msg = "";
      //if (!$s_tna) $msg = $msg . " คำนำหน้า";
      if (!$br_id) $msg = $msg . " แผนก-สาขา";
      echo "<script>Swal.fire({
        type: 'error',
        title: 'กรุณาเลือก{$msg}',
        showConfirmButton: true,
        timer: 1500
        }).then(() => { 
         window.history.back()
        });
        </script>";
    } else {
      $query = "SELECT  student.* FROM student WHERE student.s_user='$s_user' and (student.s_fna='$s_fna' and student.s_lna='$s_lna') and s_id != '$s_id'";
      $result = mysqli_query($conn, $query);
      $total = mysqli_num_rows($result);
      if ($total != 0) {
        echo "<script>Swal.fire({
          type: 'error',
          title: 'ข้อมูลนี้มีอยู่แล้ว',
          showConfirmButton: true,
          timer: 1500
          }).then(() => { 
           window.history.back()
          });
          </script>";
      } else {
        $query = "INSERT INTO student (s_id,s_tna,s_fna,s_lna,br_id,s_group,s_user,s_pass) VALUES ('$s_id','$s_tna','$s_fna','$s_lna','$br_id','$s_group','$s_user','$s_pass')";
        mysqli_query($conn, $query);
        $id = substr($s_id, 0, 2);
        // ////////////////////////////////////////////////////////////////////////////////
        $query = "SELECT SUBSTR(student.s_id,1,2) As id,student.s_sdate,student.s_edate FROM student 
        WHERE student.s_id LIKE '$id%' GROUP BY id ";
        $result = mysqli_query($conn, $query);
        $total = mysqli_num_rows($result);
        while ($row1 = mysqli_fetch_array($result)) {
          $s_sdate = "$row[s_sdate]";
          $s_edate = "$row[s_edate]";
        }
        if($total != 0){
          $query = "UPDATE student SET s_sdate ='$s_sdate',s_edate ='$s_edate' WHERE s_id = '$s_id' ";
          $result = mysqli_query($conn, $query);
        }
        // ////////////////////////////////////////////////////////////////////////////////
        $query = "SELECT teacher.t_id,teacher.t_fna,teacher.t_lna
        from  advisor
        LEFT JOIN student ON advisor.s_id = student.s_id
        LEFT JOIN teacher ON advisor.t_id = teacher.t_id
        LEFT JOIN branch ON branch.br_id = student.br_id
        WHERE advisor.t_id != '0' and student.br_id = '$br_id' and student.s_group = '$s_group' and student.s_id LIKE '$id%' GROUP BY advisor.t_id";
        $result = mysqli_query($conn, $query);
        $result1 = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        $total = mysqli_num_rows($result);
        if ($total != 0) {
          while ($row1 = mysqli_fetch_array($result1)) {
            $query = "INSERT INTO advisor (s_id,t_id,br_id) VALUES ('$s_id','$row1[t_id]','$br_id')";
            $result = mysqli_query($conn, $query);
          }
          //$note = "เลือกอาจารย์ที่ปรึกษาแล้ว";
        } else {
          $query = "INSERT INTO advisor (s_id,t_id,br_id) VALUES ('$s_id','0','$br_id')";
          $result = mysqli_query($conn, $query);
          //$note = "ยังไม่เลือกอาจารย์ที่ปรึกษา";
        }
        $i = 0;
        while ($i < 3) {
          $query = "INSERT INTO parent (s_id,pa_status) VALUES ('$s_id','$i')";
          $result = mysqli_query($conn, $query);
          $i++;
        }
        if ($year == "" || $year == 0) {
          echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 3000
          }).then(() => { 
            window.location = 'indexsub.php'
            });
          </script>";
        } else {
          echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 3000
          }).then(() => { 
            window.location = 'index.php?id=$br_id&year=$year'
            });
          </script>";
        }
      }
    }
  }
  //
  //**************************************UPDATE*********************************************************** */
  if (isset($_POST['btnedit'])) {
    $s_id = $_POST['s_id']; //ห้ามซ้ำ
    $s_tna = $_POST['s_tna'];
    $s_fna = $_POST['s_fna'];
    $s_lna = $_POST['s_lna'];
    $br_id = $_POST['br_id'];
    $year = $_POST['year'];
    $s_group = $_POST['s_group'];
    $s_user = $_POST['s_id'];
    $s_pass = $_POST['s_pass'];

    if ((empty($s_id)) || (empty($s_fna)) || (empty($s_fna)) || (empty($s_group)) || (empty($s_user)) || (empty($s_pass))) {
      $msg = "";
      if (!$s_id) $msg = $msg . " รหัสนักศึกษา";
      if (!$s_fna) $msg = $msg . " ชื่อ";
      if (!$s_fna) $msg = $msg . " นามสกุล";
      if (!$s_group) $msg = $msg . " กลุ่ม";
      if (!$s_user) $msg = $msg . " Username";
      if (!$s_pass) $msg = $msg . " Password";
      echo "<script>Swal.fire({
			type: 'error',
			title: 'กรุณาใส่{$msg}',
			showConfirmButton: true,
			timer: 1500
		  }).then(() => { 
			 window.history.back()
			});
		  </script>";
    }
    if ((empty($br_id))) {
      $msg = "";
      //if (!$s_tna) $msg = $msg . " คำนำหน้า";
      if (!$br_id) $msg = $msg . " แผนก-สาขา";
      echo "<script>Swal.fire({
        type: 'error',
        title: 'กรุณาเลือก{$msg}',
        showConfirmButton: true,
        timer: 1500
        }).then(() => { 
         window.history.back()
        });
        </script>";
    } else {
      $query = "SELECT  student.* FROM student WHERE student.s_user='$s_user' and (student.s_fna='$s_fna' and student.s_lna='$s_lna') and s_id != '$s_id'";
      $result = mysqli_query($conn, $query);
      $total = mysqli_num_rows($result);
      if ($total != 0) {
        echo "<script>Swal.fire({
          type: 'error',
          title: 'ข้อมูลนี้มีอยู่แล้ว',
          showConfirmButton: true,
          timer: 1500
          }).then(() => { 
            window.history.back()
          });
          </script>";
      } else {
        $id = substr($s_id, 0, 2);
        $query = "SELECT teacher.t_id,teacher.t_fna,teacher.t_lna
        from  advisor
        LEFT JOIN student ON advisor.s_id = student.s_id
        LEFT JOIN teacher ON advisor.t_id = teacher.t_id
        LEFT JOIN branch ON branch.br_id = student.br_id
        WHERE advisor.t_id != '0' and student.br_id = '$br_id' and student.s_group = '$s_group' and student.s_id LIKE '$id%' GROUP BY advisor.t_id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        $total = mysqli_num_rows($result);
        $query = "UPDATE student set s_tna='$s_tna',s_fna='$s_fna',s_lna='$s_lna',br_id='$br_id',s_group='$s_group',s_user='$s_user',s_pass='$s_pass'WHERE s_id = '$s_id'";
        $result = mysqli_query($conn, $query);
        // if ($total != 0) {
        //   $query = "UPDATE student SET t_id ='$row[t_id]' WHERE s_id = '$s_id' and br_id='$br_id'";
        //   $result = mysqli_query($conn, $query);
        // } else {
        //   $query = "UPDATE student SET t_id ='0' WHERE s_id = '$s_id' and br_id='$br_id'";
        //   $result = mysqli_query($conn, $query);
        //   // $query = "INSERT INTO advisor (s_id,t_id,br_id) VALUES ('$s_id','0','$br_id')";
        //   // $result = mysqli_query($conn, $query);
        // }
        echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 3000
          }).then(() => { 
            window.location = 'index.php?id=$br_id&year=$year'
            });
          </script>";
      }
    }
  }
  //  
  //**************************************DELETE*********************************************************** */
  if (isset($_POST['btndelect'])) {
    $s_id = $_POST['s_id'];
    $br_id = $_POST['br_id'];
    $year = $_POST['year'];
    $query = "DELETE FROM student WHERE s_id = '$s_id'";
    mysqli_query($conn, $query);
    $query = "DELETE FROM parent WHERE s_id = '$s_id'";
    mysqli_query($conn, $query);
    $query = "DELETE FROM supervision WHERE s_id = '$s_id'";
    mysqli_query($conn, $query);
    echo "<script>Swal.fire({
    type: 'success',
    title: 'ลบข้อมูลเรียบร้อย',
    showConfirmButton: true,
    timer: 1500
    }).then(() => { 
      window.location = 'index.php?id=$br_id&year=$year'
    });
    </script>";
  }
  //**************************************UPDATEME*********************************************************** */
  if (isset($_POST['btneditme'])) {
    $s_id = $_POST['s_id']; //ห้ามซ้ำ
    $s_pass = $_POST['s_pass'];
    $s_bdate = $_POST['s_bdate'];
    $s_age = $_POST['s_age'];
    $s_tel = $_POST['s_tel'];
    $s_mail = $_POST['s_mail'];
    $s_height = $_POST['s_height'];
    $s_weight = $_POST['s_weight'];
    $s_race = $_POST['s_race'];
    $s_cult = $_POST['s_cult'];
    $s_nation = $_POST['s_nation'];
    $s_lbood = $_POST['s_lbood'];
    $s_points = $_POST['s_points'];
    $s_disease = $_POST['s_disease'];
    $s_drug = $_POST['s_drug'];
    $s_ability1 = $_POST['s_ability1'];
    $s_ability2 = $_POST['s_ability2'];
    $s_ability3 = $_POST['s_ability3'];
    $s_No1 = $_POST['s_No1'];
    $s_village1 = $_POST['s_village1'];
    $s_road1 = $_POST['s_road1'];
    $s_No2 = $_POST['s_No2'];
    $s_village2 = $_POST['s_village2'];
    $s_road2 = $_POST['s_road2'];
    $s_frina = $_POST['s_frina'];
    $s_friadd = $_POST['s_friadd'];
    $s_ftel = $_POST['s_ftel'];
    $district_id3 = $_POST['districts3'];
    $district_id1 = $_POST['districts'];
    $district_id2 = $_POST['districts2'];


    if ((empty($s_id)) || (empty($s_pass)) || (empty($s_bdate)) || (empty($s_age)) || (empty($s_tel)) || (empty($s_mail)) || (empty($s_height))
      || (empty($s_weight)) || (empty($s_race)) || (empty($s_cult)) || (empty($s_nation)) || (empty($s_lbood)) || (empty($s_points)) || (empty($s_disease))
      || (empty($s_drug)) || (empty($s_No1)) || (empty($s_village1)) || (empty($s_road1)) || (empty($s_No2)) || (empty($s_village2))
      || (empty($s_road2))
    ) {
      $msg = "";
      if (!$s_id) $msg = $msg . " รหัสนักศึกษา";
      if (!$s_pass) $msg = $msg . " Password";
      if (!$s_bdate) $msg = $msg . " วันเกิด";
      if (!$s_age) $msg = $msg . " อายุ";
      if (!$s_tel) $msg = $msg . " เบอร์โทร";
      if (!$s_mail) $msg = $msg . " อีเมล";
      if (!$s_height) $msg = $msg . " ส่วนสูง";
      if (!$s_weight) $msg = $msg . " น้ำหนัก";
      if (!$s_race) $msg = $msg . " เชื้อชาติ";
      if (!$s_cult) $msg = $msg . " ศาสนา";
      if (!$s_nation) $msg = $msg . " สัญชาติ";
      if (!$s_points) $msg = $msg . " คะแนนสะสม";
      if (!$s_disease) $msg = $msg . " โรคประจำตัว ";
      if (!$s_drug) $msg = $msg . " ยาที่แพ้ ";
      if (!$s_No1) $msg = $msg . " บ้านเลขที่ ";
      if (!$s_village1) $msg = $msg . " หมู่";
      if (!$s_road1) $msg = $msg . " ถนน";
      if (!$s_No2) $msg = $msg . " บ้านเลขที่";
      if (!$s_village2) $msg = $msg . " หมู่";
      if (!$s_road2) $msg = $msg . " ถนน";
      echo "<script>Swal.fire({
			type: 'error',
			title: 'กรุณาใส่{$msg}',
			showConfirmButton: true,
			timer: 1500
		  }).then(() => { 
			 window.history.back()
			});
		  </script>";
    }
    if ($s_age < 18) {
      echo "<script>Swal.fire({
        type: 'error',
        title: 'กรุณาตรวจสอบวันเกิด และอายุ!!',
        showConfirmButton: true,
        timer: 1500
        }).then(() => { 
         window.history.back()
        });
        </script>";
    }
    if ((empty($district_id1)) || (empty($district_id2)) || (empty($district_id3))) {
      //if ((empty($s_lbood)) || (empty($district_id1)) || (empty($district_id2)) || (empty($district_id3))) {
      $msg = "";
      //if (!$s_tna) $msg = $msg . " คำนำหน้า";
      //if (!$s_lbood) $msg = $msg . " กรุ๊ปเลือด";
      if (!$district_id1) $msg = $msg . " ภูมิลำเนาเดิม";
      if (!$district_id2) $msg = $msg . " ที่อยู่ปัจจุบัน";
      if (!$district_id3) $msg = $msg . " ที่อยู่เพื่อนสนิด";
      echo "<script>Swal.fire({
        type: 'error',
        title: 'กรุณาเลือก{$msg}',
        showConfirmButton: true,
        timer: 1500
        }).then(() => { 
         window.history.back()
        });
        </script>";
    } else {
      $query = "SELECT  student.s_pass FROM student WHERE s_id = '$s_id'";
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_array($result);
      if ($row['s_pass'] != $s_pass) {
        $query = "UPDATE student set s_pass='$s_pass',s_bdate='$s_bdate',s_age='$s_age',s_tel='$s_tel',s_mail='$s_mail',
        s_height='$s_height',s_weight='$s_weight',s_race='$s_race',s_cult='$s_cult',s_nation='$s_nation'
        ,s_lbood='$s_lbood',s_points='$s_points',s_disease='$s_disease',s_drug='$s_drug',
        s_ability1='$s_ability1',s_ability2='$s_ability2',s_ability3='$s_ability3',s_No1='$s_No1'
        ,s_village1='$s_village1',s_road1='$s_road1',s_No2='$s_No2',s_village2='$s_village2',s_road2='$s_road2'
        ,s_frina='$s_frina',s_friadd='$s_friadd',s_ftel='$s_ftel',district_id3='$district_id3',district_id1='$district_id1'
        ,district_id2='$district_id2' WHERE s_id = '$s_id'";
        mysqli_query($conn, $query);
        echo "<script>Swal.fire({
          type: 'success',
          title: 'บันทึกข้อมูลเรียบร้อย',
          showConfirmButton: true,
          timer: 1500
        }).then(() => { 
          window.location = '$baseURL/logoutstd.php'
          });
        </script>";
      } else {
        $query = "UPDATE student set s_bdate='$s_bdate',s_age='$s_age',s_tel='$s_tel',s_mail='$s_mail',
        s_height='$s_height',s_weight='$s_weight',s_race='$s_race',s_cult='$s_cult',s_nation='$s_nation'
        ,s_lbood='$s_lbood',s_points='$s_points',s_disease='$s_disease',s_drug='$s_drug',
        s_ability1='$s_ability1',s_ability2='$s_ability2',s_ability3='$s_ability3',s_No1='$s_No1'
        ,s_village1='$s_village1',s_road1='$s_road1',s_No2='$s_No2',s_village2='$s_village2',s_road2='$s_road2'
        ,s_frina='$s_frina',s_friadd='$s_friadd',s_ftel='$s_ftel',district_id3='$district_id3',district_id1='$district_id1'
        ,district_id2='$district_id2' WHERE s_id = '$s_id'";
        mysqli_query($conn, $query);
        echo "<script>Swal.fire({
          type: 'success',
          title: 'บันทึกข้อมูลเรียบร้อย',
          showConfirmButton: true,
          timer: 1500
        }).then(() => { 
          window.location = '$baseURL/views/student/indexme.php?s_id=$s_id'
          });
        </script>";
      }
    }
  }

  //
  ?>
  <?php include("../../scr.php"); ?>
</body>

</html>