<div id="content" >
<div class="breadcrumb_main">
<?=$breadcrumb['breadcrumb_main']." » ";?>
<?=$breadcrumb['hardcoded_segment'];?>
<a class="download" href="/video/add">Додати відеозаписи</a>
</div>
<?=$page_nav;?>
<div class="clear"></div>
<div class="video">
<?php foreach($video as $v) : ?>
<div class="youtube">
<iframe width="320" height="180" src="<?=$v['href'];?>" frameborder="0" allowfullscreen></iframe>
<div class="title_video"><?=$v['name'];?></div>
</div>
<?php endforeach;?>
<div class="clear"></div>
 </div>
 <?=$page_nav;?>
 <div id="back-top"><a href="#top"><img src="/img/up.png"  title="Вверх" alt="Вгору"></a></div>
 </div>