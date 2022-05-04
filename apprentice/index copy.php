<?php include("connect.php"); ?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/mystyle.css">
  <title>วิทยาลัยการอาชีพวิเชียรบุรี</title>
  <style>
    body {
      /* background-color: #96dbfb; */
      background-color: #ffffff;
    }
  </style>
</head>

<body>
  <!--start  banner -->
  <div class="container">
    <div class="row">
      <div class="col col-sm-12 col-md-12">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="http://www.wicec.ac.th/web/images/head.gif" class="d-block w-100" alt="...">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--end  banner -->
  <!--start  menu2 -->
  <div class="container">
    <div class="row">
      <div class="col col-sm-12 col-md-12">
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #96dbfb;">
          <a class="navbar-brand" href="index.php">
            หน้าแรก
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link" href="https://www.youtube.com/c/devbanban" target="_blank">Youtube</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="https://devbanban.com/?p=2867" target="_blank">คอร์สออนไลน์</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="https://devbanban.com/?page_id=2309" target="_blank">สนับสนุน</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="https://www.facebook.com/sornwebsites/" target="_blank">ติดต่อ</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Dropdown
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </div>
  </div>
  <!--start  main -->
  <div class="container">
    <div class="row">

      <!--start content -->
      <div class="col col-sm-9 col-md-12">
        <br>
        <div class="row">
          <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0 ">
            <div class="card card shadow mb-4">
              <h5 class="card-header bg-success text-white" align="center">
                <font size="5" face="TH SarabunPSK"><b>สถานประกอบการ</b></font>
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
                <font size="5" face="TH SarabunPSK"><b>นักศึกษา</b></font>
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
                <font size="5" face="TH SarabunPSK"><b>อาจารย์และเจ้าหน้าที่</b></font>
              </h5>
              <div class="card-body">
                <div align="center">
                  <a class="card-text text-success" align="center" href="frm_loginteac.php"> เข้าสู้ระบบ <i class="fas fa-arrow-circle-right"></i></a>
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


  <!--start  main -->
  <div class="container">
    <div class="row">

      <!--start content -->
      <div class="col col-sm-9 col-md-12">
        <br>
        <div class="alert alert-info" role="alert">
          - ข่าวประชาสัมพันธ์
        </div>
        <div class="row">
          <div class="col-6 col-sm-3 col-md-3" style="margin-bottom: 20px;">
            <div class="card" style="width: 100%;">
              <img src="img/2.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">คอร์สออนไลน์</h5>
                <a href="https://devbanban.com/?p=2867" class="btn btn-primary btn-sm" target="_blank">Read More..</a>
              </div>
            </div>
          </div>
          <div class="col-6 col-sm-3 col-md-3" style="margin-bottom: 20px;">
            <div class="card" style="width: 100%;">
              <img src="img/2.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">คอร์สออนไลน์</h5>
                <a href="https://devbanban.com/?p=2867" class="btn btn-primary btn-sm" target="_blank">Read More..</a>
              </div>
            </div>
          </div>
          <div class="col-6 col-sm-3 col-md-3" style="margin-bottom: 20px;">
            <div class="card" style="width: 100%;">
              <img src="img/2.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">คอร์สออนไลน์</h5>
                <a href="https://devbanban.com/?p=2867" class="btn btn-primary btn-sm" target="_blank">Read More..</a>
              </div>
            </div>
          </div>
          <div class="col-6 col-sm-3 col-md-3" style="margin-bottom: 20px;">
            <div class="card" style="width: 100%;">
              <img src="img/2.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">คอร์สออนไลน์</h5>
                <a href="https://devbanban.com/?p=2867" class="btn btn-primary btn-sm" target="_blank">Read More..</a>
              </div>
            </div>
          </div>
        </div><!-- row -->


        <div class="alert alert-danger" role="alert">
          - ภาพกิจกรรม
        </div>
        <div class="row">
          <div class="col-6 col-sm-3 col-md-3" style="margin-bottom: 20px;">
            <div class="card" style="width: 100%;">
              <img src="img/2.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">ภาพกิจกรรม</h5>
                <a href="https://devbanban.com/?p=2867" class="btn btn-primary btn-sm" target="_blank">Read More..</a>
              </div>
            </div>
          </div>
          <div class="col-6 col-sm-3 col-md-3" style="margin-bottom: 20px;">
            <div class="card" style="width: 100%;">
              <img src="img/2.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">ภาพกิจกรรม</h5>
                <a href="https://devbanban.com/?p=2867" class="btn btn-primary btn-sm" target="_blank">Read More..</a>
              </div>
            </div>
          </div>
          <div class="col-6 col-sm-3 col-md-3" style="margin-bottom: 20px;">
            <div class="card" style="width: 100%;">
              <img src="img/2.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">ภาพกิจกรรม</h5>
                <a href="https://devbanban.com/?p=2867" class="btn btn-primary btn-sm" target="_blank">Read More..</a>
              </div>
            </div>
          </div>
          <div class="col-6 col-sm-3 col-md-3" style="margin-bottom: 20px;">
            <div class="card" style="width: 100%;">
              <img src="img/2.jpg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">ภาพกิจกรรม</h5>
                <a href="https://devbanban.com/?p=2867" class="btn btn-primary btn-sm" target="_blank">Read More..</a>
              </div>
            </div>
          </div>
        </div><!-- row -->
      </div>
      <!--end content -->
    </div>
  </div>
  <!--end  main  -->

  <!--start  footer -->
  <div class="container-fluid" style="background-color: #e3f2fd;">
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12">
        <p align="center" class="myfooter"> วิทยาลัยการอาชีพวิเชียรบุรี 100 ม.5 ต.สระประดู่ อ.วิเชียรบุรี จ.เพชรบูรณ์ 67130 <br> เบอร์โทร 056-753049 </p>
      </div>
    </div>
  </div>
  <!--end  footer -->
</body>

</html>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>