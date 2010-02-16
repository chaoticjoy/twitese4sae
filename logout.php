<?php 
	include ('lib/twitese.php');
	$time = time() - 300;
	delCookie('twitese_name');
	delCookie('twitese_pw');
	delCookie('friends_count');
	delCookie('statuses_count');
	delCookie('followers_count');
	delCookie('imgurl');
	delCookie('name');
	header('location: login.php');
?>