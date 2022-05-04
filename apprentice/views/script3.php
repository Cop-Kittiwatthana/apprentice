<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script type="text/javascript">
  $('#provinces3').change(function() {
    var id_province = $(this).val();

      $.ajax({
      type: "POST",
      url: "../ajax_db3.php",
      data: {id:id_province,function:'provinces3'},      
      success: function(data){
          $('#amphures3').html(data); 
          $('#districts3').html(''); 
          $('#districts3').val('');  
          $('#zip_code3').val(''); 
      }
    });
  });

  $('#amphures3').change(function() {
    var id_amphures = $(this).val();
      $.ajax({
      type: "POST",
      url: "../ajax_db3.php",
      data: {id:id_amphures,function:'amphures3'},
      success: function(data){
          $('#districts3').html(data);  
      }
    });
  });

   $('#districts3').change(function() {
    var id_districts= $(this).val();

      $.ajax({
      type: "POST",
      url: "../ajax_db3.php",
      data: {id:id_districts,function:'districts3'},
      success: function(data){
          $('#zip_code3').val(data)
      }
    });
  
  });
</script>