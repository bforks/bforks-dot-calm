<?php if (!defined('SITE')) exit('No direct script access allowed');

/**
* Simple News
*
* Plugin
* 
* @version 1.0.1
* @author Vaska 
*/

function simple_news($id=0, $limit=6)
{
	$OBJ =& get_instance();
	global $rs;
	
	if ($id == 0) return;
	
	$pages = $OBJ->db->fetchArray("SELECT user_format, user_offset, url, title, content, pdate  
		FROM ".PX."objects 
		INNER JOIN ".PX."users 
		WHERE status = 1 
		AND hidden = 1 
		AND section_id = '$id'
		ORDER BY ord ASC, pdate DESC 
		LIMIT 0,$limit");
	
	if (!$pages) return;
	
	$s = '';
	
	foreach ($pages as $page)
	{
		$when = convertDate($page['pdate'], $page['user_offset'], $page['user_format']);
		
		$s .= "<p><a href='" . BASEURL . ndxz_rewriter($page['url']) . "'>$page[title]</a><br /><span style='color:#999;'>$when</span></p>\n";
		$s .= $page['content'];
		$s .= "<p style='margin-bottom: 27px;'><span style='color:#999;'> &raquo; <a href='" . BASEURL . ndxz_rewriter($page['url']) . "'>Permalink</a></span></p>\n";
	}
	
	// silly bug where text processing add paragraph tags about <plug:.../>
	$s = preg_replace(array('/^<p>/i', '/<\/p>$/i'), array('', ''), trim($s));
		
	return $s;
}


?>