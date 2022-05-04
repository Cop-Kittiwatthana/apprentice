<?php include("connect.php"); ?>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">คำเตือน!</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">คุณต้องการออกจากระบบใช่หรือไม่?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                <a class="btn btn-primary" href="logout.php">ออกจากระบบ</a>
            </div>
        </div>
    </div>
</div>
<!-- ********************************************** -->
<script src="<?= $baseURL ?>/vendor/jquery/jquery.min.js"></script>
<script src="<?= $baseURL ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= $baseURL ?>/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= $baseURL ?>/js/sb-admin-2.min.js"></script>
<script src="<?= $baseURL ?>/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= $baseURL ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!-- <script src="<?= $baseURL ?>/vendor/chart.js/Chart.min.js"></script>
<script src="<?= $baseURL ?>/js/demo/chart-area-demo.js"></script>
<script src="<?= $baseURL ?>/js/demo/chart-pie-demo.js"></script> -->
<!-- <script src="../js/demo/datatables-demo.js"></script> -->
<!-- loading -->
<link rel="stylesheet" type="text/css" href="<?= $baseURL ?>/css/loading.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/loadingio/loading.css@v2.0.0/dist/loading.min.css" />