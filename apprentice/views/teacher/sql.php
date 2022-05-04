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
  if (isset($_POST['btnsave'])) {
    $t_user = $_POST['t_user']; //ห้ามซ้ำ
    $t_pass = $_POST['t_pass'];
    $type = $_POST['type'];
    $t_tna = $_POST['t_tna'];
    $t_fna = $_POST['t_fna'];
    $t_lna = $_POST['t_lna'];
    $t_add = $_POST['t_add'];
    $t_tel = $_POST['t_tel'];
    $t_mail = $_POST['t_mail'];
    $t_date = $_POST['t_date'];
    $dp_id = $_POST['dp_id'] ? intval($_POST['dp_id']) : '0';
    $p_id = $_POST['p_id'] ? intval($_POST['p_id']) : '0';
    $districts = $_POST['districts'] ? intval($_POST['districts']) : '0';

    $fileupload = $_FILES['preview']['tmp_name'];
    $fileupload_name = uniqid() . '_' . $_FILES['preview']['name'];


    if ((empty($t_user)) || (empty($t_pass)) || (empty($t_fna)) || (empty($t_lna)) || (empty($dp_id)) || (empty($p_id))) {
      $msg = "";
      if (!$t_user) $msg = $msg . " Username";
      if (!$t_pass) $msg = $msg . " Password";
      if (!$t_fna) $msg = $msg . " ชื่อ";
      if (!$t_lna) $msg = $msg . " นามสกุล";
      if (!$dp_id) $msg = $msg . " แผนก";
      if (!$p_id) $msg = $msg . " ตำแหน่ง";
      echo "<script>Swal.fire({
			type: 'error',
			title: 'กรุณาใส่{$msg}',
			showConfirmButton: true,
			timer: 1500
		  }).then(() => { 
			 window.history.back()
			});
		  </script>";
    } else {
      $query = "SELECT teacher.* FROM teacher
                WHERE  (teacher.t_user='$t_user' or teacher.t_fna='$t_fna' and  teacher.t_lna='$t_lna')
                and (teacher.t_id !='$t_id')";
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
        //เซ็ครูปภาพ
        if ($fileupload != "") {
          copy($fileupload, "../../picture/" . $fileupload_name);
          //เงื่อนไข INSERT INTO ตารางที่1-----
          //if เงื่อนไขเพิ่มข้อมูลแแบบ--มีรูปภาพ
          $query = "INSERT INTO teacher(t_tna,t_fna,t_lna,t_tel,t_mail,t_add,t_pic,t_date,t_user,t_pass,type,dp_id,p_id,district_id)VALUES ('$t_tna','$t_fna','$t_lna','$t_tel','$t_mail','$t_add','$fileupload_name','$t_date','$t_user','$t_pass','$type','$dp_id','$p_id','$districts')";
          //echo "บันทึก";
        } //else เงื่อนไขเพิ่มข้อมูลแแบบ--ไม่มีรูปภาพ
        else {
          $query = "INSERT INTO teacher(t_tna,t_fna,t_lna,t_tel,t_mail,t_add,t_date,t_user,t_pass,type,dp_id,p_id,district_id)VALUES ('$t_tna','$t_fna','$t_lna','$t_tel','$t_mail','$t_add','$t_date','$t_user','$t_pass','$type','$dp_id','$p_id','$districts')";
        }
        mysqli_query($conn, $query);
        echo "<script>Swal.fire({
            type: 'success',
            title: 'บันทึกข้อมูลเรียบร้อย',
            showConfirmButton: true,
            timer: 1500
          }).then(() => { 
            window.location = 'index.php'
            });
          </script>";
      }
    }
  }
  //
  //**************************************UPDATE*********************************************************** */
  if (isset($_POST['btnedit'])) {
    $t_id = $_POST['t_id'];
    $t_user = $_POST['t_user']; //ห้ามซ้ำ
    $t_pass = $_POST['t_pass'];
    $type = $_POST['type'];
    $t_tna = $_POST['t_tna'];
    $t_fna = $_POST['t_fna'];
    $t_lna = $_POST['t_lna'];
    $t_add = $_POST['t_add'];
    $t_tel = $_POST['t_tel'];
    $t_mail = $_POST['t_mail'];
    $t_date = $_POST['t_date'];
    $t_pic = $_POST['t_pic'];
    $dp_id = $_POST['dp_id'] ? intval($_POST['dp_id']) : '0';
    $p_id = $_POST['p_id'] ? intval($_POST['p_id']) : '0';
    $districts = $_POST['districts'] ? intval($_POST['districts']) : '0';

    $fileupload = $_FILES['preview']['tmp_name'];
    $fileupload_name = uniqid() . '_' . $_FILES['preview']['name'];

    if ((empty($t_user)) && (empty($t_pass)) && (empty($t_fna)) && (empty($t_lna))) {
      $msg = "";
      if (!$t_user) $msg = $msg . " Username";
      if (!$t_pass) $msg = $msg . " Password";
      if (!$t_fna) $msg = $msg . " ชื่อ";
      if (!$t_lna) $msg = $msg . " นามสกุล";
      echo "<script>Swal.fire({
			type: 'error',
			title: 'กรุณาใส่{$msg}',
			showConfirmButton: true,
			timer: 1500
		  }).then(() => { 
			 window.history.back()
			});
		  </script>";
    } else {
      $query = "SELECT teacher.* FROM teacher
                WHERE  (teacher.t_user='$t_user' or teacher.t_fna='$t_fna' and  teacher.t_lna='$t_lna')
                and (teacher.t_id !='$t_id')";
      $result = mysqli_query($conn, $query);
      $total = mysqli_num_rows($result);
      if ($total != 0) {
        echo "<script>Swal.fire({
          type: 'error',
          title: 'มีคนใช้ username นี้แล้ว',
          showConfirmButton: true,
          timer: 1500
          }).then(() => { 
           window.history.back()
          });
          </script>";
      } else {
        //เซ็ครูปภาพ
        if ($fileupload != "") {
          if ($t_pic != "") {
            unlink("../../picture/$t_pic");
          }
          copy($fileupload, "../../picture/" . $fileupload_name);
          //เงื่อนไข INSERT INTO ตารางที่1-----
          //if เงื่อนไขเพิ่มข้อมูลแแบบ--มีรูปภาพ
          $query = "UPDATE teacher set t_tna='$t_tna',t_fna='$t_fna',t_lna='$t_lna',t_tel='$t_tel',t_mail='$t_mail',t_add='$t_add',t_pic='$fileupload_name',t_date='$t_date',t_user='$t_user',t_pass='$t_pass',type='$type',dp_id='$dp_id',p_id='$p_id',district_id='$districts' WHERE t_id = '$t_id'";
          mysqli_query($conn, $query);
          //echo "บันทึก";
        } //else เงื่อนไขเพิ่มข้อมูลแแบบ--ไม่มีรูปภาพ
        else {
          $query = "UPDATE teacher set t_tna='$t_tna',t_fna='$t_fna',t_lna='$t_lna',t_tel='$t_tel',t_mail='$t_mail',t_add='$t_add',t_date='$t_date',t_user='$t_user',t_pass='$t_pass',type='$type',dp_id='$dp_id',p_id='$p_id',district_id='$districts' WHERE t_id = '$t_id'";
          mysqli_query($conn, $query);
        }
        //$query = "INSERT INTO provinces (provinces_name_th,geo_id) VALUES ('$provinces_name_th','$geo_id')";
        mysqli_query($conn, $query);
        echo "<script>Swal.fire({
          type: 'success',
          title: 'บันทึกข้อมูลเรียบร้อย',
          showConfirmButton: true,
          timer: 1500
        }).then(() => { 
          window.location = 'index.php' 
          });
        </script>";
      }
    }
  }
  //   
  //**************************************DELETE*********************************************************** */
  if (isset($_POST['btndelect'])) {
    $t_id = $_POST['t_id'];
    $query = "DELETE FROM teacher WHERE t_id = '$t_id'";
    mysqli_query($conn, $query);
    echo "<script>Swal.fire({
    type: 'success',
    title: 'ลบข้อมูลเรียบร้อย',
    showConfirmButton: true,
    timer: 1500
    }).then(() => { 
      window.location = 'index.php'
    });
    </script>";
  }
  //**************************************EDITME*********************************************************** */
  if (isset($_POST['btneditme'])) {
    $t_id = $_POST['t_id'];
    $t_user = $_POST['t_user']; //ห้ามซ้ำ
    $t_pass = $_POST['t_pass'];
    $type = $_POST['type'];
    $t_tna = $_POST['t_tna'];
    $t_fna = $_POST['t_fna'];
    $t_lna = $_POST['t_lna'];
    $t_add = $_POST['t_add'];
    $t_tel = $_POST['t_tel'];
    $t_mail = $_POST['t_mail'];
    $t_date = $_POST['t_date'];
    $t_pic = $_POST['t_pic'];
    $dp_id = $_POST['dp_id'] ? intval($_POST['dp_id']) : '0';
    $p_id = $_POST['p_id'] ? intval($_POST['p_id']) : '0';
    $districts = $_POST['districts'] ? intval($_POST['districts']) : '0';

    $fileupload = $_FILES['preview']['tmp_name'];
    $fileupload_name = uniqid() . '_' . $_FILES['preview']['name'];

    if ((empty($t_user)) && (empty($t_pass)) && (empty($t_fna)) && (empty($t_lna))) {
      $msg = "";
      if (!$t_user) $msg = $msg . " Username";
      if (!$t_pass) $msg = $msg . " Password";
      if (!$t_fna) $msg = $msg . " ชื่อ";
      if (!$t_lna) $msg = $msg . " นามสกุล";
      echo "<script>Swal.fire({
			type: 'error',
			title: 'กรุณาใส่{$msg}',
			showConfirmButton: true,
			timer: 1500
		  }).then(() => { 
			 window.history.back()
			});
		  </script>";
    } else {
      $query = "SELECT teacher.* FROM teacher
                 WHERE teacher.t_user='$t_user' and  (teacher.t_fna='$t_fna' and  teacher.t_lna='$t_lna')
                and (teacher.t_id !='$t_id')";
      $result = mysqli_query($conn, $query);
      $total = mysqli_num_rows($result);
      if ($total != 0) {
        echo "<script>Swal.fire({
          type: 'error',
          title: 'มีคนใช้ username นี้แล้ว',
          showConfirmButton: true,
          timer: 1500
          }).then(() => { 
           window.history.back()
          });
          </script>";
      } else {
        $query = "SELECT  teacher.t_pass FROM teacher WHERE t_id = '$t_id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        if ($row['t_pass'] != $t_pass) {
          //เซ็ครูปภาพ
          if ($fileupload != "") {
            if ($t_pic != "") {
              unlink("../../picture/$t_pic");
            }
            copy($fileupload, "../../picture/" . $fileupload_name);
            $query = "UPDATE teacher set t_tna='$t_tna',t_fna='$t_fna',t_lna='$t_lna',t_tel='$t_tel',t_mail='$t_mail',t_add='$t_add',t_pic='$fileupload_name',t_date='$t_date',t_user='$t_user',t_pass='$t_pass',dp_id='$dp_id',p_id='$p_id',district_id='$districts' WHERE t_id = '$t_id'";
            mysqli_query($conn, $query);
          } else {
            $query = "UPDATE teacher set t_tna='$t_tna',t_fna='$t_fna',t_lna='$t_lna',t_tel='$t_tel',t_mail='$t_mail',t_add='$t_add',t_date='$t_date',t_user='$t_user',t_pass='$t_pass',dp_id='$dp_id',p_id='$p_id',district_id='$districts' WHERE t_id = '$t_id'";
            mysqli_query($conn, $query);
          }
          //mysqli_query($conn, $query);
          echo "<script>Swal.fire({
          type: 'success',
          title: 'บันทึกข้อมูลเรียบร้อย',
          showConfirmButton: true,
          timer: 1500
          }).then(() => { 
            window.location = '$baseURL/logoutteac.php'
            });
          </script>";
        } else {
          //เซ็ครูปภาพ
          if ($fileupload != "") {
            if ($t_pic != "") {
              unlink("../../picture/$t_pic");
            }
            copy($fileupload, "../../picture/" . $fileupload_name);
            $query = "UPDATE teacher set t_tna='$t_tna',t_fna='$t_fna',t_lna='$t_lna',t_tel='$t_tel',t_mail='$t_mail',t_add='$t_add',t_pic='$fileupload_name',t_date='$t_date',t_user='$t_user',dp_id='$dp_id',p_id='$p_id',district_id='$districts' WHERE t_id = '$t_id'";
            mysqli_query($conn, $query);
          } else {
            $query = "UPDATE teacher set t_tna='$t_tna',t_fna='$t_fna',t_lna='$t_lna',t_tel='$t_tel',t_mail='$t_mail',t_add='$t_add',t_date='$t_date',t_user='$t_user',t_pass='$t_pass',dp_id='$dp_id',p_id='$p_id',district_id='$districts' WHERE t_id = '$t_id'";
            mysqli_query($conn, $query);
          }
          //mysqli_query($conn, $query);
          echo "<script>Swal.fire({
          type: 'success',
          title: 'บันทึกข้อมูลเรียบร้อย',
          showConfirmButton: true,
          timer: 1500
        }).then(() => { 
          window.location = '$baseURL/views/teacher/indexme.php?t_id=$t_id'
          });
        </script>";
        }
      }
    }
  }
  //

  ?>
  <?php include("../../scr.php"); ?>
</body>

</html>