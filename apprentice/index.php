<?php include("connect.php");
include("pagination_function.php");
$date = date("Ymd", strtotime($Result["order_sent"] . "+543 year"));
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
        .slicknav_nav{
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
                                                    <font size="5" face="TH SarabunPSK"><b style="color: white;"">หน้าแรก</b></font>
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
        <div class="container">
            <div class="row">

                <!--start content -->
                <div class="col col-sm-9 col-md-12">
                    <br>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0 ">
                            <div class="card card shadow mb-4">
                                <h5 class="card-header bg-success" align="center">
                                    <font size="5" face="TH SarabunPSK"><b style="color: white;">สถานประกอบการ</b></font>
                                </h5>
                                <div class="card-body">
                                    <div align="center">
                                        <a class="card-text text-success" align="center" href="frm_logincony.php"> เข้าสู่ระบบ <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0 ">
                            <div class="card card shadow mb-4">
                                <h5 class="card-header bg-info text-white" align="center">
                                    <font size="5" face="TH SarabunPSK"><b style="color: white;">นักศึกษา</b></font>
                                </h5>
                                <div class="card-body">
                                    <div align="center">
                                        <a class="card-text text-success" align="center" href="frm_loginstd.php"> เข้าสู่ระบบ <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0 ">
                            <div class="card card shadow mb-4">
                                <h5 class="card-header bg-dark text-white" align="center">
                                    <font size="5" face="TH SarabunPSK"><b style="color: white;">อาจารย์และเจ้าหน้าที่</b></font>
                                </h5>
                                <div class="card-body">
                                    <div align="center">
                                        <a class="card-text text-success" align="center" href="frm_loginteac.php"> เข้าสู่ระบบ <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- row -->
                </div><!-- row -->
            </div>
            <!--end content -->
        </div>
        <!--end  main  -->
        <div class="container">
            <div class="row">
                <!--start content -->
                <div class="col col-sm-9 col-md-12">
                    <br>
                    <div class="alert alert-info" style="background-color: #b0f3ff;" role="alert">
                        <font size="5" face="TH SarabunPSK"><b style="color: black;">- ข่าวประชาสัมพันธ์</b></font>
                    </div>
                    <div class="row">

                        <?php
                        $num = 0;
                        $sql = "SELECT * FROM news where 1 and $date <= n_enddate or n_enddate = '0000-00-00' or n_enddate is null  ";
                        $result = mysqli_query($conn, $sql);
                        $total = mysqli_num_rows($result);
                        $e_page = 3; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
                        $step_num = 0;
                        if (!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1)) {
                            $_GET['page'] = 1;
                            $step_num = 0;
                            $s_page = 0;
                        } else {
                            $s_page = $_GET['page'] - 1;
                            $step_num = $_GET['page'] - 1;
                            $s_page = $s_page * $e_page;
                        }
                        $sql .= " ORDER BY n_id DESC  LIMIT " . $s_page . ",$e_page";
                        //while ($row = mysqli_fetch_array($result)) {  // preparing an array
                        $result = mysqli_query($conn, $sql);
                        if ($result && $result->num_rows > 0) {  // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
                            while ($row = $result->fetch_assoc()) { // วนลูปแสดงรายการ
                                $num++;
                        ?>
                               <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0 ">
                            <div class="card card shadow mb-4">
                                    <!-- <div class="col-6 col-sm-4 col-md-4" style="margin-bottom: 20px;"> -->
                                        <div class="card" style="width: 100%;">
                                            <?php if ($n_pic != "") { ?>
                                                <img src="picture/<?= $row['n_pic'] ?>" style="height: 225px; width: 100%; display: block;" id="preview" class="img-thumbnail">
                                            <?php } else { ?>
                                                <img src="picture/<?= $row['n_pic'] ?>" style="height: 225px; width: 100%; display: block;" id="preview" class="img-thumbnail">
                                            <?php  } ?>
                                            <div class="card-body">
                                                <h5 class="card-title" id="card_topic">
                                                    <font size="5" face="TH SarabunPSK"><b><?= $row['n_na'] ?></b></font>
                                                </h5>
                                                <a href="indexviewdetailnew.php?id=<?= $row['n_id'] ?>" class="btn btn-primary btn-sm" target="_blank">
                                                    <font size="4" face="TH SarabunPSK"><b style="color: white;">Read More..</b></font>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <!--end content -->
                </div>
            </div>
        </div>
        <center>
            <?php
            page_navi($total, (isset($_GET['page'])) ? $_GET['page'] : 1, $e_page, $_GET);
            ?>
        </center>
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