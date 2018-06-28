<section>
<div class="menu">
<?php 
$this->Menu_lib->outTreeAdmin(0,0);
?>
</div>
<div class="rud">
<div id="dialog-message"></div>
<p class="load"></p>
<form action="" method="post" id="pages">
<table>
<tr>
	<td><label for="id">ID</label><input class="style_p" name="id" id="id" type="text" size="2" readonly></td>
    <td><label for="menu_id">Назва силки</label><input class="style_p" name="menu_id"  type="text" readonly></td>
    <td><label for="parent_id">Батьківський id</label><input class="style_p" name="parent_id"  size="2" type="text"></td>
    <td><label for="new">Сторінка нова</label><input name="new" type="checkbox" value="1"></td>
</tr>
<tr>
	<td><label for="name">Ім'я сторінки</label></td><td colspan="3"><input class="stylepage" name="name" type="text" ></td>
</tr>
<tr>
<tr>
	<td><label for="title">Заголовок сторінки</label></td><td colspan="3"><input class="stylepage" name="title" type="text" ></td>
</tr>
<tr>
    <td><label for="description">Короткий опис</label></td><td colspan="3"><textarea id="meta_d" name="description" cols="" rows=""></textarea></td>
</tr>
<tr>
	<td><label for="keywords">Ключові слова</label></td><td colspan="3"><input class="stylepage" name="keywords" type="text" ></td>
</tr>
<tr>
    <td colspan="4"><label for="main_text">Основний текст</label></td>
</tr>
<tr>
	<td colspan="4"><?php $this->CI_CKEditor->editor("main_text"); ?></td>
</tr>
<tr>
<td colspan="4"><input name="sub" type="submit" value="Оновити"></td>
</tr>
</table>
</form>
</div>
</section>
<script type="text/javascript">
$(document).ready(function(){
	var url;
	$('input,#meta_d').attr('disabled','disabled');
	$('.menu a').click(function(e){
		e.preventDefault();
		url  = $(this).attr('href');
		$.ajax({
          type: "POST",
          data: "ajax=1",
          url: url,
          beforeSend: function() 
		  {
            $("p.load").html('Триває завантаження...');
          },
          success: function(msg)
		  {
            var data,pole ;
			pole = ["id","menu_id","parent_id","name","title","keywords"];
			data = JSON.parse(msg);
			for(var i =0;i<pole.length;i++)
			{
				$("input[name = '"+pole[i]+"']").val(data[pole[i]]);
			}
			if(data['new']==1)
				{$("input[name = 'new']").attr("checked","checked");}
			else
				{$("input[name = 'new']").removeAttr('checked');}
			$("#meta_d").html(data['description']);
			 CKEDITOR.instances['ckeditor'].setData(data['main_text']);
			 $('input,#meta_d').removeAttr('disabled');
			$("p.load").html('');
          }
        });
	});
	$("#pages").validate({
		rules:
		{
			parent_id:  {required : true,number:true},
			name:  {required : true},
			title:  {required : true},
			description:  {required : true},
		},
		messages:{},
		errorPlacement: function(error, element)
		{	
			//error.insertAfter(element);
		},
		submitHandler: function()
		{
			CKEDITOR.instances.ckeditor.updateElement();//оновлення fckeditor
			$.post("/adminka/pageupdate",$("#pages").serialize(),function(msg)
			{
				message('',msg);
				$( "form" )[ 0 ].reset();
				 CKEDITOR.instances['ckeditor'].setData('');
				 $('#meta_d').html('');
				 $('input,#meta_d').attr('disabled','disabled');
			},'json');
		}
	});

	
});
</script>
