/* Author: Christopher Pond (@ponddesign) */

// twitter api
var twitter;
$(document).ready(function(){

	var fileref = document.createElement('script');
	fileref.setAttribute("type","text/javascript");
	fileref.setAttribute("src", "https://api.twitter.com/1/statuses/user_timeline.json?include_entities=true&include_rts=true&screen_name=brittanyforks&count=1&callback=tweet");
	document.getElementsByTagName("head")[0].appendChild(fileref);
});
function tweet(data) {
	twitter = data;
	$.each(data, function(i,item) {
		var tweetContent = item.text;
		var regexp = /((ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?)/gi;
		tweetContent = tweetContent.replace(regexp,"<a href=\"$1\">$1</a>");
		
		$('.twitter ul').append('<li>' + tweetContent + '<ul class="actions"><li><a href="https://twitter.com/intent/tweet?in_reply_to=' + item.id_str + '">Reply</a></li><li><a href="https://twitter.com/intent/retweet?tweet_id=' + item.id_str + '">Retweet</a></li><li><a href="https://twitter.com/intent/favorite?tweet_id=' + item.id_str + '">Favorite</a></li></ul></li>');
	});
}

twttr.anywhere(function (T) {
	// T(".linkify").linkifyUsers();
	T(".twitter").hovercards();
});
// dribbble api
$(document).ready(function(){
	
	var numberOfShots = '1';
	var playerName = 'brittanyforks';
	
	var fileref = document.createElement('script');
	fileref.setAttribute("type","text/javascript");
	fileref.setAttribute("src", "http://api.dribbble.com/players/" + playerName + "/shots?callback=dribbble&per_page=" + numberOfShots);

	document.getElementsByTagName("head")[0].appendChild(fileref); // appends the JSON to your <head> in the html so we can access it

});
function dribbble(data) {
	$.each(data.shots, function(i,item) {
		$('.dribbble ul').append('<li><a href="' + item.url + '"><img src="' + item.image_url + '" alt="' + item.title + '" /></a></li>');
	});
}

//slideshow
$(document).ready(function(){ 
	$('.cycle').cycle({
		fx:'fade',
		speed:'250', 
		timeout: '10000', 
		next:'.cycle-controller li.cycle-next a', prev:'.cycle-controller li.cycle-previous a',
		after:  function() {
			$('.cycle-controller').show();
		}
	});
	
});
