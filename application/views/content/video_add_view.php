<div id="content" >
<div class="breadcrumb_main">
<?=$breadcrumb['breadcrumb_main']." » ";?>
<?=$breadcrumb['hardcoded_segment']." » ";?>
<?=$breadcrumb['breadcrumb_arrow'];?>
<div id="time"></div>
</div>
<div class="video">
<div class="preview"><p>Мабуть кожен знає про відеосервіс YouTube і зареєстрований в Google. Тому для, того щоб додати відеозапис на наш сайт необхідно залити його у свій анкаут на YouTube  і скопіювати силку у форму нижче. На жаль прямого завантаження відео на нашому сайті поки немає(в розробці).</p><p>Якщо користувач авторизований - відео буде додано одразу, Гість - після перевірки адміністратором. </p></div>
<form action="" method="post" id="addVideo">
<div class="ruleStar">Поля відмічені * обов'язкові для заповнення</div>
<table>
  <tr>
    <th><label for="name">Назва<span class="red">*</span></label></th>
    <td><input name="name" type="text"></td>
  </tr>

  <tr>
    <th><label for="href">Силка на відео<span class="red">*</span></label></th>
    <td><input name="href" type="text" placeholder="http://"></td>
  </tr>
  <tr>
    <th><label for="date">Дата<span class="red">*</span></label></th>
    <td><input name="date" type="text" value="<?=date('Y-m-d H:i:s');?>"></td>
  </tr>
    <tr>
    <th><label for="access">Доступ<span class="red">*</span></label></th>
    <td>
     <select id="access"  name="access" >
      <option value="0">Обрати:</option>
      <option value="1">Для всіх</option>
      <option value="2">Тільки для зареєстрованих</option>
     </select>
    </td>
  </tr>
  <tr>
    <td colspan="2"><p class="rul"><input name="sub" type="checkbox" id="rul" value="1"> Я згідний(на) з правилами використання сайту, а також з передачею та обробкою моїх даних, також підтверджую свою відповідальність за розміщення даного відеоролика</p></td>
   
  </tr>
  <tr>
  <td colspan="2">
  <button class="s_video sub" type="submit" name="sub">Додати</button>
  </td>

  </tr>
</table>

</form>
</div>
<script>
$(document).ready(function(e) {
    $("#addVideo").validate({
		rules:
		{
			name : {required : true,minlength:5},
			href : {required : true},
			date : {required : true}
		},
		messages:
		{
				name : {required : 'Введіть назву відео',minlength:"Мінімум 5 символів"},
				href : {required : 'Введіть силку на відео'},
				date : {required : 'Введіть дату'},
		},
		errorPlacement: function(error, element)
		{	
			error.insertBefore(element);
		},
		submitHandler: function()
		{
			if($("#access").val()==0)
				message('Попередження','Оберіть доступ');	
			else if($("#rul").prop("checked")==false)
				message('Попередження','Поставте галочку');		
			else
				$.post('/video/add',$("#addVideo").serialize(),function(msg)
				{
					message('Повідомлення','Відеозапис додано');	
					window.location.href = "http://naraiv.org.ua/video/add";	
					
					
				});
				
			
		}
	});
});
</script>
 <div id="back-top"><a href="#top"><img src="/img/up.png"  title="Вверх" alt="Вгору"></a></div>
 </div>