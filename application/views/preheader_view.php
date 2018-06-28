<!DOCTYPE html>
 <html lang="uk">
  <head>
   <meta charset="UTF-8"/>
   <meta  name="description" content="{description}"/>
   <meta name="keywords" content="{keywords}" />
   <title>{title}</title>
   <link rel="shortcut icon" href="/img/favicon2.ico" type="image/x-icon" />
   <link rel="icon" href="/img/favicon2.ico" type="image/x-icon" />
   <link rel="stylesheet" href="/css/style.css"><!--Основний стиль-->
   <link rel="stylesheet" href="/css/custom-theme/jquery-ui-1.10.3.custom.min.css"> 
   <?php if(isset($css) && is_array($css)){foreach($css as $cssObject){echo $cssObject."\n";}}?>
	<script src="http://code.jquery.com/jquery-1.9.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.0.0.min.js"></script>
	

    <script src="/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="/js/jquery.cookie.js"></script>
	<script src="/js/all_script.js"></script>
	<script src="/js/jquery.validate.min.js"></script>
    <script src="http://userapi.com/js/api/openapi.js?49"></script>
    <!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
			<!--Підключення додаткових скриптів-->
<?php if(isset($script) &&  is_array($script)){foreach($script as $scriptObject){echo $scriptObject."\n";}}?>
	<script type="text/javascript">

VK.Widgets.Group("Vkontakte", {mode: 0, width: "230", height: "290"}, 39922260); 
	  var pager = new Imtech.Pager();	
	$(document).ready(function(){
		<?php if(isset($js)){echo $js;}?>
		
		});//theEnd
	
	 
	</script>
	<!--Google Analytics-->
	<script type="text/javascript">
 	 var _gaq = _gaq || [];
 	_gaq.push(['_setAccount', 'UA-34330674-1']);
  	_gaq.push(['_trackPageview']);
  	(function() {
     var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
     ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
     var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  	})();
	</script>
</head>