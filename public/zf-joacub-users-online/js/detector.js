var xhrUsersOnline = null;
var abortDetector = false;
var intervalUserOnline = false;
jQuery(document).ready(function($) {

	intervalUserOnline = setInterval(function() {
		if(abortDetector)
			return;
		var date = new Date();
		xhrUsersOnline = $.ajax({
			url : site_url + "/users-online-detector?"+date.getTime(),
		});
	}, 2000);
	
	$(window).bind('beforeunload',function(){
		clearInterval(intervalUserOnline);
		abortDetector = true;
		xhrUsersOnline.abort();

	});
	
});