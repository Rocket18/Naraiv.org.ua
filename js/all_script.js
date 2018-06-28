					/*Діалогові вікна*/
function message(title,text)
{
	$( "#message" ).html(text).dialog({ modal: true,title: title,height:100});
}
$(document).ready(function() {

					/*Годинник*/
function time(){	
var dataTime = new Date();
var day = dataTime.getDate();
var month = ["Січня","Лютого","Березня","Квітня","Травня","Червня","Липня","Серпня","Вересня","Жовтня","Листопада","Грудня"];
		var hou = dataTime.getHours().toString();
		var min = dataTime.getMinutes().toString();
		var sec = dataTime.getSeconds().toString();
		hou = (hou<10)?0+hou:hou;
		min = (min<10)?0+min:min;
		sec = (sec<10)?0+sec:sec;
	$('#time').html(day + ' ' + month[dataTime.getMonth()] +' '+ hou + ':' + min + ':' + sec);	
setTimeout(time,1000);

}
time();	
					/*Передбачення*/
if($.cookie('prognoz')==null)	
	prognoz();
else
{
	  var now = new Date();
	  var msDate = Date.UTC(now.getFullYear(), now.getMonth(), now.getDate());
	   if (parseFloat($.cookie('prognoz')) < parseFloat(msDate))
			prognoz();
}
function prognoz()
{
	$.post('/main/prognoz',function(msg)
	{	
		var now = new Date();
		var msDate = Date.UTC(now.getFullYear(), now.getMonth(), now.getDate());
		if(msg!='')
		{
			message('Передбачення для вас',msg);
			$.cookie('prognoz',msDate,{expires: 1});//Час життя 1 день
		}
		else 
			$.cookie('prognoz',msDate,{expires: 1});//Час життя 1 день	
	});
					/*Голосування*/		
}

if ($.cookie('poll'))
{
	 animateResults();
}
function animateResults(){
  $("#poll-results div").each(function(){
      var percentage = $(this).width();
      $(this).css({width: "0%"}).animate({
				width: percentage}, 'slow');
  });
}
$('#pollForm').submit(function(e){
	e.preventDefault();
	var answer = $("#poll input[name = 'answer']"); 
	 if (answer.is(':checked'))
	  {
		  var voted = $('#pollForm').serialize();
		  $('#poll .area').append("<div class='load'>Триває завантаження...</div>");
   		  $.post('/poll/set_poll',voted,function(msg)
		  {
			 $("#pollForm").fadeOut("slow",function(){
			$(this).empty();
			$('div.load').remove();
			  $('#poll .area').html(msg);
			   animateResults();
	      });
		 });
  	  }
	
	
});
$('#result').click(function(e)
{
	e.preventDefault();
	
		 $('#poll .area').append("<div class='load'>Триває завантаження...</div>");
		 
	$.post('poll/poll_result',function(msg){
		$("#pollForm").fadeOut("slow",function(){
		$('div.load').remove();
		$('#poll .area').append(msg);
		animateResults();
	});
	 });
});


					/*Блок для користувачів*/
var name = {'auth':'Авторизація','know':'Забули пароль?','reg':'Реєстрація'};
	$("#tab1 div").hide(); // Скрываем содержание
	$("#tab1 div:first").fadeIn(); // Выводим содержание
    $('#tab1 a.tabs').click(function(e) 
	{
        e.preventDefault();
        $("#tab1 div").hide(); //Скрыть все сожержание
		$('#name').text(name[$(this).attr('title')]);
        $('#' + $(this).attr('title')).fadeIn(); // Выводим содержание текущей закладки
	});				
				/*Вкладки для груп та RSS*/
$("#tab div").hide(); // Скрываем содержание
	$("#tabs li:first").attr("class","current"); // Активируем первую закладку
	$("#tab div:first").fadeIn(); // Выводим содержание

    $('#tabs a').click(function(e) {
        e.preventDefault();
        $("#tab div").hide(); //Скрыть все сожержание
        $("#tabs li").attr("class",""); //Сброс ID
        $(this).parent().attr("class","current"); // Активируем закладку
        $('#' + $(this).attr('title')).fadeIn(); // Выводим содержание текущей закладки
		 });
		 
		 /*Вкладки для останніх та популярник новин*/
$("#tab2 div").hide(); // Скрываем содержание
	$("#tabs2 li:first").attr("class","current"); // Активируем первую закладку
	$("#tab2 div:first").fadeIn(); // Выводим содержание

    $('#tabs2 a').click(function(e) {
        e.preventDefault();
        $("#tab2 div").hide(); //Скрыть все сожержание
        $("#tabs2 li").attr("class",""); //Сброс ID
        $(this).parent().attr("class","current"); // Активируем закладку
        $('#' + $(this).attr('title')).fadeIn(); // Выводим содержание текущей закладки
		 });
		 		 
$('#tree li.submenu').click(function()
{
	$('ul',this).css('display','block');
});
  					/*Новин на сторінці*/
$('#limit').on('change', function() {
	var limit = $(this).val();
	$.post("/news/limit/",{limit:limit},function()
	{
		//$(window.location).attr('href','/news/all');
		window.location.replace("http://naraiv.org.ua/news/all");
	});
});
$('#limit_user').on('change', function() {
	var limit = $(this).val();
	$.post("/news/limit/",{limit:limit},function()
	{
		window.location.replace("http://naraiv.org.ua/news/all_where");
	});
});


	//міні-галарея
	$(function() {
    $('.image').on('click', function() {
        var image = $('#image');
        var imageRel = $(this).attr('rel');
        image.hide().fadeIn('slow');
        image.html('<img src="' + imageRel + '" class="center" />');
        return false;  
    });
 
 
});

		/*Кнопка вверх*/
	$("#back-top").hide();
	jQuery(function (){
		$(window).scroll(function (){
			if ($(this).scrollTop() > 300){
				$('#back-top').fadeIn();
			}else{
				$('#back-top').fadeOut();
			}
		});
	$('#back-top a').click(function () {
		$('body,html').animate({scrollTop: 100}, 500);
			return false;
		});
	});
	
				
					/*Реєстрація*/
$("#regForm").validate({
		rules:
		{
			email : {required : true, email: true}
		},
		messages:
		{
			email:{required: "Введіть email",email : "Некоректний email"},	
		},
		errorPlacement: function(error, element)
		{	
			error.insertAfter(element);
		},
		submitHandler: function()
		{
			var email = $("#email").val();	
			$('p.run').text('Триває завантаження').fadeIn();;	
			$.post("/users/check_email",{ email: email } ,function(data)
			{
				
				if(data)//Якщо email доступний
				{
					
					$.post("/users/add",$("#regForm").serialize(),function(msg)
					{
					$('p.run').text('').fadeOut();
					$("#regForm")[0].reset();
					message('Повідомлення',msg);
					},'json');	
				}
				else
				{
					$('p.run').text('').fadeOut();
					$("div.error").fadeTo(200,0.1,function() //начнет появляться сообщение
					{ 
						$(this).html('Користувач з такою електронною поштою вже зареєстрований').fadeTo(900,1).fadeOut(2000);
					});
					
				}
			},'json');
		}
	});
					//Авторизація
	$("#authForm").validate({
	rules: {
				email : {required : true, email: true},
				pass : {required : true, minlength : 6}
			},
	messages:{
				email:{required: "Введіть email",email : "Некоректний email", },
				pass:{required: "Введіть пароль", minlength: "Не менше 6 символів",}
			 },
	errorPlacement: function(error, element)
	{	
		error.insertAfter( element);
	},
	submitHandler: function()
	{
		$('p.run').text('Триває завантаження').fadeIn();	
		$.post("/users/login",$("#authForm").serialize(),function(msg){
			
			if(msg==1)
			{
					$('p.run').text('').fadeOut();
					//location.reload();
					window.location.reload();	
			}
			else
			{
				$('p.run').text('').fadeOut();
					$("div.error").fadeTo(200,0.1,function() //начнет появляться сообщение
					{ 
						$(this).html(msg).fadeTo(900,1).fadeOut(2000);
					});
			}
		},'json');	
	}
});	
						/*Відновлення паролю*/
	$("#recover").validate({
		rules:
		{
			email : {required : true, email: true}
		},
		messages:
		{
			email:{required: "Введіть email",email : "Некоректний email"},	
		},
		errorPlacement: function(error, element)
		{	
			error.insertAfter(element);
		},
		submitHandler: function()
		{
			var email = $("#recover input[name=email]").val();	
			$('p.run').text('Триває завантаження').fadeIn();	
			$.post("/users/recover",{ email: email } ,function(data)
			{
				if(data == 1)//Якщо email доступний
				{
					$('p.run').text('').fadeOut();
					$("#recover")[0].reset();
					message('Повідомлення','Відвідайте вашу пошту і перейдіть по спеціальній силці щоб змінити пароль');	
				}
				else
				{
					$('p.run').text('').fadeOut();
					$("div.error").fadeTo(200,0.1,function() //начнет появляться сообщение
					{ 
						$(this).html(data).fadeTo(900,1).fadeOut(2000);
					});
					
				}
			},'json');
		}
	});

	
	
				//Оновлення captcha
$('#refresh').click(function(){
	$.post("/main/refresh_captcha", { },
   function(data) {
$('#captcha').html(data);
   });

});
$("#feedback").validate({
		rules: {
					name  : {required : true, minlength : 3}, 
					email  : {required : true, email : true}, 
					subject  : {required : true, minlength : 3}, 
					message   : {required : true, minlength : 5},
					captcha : {required : true, minlength : 4, number : true}
				},
		messages:{
					name:{required: " Введіть своє ім\'я", minlength: "Імя повинно містити мінімум 3 символи"},
					email:{required: " Введіть Ваш email", email: "Некоректний email"},
					subject:{required: " Введіть тему повідомлення", minlength: "Мінімум 3 символи"},
					message:{required: "Впишіть Ваше повідомлення", minlength: "Поле повинно містити мінімум 5 символів"},
					captcha:{required: "Введіть код з картинки", minlength: "Код містьти 4 цифри", number: "Лише цифри!"}
				},
		errorPlacement: function(error, element)
		{	
			error.insertAfter(element);
			
			
		},
		submitHandler: function()
		{
			var	code = $(".captcha").val();		
 			// Превірка на правильність captcha 
			$.post("/main/check_captcha", { "captcha" : code },function(data)
			{
			   if(data == 'false')
				{
					$("span.error").fadeTo(200,0.1,function() //начнет появляться сообщение
					{ 
						$(this).html('Невірний код').fadeTo(900,1).fadeOut(2000);
					});	
				}
				else
				{
					$('.error').text('');
					$.post("/main/feedback",$("#feedback").serialize(),function(msg){
					   message('Повідомлення',msg);
					   $("#feedback")[0].reset();
					
					},'json');
				}
			});
		}
});



	// Автоматичне розкривання textarea
	$(function() {
			var txt = $('#textarea'),    
			hiddenDiv = $(document.createElement('div')),
			content = null;
			txt.addClass('noscroll');
			hiddenDiv.addClass('hiddendiv');
			$('body').append(hiddenDiv);
			txt.bind('keyup', function() {
				content = txt.val();
				content = content.replace(/\n/g, '<br>');
				hiddenDiv.html(content);
				txt.css('height', hiddenDiv.height());
			});
		});


	$(function() {
			var txt = $('#AdvertTextarea'),    
			hiddenDiv = $(document.createElement('div')),
			content = null;
			txt.addClass('noscroll');
			hiddenDiv.addClass('Adverthiddendiv');
			$('body').append(hiddenDiv);
			txt.bind('keyup', function() {
				content = txt.val();
				content = content.replace(/\n/g, '<br>');
				hiddenDiv.html(content);
				txt.css('height', hiddenDiv.height());
			});
		});






});//The End