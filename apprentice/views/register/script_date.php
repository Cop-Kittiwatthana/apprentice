<link href='<?= $baseURL ?>/css/jquery-ui-1.8.10.custom.css' rel='stylesheet' type='text/css' />
<script type="text/javascript" src="<?= $baseURL ?>/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?= $baseURL ?>/js/jquery.datepick.js"></script>

<script type="text/javascript">
    $(function() {
        $('#s_sdate').datepicker({
            buttonImage: 'images/ico-calendar.gif',
            minDate: 0,
            autoclose: true,
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            isBuddhist: true,
            yearRange: "-1:+2",
            dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
            dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
            monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
            onClose: function(dateText, inst) {
                if ($('#s_edate').val() != '') {
                    var testStartDate = $('#s_sdate').datepicker('getDate');
                    var testEndDate = $('#s_edate').datepicker('getDate');
                    if (testStartDate > testEndDate)
                        $('#s_edate').datepicker('setDate', testStartDate);
                } else {
                    $('#s_edate').val(dateText);
                }
            },
            onSelect: function(selectedDateTime) {
                $('#s_edate').datepicker('option', 'minDate', $('#s_sdate').datepicker('getDate'));
            }
        });
        $('#s_edate').datepicker({
            buttonImage: 'images/ico-calendar.gif',
            minDate: 0,
            autoclose: true,
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            isBuddhist: true,
            yearRange: "-1:+2",
            dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
            dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
            monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
            onClose: function(dateText, inst) {
                if ($('#s_sdate').val() != '') {
                    var testStartDate = $('#s_sdate').datepicker('getDate');
                    var testEndDate = $('#s_edate').datepicker('getDate');
                    if (testStartDate > testEndDate)
                        $('#s_sdate').datepicker('setDate', testEndDate);
                } else {
                    $('#s_sdate').val(dateText);
                }
            },
            onSelect: function(selectedDateTime) {
                $('#s_sdate').datepicker('option', 'maxDate', $('#s_edate').datepicker('getDate'));
            }
        });
    });
</script>