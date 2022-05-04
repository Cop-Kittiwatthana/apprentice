<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ข้อมูลข่าวประชาสัมพันธ์</title>


   <?php include("../../head.php"); ?>

  <!--ปฏิทิน-->

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js" integrity="sha256-0YPKAwZP7Mp3ALMRVB2i8GXeEndvCq3eSl/WsAl1Ryk=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">

  <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
</head>

<body id="page-top">
  <tr>
    <th>เริ่มแสดงข่าว :</th>
    <td>
      <input class="form-control" placeholder="กรุณาเลือก ว/ด/ป เริ่มแสดงข่าว" autocomplete="off" type="text" name="pu_datestrat" id="pu_datestrat" onkeypress="isInputChar(event)" />
    </td>
  </tr>
  <br>
  <tr>
    <th>แสดงข่าวถึง :</th>
    <td>
      <input class="form-control" placeholder="กรุณาเลือก ว/ด/ป แสดงข่าวถึง" autocomplete="off" type="text" name="pu_dateend" id="pu_dateend" onkeypress="isInputChar(event)" />
    </td>
  </tr>
  <br>
  <center>
    <tr>
      <td colspan="2" align="center">
        <input class="btn btn-success mb-3" type="submit" name="btnsave" id="btnsave" value=" บันทึก " />
        <input class="btn btn-danger mb-3" type="reset" onclick="window.history.back()" name="btnCancel" id="btnCancel" value=" ยกเลิก " />
      </td>
  </center>
  </tr>
  <br>
  </div>
  </form>
  </tr>

  </div>
  <!-- End of Main Content -->

  </div>
  <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->

  <script type="text/javascript">
    $(function() {
      $("#pu_datestrat").datepicker({
        numberOfMonths: 2,
        onSelect: function(selected) {
          var dt = new Date(selected);
          dt.setDate(dt.getDate() + 1);
          $("#pu_dateend").datepicker("option", "minDate", dt);
        }
      });
      $("#pu_dateend").datepicker({
        numberOfMonths: 2,
        onSelect: function(selected) {
          var dt = new Date(selected);
          dt.setDate(dt.getDate() - 1);
          $("#pu_datestrat").datepicker("option", "maxDate", dt);
        }
      });
    });
  </script>


</body>

</html>

