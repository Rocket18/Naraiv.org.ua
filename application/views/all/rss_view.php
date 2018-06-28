<?php header("Content-type: text/xml");
echo '<?xml version = "1.0" encoding = "utf-8"?>'?>
<rss version = "2.0">
<channel>
<title>Новини Нараєва</title>
<link><?=base_url();?></link>
<description>Підписка на розсилку новин села Нараїв</description>
<language>ua</language>
<?php foreach($feeds as $rss):?>
<item>
    <title><?=$rss['title_news'];?></title>
    <link><?=base_url()?>news/<?=$rss['news_id'];?></link>
    <description><?=$rss['short_text'];?></description>
    <guid><?=base_url();?>news/<?=$rss['news_id'];?></guid>
</item>
<?php endforeach;?>
</channel>
</rss>