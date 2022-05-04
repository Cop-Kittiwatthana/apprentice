<link href='<?= $baseURL ?>/css/jquery-ui-1.8.10.custom.css' rel='stylesheet' type='text/css' />
<script type="text/javascript" src="<?= $baseURL ?>/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?= $baseURL ?>/js/jquery.datepick.js"></script>

<script type="text/javascript">
    $(function() {
        $('#pe_date1').datepicker({
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
                if ($('#pe_date2').val() != '') {
                    var testStartDate = $('#pe_date1').datepicker('getDate');
                    var testEndDate = $('#pe_date2').datepicker('getDate');
                    if (testStartDate > testEndDate)
                        $('#pe_date2').datepicker('setDate', testStartDate);
                } else {
                    $('#pe_date2').val(dateText);
                }
            },
            onSelect: function(selectedDateTime) {
                $('#pe_date2').datepicker('option', 'minDate', $('#pe_date1').datepicker('getDate'));
            }
        });
        $('#pe_date2').datepicker({
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
                if ($('#pe_date1').val() != '') {
                    var testStartDate = $('#pe_date1').datepicker('getDate');
                    var testEndDate = $('#pe_date2').datepicker('getDate');
                    if (testStartDate > testEndDate)
                        $('#pe_date1').datepicker('setDate', testEndDate);
                } else {
                    $('#pe_date1').val(dateText);
                }
            },
            onSelect: function(selectedDateTime) {
                $('#pe_date1').datepicker('option', 'maxDate', $('#pe_date2').datepicker('getDate'));
            }
        });
    });
</script>