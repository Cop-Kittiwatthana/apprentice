<?php
session_start();
if (!isset($_SESSION["username"]) && !isset($_SESSION["password"])) {
    header("Location: index.php");
} else {
    include("connect.php");
    include("sty.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $type = $_SESSION["type"];
    if ($status == '0' && $type == "0") {
        $query = "Select * from teacher WHERE t_user = '$username' AND t_pass = '$password'";
        $result = mysqli_query($conn, $query)
            or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
        while ($row = mysqli_fetch_array($result)) {  // preparing an array
            $username = "$row[t_user]";
            $t_id = "$row[t_id]";
            $fna = "$row[t_fna]";
            $lna = "$row[t_lna]";
            $picture = "$row[t_pic]";
        } ?>
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $baseURL; ?>/indexnews.php">
                <div class="sidebar-brand-icon ">
                    <img src="<?= $baseURL; ?>/img/brand.png" width="40%" height="auto" alt="">
                    <div class="sidebar-brand-text mx-3"></div>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Heading -->

            <li class="nav-item">
                <a class="nav-link" href="<?= $baseURL; ?>/indexnews.php">
                    <span>
                        <font size="3">หน้าหลัก | ผู้ดูแลระบบ</font>
                    </span></a>
                <hr class="sidebar-divider">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>
                        <font size="3">Profile</font>
                    </span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="profile-sidebar">
                        <div class="profile-userpic " style="text-align: center;">
                            <?php if ($picture != "") { ?>
                                <img src="<?= $baseURL; ?>/picture/<?= $picture ?>" class="img-responsive" alt="">
                            <?php } else { ?>
                                <img src="<?= $baseURL; ?>/icon/noimg.png" class="img-responsive" alt="">
                            <?php  } ?>
                        </div>
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                                <?php echo $fna  ?> <?php echo $lna  ?>
                            </div>
                        </div>
                        <?php if ($username == "admin") { ?>
                            <div class="profile-userbuttons">
                                <button type="button" class="btn btn-danger btn-sm" href="logout.php" data-toggle="modal" data-target="#logoutModal">Logout</button>
                            </div>
                        <?php  } else {
                        ?>
                            <div class="profile-userbuttons">
                                <button type="button" class="btn btn-success btn-sm" onclick="location.href='<?= $baseURL; ?>/views/teacher/indexme.php?t_id=<?= $t_id ?>'">Profile</button>
                                <button type="button" class="btn btn-danger btn-sm" href="logout.php" data-toggle="modal" data-target="#logoutModal">Logout</button>
                            </div>
                        <?php  }
                        ?>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Dashboard -->
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                ข้อมูล
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>
                        <font size="3">ข้อมูลทั่วไป</font>
                    </span>
                </a>
                <div id="collapsePages2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">เขตที่อยู่</h6>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/provinces/index.php">จังหวัด</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/amphures/index.php">อำเภอ</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/district/index.php">ตำบล</a>
                        <h6 class="collapse-header">เขตตำแหน่ง</h6>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/position/index.php">ตำแหน่ง</a>
                        <h6 class="collapse-header">แผนก-สาขา</h6>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/department/index.php">แผนก-สาขา</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages3" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>
                        <font size="3">ข้อมูล<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;อาจารย์/เจ้าหน้าที่</font>
                    </span>
                </a>
                <div id="collapsePages3" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/teacher/index.php">อาจารย์/เจ้าหน้าที่</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/advisor/indexsup.php">อาจารย์ที่ปรึกษา</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages4" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>
                        <font size="3">ข้อมูลนักศึกษา</font>
                    </span>
                </a>
                <div id="collapsePages4" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/student/indexsub.php">นักศึกษา</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages5" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>
                        <font size="3">สถานประกอบการ</font>
                    </span>
                </a>
                <div id="collapsePages5" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/company/index.php">ข้อมูลสถานประกอบการ</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/demand/index.php">ข้อมูลความต้องการ</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages6" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>
                        <font size="3">ข้อมูลการฝึกงาน</font>
                    </span>
                </a>
                <?php $thai_year = date('Y') + 543; ?>
                <div id="collapsePages6" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/register/index.php">ระยะเวลาการยื่นเรื่อง </a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/status/index.php?year=<?= $thai_year ?>">สถานะการยื่นเรื่อง </a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/sup/indexsup.php?year=<?= $thai_year ?>">อาจารย์นิเทศ</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/supervision/index.php?year=<?= $thai_year ?>">รายละเอียดการนิเทศ</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/score/indexsub.php">ผลการฝึกงาน </a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/documents/index.php">เอกสารการฝึกงาน </a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages7" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>
                        <font size="3">ข้อมูลข่าวสาร</font>
                    </span>
                </a>
                <div id="collapsePages7" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/notify/index.php">แจ้งเตือนไลน์</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/news/index.php">ข่าวสาร </a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages8" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>
                        <font size="3">รายงาน</font>
                    </span>
                </a>
                <div id="collapsePages8" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/reportadmin/indexpdfteacher.php" >อาจารย์ทั้งหมด</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/reportadmin/indexstudent.php">นักศึกษา</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/reportadmin2/indexdismiss.php">นักศึกษาที่ยกเลิกการฝึก</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/reportadmin/indexdisease.php">โรคประจำตัวนักศึกษา</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/reportadmin/indexcomstu.php">จำนวนนักศึกษาที่ฝึกงาน</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/reportadmin/indexpdfcompany.php">สถานประกอบการทั้งหมด</a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
    <?php } //อาจารย์
    if ($status == '0' && $type == "1") {
        $query = "Select * from teacher WHERE t_user = '$username' AND t_pass = '$password'";
        $result = mysqli_query($conn, $query)
            or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
        while ($row = mysqli_fetch_array($result)) {  // preparing an array
            $username = "$row[t_user]";
            $t_id = "$row[t_id]";
            $fna = "$row[t_fna]";
            $lna = "$row[t_lna]";
            $picture = "$row[t_pic]";
        } ?>
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $baseURL; ?>/views/teacher/indexme.php?t_id=<?= $t_id ?>">
                <div class="sidebar-brand-icon ">
                    <img src="<?= $baseURL; ?>/img/brand.png" width="40%" height="auto" alt="">
                    <div class="sidebar-brand-text mx-3"></div>
                </div>
            </a>


            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Heading -->

            <li class="nav-item">
                <a class="nav-link" href="<?= $baseURL; ?>/views/teacher/indexme.php?t_id=<?= $t_id ?>">
                    <span>
                        <font size="3">หน้าหลัก | อาจารย์</font>
                    </span></a>
                <hr class="sidebar-divider">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>
                        <font size="3">Profile</font>
                    </span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="profile-sidebar">
                        <div class="profile-userpic " style="text-align: center;">
                            <?php if ($picture != "") { ?>
                                <img src="<?= $baseURL; ?>/picture/<?= $picture ?>" class="img-responsive" alt="">
                            <?php } else { ?>
                                <img src="<?= $baseURL; ?>/icon/noimg.png" class="img-responsive" alt="">
                            <?php  } ?>
                        </div>
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                                <?php echo $fna  ?> <?php echo $lna  ?>
                            </div>
                        </div>
                        <div class="profile-userbuttons">
                            <button type="button" class="btn btn-success btn-sm" onclick="location.href='<?= $baseURL; ?>/views/teacher/indexme.php?t_id=<?= $t_id ?>'">Profile</button>
                            <button type="button" class="btn btn-danger btn-sm" href="logout.php" data-toggle="modal" data-target="#logoutModal">Logout</button>
                        </div>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                ข้อมูล
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages3" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>
                        <font size="3">ข้อมูลการนิเทศ</font>
                    </span>
                </a>
                <div id="collapsePages3" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/supervision/index.php">รายละเอียดการนิเทศ</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages4" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>
                        <font size="3">รายงาน</font>
                    </span>
                </a>
                <div id="collapsePages4" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/reportteacher/indexadvisor.php?t_id=<?= $t_id ?>">ข้อมูลนักศึกษา</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/reportteacher/indexdiseaser.php?t_id=<?= $t_id ?>">ข้อมูลโรคประจำตัวนักศึกษา</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/reportadmin/indexpdfcompany.php">สถานประกอบการ</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/reportteacher/indexpetition.php?t_id=<?= $t_id ?>">รายงานข้อมูลคำร้องฝึกงาน</a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
    <?php } //นักศึกษา
    if ($status == '2') {
        $query = "Select * from student WHERE s_user = '$username' AND s_pass = '$password'";
        $result = mysqli_query($conn, $query)
            or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
        while ($row = mysqli_fetch_array($result)) {  // preparing an array
            $username = "$row[s_user]";
            $s_id = "$row[s_id]";
            $fna = "$row[s_fna]";
            $lna = "$row[s_lna]";
            $picture = "$row[s_pic]";
        } ?>
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $baseURL; ?>/views/student/indexme.php?s_id=<?= $s_id ?>">
                <div class="sidebar-brand-icon ">
                    <img src="<?= $baseURL; ?>/img/brand.png" width="40%" height="auto" alt="">
                    <div class="sidebar-brand-text mx-3"></div>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Heading -->

            <li class="nav-item">
                <a class="nav-link" href="<?= $baseURL; ?>/views/student/indexme.php?s_id=<?= $s_id ?>">
                    <span>
                        <font size="3">หน้าหลัก | นักศึกษา</font>
                    </span></a>
                <hr class="sidebar-divider">
                <div class="sidebar-heading">
                    ข้อมูลนักศึกษา
                </div>
                <a class="nav-link" href="<?= $baseURL; ?>/views/student/indexme.php?s_id=<?= $s_id ?>">
                    <i class="fas fa-user-graduate"></i>
                    <span>
                        <font size="3"><?php echo $fna  ?> <?php echo $lna  ?></font>
                    </span>
                </a>
            </li>
            <!-- Nav Item - Dashboard -->
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                ข้อมูล
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>
                        <font size="3">ข้อมูลที่เกี่ยวข้อง</font>
                    </span>
                </a>
                <div id="collapsePages2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/parent/indexme.php?s_id=<?= $s_id ?>">ข้อมูลผู้ปกครอง</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/portfolio/index.php">ข้อมูลผลงานนักศึกษา</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages3" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>
                        <font size="3">ข้อมูลยื่นเรื่องฝึกงาน</font>
                    </span>
                </a>
                <div id="collapsePages3" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/petition/indexcompany.php?s_id=<?= $s_id ?>">การยื่นเรื่องขอฝึกงาน</a> -->
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/petition/index.php?s_id=<?= $s_id ?>">สถานะการยื่นเรื่อง</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages4" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>
                        <font size="3">รายงาน</font>
                    </span>
                </a>
                <div id="collapsePages4" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/reportadmin/indexpdfcompany.php">สถานประกอบการทั้งหมด</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/reportstudent/indexstdsupervision.php?s_id=<?= $s_id ?>">รายงานข้อมูลอาจารย์นิเทศ</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/reportstudent/indexstdscore.php?s_id=<?= $s_id ?>">รายงานข้อมูลผลประเมิน</a>

                    </div>
                </div>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
    <?php } //สถานประกอบการ
    if ($status == '3') {
        $query = "Select * from company WHERE c_user = '$username' AND c_pass = '$password'";
        $result = mysqli_query($conn, $query)
            or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
        while ($row = mysqli_fetch_array($result)) {  // preparing an array
            $username = "$row[c_user]";
            $c_id = "$row[c_id]";
            $name = "$row[c_na]";
        } ?>
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $baseURL; ?>/views/student/indexme.php?s_id=<?= $s_id ?>">
                <div class="sidebar-brand-text mx-3">ระบบจัดการข้อมูลนักศึกษาฝึกงาน</div>
            </a> -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $baseURL; ?>/views/company/indexme.php?c_id=<?= $c_id ?>">
                <div class="sidebar-brand-icon ">
                    <img src="<?= $baseURL; ?>/img/brand.png" width="40%" height="auto" alt="">
                    <div class="sidebar-brand-text mx-3"></div>
                </div>

            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="<?= $baseURL; ?>/views/company/indexme.php?c_id=<?= $c_id ?>">
                    <span>
                        <font size="3">หน้าหลัก | สถานประกอบการ</font>
                    </span></a>
                <hr class="sidebar-divider">
                <div class="sidebar-heading">
                    ข้อมูลสถานประกอบการ
                </div>
                <a class="nav-link" href="<?= $baseURL; ?>/views/company/indexme.php?c_id=<?= $c_id ?>">
                    <i class="fas fa-building"></i>
                    <span>
                        <font size="3"><?php echo $name  ?></font>
                    </span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                ข้อมูล
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>
                        <font size="3">ข้อมูลที่เกี่ยวข้อง</font>
                    </span>
                </a>
                <div id="collapsePages2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/staff/indexcom.php?c_id=<?= $c_id ?>">ข้อมูลผู้ติดต่อ</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/com_demand/index.php?c_id=<?= $c_id ?>">ข้อมูลความต้องการ</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages4" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>
                        <font size="3">รายงาน</font>
                    </span>
                </a>
                <div id="collapsePages4" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/reportcompany/indexcomstu.php?c_id=<?= $c_id ?>">นักศึกษา</a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/reportcompany/indexdisease.php?c_id=<?= $c_id ?>">โรคประจำตัวนักศึกษา </a>
                        <a class="collapse-item" rel="stylesheet" href="<?= $baseURL; ?>/views/reportcompany/indexdoc.php?c_id=<?= $c_id ?>">เอกสารฝึกงาน </a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
<?php }
} ?>