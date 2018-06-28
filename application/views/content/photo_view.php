<div id="content" >
<div class="breadcrumb_main">
<?=$breadcrumb['breadcrumb_main']." » ";?>
<?=$breadcrumb['hardcoded_segment'];?>
<a class="download" href="/photo/add">Завантажити фотографії</a><?php if(isset($ses)){echo '<a class="photoEdit" href="/photo/edit">Редагувати</a>'; }?>
</div>
<?=$page_nav;?>
<div class="clear"></div>
 <div id="cat_photo">
<div class="title_cat">Категорія:</div> 
<ul>
<li <?php if($cat == '')echo 'class="active"';?>><a href="/photo">Все</a></li>
<li <?php if($cat == '0')echo 'class="active"';?>><a href="/photo/get/school">Школа</a></li>
<li <?php if($cat =='1')echo 'class="active"';?>><a href="/photo/get/people">Село і люди</a></li>
<li <?php if($cat =='2')echo 'class="active"';?>><a href="/photo/get/nature">Природа</a></li>
<li <?php if($cat =='3')echo 'class="active"';?>><a href="/photo/get/club">У нас в клубі</a></li>
<li <?php if($cat =='4')echo 'class="active"';?>><a href="/photo/get/other">Інше</a></li>
</ul>

</div>
<div id="gallery" class="content">
<ul>
<?php  $i=1; foreach($photo as $p) : ?>
	<li class="img_p" data-id="img_p<?=$i;?>" data-type="<?=$p['cat'];?>">
    	<a href="<?=base_url()."img/photos/gallery/".$p['photo_src'];?>" rel="prettyPhoto[gallery]" title="<?=$p['title'];?>">
       		<img   src="<?=base_url()."img/photos/thumbs/".$p['photo_src'];?>" width="215" height="130">
        	<span class="img_icon" style="display:none"></span>
        </a>
   </li>
  
<?php  $i++; endforeach;?>
</ul>
<div class="clear">
</div>
</div>
<?=$page_nav;?>
 <div id="back-top"><a href="#top"><img src="<?=base_url();?>img/up.png" title="Вверх" alt="Вгору"></a></div>
</div>