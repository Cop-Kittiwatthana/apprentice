<link href='<?= $baseURL ?>/css/jquery-ui-1.8.10.custom.css' rel='stylesheet' type='text/css' />
<script type="text/javascript" src="<?= $baseURL ?>/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?= $baseURL ?>/js/jquery.datepick.js"></script>

<script type="text/javascript">
    $(function() {
        $('#n_enddate').datepicker({
            buttonImage: 'images/ico-calendar.gif',
            minDate: 0,
            autoclose: true,
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            isBuddhist: true,
            yearRange: "-1:+10",
            dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
            dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
            monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
        });
    });
</script>