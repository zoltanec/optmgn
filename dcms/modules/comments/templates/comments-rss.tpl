<?xml version="1.0"?>
<rss version="2.0">
  <channel>
    <title>Metallurg.ru - Комментарии</title>
    <link><{$req->current_url}></link>
    <description>Liftoff to Space Exploration.</description>
    <language>en-us</language>
    <pubDate>Tue, 10 Jun 2003 04:00:00 GMT</pubDate>

    <lastBuildDate>Tue, 10 Jun 2003 09:41:01 GMT</lastBuildDate>
    <docs>http://blogs.law.harvard.edu/tech/rss</docs>
    <generator>Weblog Editor 2.0</generator>
    <managingEditor>editor@example.com</managingEditor>
    <webMaster>webmaster@example.com</webMaster>

	<{foreach item=comment from=$t.comments->latest}>
    <item>
      <title>Комментарий от <{$comment->username}></title>
      <description><![CDATA[<{$comment->content|bbcode}>]]></description>
      <pubDate><{$comment->addtime|date_format:"%a, %d %b %G %X GMT"}></pubDate>
    </item>
	<{/foreach}>
</channel>
</rss>