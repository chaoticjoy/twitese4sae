<?php
	include ('../lib/twitese.php');
	$t = getTwitter();
	$user = $t->showUser($t->username);
	if (!isset($user->error) && isset($user->name)) {
		$time = time() + 3600*24*30;
		setcookie('friends_count', $user->friends_count, $time, '/',COOKIE_DOMAIN);
		setcookie('statuses_count', $user->statuses_count, $time, '/',COOKIE_DOMAIN);
		setcookie('followers_count', $user->followers_count, $time, '/',COOKIE_DOMAIN);
		setcookie('imgurl', $user->profile_image_url, $time, '/',COOKIE_DOMAIN);
		setcookie('name', $user->name, $time, '/',COOKIE_DOMAIN);
		echo "{'friends':$user->friends_count, 'followers': $user->followers_count, 'statuses': $user->statuses_count}";
	} else {
		echo "{'error': 1}";
	}

?>