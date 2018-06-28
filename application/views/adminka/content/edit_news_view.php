<div id="news_crud">
 <h1>Додати новину</h1>
 <?php 
 $attr=array('id'=>'news_add','action'=>'');
 $author=array('name'=> 'author','value'=> 'Тарас Красниця');
 $small_img = array('name'=> 'small_img',"placeholder"=>"/img/news/");
 $data = array('name'=> 'data','value'=>date('Y-m-d H:i:s'));
 $yes = array('name'=> 'puplish','value'=> '1','checked'=> TRUE,'class'=>'subForm');
 $no = array('name'=> 'puplish','value'=> '0','class'=>'subForm');
 ?>
  <?=form_open_multipart('#',$attr);?>
 <table>
 <tr>
 
 <th><?=form_label('Назва новини:','title_news');?></th>
 <td><?=form_input('title_news');?></td>
 </tr>
  <tr>
   <tr>
 <th><?=form_label('Шлях до міні-картинки:','small_img');?></th>
 <td><?=form_input($small_img);?></td>
 </tr>
  <tr>
 <th><?=form_label('Короткий опис:','short_text');?></th>
 <td><?=form_textarea('short_text');?></td>
 </tr>
   <tr>
    <th  colspan="2">Основний текст
 <?=$this->CI_CKEditor->editor("text");?>
 
 </th>
 </tr>
  <tr>
 <th><?=form_label('Ключові слова:','keywords');?></th>
 <td><?=form_textarea('keywords');?></td>
 </tr>  
  <tr>
 <th><?=form_label('Автор:','author');?></th>
 <td><?=form_input($author);?></td>
 </tr> 
   <tr>
 <th><?=form_label('Дата:','data');?></th>
 <td><?=form_input($data).form_hidden('ip');?></td>
 </tr> 
    <tr>
 <th><?=form_label('Публікувати:','publish');?></th>
 <td>  
 	<input name="publish" type="checkbox" value="1" checked="checked" /> Так            
 </td>
 </tr> 
    <tr>
 <td></td>
 <td><?=form_submit(array("class"=>"subForm","name"=>"sub"),'Додати');?></td>
 </tr> 
 </table>
<?=form_close(); ?>  
<script type="text/javascript">
$(document).ready(function(){

	$("#news_add").validate({
						rules: {
									title_news : {required : true, maxlength : 80},
									short_text : {required : true},
									keywords:{required : true},
									author : {required : true},
									data : {required : true}
									
								},
						messages:{
									
								 },
						errorPlacement: function(error, element)
						{	
							
						},
						submitHandler: function()
						
						{
							 CKEDITOR.instances.ckeditor.updateElement();//оновлення fckeditor
							$.post("/news/add",$("#news_add").serialize(),function(msg){
								alert(msg);		
										},'json');	
										
						}
					});
});
</script>
</div>	