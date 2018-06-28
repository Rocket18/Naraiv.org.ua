<!DOCTYPE html>
<html  lang="uk">
<head>
<meta charset="utf-8">
<title>Admin-zona</title>
<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />
<link rel="icon" href="/img/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="/css/admin.css">
<link rel="stylesheet" type="text/css" media="screen" href="/css/admin_zone/jquery-ui-1.10.3.custom.min.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/ui.jqgrid.css" mce_href="css/ui.jqgrid.css" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>

<!--<script src="/js/jquery-1.7.1.min.js"></script>-->
<script src="/js/jquery-ui_admin.min.js"></script>
<script src="/js/jquery.jqgrid.min.js"></script>
<script src="/js/grid.loader.js"></script>
<script src="/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/js/admin.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(function() {
		 loadpage();
    function loadpage() {
      $("section article a").click(function() {
        var url = $(this).attr("href");
        $.ajax({
          type: "POST",
          data: "ajax=1",
          url: url,
          beforeSend: function() {
            $("section").html('<p class="load">Триває завантаження...</p>');
          },
          success: function(msg){
            $("section").html(msg);
            loadpage();
			$("body,html").animate(2000);
          }
        });
        return false;
      });
    }
  });
});	//TheEnd
</script>
</head>