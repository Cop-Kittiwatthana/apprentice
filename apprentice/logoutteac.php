<?php
session_start();
include("connect.php");
unset($_SESSION["username"]);
unset($_SESSION["password"]);
unset($_SESSION["status"]);
session_destroy();
?>
<script language="javascript">
window.location = '<?= $baseURL; ?>/frm_loginteac.php';
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>