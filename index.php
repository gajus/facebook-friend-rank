<?php
require __DIR__ . '/fb-sdk/facebook.php';
require __DIR__ . '/ay-fb-friend-rank.class.php';

// Generally this is expected to be less.
set_time_limit(60);

$fb		= new Facebook(array(
	'appId'		=> NULL, // Your Facebook app Id. You can obtain the credentials from http://developers.facebook.com/.
	'secret'	=> NULL
));

header('Content-Type: text/plain');

if($fb->getUser())
{
	$affr		= new AyFbFriendRank($fb);

	$friends	= $affr->getFriends();
	
	echo str_pad('Name', 40) . "Score\n";
	
	foreach($friends as $f)
	{
		echo str_pad($f['name'], 40) . $f['score'] . "\n";
	}
}
else
{
	echo $fb->getLoginUrl(array('scope' => 'user_photos,read_mailbox,read_stream,friends_photos,friends_birthday'));
	
	// user_hometown,friends_hometown,user_interests,friends_interests
}