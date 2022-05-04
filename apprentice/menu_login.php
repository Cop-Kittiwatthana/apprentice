<?php
session_start();
if (!isset($_SESSION["username"]) && !isset($_SESSION["password"])) {
    header("Location: index.php");
} else {
    include("connect.php");
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $status = $_SESSION["status"];
    $type = $_SESSION["type"];
    //echo $username, $status;
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
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <!-- Topbar Search -->
            <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" id="year" name="year" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                   
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form> -->
            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-md-block d-none">
                    <a class="nav-link">เข้าสู่ระบบครั้งล่าสุด: <?php echo $_SESSION['DATE_LOGIN'] ?> </a>
                </li>
                <div class="topbar-divider d-none d-sm-block"></div>
                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $fna ?> <?php echo $lna ?></span>
                        <?php if ($picture != "") { ?>
                            <img class="img-profile rounded-circle" src="<?= $baseURL; ?>/picture/<?= $picture ?>">
                        <?php } else { ?>
                            <img class="img-profile rounded-circle" src="<?= $baseURL; ?>/icon/noimg.png">
                        <?php  } ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?= $baseURL; ?>/views/teacher/indexme.php?t_id=<?= $t_id ?>">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- End of Topbar -->
    <?php }
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
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-md-block d-none">
                    <a class="nav-link">เข้าสู่ระบบครั้งล่าสุด: <?php echo $_SESSION['DATE_LOGIN'] ?> </a>
                </li>
                <div class="topbar-divider d-none d-sm-block"></div>
                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $fna ?> <?php echo $lna ?></span>
                        <?php if ($picture != "") { ?>
                            <img class="img-profile rounded-circle" src="<?= $baseURL; ?>/picture/<?= $picture ?>">
                        <?php } else { ?>
                            <img class="img-profile rounded-circle" src="<?= $baseURL; ?>/icon/noimg.png">
                        <?php  } ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?= $baseURL; ?>/views/teacher/indexme.php?t_id=<?= $t_id ?>">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- End of Topbar -->
    <?php }
    if ($status == '2') {
        $query = "Select * from student WHERE s_user = '$username' AND s_pass = '$password'";
        $result = mysqli_query($conn, $query)
            or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
        while ($row = mysqli_fetch_array($result)) {  // preparing an array
            $username = "$row[s_user]";
            $fna = "$row[s_fna]";
            $lna = "$row[s_lna]";
            $picture = "$row[s_pic]";
        } ?>
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-md-block d-none">
                    <a class="nav-link">เข้าสู่ระบบครั้งล่าสุด: <?php echo $_SESSION['DATE_LOGIN'] ?> </a>
                </li>
                <div class="topbar-divider d-none d-sm-block"></div>
                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $fna ?> <?php echo $lna ?></span>
                        <?php if ($picture != "") { ?>
                            <img class="img-profile rounded-circle" src="<?= $baseURL; ?>/picture/<?= $picture ?>">
                        <?php } else { ?>
                            <i class="fas fa-user-graduate"></i>
                        <?php  } ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?= $baseURL; ?>/views/student/indexme.php?s_id=<?= $username ?>">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- End of Topbar -->
    <?php }
    if ($status == '3') {
        $query = "Select * from company WHERE c_user = '$username' AND c_pass = '$password'";
        $result = mysqli_query($conn, $query)
            or die("3.ไม่สามารถประมวลผลคำสั่งได้") . $mysqli_error;
        while ($row = mysqli_fetch_array($result)) {  // preparing an array
            $username = "$row[c_user]";
            $c_id = "$row[c_id]";
            $name = "$row[c_na]";
        } ?>
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <!-- Topbar Navbar -->

            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-md-block d-none">
                    <a class="nav-link">เข้าสู่ระบบครั้งล่าสุด: <?php echo $_SESSION['DATE_LOGIN'] ?> </a>
                </li>
                <div class="topbar-divider d-none d-sm-block"></div>
                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $name ?></span>
                        <?php if ($picture != "") { ?>
                            <i class="fas fa-building"></i>
                        <?php } else { ?>
                            <i class="fas fa-building"></i>
                        <?php  } ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?= $baseURL; ?>/views/company/indexme.php?c_id=<?= $c_id ?>">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- End of Topbar -->


<?php }
} ?>