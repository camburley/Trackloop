<?php
$url = 'http://twitter.com/users/show/mak687';
$response = file_get_contents($url);
$t_profile = new SimpleXMLElement($response);
$count = $t_profile->followers_count;
echo "Twitter Followers : ".$count;
?>