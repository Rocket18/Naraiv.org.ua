<div class="breadcrumb">
<?=$breadcrumb['breadcrumb_main']." » ";?>
<?=$breadcrumb['hardcoded_segment']." » ";?>
<?=$breadcrumb['breadcrumb_arrow'];?>
</div>	
<div class="newsONpage">
Показати на сторінці 
<select id="limit" name="limit">
	<option value="5"  <?php if($limit==5){echo "selected";} ?>  >5</option>
    <option value="10"  <?php if($limit==10){echo "selected";} ?> >10</option>
    <option value="15"  <?php if($limit==15){echo "selected";} ?> >15</option>
    <option value="25"  <?php if($limit==25){echo "selected";} ?> >25</option> 
</select> новин
</div>	
<?php foreach($news as $n):?>
<article class="table_news">
<div class="title">
   <h1>
    <a href="<?=base_url();?>news/<?=$n['news_id'];?>"><?=$n['title_news'];?></a>
   </h1>
  </div>
 <div class="inf">
  <div><img src="/img/calendar.png" width="16" height="16" title="Опубліковано"/><?=$n['data'];?></div>
  <div><img src="/img/comment.png" width="16" height="16" title="Коментарі"/><a href="<?=base_url();?>news/<?=$n['news_id'];?>#mc-container"></a></div>
  <div><img src="/img/user.png" width="16" height="16" title="Автор"/><?=$n['surname'].' '.$n['name'];?></div>
  <div><img src="/img/view.png" width="16" height="16" title="Переглядів"/><?=$n['views'];?></div>
  
 </div>
 <div class="small_img">
  <a href="<?=base_url();?>news/<?=$n['news_id'];?>">
   <img src="<?=base_url();?><?=$n['small_img'];?>" width="450" height="190" alt="mini_img" title="Читати повністю" />
  </a>
 </div>
 <div>
  
  <p class="short_text"><?=$n['short_text'];?></p>
 </div>
</article>


<?php endforeach; ?>
<?=$page_nav;?>
 <div id="back-top"><a href="#top"><img src="/img/up.png" width="128" height="128" title="Вверх" alt="Вгору"/></a></div>
