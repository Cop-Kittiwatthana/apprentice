<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
    <?php include("head.php"); ?>
</head>

<body>

    <?php
    $TH_Month = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $nMonth = date("n") - 1;
    $date = date("j");
    $year = date("Y") + 543;
    $time = date("H:i:s");
    $_SESSION['DATE_LOGIN'] = $date . '-' . $TH_Month[$nMonth] . '-' . $year . '&nbsp;' . $time;
    //include('connect.php');
    session_start();
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['status'])) {

        include("connect.php");
        $username = $_POST['username'];
        $password = $_POST['password'];
        $status = $_POST['status'];
        //แอดมิน
        if ($status == '0') {
            $query = "SELECT * FROM teacher WHERE t_user = '$username' AND 	t_pass = '$password'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result);
                $_SESSION['username'] = $row['t_user'];
                $_SESSION['password'] = $row['t_pass'];
                $_SESSION['type'] = $row['type'];
                $_SESSION['t_fna'] = $row['t_fna'];
                $_SESSION['t_lna'] = $row['t_lna'];
                $_SESSION['t_pic'] = $row['t_pic'];
                $_SESSION['DATE_LOGIN'] = $date . '-' . $TH_Month[$nMonth] . '-' . $year . '&nbsp;' . $time;
                $t_id = $row['t_id'];
                $_SESSION['status'] = '0';
                if ($_SESSION['type'] == '0') {
                    echo "<script>Swal.fire({
                        type: 'success',
                        title: 'ยินดีต้อนรับผู้ดูแลระบบเข้าสู่ระบบ',
                        showConfirmButton: true,
                        timer: 1500
                        }).then(() => { 
                            window.location = 'indexnews.php'
                            });
                            </script>";
                    exit();
                }
                //อาจารย์
                if ($_SESSION['type'] == '1') {
                    echo "<script>Swal.fire({
                        type: 'success',
                        title: 'ยินดีต้อนรับเข้าสู่ระบบ',
                        showConfirmButton: true,
                        timer: 1500
                        }).then(() => { 
                            window.location = '$baseURL/views/teacher/indexme.php?t_id=$t_id'
                            });
                            </script>";
                    exit();
                }
            } else {
                echo "<script>Swal.fire({
                            type: 'error',
                            title: 'Not Found',
                            showConfirmButton: true,
                            timer: 1500
                          }).then(() => { 
                              window.history.go(-1)
                            });
                         
                          </script>";
                exit();
            }
        }
        //นักศึกษา
        if ($status == '2') {
            $query = "SELECT * FROM student WHERE s_user = '$username' AND 	s_pass = '$password'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result);
                $_SESSION['username'] = $row['s_user'];
                $_SESSION['password'] = $row['s_pass'];
                $_SESSION['status'] = '2';
                $_SESSION['DATE_LOGIN'] = $date . '-' . $TH_Month[$nMonth] . '-' . $year . '&nbsp;' . $time;
                if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
                    // $_SESSION['type'] = $_GET['type'];
                    echo "<script>Swal.fire({
                            type: 'success',
                            title: 'ยินดีต้อนรับเข้าสู่ระบบ',
                            showConfirmButton: true,
                            timer: 1500
                            }).then(() => { 
                                window.location = '$baseURL/views/student/indexme.php?s_id=$_SESSION[username]'
                                });
                                </script>";
                    exit();
                }
            } else {
                echo "<script>Swal.fire({
                        type: 'error',
                        title: 'Not Found',
                        showConfirmButton: true,
                        timer: 1500
                      }).then(() => { 
                          window.history.go(-1)
                        });
                     
                      </script>";
                exit();
            }
        }
        //สถานประกอบการ
        if ($status == '3') {
            $query = "SELECT * FROM company WHERE c_user = '$username' AND 	c_pass = '$password'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result);
                $_SESSION['username'] = $row['c_user'];
                $_SESSION['password'] = $row['c_pass'];
                $c_id = $row['c_id'];
                $_SESSION['status'] = '3';
                $_SESSION['DATE_LOGIN'] = $date . '-' . $TH_Month[$nMonth] . '-' . $year . '&nbsp;' . $time;
                if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
                    // $_SESSION['type'] = $_GET['type'];
                    echo "<script>Swal.fire({
                        type: 'success',
                        title: 'ยินดีต้อนรับเข้าสู่ระบบ',
                        showConfirmButton: true,
                        timer: 1500
                        }).then(() => { 
                            window.location = '$baseURL/views/company/indexme.php?c_id=$c_id'
                            });
                            </script>";
                    exit();
                }
            } else {
                echo "<script>Swal.fire({
                        type: 'error',
                        title: 'ไม่พบผู้ใช้!!!',
                        showConfirmButton: true,
                        timer: 1500
                      }).then(() => { 
                          window.history.go(-1)
                        });
                     
                      </script>";
                exit();
            }
        }
    } else {
        echo "<script>Swal.fire({
                type: 'error',
                title: 'กรุณากรอกข้อมูลให้ถูกต้อง!!!',
                showConfirmButton: true,
                timer: 1500
              }).then(() => { 
                  window.history.go(-1)
                });
              </script>";
        exit();
    }

    ?>
</body>

</html>