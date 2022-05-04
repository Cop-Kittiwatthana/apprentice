<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
  include("../../connect.php");
  $username = $_SESSION["username"];
  $password = $_SESSION["password"];
  $status = $_SESSION["status"];

  $id = $_POST['id'];
  $s_group = $_POST['s_group'];
  $br_id = $_POST['br_id'];


?>
  <!DOCTYPE html>
  <html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/brand.png">
    <title>ข้อมูลความต้องการ</title>

    <?php include("../../head.php"); ?>
    <link rel="stylesheet" href="../../dist/css/choices.min.css">
    <script src="../../dist/js/choices.min.js"></script>
  </head>

  <body id="page-top">

    <div id="wrapper">
      <?php include("../../sidebar_login.php"); ?>
      <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
          <?php include("../../menu_login.php"); ?>
          <div class="container-fluid">
            <ol class="breadcrumb mb-4">
              <!-- <li class="breadcrumb-item"><a href="indexsup.php">จัดการข้อมูลอาจารย์ที่ปรึกษา</a></li>
              <li class="breadcrumb-item"><a href="index.php?id=<?= $br_id ?>">ข้อมูลอาจารย์ที่ปรึกษา</a></li> -->
              <li class="breadcrumb-item active">ข้อมูลอาจารย์ทีปรึกษาซ้ำ</li>
            </ol>
          </div>
          <br>
          <div class="text-center">
            <h4 class="text-dark"><i class="fas fa-plus"></i> ตรวจเช็คข้อมูลอาจารย์ทีปรึกษาซ้ำ</h4>
          </div>
          <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
            <div class="container text-dark " style="width: 60%; height: auto;">
              <input type=hidden name="id" id="id" value="<?= $id ?>">
              <input type=hidden name="s_group" id="s_group" value="<?= $s_group ?>">
              <input type=hidden name="br_id" id="br_id" value="<?= $br_id ?>">
              <br>
              <tr>
                <div class="card-body" style="background-color: white;">
                  <div class="table-responsive">
                    <table class="table table-bordered text-dark" style="width: 100%;" align="center">
                      <thead>
                        <tr align="center">
                          <th style="background-color: #eaecf4;">ชื่อนามสกุล</th>
                          <th style="background-color: #eaecf4;">ห้อง</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $t_id = $_POST['t_id']; //ห้ามซ้ำ
                        if ($t_id != "") {
                          foreach ($t_id as $t) {
                            $query = "SELECT student.s_group,branch.br_na,teacher.t_id,teacher.t_fna,teacher.t_lna,'ture' as status,
                            SUBSTR(student.s_id,1,2) As id FROM advisor 
                                      LEFT JOIN student on advisor.s_id = student.s_id
                                      LEFT JOIN teacher on advisor.t_id = teacher.t_id
                                      LEFT JOIN branch on student.br_id = branch.br_id
                                      WHERE advisor.t_id = '$t' GROUP BY student.s_group,id";
                            $result = mysqli_query($conn, $query);
                            $total = mysqli_num_rows($result);
                            if ($total != 0) {
                              while ($row1 = mysqli_fetch_array($result)) {
                                if ($row1['id'] != $id && $row1['s_group'] != $s_group) {
                        ?>
                                  <tr>
                                    <td style="text-align: center;"> <?php echo "$row1[t_fna]"; ?> <?php echo "$row1[t_lna]"; ?></td>
                                    <td> <?php echo "$row1[id]"; ?>/<?php echo "$row1[s_group]"; ?></td>
                                  </tr>
                                <?php
                                }
                              }
                            } else {
                            $query2 = "SELECT teacher.t_id,teacher.t_fna,teacher.t_lna FROM teacher 
                                      WHERE teacher.t_id = '$t'";
                              $result2 = mysqli_query($conn, $query2);
                              while ($row2 = mysqli_fetch_array($result2)) { ?>
                                <tr>
                                  <td style="text-align: center;"> <?php echo "$row2[t_fna]"; ?> <?php echo "$row2[t_lna]"; ?></td>
                                  <td>(ไม่ซ้ำ)</td>
                                </tr>
                        <?php }
                            }
                          }
                        }
                        ?>
                        <?php
                        $t_id = $_POST['t_id']; //ห้ามซ้ำ
                        if ($t_id != "") {
                          foreach ($t_id as $t1) {
                            // echo $t1;
                            $query3 = "SELECT teacher.* FROM teacher  WHERE t_id = '$t1' GROUP BY t_id";
                            $result3 = mysqli_query($conn, $query3);
                            $total3 = mysqli_num_rows($result3);
                            if ($total3 != 0) {
                              while ($row3 = mysqli_fetch_array($result3)) {
                        ?>
                                <input type=hidden name="t_id[]" id="t_id" value="<?= $row3['t_id'] ?>">
                        <?php
                              }
                            }
                          }
                        }
                        ?>
                        <?php
                        $s_id = $_POST['s_id']; //ห้ามซ้ำ
                        if ($s_id != "") {
                          foreach ($s_id as $s) {
                            // echo $s;
                            $query1 = "SELECT student.* FROM student  WHERE s_id = '$s' GROUP BY s_id";
                            $result1 = mysqli_query($conn, $query1);
                            $total1 = mysqli_num_rows($result1);
                            if ($total1 != 0) {
                              while ($row2 = mysqli_fetch_array($result1)) {
                        ?>
                                <input type=hidden name="s_id[]" id="s_id" value="<?= $row2['s_id'] ?>">
                        <?php
                              }
                            }
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </tr>
              <br>
              <br>
              <div class="footer d-flex justify-content-center">
                <!-- <button class="btn btn-success btn-lg" type="submit" name="btnedit" id="btnedit" value="บันทึก">บันทึก</button>&nbsp; -->
                <button class="btn btn-success btn-lg" type="submit" name="btnedit" id="btnedit" value="บันทึก">บันทึก</button>&nbsp;
                <button class="btn btn-danger btn-lg" type="reset" name="btnCancel" onclick="gohome()" value="ยกเลิก">ยกเลิก</button>
                <!-- <button class="btn btn-danger" type="reset" onclick="window.history.back()" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button> -->
              </div>
            </div>
          </form>
        </div>
        <?php include("../../footer.php"); ?>
      </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <?php include("../../logoutmenu.php"); ?>
  </body>

  </html>
  <script>
    function gohome() {
      document.location.href = 'edit.php?id=<?= $id ?>&s_group=<?= $s_group ?>&br_id=<?= $br_id ?>';
    }
  </script>
<?php
} else {
  echo ("<script> alert('please login'); window.location='../../index.php';</script>");
  exit();
}
?>