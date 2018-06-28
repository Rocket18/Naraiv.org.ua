jQuery(document).ready(function($){
var apiKey = 'qJYeM9Xe6FeV';//Отримайте тут  http://www.websnapr.com/free_services/
    $('.accordion  a:not(.not)').each(function()
    {
        var url = encodeURIComponent( $(this).attr('href') );
		var src =  'http://images.websnapr.com/?url=' + url + '&key=' + apiKey + '&hash=' + encodeURIComponent(websnapr_hash);
        // Setup the tooltip with the content
        $(this).qtip({
            content:   
			{
			 	text: ' <img style="float:left"  src="'+ src +'" width="202" height="152" alt="Скріншот" /> '+ $(this).attr('rel'),
			},
            position:
			{
            	corner: {tooltip: 'leftMiddle',target: 'rightMiddle'}
            },
            style:
			{
				tip: true, name: 'light',
				width: {max: 600,min: 0},
			}
        });
    });
});//The End