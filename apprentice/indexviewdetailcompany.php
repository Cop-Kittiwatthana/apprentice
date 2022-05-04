<?php include("connect.php");
$c_id = $_GET['id'];
$de_id = $_GET['de_id'];

$query = "SELECT company.*,districts.*, amphures.*,provinces.*,demand.* FROM company 
INNER JOIN demand ON company.c_id = demand.c_id 
INNER JOIN districts ON company.district_id=districts.district_id 
INNER JOIN amphures ON districts.amphure_id=amphures.amphure_id 
INNER JOIN provinces ON amphures.province_id=provinces.province_id 
where company.c_id = '$c_id' and demand.de_id = '$de_id'";

//$query = "SELECT * FROM petition  where de_id = $row[de_id] and pe_status != 3";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($result)) {  // preparing an array
    $c_na = "$row[c_na]";
    $c_hnum = "$row[c_hnum]";
    $c_village = "$row[c_village]";
    $c_road = "$row[c_road]";
    $district_name_th = "$row[district_name_th]";
    $amphures_name_th = "$row[amphures_name_th]";
    $provinces_name_th = "$row[provinces_name_th]";
    $zip_code = "$row[zip_code]";
}

?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>วิทยาลัยการอาชีพ วิเชียรบุรี</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/brand.png">

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/ticker-style.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <style type="text/css">
        #card_detail {
            /*white-space: nowrap;*/
            text-overflow: ellipsis;
            -o-text-overflow: ellipsis;
            -ms-text-overflow: ellipsis;
            overflow: hidden;
            width: 100%;
            height: 131px;
        }

        #card_topic {
            white-space: nowrap;
            text-overflow: ellipsis;
            -o-text-overflow: ellipsis;
            -ms-text-overflow: ellipsis;
            overflow: hidden;
            width: 100%;
        }

        .slicknav_nav {
            background: #4fa4c3;
        }
    </style>
</head>

<body>
    <!-- Preloader Start -->
    <!-- <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="assets/img/logo/logo.png" alt="">
                </div>
            </div>
        </div>
    </div> -->
    <!-- Preloader Start -->
    <header>
        <!-- Header Start -->
        <div class="header-area">
            <div class="main-header ">
                <div class="header-mid gray-bg" style="background: #016ec4;">
                    <div class="container">
                        <div class="row d-flex align-items-center">
                            <!-- Logo -->
                            <div class="col-xl-3 col-lg-3 col-md-3 d-none d-md-block">
                                <div class="logo">
                                    <a href="index.php"><img src="assets/img/brand.png" width="100" height="100" alt=""></a>
                                </div>
                            </div>
                            <div class="col-xl-9 col-lg-9 col-md-9">
                                <div class="header-banner f-right ">
                                    <a href="index.php"><img src="img/head1.png" width="100%" height="100" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-bottom header-sticky">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-8 col-lg-8 col-md-12 header-flex">
                                <!-- sticky -->
                                <div class="sticky-logo">
                                    <a href="index.php"><img src="assets/img/brand.png" width="50" height="50" alt=""></a>
                                </div>
                                <!-- Main-menu -->
                                <div class="main-menu d-none d-md-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="index.php">
                                                    <font size="5" face="TH SarabunPSK"><b style="color: white;">หน้าแรก</b></font>
                                                </a></li>
                                            <li><a href="indexviewnew.php">
                                                    <font size="5" face="TH SarabunPSK"><b style="color: white;">ข่าวสารทั้งหมด</b></font>
                                                </a></li>
                                            <li><a href="indexviewcompany.php">
                                                    <font size="5" face="TH SarabunPSK"><b style="color: white;">สถานประกอบการ</b></font>
                                                </a></li>
                                            <li><a href="http://www.wicec.ac.th/web/dve/" target="_blank">
                                                    <font size="5" face="TH SarabunPSK"><b style="color: white;">ระบบงานทวิภาคี</b></font>
                                                </a></li>
                                            <!-- <li><a href="http://www.wicec.ac.th/web/">ติดต่อสอบถาม</a></li> -->
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="header-right f-right d-none d-lg-block">
                                    <!-- Heder social -->
                                    <ul class="header-social">
                                        <li><a href="https://www.facebook.com/people/%E0%B8%87%E0%B8%B2%E0%B8%99%E0%B8%9B%E0%B8%A3%E0%B8%B0%E0%B8%8A%E0%B8%B2%E0%B8%AA%E0%B8%B1%E0%B8%A1%E0%B8%9E%E0%B8%B1%E0%B8%99%E0%B8%98%E0%B9%8C-%E0%B8%A7%E0%B8%B4%E0%B8%97%E0%B8%A2%E0%B8%B2%E0%B8%A5%E0%B8%B1%E0%B8%A2%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B8%AD%E0%B8%B2%E0%B8%8A%E0%B8%B5%E0%B8%9E%E0%B8%A7%E0%B8%B4%E0%B9%80%E0%B8%8A%E0%B8%B5%E0%B8%A2%E0%B8%A3%E0%B8%9A%E0%B8%B8%E0%B8%A3%E0%B8%B5-%E0%B9%80%E0%B8%9E%E0%B8%8A%E0%B8%A3%E0%B8%9A%E0%B8%B9%E0%B8%A3%E0%B8%93%E0%B9%8C/100005191961692/?hc_ref=ARRC3hwsFRmtBIi4vCQ10qwF53FN9kxPHFr2O7qKPW7Ad-mCVfYCdprCOVCCZGZ6f1I&ref=nf_target"><i class="fab fa-facebook-f"></i></a></li>
                                        <!-- <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                        <li> <a href="#"><i class="fab fa-youtube"></i></a></li> -->
                                    </ul>
                                    <!-- Search Nav -->

                                </div>
                            </div>
                            <!-- Mobile Menu -->
                            <div class="col-12">
                                <div class="mobile_menu d-block d-md-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
    <main>
        <!--end  main  -->
        <div class="container">
            <div class="row">

                <!--start content -->
                <div class="col col-sm-9 col-md-12">
                    <br>
                    <div class="alert alert-info" style="background-color: #b0f3ff;" role="alert">
                        <font size="5" face="TH SarabunPSK"><b style="color: black;">- รายละเอียด</b></font>
                    </div>
                    <div class="row">

                        <div class="col-md-8 offset-md-2 ">
                            <div class="card border-primary ">
                                <div class="card-body">
                                    <div class="blog__details__text">
                                        <h3>
                                            <font size="6" face="TH SarabunPSK"><b><?php echo "$c_na"; ?></b></font>
                                        </h3>
                                        <p>
                                            <font size="5" face="TH SarabunPSK"><b><i class="fas fa-building"></i> สถานที่ปฏิบัติงาน</b></font><br>
                                            <font size="5" face="TH SarabunPSK"><b>
                                                    <?php if ($c_hnum != "") {
                                                        echo '<font size="5" face="TH SarabunPSK">ที่อยู่&nbsp;' . "$c_hnum" . '&nbsp;หมู่' . "$c_village" . '&nbsp;ถนน' . "$c_road" . '&nbsp;ตำบล'
                                                            . "$district_name_th" . '&nbsp;อำเภอ' . "$amphures_name_th" . '&nbsp;จังหวัด.' . "$provinces_name_th"
                                                            . '&nbsp;รหัสไปรษณีย์&nbsp;' . "$zip_code" . '</font>';
                                                    }
                                                    ?></b></font>
                                        </p>
                                        <hr style="border-color: black;" width="100%">
                                        <p>
                                            <font size="5" face="TH SarabunPSK"><b><i class="fas fa-address-book"></i> ติดต่อ</b></font><br>
                                            <font size="5" face="TH SarabunPSK"><b>
                                                    <?php
                                                    $query = "SELECT company.*,contact_staff.* FROM company 
                                                    INNER JOIN contact_staff ON company.c_id = contact_staff.c_id 
                                                    where company.c_id = '$c_id' ORDER BY contact_staff.cs_id ASC";
                                                    //$query = "SELECT * FROM petition  where de_id = $row[de_id] and pe_status != 3";
                                                    $result = mysqli_query($conn, $query);
                                                    while ($row = mysqli_fetch_array($result)) {  // preparing an array
                                                        $cs_na = "$row[cs_na]";
                                                        $cs_position = "$row[cs_position]";
                                                        $cs_tel = "$row[cs_tel]";
                                                        $cs_mail = "$row[cs_mail]";
                                                        $cs_fax = "$row[cs_fax]";
                                                        $cs_date = "$row[cs_date]";
                                                    }
                                                    if ($c_hnum != "") { ?>
                                                        <font size="5" face="TH SarabunPSK">
                                                            ชื่อ-นามสกุล:&nbsp;<?= $cs_na ?><br>
                                                            ตำแหน่ง:&nbsp;<?= $cs_position ?><br>
                                                            เบอร์โทร:&nbsp;<?= $cs_tel ?><br>
                                                            อีเมล์:&nbsp;<?= $cs_mail ?><br>
                                                            fax:&nbsp;<?= $cs_fax ?><br>
                                                            วันเวลาที่ติดต่อได้:&nbsp;<?= $cs_date ?><br></font>
                                                    <?php }
                                                    ?>
                                                </b></font>
                                        </p>
                                        <hr style="border-color: black;" width="100%">
                                        <p>
                                            <font size="5" face="TH SarabunPSK"><b><i class="fas fa-exclamation-circle"></i> ต้องการรับนักศึกษาเข้าฝึกงาน</b></font><br>
                                            <font size="5" face="TH SarabunPSK"><b>
                                                    <?php
                                                    $query = "SELECT company.*,demand.*,branch.* FROM company 
                                                    INNER JOIN demand ON company.c_id = demand.c_id 
                                                    INNER JOIN branch ON demand.br_id  = demand.br_id 
                                                    where company.c_id = '$c_id' and demand.de_id= '$de_id' ";
                                                    //$query = "SELECT * FROM petition  where de_id = $row[de_id] and pe_status != 3";
                                                    $result = mysqli_query($conn, $query);
                                                    while ($row = mysqli_fetch_array($result)) {  // preparing an array
                                                        $de_year = "$row[de_year]";
                                                        $de_num = "$row[de_num]";
                                                        $de_Jobdetails = "$row[de_Jobdetails]";
                                                        $de_Welfare = "$row[de_Welfare]";
                                                        $br_na = "$row[br_na]";
                                                    }
                                                    if ($c_hnum != "") { ?>
                                                        <font size="5" face="TH SarabunPSK">
                                                            รายละเอียดงาน:&nbsp;<?= $de_Jobdetails ?><br>
                                                            ปีการศึกษา:&nbsp;<?= $de_year ?>&nbsp;&nbsp;
                                                            สาขา:&nbsp;<?= $br_na ?><br>
                                                            จำนวน:&nbsp;<?= $de_num ?><br>
                                                            สวัสดิการ:&nbsp;<?= $de_Welfare ?><br></font>
                                                    <?php }
                                                    ?>
                                                </b></font>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <center>
                        <!-- <tr>
                            <td colspan="2" align="center">
                                <input class="btn btn-info" type="reset" href="javascript:history.back()" name="btnCancel" id="btnCancel" value="ย้อนกลับ" />
                            </td>
                        </tr> -->
                        <div class="footer d-flex justify-content-center">
                            <a href="javascript:history.back()"><button class="btn btn-primary btn-lg">กลับ</button></a>
                        </div>
                    </center>
                </div>
            </div>
        </div>
        <br>
    </main>
    <footer>
        <!-- Footer Start-->
        <div class="footer-main footer-bg">
            <!-- footer-bottom aera -->
            <div class="footer-bottom-area footer-bg">
                <div class="container">
                    <div class="footer-border">
                        <div class="row d-flex align-items-center">
                            <div class="col-xl-12 ">
                                <div class="footer-copy-right text-center">
                                    <p align="center" style="color: white;" class="myfooter"> วิทยาลัยการอาชีพวิเชียรบุรี 100 ม.5 ต.สระประดู่ อ.วิเชียรบุรี จ.เพชรบูรณ์ 67130 <br> เบอร์โทร 056-753049 </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End-->
    </footer>
    <!-- Search model Begin -->
    <div class="search-model-box">
        <div class="d-flex align-items-center h-100 justify-content-center">
            <div class="search-close-btn">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Searching key.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- JS here -->

    <script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <!-- Jquery Mobile Menu -->
    <script src="./assets/js/jquery.slicknav.min.js"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="./assets/js/owl.carousel.min.js"></script>
    <script src="./assets/js/slick.min.js"></script>
    <!-- Date Picker -->
    <script src="./assets/js/gijgo.min.js"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="./assets/js/wow.min.js"></script>
    <script src="./assets/js/animated.headline.js"></script>
    <script src="./assets/js/jquery.magnific-popup.js"></script>

    <!-- Scrollup, nice-select, sticky -->
    <script src="./assets/js/jquery.scrollUp.min.js"></script>
    <script src="./assets/js/jquery.nice-select.min.js"></script>
    <script src="./assets/js/jquery.sticky.js"></script>

    <!-- contact js -->
    <script src="./assets/js/contact.js"></script>
    <script src="./assets/js/jquery.form.js"></script>
    <script src="./assets/js/jquery.validate.min.js"></script>
    <script src="./assets/js/mail-script.js"></script>
    <script src="./assets/js/jquery.ajaxchimp.min.js"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="./assets/js/plugins.js"></script>
    <script src="./assets/js/main.js"></script>

</body>

</html>