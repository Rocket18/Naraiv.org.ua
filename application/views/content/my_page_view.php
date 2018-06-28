<div id="content" >
<div class="breadcrumb_main">
<?=$breadcrumb['breadcrumb_main']." » ";?> 
<?=$breadcrumb['hardcoded_segment']." » ";?>
<?=$breadcrumb['breadcrumb_arrow'];?>
</div> 
<div class="content">

<table id="my_page">
<tr>

	<th>Прізвище</th>
    <td><label for="surname"><?php if(empty($user['surname']))echo 'Додати прізвище';else echo $user['surname'];?></label><button style="display:none" class="surname" type="button">Змінити</button>
    </td>
</tr>
<tr>
	<th>Ім'я</th>
    <td><label for="name"><?php if(empty($user['name']))echo 'Додати ім\'я'; echo $user['name'];?></label>
    <button style="display:none" class="name" type="button">Змінити</button>
    </td>
</tr>
<tr>
	<th>Дата народження</th>
    <td id="beart"><input type="date" name="birth" value="<?=$user['birth'];?>"></td>
</tr>
<!--<tr>
	<th>Електронна пошта</th>
    <td id="changeEmail">Змінити

    </td>
</tr>-->
<tr>
	<th>Пароль</th>
    <td><div class="changePass">Змінити</div>
        <table id="changePass" style="display:none">
    <form method="post" action="">
    <tr><td>Введіть поточний пароль</td><td> <input name="lastpass" type="password" value=""></td></tr>
   
     <tr><td>Введіть новий пароль</td><td> <input name="newpass" type="password" value=""></td></tr>
    <tr><td>Введіть пароль ще раз</td><td> <input name="newpass2" type="password" value=""></td></tr>
   <tr><td colspan="2"><div class="error"></div><button type="button" id="changeP">Змінити</button></td></tr>
    </form>
    </table
    ></td>
</tr>
<tr>
	<th>Додано новин</th>
    <td><?=$news;?></td>
</tr>
<tr>
	<th>Завантажено фотографій</th>
    <td><?=$photo;?></td>
</tr>
<!--<tr>
	<th>Завантажено відео</th>
    <td></td>
</tr>
--></table>
</div>
<div id="back-top"><a href="#top"><img src="<?=base_url();?>img/up.png" width="128" height="128" title="Вверх" alt="Вгору"></a></div>
</div>
<script>
$(document).ready(function(){
	$('.changePass').toggle(function(){
		$('#changePass').fadeIn(2000);
	},function(){
		$('#changePass').fadeOut(2000);
		});
	
	$('#changeP').click(function(){
		var current = $('input[name="lastpass"]').val();
		var new1 = $('input[name="newpass"]').val();
		var new2 = $('input[name="newpass2"]').val();
		if(current.length<6 || new1.length<6 || new2.length<6)
			$("div.error").fadeTo(200,0.1,function() //начнет появляться сообщение
			{ 
				$(this).html('Мінімальна довжина паролю 6 символів').fadeTo(900,1).fadeOut(2000);
			});
		else
		{
			$.post('/users/changePass',{pass:current},function(msg)
			{
				if(msg=='1')
				{
					if(new1===new2)
					{
						$.post('/users/updatePass',{pass:new1},function()
						{
							message('Повідомлення','Пароль успішно змінено');
							$('#changePass input').val('');
							$('#changePass').fadeOut(2000);
						});
					}
					else
					{
						$("div.error").fadeTo(200,0.1,function() //начнет появляться сообщение
					{ 
						$(this).html('Паролі не співпадають').fadeTo(900,1).fadeOut(2000);
					});
					}
				}
				else
				{
					$("div.error").fadeTo(200,0.1,function() //начнет появляться сообщение
					{ 
						$(this).html('Невірно введений поточний пароль').fadeTo(900,1).fadeOut(2000);
					});
				}
			});
		}
	});



$('#my_page label').click(function(){
	cancel();
	var name = $(this).attr('for');
	var val = $(this).text();
	$(this).hide();
	$('button.'+name).show();
	$(this,'label').after('<div><input class="curent" name="'+name+'" type="text" value="'+val+'"></div>');
		
	});

$('button.surname,button.name').click(function(){
	$.post('/users/edit',$('input.curent').serialize());
	
	cancel();
});
function cancel()
{
	var name = $('input.curent').attr('name');
	var val  = $('input.curent').val();
	$('label[for='+name+']').text(val);
	$('label').show();
	$('input.curent').parent().remove();
	$('button.'+name).hide();
	$('#my_page div.'+name+'').hide();	
}
$('#changeEmail').click(function(){
	$.post('/users/changeEmail/',function(msg)
	{
		message('Повідомлення',msg);
	});
	});


	
	
	//Оновлення дати народження	
$('#beart input').on('change', function() {
	$.post('/users/update_inf',$(this).serialize());
	});
});
</script>
