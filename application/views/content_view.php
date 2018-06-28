<div id="content" >
	<div class="breadcrumb_main">
<?=$breadcrumb['breadcrumb_main']." » ";?> 
<?=$breadcrumb['hardcoded_segment'];?>
<?php if(isset($breadcrumb['breadcrumb_arrow'])){echo " » ".$breadcrumb['breadcrumb_arrow'];}?>
<div id="time"></div>
</div>     
  <div class="content"> 
  
<?=$mass['main_text']; echo "<br/>";?>
</div>
<div id="mc-container"></div>
<script type="text/javascript">
var mcSite = '13304';
(function() {
    var mc = document.createElement('script');
    mc.type = 'text/javascript';
    mc.async = true;
    mc.src = 'http://cackle.me/mc.widget-min.js';
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(mc);
})();
</script>
<div id="back-top"><a href="#top"><img src="<?=base_url();?>img/up.png" width="128" height="128" title="Вгору" alt="Вгору"></a></div>
</div>
