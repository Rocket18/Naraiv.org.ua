<div id="content" >
<div class="breadcrumb_main">
<?=$breadcrumb['breadcrumb_main']." » ";?>
<?=$breadcrumb['hardcoded_segment'];?>
<a href="#" onClick="advert();" class="Add">Додати оголошення</a>
</div>
<div id="advert">
<form action="" method="post" id="advertForm" style="display:none" >
<div class="ruleStar">Поля відмічені * обов'язкові для заповнення</div>
<table>
  <tr>
    <th><label for="title">Заголовок<span class="red">*</span></label></th>
    <td><input name="title" type="text"></td>
  </tr>
  <tr>
    <th><label for="cat">Категорія<span class="red">*</span></label></th>
    <td>
     <select id="cat"  name="cat" >
      <option value="0">Обрати:</option>
      <option value="1">Куплю</option>
      <option value="2">Продам</option>
      <option value="3">Шукаю</option>
      <option value="4">Послуги</option>
     </select>
    </td>
  </tr>
  <tr>
    <th><label for="tel">Контактний номер<span class="red">*</span></label></th>
    <td><input name="tel" type="text"></td>
  </tr>
  <tr>
    <th><label for="name">Ваше ім'я<span class="red">*</span></label></th>
    <td><input name="name" type="text"></td>
  </tr>
  <tr>
    <th><label for="description">Опис<span class="red">*</span></label></th>
    <td><textarea id="AdvertTextarea" name="description" cols="" rows=""></textarea></td>
  </tr>
  <tr>
    <th><label for="email">Email<span class="red">*</span></label></th>
    <td><input name="email" type="text"></td>
  </tr>
  <tr>
    <th><label for="skype">Skype</label></th>
    <td><input name="skype" type="text"></td>
  </tr>
  <tr>
    <td colspan="2"><input name="sub" type="checkbox" id="rul" value="1"> Я згідний(на) з правилами використання сайту, а також з передачею та обробкою моїх даних, також підтверджую свою відповідальність за розміщення даного рекламного оголошення </td>
   
  </tr>
  <tr>
  <td colspan="2">
  <button type="submit" name="sub">Надіслати</button>
  </td>

  </tr>
</table>

</form>
<?php 
foreach($advert as $advert):
?>
<article class="advert">
<h1><?=$advert['title'];?></h1>
 <div class="text"><?=$advert['description'];?></div>

<div class="meta"> 
<span>
<img src="/img/cat.png" title="Категорія">
 <?php switch($advert['cat']){case 1: echo 'Куплю';break;case 2:echo 'Продам';break;case 3:echo 'Шукаю';break;case 4:echo 'Послуги';break;} ?>
 </span>
 <span><img src="/img/people.png" title="Автор"> <?=$advert['name'];?></span>
  <span ><img src="/img/phone.png" title="Телефон"> <?=$advert['tel'];?></span>
  <span><img src="/img/email.png" title="Email">
<?=$advert['email'];?></span>
<?php if(!empty($advert['skype']))echo '<span><img src="/img/skype.png" title="Skype"> '.$advert['skype'].'</span>';?>
   <span><img src="/img/date.png" title="Додано">
<?=$advert['date'];?></span>
  </div>
</article>
<?php endforeach;?>
</div>
 <div id="back-top"><a href="#top"><img src="/img/up.png" width="128" height="128" title="Вверх" alt="Вгору"></a></div>
</div>
<script>
function advert()
{
	$('#advertForm')[0].reset();
    $( "#advertForm" ).dialog({
		 height: 450,
      width: 390,
	  title:"Додати оголошення",
      modal: true
		});
}
$(document).ready(function(e) {
    $("#advertForm").validate({
		rules:
		{
			title : {required : true},
			tel : {required : true},
			name : {required : true},
			description : {required : true,minlength:15},
			email :{required : true,email:true}
			
		},
		messages:
		{
				title : {required : 'Введіть заголовок'},
				tel : {required : 'Введіть контактний телефон'},
				name : {required : 'Введіть ваше ім\'я'},
				description : {required : 'Введіть короткий опис',minlength:"Мінімум 15 символів"},
				email : {required : 'Введіть  email',email:'Введіть коректний email'}
		},
		errorPlacement: function(error, element)
		{	
			error.insertBefore(element);
		},
		submitHandler: function()
		{
			if($("#cat").val()==0)
				message('Попередження','Не обрано категорію');	
			else if($("#rul").prop("checked")==false)
				message('Попередження','Поставте галочку');		
			else
				$.post('/main/advertAdd',$("#advertForm").serialize(),function(msg)
				{
					window.location.href = "http://naraiv.org.ua/advert";		
				});
				
			
		}
	});
});
</script>