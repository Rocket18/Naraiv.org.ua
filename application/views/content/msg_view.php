<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Підтвердження реєстрації</title>
<style>
body{
	margin:0;
	padding:0;
	background-color:#666;
}
.msg{
	width:800px;
	margin:0 auto;
	font-size:24px;
	color:#fff;
	font-family:"Times New Roman", Times, serif;
}
.center{text-align:center;}
</style>
</head>
<body>
<div class="msg">
<?php switch($msg)
	 {
		case 1: echo 'Виникла помилка. Можливо невірно скопійована силка для підтвердження або ця силка вже використовувалась';
		break;
		
		case 2: echo '<p class="center">Вітаю. Ви успішно пройшли реєстрацію на сайті с.Нараїв</p>
<div class="d_inf">
<p>На вашу поштову скриньку відправлено ваш пароль. Змінити його можна на вашій власній сторінці.</p>
<p>Реєстрація дає вам змогу завантажувати зображення, додавати свої новини на сайт(після підтвердження адміністратора.) </p>
<p>Прохання вказувати справжню інформація про себе. </p>
<p>Приємного користування...</p>
</div>'; 
		break;
		
		case 3: echo 'Ця силка одноразова'; break;
		case 4: echo '<p class="center">Ваш пароль змінено і відправлено вам на поштову скриньку</p>';
		break;
	 }
 ?>

</div>
</body>
</html>