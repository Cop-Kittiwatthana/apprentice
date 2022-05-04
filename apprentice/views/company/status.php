<?php
if (isset($_POST['btnstatus'])) {
    $c_id = $_POST['c_id'];
    $c_status = $_POST['c_status'];
    if ($c_status == 0) {
        $query = "UPDATE company set c_status='$c_status' WHERE c_id = '$c_id'";
        mysqli_query($conn, $query);
        echo "<script language='javascript'>window.location = 'index.php';</script>";
        // echo "<script>
        // Swal.fire({
        // type: 'success',
        // title: 'สถานะเปิด',
        // showConfirmButton: true,
        // timer: 1500
        // }).then(() => {
        // window.location = 'index.php'
        // });
        // </script>";
    }
    if ($c_status == 1) {
        $query = "UPDATE company set c_status='$c_status' WHERE c_id = '$c_id'";
        mysqli_query($conn, $query);
         echo "<script language='javascript'>window.location = 'index.php';</script>";
        //  echo "<script>Swal.fire({
        // 	type: 'error',
        // 	title: 'สถานะปิด',
        // 	showConfirmButton: true,
        // 	timer: 1500
        //   }).then(() => { 
        // window.location = 'index.php'
        // 	});
        //   </script>";
    }
}
