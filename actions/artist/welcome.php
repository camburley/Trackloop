<script type="text/javascript">
var fb_param = {};
fb_param.pixel_id = '6009683277303';
fb_param.value = '0.00';
fb_param.currency = 'USD';
(function(){
  var fpw = document.createElement('script');
  fpw.async = true;
  fpw.src = '//connect.facebook.net/en_US/fp.js';
  var ref = document.getElementsByTagName('script')[0];
  ref.parentNode.insertBefore(fpw, ref);
})();
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/offsite_event.php?id=6009683277303&amp;value=0&amp;currency=USD" /></noscript>

<?php

// Authorization
Application::allow('artist, member');

/**
 * Users with the "member" role don't get their artist's name loaded to the session at login
 * Here we check if the current role is "member" then we issue a call to get and set the proper artist name
*/
if ('member' == $_SESSION['role']) {
	$artist = $apicaller->sendRequest(array(
		'controller' =>	'User',
		'action'	 =>	'readartist',
		'uniqueid' 	 =>	$_SESSION['artistuniqueid']
	));
	
	$_SESSION['firstname'] = ucfirst($artist[0]->firstname);
	$_SESSION['lastname']  = ucfirst($artist[0]->lastname);
}

// Render view
Application::render('welcome', 'default');