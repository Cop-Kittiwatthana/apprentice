<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) &&  $_SESSION["status"] == '0') {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];

    $id = $_GET['id'];
    $year = $_GET['year'];
    $query = "SELECT * FROM company WHERE c_id = '$c_id'";
    $result = mysqli_query($conn, $query)
        or die("3. ไม่สามารถประมวลผลคำสั่งได้") . $mysql->error();
    $data = array();
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $c_na = "$row[c_na]";
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
        <title>ข้อมูลการยื่นเรื่องฝึกงาน</title>
        <?php include("../../head.php") ?>
    </head>

    <body id="page-top">
        <div id="wrapper">
            <?php include("../../sidebar_login.php") ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include("../../menu_login.php") ?>
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                            <!-- <li class="breadcrumb-item"><a href="../../indexnews.php">หน้าหลัก</a></li> -->
                            <li class="breadcrumb-item"><a href="indexsup.php">จัดการข้อมูลอาจารย์ที่ปรึกษา</a></li>
                            <li class="breadcrumb-item active">ข้อมูลอาจารย์ทีปรึกษา</li>
                        </ol>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <font size="6" face="TH SarabunPSK"> รายงานข้อมูลอาจารย์ทีปรึกษา </font>
                                    <!-- <a href="add.php"><span class="btn btn-primary fa fas-plus float-right "><i class="fas fa-plus-circle"> เพิ่มข้อมูลอาจารย์ทีปรึกษา</i></a> -->
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered " id="data" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #f8f9fc;" width="20%">
                                                    <select name="year" id="year" class="form-control">
                                                        <option value="">รหัสรุ่น</option>
                                                        <?php
                                                        $query = "SELECT SUBSTR(student.s_id,1,2) As id FROM student 
                                                        WHERE br_id =  '$id'  GROUP BY id  ORDER BY id DESC";
                                                        $result = mysqli_query($conn, $query);
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <option value="<?php echo $row["id"]; ?>"><?php echo $row["id"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </th>
                                                <th style="background-color: #f8f9fc;">กลุ่ม</th>
                                                <th style="background-color: #f8f9fc;"></th>
                                                <th style="background-color: #f8f9fc;text-align:center;" width="220">แก้ไข/ลบ</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.container-fluid -->
                </div>
                <?php include("../../footer.php") ?>
                <!-- End of Footer -->
            </div>
        </div>
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <?php include("../../logoutmenu.php"); ?>
    </body>

    </html>
    <script type="text/javascript" language="javascript">
        $(document).ready(function() {

            load_data();

            function load_data(is_year) {
                var dataTable = $('#data').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "ajax": {
                        url: "data.php",
                        type: "POST",
                        data: {
                            br_id: <?= $id ?>,
                            is_year: is_year,
                        },
                        error: function() { // error handling
                            $(".data-error").html("");
                            $("#data").append('<tbody class="parish-data-error"><tr><th colspan="4">No data found in the server</th></tr></tbody>');
                            $("#data-processing").css("display", "none");
                        }
                    },
                    "columnDefs": [{
                        "targets": [0,2],
                        "orderable": false,
                    }, ],
                });
            }

            $(document).on('change', '#year', function() {
                var year = $(this).val();
                $('#data').DataTable().destroy();
                if (year != '') {
                    load_data(year);
                } else {
                    load_data();
                }
            });
        });
    </script>
<?php
} else {
    echo "<script> alert('Please Login'); window.location='../../index.php';</script>";
    exit();
}
?>