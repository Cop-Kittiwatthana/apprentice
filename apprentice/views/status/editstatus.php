<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0' &&  $_SESSION["type"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $c_id = $_GET['c_id'];
    $de_id = $_GET['de_id'];
    $s_id = $_GET['s_id'];
    $pe_id = $_GET['pe_id'];
    $query = "SELECT petition.*,student.*,company.*,demand.*
    FROM petition 
    LEFT JOIN student ON student.s_id  = petition.s_id  
    LEFT JOIN demand ON petition.de_id  = demand.de_id  
    LEFT JOIN company ON demand.c_id  = company.c_id  
    WHERE student.s_id= '$s_id' and company.c_id = '$c_id' and petition.pe_id = '$pe_id'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {
        $c_na = "$row[c_na]";
        $s_fna = "$row[s_fna]";
        $s_lna = "$row[s_lna]";
        $pe_id = "$row[pe_id]";
        $pe_term = "$row[pe_term]";
        $pe_semester = "$row[pe_semester]";
        $pe_date1 = "$row[pe_date1]";
        $pe_date2 = "$row[pe_date2]";
        $pe_status = "$row[pe_status]";
        $s_mail = "$row[s_mail]";
        $note = "$row[note]";
        $num = "$row[num]";
        $de_id = "$row[de_id]";
    }

    // $date = date("d-m-Y");
    // // $de_day = date('d', strtotime($i . 'd'));
    // // $de_month = date('m', strtotime($i . 'm'));
    // // $de_year = date('Y', strtotime($i . 'year'));
    // for ($i = 0; $i < 3; $i++) {
    //     $de_year1 = date('Y', strtotime($i . 'year'));
    // }

    // $query = "SELECT COUNT(s_id)as totalsum FROM petition WHERE s_id = '$s_id'";
    // $result = mysqli_query($conn, $query) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    // while ($row = mysqli_fetch_array($result)) {
    //   echo  $totalsum = "$row[totalsum]";
    // }


    $query_branch = "SELECT department.*,branch.* FROM department inner JOIN branch ON department.dp_id = branch.dp_id";
    $result_branch = mysqli_query($conn, $query_branch);
    $id = $_GET['id'];
    if ($id == 0) {
        $hname = "คำร้องรอการตรวจสอบ";
    }
    if ($id == 1) {
        $hname = "ตรวจสอบแล้ว";
    }
    if ($id == 2) {
        $hname = "สถานประกอบการตอบรับ";
    }
    if ($id == 3) {
        $hname = "สถานประกอบการปฏิเสธ";
    }
    if ($id == 5) {
        $hname = "กำลังออกฝึก";
    }
    if ($id == 6) {
        $hname = "เสร็จสิ้นการฝึกงานเทอม1";
    }
    if ($id == 7) {
        $hname = "เปลี่ยนสถานที่ฝึก";
    }
    if ($id == 8) {
        $hname = "เสร็จสิ้นการฝึกงาน";
    }

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
        <title>จัดการสถานะการฝึก</title>

        <?php include("../../head.php"); ?>
        <style>
            input[type="radio"] {
                -ms-transform: scale(1.5);
                /* IE 9 */
                -webkit-transform: scale(1.5);
                /* Chrome, Safari, Opera */
                transform: scale(1.5);
            }
        </style>
    </head>

    <body id="page-top">

        <div id="wrapper">
            <?php include("../../sidebar_login.php"); ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php"); ?>
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="indexstatus.php?id=<?= $id ?>&year=<?= $pe_semester ?>">รายงานสถานะ<?= $hname ?></a></li>
                            <li class="breadcrumb-item active">จัดการสถานะการฝึก</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> จัดการสถานะการฝึก</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <input type=hidden name="c_id" id="c_id" value="<?= $c_id ?>">
                            <input type=hidden name="s_id" id="s_id" value="<?= $s_id ?>">
                            <input type=hidden name="pe_id" id="pe_id" value="<?= $pe_id ?>">
                            <input type=hidden name="de_id" id="de_id" value="<?= $de_id ?>">
                            <input type=hidden name="num" id="num" value="<?= $num ?>">
                            <input type=hidden name="s_mail" id="s_mail" value="<?= $s_mail ?>">
                            <!-- <input type=hidden name="totalsum" id="totalsum" value="<?= $totalsum ?>"> -->
                            <input type=hidden name="pe_semester" id="pe_semester" value="<?= $pe_semester ?>">
                            <input type=hidden name="id" id="id" value="<?= $id ?>">
                            <input type=hidden name="pe_term" id="pe_term" value="<?= $pe_term ?>">
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>รหัสคำร้อง :</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="pe_id" id="pe_id" value="<?= $pe_id ?>" class="form-control" type="text" readonly>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-6">
                                        <th>สถานประกอบการ :</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="c_na" id="c_na" value="<?= $c_na ?>" class="form-control" type="text" readonly>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <th>รหัสนักศึกษา :</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="s_id" id="s_id" value="<?= $s_id ?>" class="form-control" type="text" readonly>
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-8">
                                        <th>ชื่อ-นามสกุล :</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="s_na" id="s_na" value="<?= $s_fna ?>&nbsp;<?= $s_lna ?>" class="form-control" type="text" readonly>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                        </div>
                        <div class="container text-dark " style="width: 80%; height: 60%;">
                            <tr>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-bordered " style="width: 90%;height: 100px;" align="center">
                                                    <thead>
                                                        <tr align="center">
                                                            <th style="background-color: #f8f9fc;">#</th>
                                                            <th style="background-color: #f8f9fc;">เอกสาร</th>
                                                            <th style="background-color: #f8f9fc;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr align="center">
                                                            <th>1</th>
                                                            <th>คำร้องขอฝึก</th>
                                                            <th><a href="<?= $baseURL; ?>/views/mpdf/indexpdf.php?s_id=<?= $s_id ?>&pe_id=<?= $pe_id ?>&id=1<?= $id ?>">
                                                                    <span class="btn btn-primary btn-sm fas fa-eye"></a></th>
                                                        </tr>
                                                        <tr align="center">
                                                            <th>2</th>
                                                            <th>คำขออนุญาติผู้ปกครอง</th>
                                                            <th><a href="<?= $baseURL; ?>/views/mpdf/indexpdf.php?s_id=<?= $s_id ?>&pe_id=<?= $pe_id ?>&id=2<?= $id ?>">
                                                                    <span class="btn btn-primary btn-sm fas fa-eye "></a></th>
                                                        </tr>
                                                        <tr align="center">
                                                            <th>3</th>
                                                            <th>สัญญาฝึกที่1</th>
                                                            <th><a href="<?= $baseURL; ?>/views/mpdf/indexpdf.php?s_id=<?= $s_id ?>&pe_id=<?= $pe_id ?>&id=3<?= $id ?>">
                                                                    <span class="btn btn-primary btn-sm fas fa-eye "></a></th>
                                                        </tr>
                                                        <tr align="center">
                                                            <th>4</th>
                                                            <th>สัญญาฝึกที่2</th>
                                                            <th><a href="<?= $baseURL; ?>/views/mpdf/indexpdf.php?s_id=<?= $s_id ?>&pe_id=<?= $pe_id ?>&id=4<?= $id ?>">
                                                                    <span class="btn btn-primary btn-sm fas fa-eye "></i></a></th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-check">
                                                            <input <?php echo ($pe_status == '1' || $pe_status == '0') ? 'checked' : '' ?> class="form-check-input" type="radio" name="pe_status" onclick="hiddenn('1')" id="pe_status1" value="1" <?php if ($pe_status == 1 || $pe_status == 2 || $pe_status == 5 || $pe_status == 6 || $pe_status == 7 || $pe_status == 8 || $pe_status == 10 || $pe_status == 11) { ?> disabled="disabled" <?php } ?>>
                                                            <label class="form-check-label" for="exampleRadios1">
                                                                &nbsp;ตรวจสอบแล้ว
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-check">
                                                            <input <?php echo ($pe_status == '4') ? 'checked' : '' ?> class="form-check-input" type="radio" name="pe_status" onclick="hiddenn('0')" id="pe_status4" value="4" <?php if ($pe_status == 1 || $pe_status == 2 || $pe_status == 5 || $pe_status == 6 || $pe_status == 7 || $pe_status == 8 || $pe_status == 10 || $pe_status == 11) { ?> disabled="disabled" <?php } ?>>
                                                            <label class="form-check-label" for="exampleRadios1">
                                                                &nbsp;ข้อมูลไม่ถูกต้อง
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-check">
                                                            <input <?php echo ($pe_status == '2') ? 'checked' : '' ?> class="form-check-input" type="radio" name="pe_status" onclick="hiddenn('1')" id="pe_status2" value="2" <?php if ($pe_status == 0 || $pe_status == 2 || $pe_status == 5 || $pe_status == 6 || $pe_status == 7 || $pe_status == 8 || $pe_status == 10 || $pe_status == 11) { ?> disabled="disabled" <?php } ?>>
                                                            <label class="form-check-label" for="exampleRadios1">
                                                                &nbsp;รับเข้าฝึกงาน
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-check">
                                                            <input <?php echo ($pe_status == '3') ? 'checked' : '' ?> class="form-check-input" type="radio" name="pe_status" onclick="hiddenn('0')" id="pe_status3" value="3" <?php if ($pe_status == 0 || $pe_status == 2 || $pe_status == 5 || $pe_status == 6 || $pe_status == 7 || $pe_status == 8 || $pe_status == 10 || $pe_status == 11) { ?> disabled="disabled" <?php } ?>>
                                                            <label class="form-check-label" for="exampleRadios1">
                                                                &nbsp;ปฏิเสธรับเข้าฝึกงาน
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-check">
                                                            <input <?php echo ($pe_status == '5') ? 'checked' : '' ?> class="form-check-input" type="radio" name="pe_status" onclick="hiddenn('1')" id="pe_status5" value="5" <?php if ($pe_status == 0 || $pe_status == 1 ||  $pe_status == 3 || $pe_status == 4 || $pe_status == 6 || $pe_status == 7 || $pe_status == 8 || $pe_status == 10 || $pe_status == 11) { ?> disabled="disabled" <?php } ?>>
                                                            <label class="form-check-label" for="exampleRadios1">
                                                                &nbsp;กำลังออกฝึก
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-check">
                                                            <input <?php echo ($pe_status == '6') ? 'checked' : '' ?> class="form-check-input" type="radio" name="pe_status" onclick="hiddenn('1')" id="pe_status6" value="6" <?php
                                                                                                                                                                                                                                if ($pe_status != '5') { { ?> disabled="disabled" <?php }
                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                $query = "SELECT * FROM supervision WHERE pe_id= '$pe_id' and (su_term = '1' or su_term = '2' or su_term = '3')  ";
                                                                                                                                                                                                                                                                                $result = mysqli_query($conn, $query)
                                                                                                                                                                                                                                                                                    or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
                                                                                                                                                                                                                                                                                while ($row = mysqli_fetch_array($result)) {
                                                                                                                                                                                                                                                                                    if ($row['su_score'] == "") { ?> disabled="disabled" <?php }
                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                            ?>>
                                                            <label class="form-check-label" for="exampleRadios1">
                                                                &nbsp;ฝึกงานเสร็จสิ้นเทอม1
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $query2 = "SELECT petition.* FROM petition WHERE  s_id = '$s_id' and pe_status = 10";
                                                $result2 = mysqli_query($conn, $query2) or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
                                                while ($row2 = mysqli_fetch_array($result2)) {
                                                    $pe_status2 = "$row2[pe_status]";
                                                }  ?>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-check">
                                                            <input <?php echo ($pe_status == '7') ? 'checked' : '' ?> class="form-check-input" type="radio" name="pe_status" onclick="hiddenn('0')" id="pe_status7" value="7" <?php if ($pe_status == 6 || $pe_status == 7 || $pe_status == 8 || $pe_status == 10 || $pe_status2 == 10 || $pe_status == 11) { { ?> disabled="disabled" <?php }
                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                    $query = "SELECT * FROM supervision WHERE pe_id= '$pe_id' and su_no = '3'";
                                                                                                                                                                                                                                                                                                                                                                                    $result = mysqli_query($conn, $query);
                                                                                                                                                                                                                                                                                                                                                                                    while ($row = mysqli_fetch_array($result)) {
                                                                                                                                                                                                                                                                                                                                                                                        if ($row['su_score'] != "") { ?> disabled="disabled" <?php }
                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                }  ?>>
                                                            <label class="form-check-label" for="exampleRadios1">
                                                                &nbsp;เปลี่ยนสถานที่ฝึกเทอม1
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if ($pe_status2 == 10) { ?>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="form-check">
                                                                <input <?php echo ($pe_status == '10') ? 'checked' : '' ?> class="form-check-input" type="radio" name="pe_status" onclick="hiddenn('0')" id="pe_status10" value="10" <?php if ($pe_status == 8 || $pe_status == 10 || $pe_status == 11) { { ?> disabled="disabled" <?php }
                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                echo  $query = "SELECT * FROM supervision WHERE pe_id= '$pe_id' and su_no = '6'";
                                                                                                                                                                                                                                                                                                                                $result = mysqli_query($conn, $query);
                                                                                                                                                                                                                                                                                                                                while ($row = mysqli_fetch_array($result)) {
                                                                                                                                                                                                                                                                                                                                    if ($row['su_score'] != "") { ?> disabled="disabled" <?php }
                                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                            }  ?>>
                                                                <label class="form-check-label" for="exampleRadios1">
                                                                    &nbsp;เปลี่ยนสถานที่ฝึกเทอม2
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="form-check">
                                                                <input <?php echo ($pe_status == '10') ? 'checked' : '' ?> class="form-check-input" type="radio" name="pe_status" onclick="hiddenn('0')" id="pe_status10" value="10" <?php if ($pe_status == 0 || $pe_status == 1 || $pe_status == 2 || $pe_status == 3 || $pe_status == 4 || $pe_status == 5 || $pe_status == 7 || $pe_status == 8 || $pe_status == 10 || $pe_status == 11) { { ?> disabled="disabled" <?php }
                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo   $query = "SELECT * FROM supervision WHERE pe_id= '$pe_id' and su_no = '6'";
                                                                                                                                                                                                                                                                                                                                                                                                                                                    $result = mysqli_query($conn, $query)
                                                                                                                                                                                                                                                                                                                                                                                                                                                        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
                                                                                                                                                                                                                                                                                                                                                                                                                                                    while ($row = mysqli_fetch_array($result)) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                        if ($row['su_score'] != "") { ?> disabled="disabled" <?php }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                }  ?>>
                                                                <label class="form-check-label" for="exampleRadios1">
                                                                    &nbsp;เปลี่ยนสถานที่ฝึกเทอม2
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input <?php echo ($pe_status == '11') ? 'checked' : '' ?> class="form-check-input" type="radio" name="pe_status" onclick="hiddenn('0')" id="pe_status11" value="11" <?php if ($pe_status == '7' || $pe_status == '8' || $pe_status == '10' || $pe_status == '11') { { ?> disabled="disabled" <?php }
                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                $query = "SELECT * FROM supervision WHERE pe_id= '$pe_id' and (su_no = '3' or su_no = '6')";
                                                                                                                                                                                                                                                                                $result = mysqli_query($conn, $query)
                                                                                                                                                                                                                                                                                    or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
                                                                                                                                                                                                                                                                                while ($row = mysqli_fetch_array($result)) {
                                                                                                                                                                                                                                                                                    if ($row['su_score'] != "") { ?> disabled="disabled" <?php }
                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                            ?>>
                                                    <label class="form-check-label" for="exampleRadios1">
                                                        &nbsp;ยกเลิกการฝึก
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input <?php echo ($pe_status == '8') ? 'checked' : '' ?> class="form-check-input" type="radio" name="pe_status" onclick="hiddenn('1')" id="pe_status8" value="8" <?php if ($pe_status != '6' || $pe_status == '7' || $pe_status == '11') { { ?> disabled="disabled" <?php }
                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                    $query = "SELECT * FROM supervision WHERE pe_id= '$pe_id' and su_no = '6'";
                                                                                                                                                                                                                                                                                                                    $result = mysqli_query($conn, $query)
                                                                                                                                                                                                                                                                                                                        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
                                                                                                                                                                                                                                                                                                                    while ($row = mysqli_fetch_array($result)) {
                                                                                                                                                                                                                                                                                                                        if ($row['su_score'] == "") { ?> disabled="disabled" <?php }
                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                            ?>>
                                                    <label class="form-check-label" for="exampleRadios1">
                                                        &nbsp;ฝึกงานเสร็จสิ้นทั้งหมด
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <th>หมายเหตุ :กรุณาระบุหมายเหตุ</th>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <?php if ($pe_status == 3 || $pe_status == 4 || $pe_status == 7 || $pe_status == 10 || $pe_status == 11) { ?>
                                                            <textarea name="note" id="note" class="form-control" required placeholder="-กรุณาใส่รายละเอียด-" onkeypress="isInputChar(event)" type="text"><?php echo $note ?></textarea>
                                                        <?php } else { ?>
                                                            <textarea disabled name="note" id="note" class="form-control" placeholder="-กรุณาใส่รายละเอียด-" onkeypress="isInputChar(event)" type="text"></textarea>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            <br>
                            <div class="footer d-flex justify-content-center">
                                <button class="btn btn-success btn-lg" type="submit" name="btnedit" id="btnedit" value="บันทึก">บันทึก</button>&nbsp;
                                <button class="btn btn-danger btn-lg" type="reset" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button>
                                <!-- <button class="btn btn-danger" type="reset" onclick="window.history.back()" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button> -->
                            </div>
                        </div>
                    </form>
                </div>
                <?php include("../../footer.php"); ?>
            </div>
        </div>
        <script>
            function hiddenn(pvar) {
                if (pvar == 0) {
                    $("#note").attr("disabled", false);
                    document.getElementById("note").value = "<?php echo $note ?>";
                    //document.getElementById("note").style.display = disabled;
                } else {
                    $("#note").attr("disabled", true);
                    document.getElementById('note').value = null;
                    //document.getElementById("note").style.display = enable;
                }
            }
        </script>
    </body>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <?php include("../../logoutmenu.php"); ?>
    </body>

    </html>
<?php
} else {
    echo "<script> alert('Please Login'); window.location='../../index.php';</script>";
    exit();
}
?>