<link href='<?= $baseURL ?>/css/jquery-ui-1.8.10.custom.css' rel='stylesheet' type='text/css' />
<script type="text/javascript" src="<?= $baseURL ?>/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?= $baseURL ?>/js/jquery.datepick.js"></script>

<script type="text/javascript">
    $(function() {
        $('#s_bdate').datepicker({
            buttonImage: 'images/ico-calendar.gif',
            maxDate: -6930,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy',
            isBuddhist: true,
            yearRange: "-30:+1",
            dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
            dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
            monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
            onClose: function(dateText, inst) {
                var today = new Date();
                var tday = String(today.getDate()).padStart(2, '0');
                var tmonth = String(today.getMonth() + 1).padStart(2, '0');
                var tyear = today.getFullYear() + 543;
                var dateObject = $("#s_bdate").datepicker("getDate");
                var bday = String(dateObject.getDate()).padStart(2, '0');
                var bmonth = String(dateObject.getMonth() + 1).padStart(2, '0');
                var byear = dateObject.getFullYear() + 543;
                var m = tmonth - bmonth;
                var age = tyear - byear;
                if (m < 0 || (m === 0 && tday < bday)) {
                    age--;
                }
                $('#s_age').val(age);
                // var mbirthday = new Date(byear, bmonth, bday, 0, 0, 0).getTime() / 1000;
                // var mnow = new Date(tyear, tmonth, tday, 0, 0, 0).getTime() / 1000;
                // var mage = (mnow - mbirthday);
                // var u_y = mage.getFullYear() - 1970;
                // $('#s_age').val(u_y);

            },
        });
    });
</script>