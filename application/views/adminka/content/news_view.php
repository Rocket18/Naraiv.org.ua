<section>
<table id="content_menu">
<tr>
<td><article><a href="/adminka/show/news_show"><img src="/img/adminka/news_view.png" width="128" height="128" alt="Переглянути" /><p>Переглянути(<?=$count_all; ?>)</p></a></article></td>
<td><article><a href="/adminka/show/news_new"><img src="/img/adminka/news_new.png" width="128" height="128"  alt="Нові новини"><p>Нові новини(<?php if(empty($count_new)){echo 'Немає';}else{echo $count_new;} ?>)</p></a></article></td>
<td><article><a href="/adminka/show/news_add/"><img src="/img/adminka/news_add.png" width="128" height="128"  alt="Додати"><p>Додати</p></a></article></td>
</tr>
</table>
</section>