$(document).ready(function(){
	console.log('ready');
	var urlPath = window.location.pathname,
    urlPathArray = urlPath.split('.'),
    tabId = urlPathArray[0].split('/').pop();
	$('#department, #user, #ticket').removeClass('active');	
	$('#'+tabId).addClass('active');
});