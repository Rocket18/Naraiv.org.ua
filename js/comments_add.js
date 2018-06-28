jQuery(document).ready(function($){

	
	$("#my_comment").validate({
		rules: {
				author  : {required : true, minlength : 3,}, 
				email  : {required : true, email : true,}, 
				text    : {required : true, minlength : 5,},
				captcha : {required : true, minlength : 4, number : true,}
				},
		messages:{
				author:{required: " Введіть своє ім\'я", minlength: "Імя повинно містити мінімум 3 символи",},
				email:{required: " Введіть Ваш email", email: "Некоректний email",},
				text:{required: "Впишіть Ваш коментар", minlength: "Поле повинно містити мінімум 5 символів",},
				captcha:{required: "Введіть код з картинки", minlength: "Код містьти 4 цифри", number: "Лише цифри!",},
				},
		errorPlacement: function(error, element)
		{	
			error.insertAfter( element);
		},
		submitHandler: function()
		{
			var	code = $("#captcha_input").val();		
 			// Превірка на правильність captcha 
			$.post("/comments/check_captcha", { "captcha" : code },function(data)
			{
			   if(data == 'false')
				{
					$('#captcha_input').after('Невірний код');	
				}
				else
				{
					$.post("/comments/add",$("#my_comment").serialize(),function(msg){
					alert(msg);
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
});