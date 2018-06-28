<div id="content" >
<div class="breadcrumb_main">
<?=$breadcrumb['breadcrumb_main']." » ";?> 
<?=$breadcrumb['hardcoded_segment'].' » ';?>
<?=$breadcrumb['breadcrumb_arrow'];?>
</div> 
<div class="content" id="cunews"> 
<?php 

 $attr=array('id'=>'news_add','action'=>'');
if(empty($id))
{
	echo '<h1>Додати новину</h1>';
	$title_news = array('name'=>'title_news',);
	$small_img = array('small_img'=> '');
	$short_text = array('name'=> 'short_text','rows'=>5,'cols'=>'10');
	$text ='';
	$keywords = array('keywords'=>'');
 	$author=array('author'=>$id_user);
 	$data = array('data'=>date('Y-m-d H:i:s'));
	$vubir = 'Додати';
}
	else
{
	echo '<h1>Редагувати  новину</h1>';
	$title_news = array('name'=>'title_news','value'=>$news['title_news']);
	$small_img = array('small_img'=> $news['small_img']);
	$short_text = array('name'=> 'short_text',"value"=>$news['short_text']);
	$text = $news['text'];
	$keywords = array('keywords'=> $news['keywords']);
 	$author=array('author'=> $news['author']);
 	$data = array('data'=> $news['data']);
	$vubir = 'Оновити';
}
 ?>
  <?=form_open_multipart('#',$attr);?>
 <table>
 <tr>
 <th><?=form_label('Назва новини:','title_news');?></th>
 <td><?=form_input($title_news );?>
 </td>
 </tr>
  <tr>
   <tr>
 <th><?=form_label('Міні-картинка:','small_img');?></th>
 <td class="mini">
 <?=form_hidden($small_img); if(!empty($id)){
	 echo '<img src="'.base_url().$news['small_img'].'"width="150" height="90" id="thumb"/>
	 	   <input  style="display:none"   type="file" name="userfile" id="userfile" />
           <button  name="sub" style="display:none"   type="button" id="upload">Завантажити</button> 
           <button type="button"  id="change">Змінити міні-картинку</button>';
}
 
 else
 {
	echo '<input   type="file" name="userfile" id="userfile" />
<button  name="sub"   type="button" id="upload">Завантажити</button> 
<button type="button" style="display:none"  id="change">Змінити міні-картинку</button	'; 
}
echo form_hidden($small_img);
  ?>
  <p class="run" style="display:none"></p>
</td>
 </tr>
  <tr>
 <th><?=form_label('Короткий опис:','short_text');?></th>
 <td><?=form_textarea($short_text);?></td>
 </tr>
   <tr>
    <th  colspan="2">Основний текст
 <?php $this->CI_CKEditor->editor("text",$text); ?>
 
 </th>
 </tr>
  <tr>
 <td><?=form_hidden($keywords).form_hidden($author).form_hidden($data);?></td>
 <td><input type="hidden" name="publish" value="0"></td>

 </tr>  

    <tr>
 <td></td>
 <td><button name="sub"  type="submit"><?=$vubir;?></button></td>
 </tr> 
 </table>
<?=form_close(); ?>
<script type="text/javascript">
$(function() {
	
   $('#upload').click(function() {
	   
      $.ajaxFileUpload({
         url         :'/photo/upload_file',
         secureuri      :false,
         fileElementId  :'userfile',
         dataType    : 'json',
         success  : function (data, status)
         { 
		 	$('p.run').fadeIn().text('Триває завантаження. Будь ласка зачекайте...');
            if(data.status != 'error')
            {
				$('p.run').fadeIn().text('');
				$('td.mini input,td.mini button').hide();
				$('td.mini').prepend('<img src="/img/news/'+data.msg+'" width="150" height="90" id="thumb"/>');
				$('#change').css('display','block');
				$('td.mini input[type="hidden"]').attr('value','img/news/'+data.msg);
			}else{message('Попередження',data.msg);$('p.run').fadeIn().text('');}
         }
      });
	  
      return false;
   });
  
});
$(document).ready(function(){
	
	$('#change').click(function(){
		
		$('td.mini img').remove();
		$('td.mini input,td.mini button').css('display','block');
		$(this).css('display','none');
		$('td.mini input:hidden').val('');
	});
	
	$("#news_add").validate({
	rules: {
				title_news : {required : true,minlength : 5},
				short_text : {required : true,minlength : 15},
			},
	messages:
	{
		title_news:{required:'Введіть назку новини',minlength:'Мінімум 5 символів'},
		short_text : {required : 'Введіть короткий опис',minlength : 'Мінімум 15 символів'},
	},
	errorPlacement: function(error, element){error.insertAfter(element);},
	submitHandler: function()
	{
		CKEDITOR.instances.ckeditor.updateElement();//оновлення fckeditor
		var  ckVal = CKEDITOR.instances.ckeditor.getData();
		if(ckVal=='')
			message('Попередження','Введіть текст статті');
		else if($('td.mini input[type="hidden"]').val() == '' )
		{
			message('Попередження',"Ви не завантажили міні-картинку");
		}
		else
		{
			$.post("/news/add/<?=$id;?>",$("#news_add").serialize(),function(msg)
			{
				message('Повідомлення',msg);	
				window.location.href = "http://naraiv.org.ua/news/all_where";	
			},'json');	
		}			
	}
});
});
</script>
</div>
<div id="back-top"><a href="#top"><img src="<?=base_url();?>img/up.png" width="128" height="128" title="Вверх" alt="Вгору"></a></div>
</div>
