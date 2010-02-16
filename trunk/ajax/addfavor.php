<?php 
	include ('../lib/twitese.php');
	$t = getTwitter();
	$result = $t->makeFavorite($_POST['status_id']);
	if (isset($result->created_at)) echo 'success';
	else if ($result == 'favorited') echo 'favorited';
	else echo 'error';
?>