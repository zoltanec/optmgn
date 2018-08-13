<?xml version="1.0"?>
<rss version="2.0">
  <channel>
    <title>Новости сайта "<{$config->site_name}></title>
    <link><{$req->current_url}></link>
    <description>Новости сайта <{$config->site_name}></description>
    <language>ru-RU</language>
    <lastBuildDate><{strftime('%a, %d %b %G %T GMT')}></lastBuildDate>
    <generator>dCMS</generator>
    <managingEditor></managingEditor>
    <webMaster></webMaster>

	<{foreach item=news from=News_News::LatestNews(15)}>
    <item>
      <title><{$news->title}></title>
      <link><{$me.path}>/read/<{$news->nid}></link>
      <description><![CDATA[<{$news->content_preview}>]]></description>
      <pubDate><{$news->add_time|date_format:"%a, %d %b %G %X GMT"}></pubDate>
    </item>
	<{/foreach}>
</channel>
</rss>