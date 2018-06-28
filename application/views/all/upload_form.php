<html>
<head>
<title>Форма загрузки</title>
<script type="text/javascript" src="/js/jQuery.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	
$('form').submit(function(e){
	e.preventDefault();
	$.ajax({
          type: "POST",
          data: "ajax=1",
          url: "/upload/do_upload/",
          success: function(msg) {
       		alert(msg);
		  }
	 	});
	});
	
	
	
	});
	
</script>
</head>
<body>

<?php echo $error;?>

<?php echo form_open_multipart('upload/do_upload');?>

<input type="file" name="userfile" size="20" />


<br />

<input type="submit" value="Завантажити!" id="a" />

</form>

</body>
</html>