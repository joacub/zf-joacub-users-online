var xhrUsersOnline = null;
var abortDetector = false;
var intervalUserOnline = false;
jQuery(document).ready(function($) {

	intervalUserOnline = setInterval(function() {
		if(abortDetector)
			return;
		
		abortDetector = true;
		var date = new Date();
		xhrUsersOnline = $.ajax({
			url : site_url + "/users-online-detector?"+date.getTime(),
			complete:function() {
				abortDetector = false;
			}
		});
	}, 10000);
	
	$(window).bind('beforeunload',function(){
		clearInterval(intervalUserOnline);
		abortDetector = true;
		if(typeof(xhrUsersOnline) != 'undefined')
		xhrUsersOnline.abort();

	});
	
});