<?php if (!defined('SITE')) exit('No direct script access allowed');

/**
* Indexhibit iFramed
*
* Plugin
* 
* @version 1.0
* @author Vaska 
*/

function ndxz_iframed($url=false)
{
$iframe = <<< EOH
<style type='text/css'>
#content .container { padding: 0; }
</style>

<script type='text/javascript'>
function iframer() 
{ 
	// get width of #content 
	frame_x = $('#content').width(); 
	// get height of #menu 
	frame_y = $('#menu').height(); 
	
	// apply height and width 
	$('#iframed').css('width', frame_x); 
	$('#iframed').css('height', frame_y); 
} 

$(document).ready( function() { iframer(); } );
$(window).resize( function() { iframer(); } );
</script>

<iframe src='$url' frameborder='0' id='iframed'></iframe>
EOH;
		
	return $iframe;
}


?>