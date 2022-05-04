<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    include("../../connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $t_id = $_GET['t_id'];
    $query = "SELECT teacher.*,districts.*, amphures.*, provinces.*,department.*,position.*
                FROM teacher
                LEFT JOIN districts ON teacher.district_id = districts.district_id
                LEFT JOIN amphures ON districts.amphure_id = amphures.amphure_id
                LEFT JOIN provinces ON amphures.province_id = provinces.province_id
                LEFT JOIN position ON teacher.p_id = position.p_id
                LEFT JOIN department ON teacher.dp_id = department.dp_id
                WHERE teacher.t_id = $t_id";
    $result = mysqli_query($conn, $query)
        or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
    while ($row = mysqli_fetch_array($result)) {  // preparing an array
        $t_tna = "$row[t_tna]";
        $t_fna = "$row[t_fna]";
        $t_lna = "$row[t_lna]";
        $t_tel = "$row[t_tel]";
        $t_mail = "$row[t_mail]";
        $t_add = "$row[t_add]";
        $photo = "$row[t_pic]";
        $t_date = "$row[t_date]";
        $t_user = "$row[t_user]";
        $t_pass = "$row[t_pass]";
        $type = "$row[type]";
        $dp_na = "$row[dp_na]";
        $p_na = "$row[p_na]";
        $district_name_th = $row['district_name_th'];
        $amphures_name_th = $row['amphures_name_th'];
        $provinces_name_th = $row['provinces_name_th'];
        $zip_code = $row['zip_code'];
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
        <title>ข้อมูลอาจารย์</title>

        <?php include("../../head.php"); ?>
        <script>
            $(document).ready(function() {
                $("select").each(function() {
                    $(this).val($(this).find('option[selected]').val());
                });
            })
        </script>
        <style>
            .file {
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
                    <br>
                    <div class="text-center">
                        <h4 class="text-dark"><i class="fas fa-user-edit"></i> ข้อมูลส่วนตัวอาจารย์</h4>
                        <a href="editme.php?t_id=<?= $t_id ?>"><span class="btn btn-primary fa fas-plus float-center "><i class="fas fa-plus-circle"> แก้ไขข้อมูลส่วนตัว</i></a>
                    </div>
                    <form action="sql.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="container text-dark " style="width: 60%; height: auto;">
                            <br>
                            <div class="card">
                                <div class="card-body">
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <th>ชื่อผู้ใช้ : <a style="color:black;"><?= $t_user ?></a></th>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <img echo src="<?= $baseURL; ?>/picture/<?= $photo ?>" style="display:block;" width="120px" height="auto" id="preview" class="img-thumbnail">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <th>แผนก-สาขา : <a style="color:black;"><?= $dp_na ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <?php
                                                if ($t_tna == 0) {
                                                    $tna = "นาย";
                                                }
                                                if ($t_tna == 1) {
                                                    $tna = "นาง";
                                                }
                                                if ($t_tna == 2) {
                                                    $tna = "นางสาว";
                                                }
                                                ?>
                                                <th>ชื่อ-นามสกุล : <a style="color:black;"><?= $tna ?> <?= $t_fna ?> <?= $t_lna ?></a></th>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <th>ตำแหน่ง : <a style="color:black;"><?= $p_na ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <th>เบอร์ : <a style="color:black;"><?= $t_tel ?></a></th>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <th>อีเมล์ : <a style="color:black;"><?= $t_mail ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <th>ที่อยู่ : <a style="color:black;"><?= $t_add ?></a></th>
                                                <th><a style="color:black;">ตำบล<?= $district_name_th ?> อำเภอ<?= $amphures_name_th ?> จังหวัด<?= $provinces_name_th ?> รหัสไปรษณีย์ <?= $zip_code ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <th>วันเวลาที่ติดต่อได้ : <a style="color:black;"><?= $t_date ?></a></th>
                                            </div>
                                        </div>
                                    </tr>
                                </div>
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
<?php
} else {
    echo ("<script> alert('please login'); window.location='../../index.php';</script>");
    exit();
}
?>
<script>
    $(document).on("click", ".browse", function() {
        var file = $(this).parents().find(".file");
        file.trigger("click");

    });
    // $(document).on("click", ".delect", function() {
    //     document.getElementById('preview').src = "";
    //     document.getElementById('preview').style = "display: none;";
    //     document.getElementById('photo').value = null;
    // });
    $('input[type="file"]').change(function(e) {
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
</script>
<?php include("../script.php"); ?>