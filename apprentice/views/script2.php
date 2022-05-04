<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script type="text/javascript">
  $('#provinces2').change(function() {
    var id_province = $(this).val();

      $.ajax({
      type: "POST",
      url: "../ajax_db2.php",
      data: {id:id_province,function:'provinces2'},      
      success: function(data){
          $('#amphures2').html(data); 
          $('#districts2').html(''); 
          $('#districts2').val('');  
          $('#zip_code2').val(''); 
      }
    });
  });

  $('#amphures2').change(function() {
    var id_amphures = $(this).val();
      $.ajax({
      type: "POST",
      url: "../ajax_db2.php",
      data: {id:id_amphures,function:'amphures2'},
      success: function(data){
          $('#districts2').html(data);  
      }
    });
  });

   $('#districts2').change(function() {
    var id_districts= $(this).val();

      $.ajax({
      type: "POST",
      url: "../ajax_db2.php",
      data: {id:id_districts,function:'districts2'},
      success: function(data){
          $('#zip_code2').val(data)
      }
    });
  
  });
</script>