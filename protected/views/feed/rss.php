<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
    xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	>
	
<channel>
	<title><?php echo $feedname;?></title>
	<atom:link href="<?php echo aurl('feed/timeline');?>" rel="self" type="application/rss+xml" />
	<link><?php echo abu('/');?></link>
	<description><?php echo param('shortdesc');?></description>
	<lastBuildDate><?php echo date('D, d M Y H:i:s O', $_SERVER['REQUEST_TIME']);?></lastBuildDate>
	<language><?php echo app()->language;?></language>
	<sy:updatePeriod>hourly</sy:updatePeriod>
	<sy:updateFrequency>1</sy:updateFrequency>
	<generator>http://www.24beta.com/?v=<?php echo BetaBase::VERSION;?></generator>
	<?php foreach ((array)$rows as $row):?>
	<item>
		<title><?php echo $row['title'];?></title>
		<link><?php echo aurl('post/show', array('id'=>$row['id']));?></link>
		<comments><?php echo aurl('comment/list', array('pid'=>$row['id']));?></comments>
		<pubDate><?php echo date('D, d M Y H:i:s O', $row['create_time']);?></pubDate>
		<?php if ($row['user_name']):?><dc:creator><?php echo $row['user_name'];?></dc:creator><?php endif;?>
		<description><![CDATA[<?php echo $row['summary'];?>]]></description>
		<content:encoded><![CDATA[<?php echo $row['content'];?>]]></content:encoded>
	</item>
	<?php endforeach;?>
</channel>
</rss>