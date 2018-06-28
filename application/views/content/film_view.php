<div id="content" >
<div class="breadcrumb_main">
<?=$breadcrumb['breadcrumb_main']." » ";?>
<?=$breadcrumb['hardcoded_segment'];?>
<a href="#" onClick="addFilm()" class="Add">Додати фільм</a>
</div>
<div id="message"></div>
  <div class="content"> 
<?=$mass['main_text']?> 
<div style="display:none" id="dialog-form" title="Зарокомендувати фільм">
  <p class="validateTips">Всі поля обовязкові для заповнення</p>
  <form method="post" action="" id="addNewFilm"> 
   <table>
   <tr>
   		<td class="lparam"><label for="name">Назва фільму</label></td>
        <td><input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" /></td>
   </tr>
   <tr>
   		<td>  <label for="year">Оберіть рік</label></td>
        <td><select id="year" name="year" class="online">
        		<option value="NULL">Обрати</option>
        		<?php 
				$i = 1970;
				$j = date('Y');
				for($j;$j>=$i;$j--)
				echo '<option value="'.$j.'">'.$j.'</option>';
		?>
        </select></td>
   </tr>
   <table id="cat">
   <tr>
   		<td colspan="3"><label style="text-align:center">Оберіть жанр</label></td>
   </tr>
   <tr>
   		<td><label> <input name="cat[]" type="checkbox" value="1">Фантастика </label> </td>
        <td><label> <input name="cat[]" type="checkbox" value="2"> Жахи</label></td>
        <td> <label> <input name="cat[]" type="checkbox" value="3"> Комедія</label></td>
   </tr>
    <tr>
   		
        <td><label> <input name="cat[]" type="checkbox" value="4"> Історичний</label></td>
        <td><label> <input name="cat[]" type="checkbox" value="5"> Мультфільм</label></td>
        <td><label> <input name="cat[]" type="checkbox" value="6"> Серіал</label></td>
   </tr>
	<tr>
   		<td><label> <input name="cat[]" type="checkbox" value="7"> Драма</label></td>
        <td><label> <input name="cat[]" type="checkbox" value="8"> Бойовик</label></td>
        <td><label> <input name="cat[]" type="checkbox" value="9"> 18+</label></td>
   </tr>
   </table>
  
   </form>
   
</div>

<table id="leftmenu">
<form action="" method="post" id="getRes">
 <tr>
   		<td ><label style="text-align:center">Оберіть рік</label></td>
   </tr>
   <tr>
   		<td> 
        <select name="year" class="online">
        <option value="NULL">Обрати</option>
<?php $i = 1970; $j = date('Y'); for($j;$j>=$i;$j--)
echo '<option value="'.$j.'">'.$j.'</option>\n';
		?>
        </select>
        </td>
   </tr>
   <tr>
   		<td ><label style="text-align:center">Оберіть жанр</label></td>
   </tr>
   <tr>
   		<td><label><input name="cat[]" type="checkbox" value="1"> Фантастика </label> </td>
    </tr>
    <tr>
        <td><label> <input name="cat[]" type="checkbox" value="2">Жахи</label></td>
      </tr>
    <tr>
        <td> <label><input name="cat[]" type="checkbox" value="3"> Комедія</label></td>
     </tr>
    <tr>
        <td><label><input name="cat[]" type="checkbox" value="4"> Історичний</label></td>
      </tr>
    <tr>
        <td><label> <input name="cat[]" type="checkbox" value="5">Мультфільм</label></td>
      </tr>
    <tr>
        <td><label><input name="cat[]" type="checkbox" value="6"> Серіал</label></td>
   </tr>
	<tr>
   		<td><label><input name="cat[]" type="checkbox" value="7"> Драма</label></td>
     </tr>
    <tr>
        <td><label> <input name="cat[]" type="checkbox" value="8">Бойовик</label></td>
      </tr>
    <tr>
        <td><label><input name="cat[]" type="checkbox" value="9"> 18+</label></td>
   </tr>
    <tr>
        <td><input type="button" value="Отримати" class="getFilm"></td>
   </tr>
   </form>
</table>
<div id="result"></div>
<div class="clear"></div>

</div>
<script>
 function addFilm() {
	 $( "#addNewFilm" )[ 0 ].reset();
	 $('.validateTips').text('Всі поля обов\'язкові для заповнення');
    $( "#dialog-form" ).dialog({
		 height: 300,
      width: 400,
      modal: true,
      buttons: {
        "Додати": function() 
		{
			var error = ["Не введено назву фільму","Не вибрано рік","Не вибрано жанр"];
			var name = $("#dialog-form #name").val();
			var year = $("#dialog-form #year").val();
  			if ($('#dialog-form input:checked').length < 1) 
				$('.validateTips').html(error[2]);
			else if(name=='')
				$('.validateTips').html(error[0]);
			else if(year=='NULL')
				$('.validateTips').html(error[1]);
			else
			{
				
				$.post("/main/addFilm",$("#addNewFilm").serialize(),function(data)
				{
					$('#dialog-form').dialog( "close" );
					message('Повідомлення',data);
					
				},'json');	
			}
		},
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
		});
  }; 
 $(document).ready(function(){
	
$('.getFilm').click(function()
{
	
	//$(this).hide();
	var error = ["Не вибрано рік","Не вибрано жанр"];
	var year = $("#leftmenu  input[name=year]").val();
  			if ($('#leftmenu input:checked').length < 1) {
				message('Попередження',error[1]);
			}
			else if(year=='NULL')
				message('Попередження',error[0]);
			else
			{
				
				$.post("/main/getFilm",$("#getRes").serialize(),function(data)
				{
					///$('#object').html(JSON.stringify(data['name']));
					var i=0;
					$('#result').text(data[i]['name']);
					alert(JSON.stringify(data));
					
					
				},'json');	
			}

}); 
	
}); 	
</script>

 <div id="back-top"><a href="#top"><img src="/img/up.png" width="128" height="128" title="Вверх" alt="Вгору"></a></div>
</div>
