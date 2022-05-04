<?php include("connect.php"); ?>
<!-- Custom fonts for this template -->
<link href="<?= $baseURL ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="<?= $baseURL ?>/css/sb-admin-2.min.css" rel="stylesheet">
<link href="<?= $baseURL ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script type="text/javascript" language="javascript" src="<?= $baseURL ?>/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?= $baseURL ?>/js/jquery.dataTables.js"></script>
<!-- alert -->
<link rel="stylesheet" href="<?= $baseURL ?>/css/sweetalert2.min.css">
<script src="<?= $baseURL ?>/js/sweetalert2.min.js"></script>
<!-- <script src="<?= $baseURL ?>/js/excelexportjs.js"></script> -->

<!-- datetime -->




<!-- onkeypress -->
<script>
	function isInputNumber(evt) {
		var ch = String.fromCharCode(evt.which);
		if (!(/[0-9]/.test(ch))) {
			evt.preventDefault();
		}
	}

	function isInputNumber2(evt) {
		var ch = String.fromCharCode(evt.which);
		if (!(/[0-9 && / && .]/.test(ch))) {
			evt.preventDefault();
		}
	}

	function isInputChar(evt) {
		var ch = String.fromCharCode(evt.which);
		if (!(/[a-z && A-Z && ก-ฮ && ะ && า &&  ิ &&  ี && ึ && ื && ุ && ู && เ && แ && โ && ์ && ่ && ้ && ๊ && ๋ && ๆ && ไ && ำ && ั && ็ && ใ]/.test(ch))) {
			evt.preventDefault();
		}
	}

	function isInputCharth(evt) {
		var ch = String.fromCharCode(evt.which);
		if (!(/[- &&ก-ฮ && ะ && า &&  ิ &&  ี && ึ && ื && ุ && ู && เ && แ && โ && ์ && ่ && ้ && ๊ && ๋ && ๆ && ไ && ำ && ั && ็ && ใ]/.test(ch))) {
			evt.preventDefault();
		}
	}

	function isInputChar1(evt) {
		var ch = String.fromCharCode(evt.which);
		if (!(/[. && a-z && A-Z && ก-ฮ && ะ && า &&  ิ &&  ี && ึ && ื && ุ && ู && เ && แ && โ && ์ && ่ && ้ && ๊ && ๋ && ๆ && ไ && ำ && ั && ็ && ใ]/.test(ch))) {
			evt.preventDefault();
		}
	}

	function isInputChar2(evt) {
		var ch = String.fromCharCode(evt.which);
		if (!(/[- && / && 0-9 && a-z && A-Z && ก-ฮ && ะ && า &&  ิ &&  ี && ึ && ื && ุ && ู && เ && แ && โ && ์ && ่ && ้ && ๊ && ๋ && ๆ && ไ && ำ && ั && ็ && ใ]/.test(ch))) {
			evt.preventDefault();
		}
	}

	function isInputPassword(evt) {
		var ch = String.fromCharCode(evt.which);
		if (!(/[a-z && A-Z && 0-9]/.test(ch))) {
			evt.preventDefault();
		}
	}
</script>