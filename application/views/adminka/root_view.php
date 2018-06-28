<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Вхід|Adminka</title>
<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />
<link rel="icon" href="/img/favicon.ico" type="image/x-icon" />
<link rel="stylesheet"  href="/css/adminka.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
$("#auth").validate({
	rules: {
				email : {required : true,maxlength : 25,},
				pass : {required : true, minlength : 6,}
			},
	messages:{
				email:{required: "Введіть email"},
				pass:{required: "Введіть пароль", minlength: "Не менше 6 символів",}
			 },
	errorPlacement: function(error, element)
	{	
		error.insertAfter( element);
	},
	submitHandler: function()
	{
		$.post("/adminka/login",$("#auth").serialize(),function(msg){
		
			if(msg==1){
				
				window.location = 'http://naraiv.org.ua/adminka/root';
		
			}else{
			$("div.error").fadeTo(200,0.1,function(){$(this).html(msg).fadeTo(900,1).fadeOut(2000);}); }
					},'json');	
	}
});	
});//theEnd
</script>
</head>
<body>
<section id="root">
<div id="logo">Naraiv.org.ua</div>
<form action="#" method="post" accept-charset="utf-8" id="auth">
<table>
  <tr>
    <td class="title"><label for="email">Ваш email</label></td>
    <td class="input"><input type="text" name="email" value="" id="email" placeholder="Введіть  email"  /></td>
  </tr>
  <tr>
    <td class="title"><label for="pass">Пароль</label></td>
    <td class="input"><input type="password" name="pass" value="" id="pass" placeholder="Введіть пароль"  /></td>
  </tr>
    <tr>
    <td colspan="2" class="login"><div class="error"></div><input name="sub" type="submit" value="Вхід"></td>
  </tr>
</table>
</form>
</section>
</body>
</html>