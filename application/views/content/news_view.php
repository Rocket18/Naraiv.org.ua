<div id="content" >
<div class="breadcrumb_main">
<?=$breadcrumb['breadcrumb_main']." » ";?> 
<?=$breadcrumb['hardcoded_segment']." » ";?>
<?=$news_all['title_news'];?>
	</div>		

<div class="content">
<h2 class="title_all"><?=$news_all['title_news'];?></h2>
<?=$news_all['text'];?>
<div id="add_inf">
	<span><img src="/img/calendar.png" width="16" height="16" /> <?=$news_all['data'];?></span>
    <span>  <img src="/img/user.png" width="16" height="16" /> <?=$news_all['surname'].' '.$news_all['name'];?>  </span>
      <span class="comments"><img src="/img/comment.png" width="16" height="16" /> <a href="<?=base_url();?>news/<?=$news_all['news_id'];?>#mc-container"></a></span>
     <span class="view">  <img src="/img/view.png" width="16" height="16" /><?=$news_all['views'];?></span>
</div>
</div>
<div id="comments">
<div id="mc-container"></div>
</div>
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
<div id="back-top"><a href="#top"><img src="/img/up.png" width="128" height="128" title="Вверх" alt="Вгору"></a></div>
</div>
