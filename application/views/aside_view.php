<aside>
<div id="message"></div>

					<!-- Блок для користувачів  -->
              <?php  if(isset($userMenu)){echo $userMenu;} ?>
 <div class="menu  <?php  if(isset($ses)){echo 'none'; } ?>" id="userBlock">
  <div class="name" id="name">Авторизація</div>
   <div class="area" id="tab1">
    <div id="auth">
     <form method="post" action="" id="authForm">
      <fieldset class="l">
       <input name="email"  value = "" placeholder="Ваш email" type="text" />
       <input name="pass"  value = "" placeholder="Ваш пароль" type="password" />
      </fieldset>
      <button name="sub" class="auth" type="submit" >ОК</button>
      <p class="clear"></p>
        <div class="error"></div>
      <p class="run"></p>
      
      <a href="#" class="tabs" title="know">Забули пароль?</a>
      <a href="#" class="tabs" title="reg">Реєстрація</a>
      <p>Ввійти через: <a href="/users/oauth/Facebook" title="Ввійти через Facebook"><img src="/img/fb-16.png"/></a> <a href="/users/oauth/Vkontakte" title="Ввійти через Вконтакте"><img src="/img/vk-16.png"/></a></p>
     </form>
    </div>
    <div id="know">
     <form method="post" action="" id="recover">
      <fieldset class="l">
       <input name="email"  value = "" placeholder="Ваш email" type="text" />
      </fieldset>
      <button name="sub" type="submit" >ОК</button>
      <div class="error"></div>
      <p class="run"></p>
      <p class="clear"></p>
      <a href="#" class="tabs"  title="auth">Авторизація?</a>
      <a href="#" class="tabs"  title="reg">Реєстрація</a> 
     </form>
      <span>&nbsp;</span>
    </div>
    <div id="reg">
     <form method="post" action="" id="regForm">
      <fieldset class="l">
       <input name="email" id="email"   value = "" placeholder="Ваш email" type="text" />
      </fieldset>
      <button name="sub" type="submit" >ОК</button>
       <div class="error"></div>
       <p class="run"></p>
      <p class="clear"></p>
      <a href="#" class="tabs"  title="auth">Авторизація?</a>
      <a href="#" class="tabs"  title="know">Забули пароль?</a> 
    </form>
    <span>&nbsp;</span>
   </div>
 </div>
</div>
 <div class="menu">
  <div class="name">
   <ul id="tabs">
    <li><a href="#" title="Vkontakte"><img src="<?=base_url();?>img/vk.png" width="32" height="32" title="Ми Вконтакті" /></a></li>
    <li><a href="#" title="Facebook"><img src="<?=base_url();?>img/f.png" width="32" height="32" title="Ми на Facebook" /></a></li>
    <li><a href="#" title="RSS"><img src="<?=base_url();?>img/rss_mini.png" width="32" height="32" title="Наш RSS"/></a></li>
   </ul>
  </div>
  <div class="area" id="tab">
   <div id="Vkontakte"></div>
   <div id="Facebook" class="fb-like-box" data-href="http://www.facebook.com/seloNaraiv" data-width="230" data-height="290" data-show-faces="true" data-stream="false" data-header="true"></div>
   <div id="RSS"><p class="rss">Підписка на нові новини</p>
	<img class="rss_img" src="<?=base_url();?>img/rss.png" width="200" height="200" alt="RSS"  />
	 <p class="write"><a href="<?=base_url();?>rss" target="_blank">Підписатися</a></p></div>
 </div>
</div>
   									<!--Новини останні/популянні-->
 <div id="newsBlock" <?php  if(isset($is_news)){ echo 'class="none" ';} ?> >
  <div class="menu" >
   <div class="name">
    <ul id="tabs2"> 
	 <li><a href="#" title="last">Останні</a></li> 
	 <li><a href="#" title="popular">Популярні</a></li> 
    </ul> 
	</div>
   <div class="area" id="tab2">
	<div id="last">
	 <ul>
	  <?php   if(isset($last_news)){ foreach($last_news as $news): ?>
	  <li class="n"><a href="<?=base_url();?>news/<?=$news['news_id'];?>"><?=$news['title_news'];?></a></li>
	  <?php  endforeach;} ?>
	 </ul>
    </div>
	<div id="popular">
	 <ul>
	  <?php if(isset($popular_news)){ foreach($popular_news as $popular): ?>
	   <li class="n"><a href="<?=base_url();?>news/<?=$popular['news_id'];?>"><?=$popular['title_news'];?></a></li>
	   <?php  endforeach;} ?>
	  </ul>
	 </div>
    </div>
   </div>
  </div>
</aside>
</div>
</section>