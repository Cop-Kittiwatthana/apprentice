<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $pf_id  = $_GET['pf_id'];

    $query = "SELECT * FROM student  WHERE s_user = '$username' and s_pass = '$password'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $s_id = "$row[s_id]";
        $s_tna = "$row[s_tna]";
        $s_fna = "$row[s_fna]";
        $s_lna = "$row[s_lna]";
        
    }

    $query1 = "SELECT * FROM portfolio WHERE pf_id = '$pf_id'";
    $result1 = mysqli_query($conn, $query1);
    while ($row = mysqli_fetch_array($result1)) {  // preparing an array
        $pf_na = "$row[pf_na]";
        $pf_file = "$row[pf_file]";
        $s_id  = "$row[s_id]";
    }
    

    $query_notify = "SELECT * FROM notify ";
    $result_notify = mysqli_query($conn, $query_notify);

    //$date = date("d-m-Y", strtotime($Result["order_sent"] . "+543 year"));
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
        <title>ข้อมูลผลงานนักศึกษา</title>

        <?php include("../../head.php"); ?>
        <style>
            .file {
                visibility: hidden;
                position: absolute;
            }

            .file-field {
                visibility: hidden;
                position: absolute;
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
                            <li class="breadcrumb-item"><a href="index.php">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">เพิ่มข้อมูลผลงานนักศึกษา</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> แก้ไขข้อมูลผลงานนักศึกษา</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                        <input type=hidden name="pf_id" id="pf_id" value="<?= $pf_id ?>">
                        <input name="pf_file" type="hidden" id="pf_file" value="<?= "$pf_file"; ?>" />
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>ชื่อ-สกุล :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input type=hidden name="s_id" id="s_id" value="<?= $s_id ?>">
                                                <input class="form-control" readonly type="text" id="s_name" name="s_name" value="<?= $s_fna ?>&nbsp;<?= $s_lna ?>" require />
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>ชื่อผลงาน :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="pf_na" id="pf_na" value="<?= $pf_na ?>" class="form-control" placeholder="-กรุณาใส่ชื่อผลงาน-" onkeypress="isInputChar(event)" required type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>รูป :<a style="color:red;">*</a></th>
                                        <img src="../../picture/<?= $pf_file ?>" style="display:block;" width="400" height="auto" id="preview" class="img-thumbnail">
                                        <td>
                                            <div class="form-group mb-3">
                                                <input type="file" name="img" class="file-field" multiple accept="image/*" >
                                                <div class="input-group">
                                                    <input type="text" class="form-control" disabled placeholder="Upload File" id="photo" value="<?= $pf_file ?>">
                                                    <div class="input-group-append">
                                                        <button type="button" class="browse btn btn-primary">เพิ่มรูป...</button>
                                                    </div>
                                                    <!-- <div class="input-group-append">
                                                        <button type="button" class="delect btn btn-danger">ลบ...</button>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <div class="footer d-flex justify-content-center">
                                <button class="btn btn-success btn-lg" type="submit" name="btnedit" id="btnedit" value="บันทึก">บันทึก
                                    <button class="btn btn-danger btn-lg" type="reset" name="btnCancel" id="btnCancel" value="ยกเลิก">ยกเลิก</button>
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
    <!-- <script>
        $(document).on('click', '#btnedit', function(e) {
            var form = $(this).parents('form1');
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ตกลง!'
            }).then(function(result) {
                if (result.value) {
                    //$('#form1').submit();
                    document.getElementById("form1").submit();
                    
                } else {

                }
            });
        });
    </script> -->

    </html>
<?php
} else {
    echo ("<script> alert('please login'); window.location='../../index.php';</script>");
    exit();
}
?>
<script>
    i = 0;
    $(document).on("click", ".browse", function() {
        var file = $(this).parents().find(".file-field");
        file.trigger("click");

    });
    // $(document).on("click", ".delect", function() {
    //     document.getElementById('preview').src = "";
    //     document.getElementById('preview').style = "display: none;";
    //     document.getElementById('photo').value = null;

    // });
    $('input[name="img"]').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#photo").val(fileName);
        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview").style = "display: block;";
            document.getElementById("preview").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });

    $(document).on("click", ".browsefile", function() {
        var file = $(this).parents().find(".file");
        file.trigger("click");
    });
    $(document).on("click", ".delectfile", function() {
        document.getElementById('file').value = null;
    });
    $('input[name="file"]').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file").val(fileName);
    });
</script>
<?php include("../script.php"); ?>