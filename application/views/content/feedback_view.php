<div id="content">
<div class="breadcrumb_main">
<?=$breadcrumb['breadcrumb_main']." » "?>
<?=$breadcrumb['hardcoded_segment'];?>
<div id="time"></div>
</div>
 <div class="feedback content">
<?=$mass['main_text'];?>
<form action="" method="post" id="feedback">
		<table>
		<tr>
          <td> <label for="name">Ваше ім'я:</label></td>
          <td><input name="name" type="text"></td>
        </tr>
		<tr>
          <td><label for="email">Ваша email адреса:</label></td>
		  <td><input name="email" type="text"> </td>
		</tr>
		<tr>
          <td><label for="subject"> Тема:</label></td>
		  <td><input name="subject" type="text"></td>
		</tr>
		<tr>
		  <td><label for="message">Повідомлення:</label></td>
          <td><textarea name="message" cols="" rows="" id="textarea"></textarea></td></tr>
		<tr>
          <td><label for="captcha">Введіть літери з картинки:</label></td>
		  <td>
            	<span id="captcha"><?=$imgcode;?></span>
                <span id="refresh"><img class="imgcaptcha"  src="<?=base_url();?>img/refresh.png" width="32" height="32" title="Оновити"></span> 
           		<input name="captcha" type="text" maxlength="4" class="captcha">
                <span class="error"></span>
                <button type="submit" class="sub">Надіслати</button>
		  </td>
      	</tr>
		
        </table>
</form>
</div>
 <div id="back-top"><a href="#top"><img src="/img/up.png" width="128" height="128" title="Вверх" alt="Вгору"></a></div>
</div>
