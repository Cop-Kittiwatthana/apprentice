<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];

    $query = "SELECT * FROM teacher  WHERE t_user = '$username' and t_pass = '$password'";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $t_id = "$row[t_id]";
        $t_tna = "$row[t_tna]";
        $t_fna = "$row[t_fna]";
        $t_lna = "$row[t_lna]";
    }

    $query_notify = "SELECT * FROM notify";
    $result_notify = mysqli_query($conn, $query_notify);

    $date = date("Y-m-d", strtotime($Result["order_sent"] . "+543 year"));
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
        <title>ข้อมูลข่าวสาร</title>

        <?php include("../../head.php"); ?>
        <?php include("script_date.php"); ?>
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
                            <li class="breadcrumb-item"><a href="index.php">ข้อมูลข่าวสาร</a></li>
                            <li class="breadcrumb-item active">เพิ่มข้อมูลข่าวสาร</li>
                        </ol>
                    </div>
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-plus"></i> เพิ่มข้อมูลข่าวสาร</h4>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <br>
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>ผู้ประกาศ :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input type=hidden name="t_id" id="t_id" value="<?= $t_id ?>">
                                                <input class="form-control" readonly type="text" id="t_name" name="t_name" value="<?= $t_fna ?>&nbsp;<?= $t_lna ?>" require />
                                            </div>
                                        </td>
                                    </div>

                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <th>วันที่ลงข่าว :</th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input class="form-control" readonly type="text" size="10" id="n_date" name="n_date" value="<?= $date ?>" require />
                                            </div>
                                        </td>
                                    </div>
                                    <div class="col-md-6">
                                        <th>วันที่สิ้นสุด :</th>
                                        <td>
                                            <div class="input-group mb-3" >
                                                <input class="form-control" required placeholder="กรุณาเลือก ว/ด/ป " autocomplete="off" type="text" name="n_enddate" id="n_enddate" />
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>หัวข้อข่าว :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <input name="n_na" id="n_na" class="form-control" placeholder="-กรุณาใส่หัวข้อข่าว-"  required type="text">
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>รายละเอียด :<a style="color:red;">*</a></th>
                                        <td>
                                            <div class="input-group mb-3">
                                                <textarea name="n_detail" id="n_detail" class="form-control" placeholder="-กรุณาใส่รายละเอียดข่าว-" onkeypress="isInputChar2(event)" type="text"></textarea>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>รูป :<a style="color:red;">*</a></th>
                                        <img src="../../picture/<?= $photo ?>" style="display:none;" width="400" height="auto" id="preview" class="img-thumbnail">
                                        <td>
                                            <div class="form-group mb-3">
                                                <input type="file" name="img" class="file-field" accept="image/*">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" disabled placeholder="Upload File" id="photo">
                                                    <div class="input-group-append">
                                                        <button type="button" class="browse btn btn-primary">เพิ่มรูป...</button>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <button type="button" class="delect btn btn-danger">ลบ...</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>ไฟล์ :</th>
                                        <td>
                                            <div class="form-group mb-3">
                                                <input type="file" name="file" class="file" accept=".pdf, .doc, .docx, .zip">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" disabled placeholder="Upload File" id="file">
                                                    <div class="input-group-append">
                                                        <button type="button" class="browsefile btn btn-primary">เพิ่มไฟล์...</button>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <button type="button" class="delectfile btn btn-danger">ลบ...</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <th>line notify: <a style="color:red;">เลือกหากต้องการให้แจ้งเตือน line </a></th>
                                        <!-- <td>
                                            <div class="input-group mb-3">
                                                <input name="token" id="token" class="form-control" placeholder="-กรุณาใส่Token line notify-" type="text">
                                            </div>
                                        </td> -->
                                        <td>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="token" id="token" placeholder="-กรุณาเลือกกลุ่มแจ้งเตือน-" oninvalid="this.setCustomValidity('-กรุณาเลือกกลุ่มแจ้งเตือน-')" oninput="setCustomValidity('')">
                                                    <option value="0" selected disabled>-กรุณาเลือกกลุ่มแจ้งเตือน-</option>
                                                    <?php foreach ($result_notify as $value) { ?>
                                                        <option value="<?= $value['token'] ?>"><?= $value['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </td>
                                    </div>
                                </div>
                            </tr>
                            <div class="footer d-flex justify-content-center">
                                <button class="btn btn-success btn-lg" type="submit" name="btnsave" id="btnsave" value="บันทึก">บันทึก</button>&nbsp;
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
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">คำเตือน!</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">คุณต้องการออกจากระบบใช่หรือไม่?</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                        <a class="btn btn-primary" href="../../logout.php">ออกจากระบบ</a>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
        <!-- <script src="<?= $baseURL ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
        <script src="<?= $baseURL ?>/js/sb-admin-2.min.js"></script>
        <script src="<?= $baseURL ?>/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= $baseURL ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    </body>
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
    $(document).on("click", ".delect", function() {
        document.getElementById('preview').src = "";
        document.getElementById('preview').style = "display: none;";
        document.getElementById('photo').value = null;

    });
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