<?php 
	include ('../lib/twitese.php');
	$t = getTwitter();
	if ( isset($_GET['since_id']) ) {
		
		$statuses = $t->replies(false, $_GET['since_id']);
		
		$empty = count($statuses) == 0? true: false;
		
		if ($empty) {
			echo "empty";
		} else {
			$count = 0;
			foreach ($statuses as $status) {
				$user = $status->user;
				$date = formatDate($status->created_at);
				$rawdate = formatDate($status->created_at, true);
				$text = formatText($status->text);
				$status_id = $status->id;
				if (++$count == count($statuses)) 
					$output = "<li style=\"border-bottom:1px solid #ccc\">";
				else
					$output = "<li>";
					
				$output .= "
							<span class=\"status_author\">
								<a href=\"user.php?id=$user->screen_name\" target=\"_blank\"><img src=\"$user->profile_image_url\" title=\"$user->screen_name\" /></a>
							</span>
							<span class=\"status_body\">
								<span class=\"status_id\">$status_id</span>
								<span class=\"status_word\"><a class=\"user_name\" href=\"user.php?id=$user->screen_name\" target=\"_blank\">$user->screen_name</a> $text </span>
								"; 
					if ($shorturl = unshortUrl($status->text)) $output .= "<span class=\"unshorturl\">$shorturl</span>";
					
					$output .= "<span class=\"status_info\">";
					$output .= "<a class=\"replie_btn\" href=\"a_reply.php?id=$status->id\">回复</a>";
					$output .= "<a class=\"rt_btn\" href=\"a_rt.php?id=$status->id\">回推</a>";
					if ($user->screen_name != $t->username) $output .= "<a class=\"ort_btn\" href=\"a_ort.php?id=$status->id\">官方RT</a>";
					$output .= "<a class=\"favor_btn\" href=\"a_favor.php?id=$status->id\">收藏</a>";
					if ($user->screen_name == $t->username) $output .= "<a class=\"delete_btn\" href=\"a_del.php?id=$status->id&t=s\">删除</a>";
					
					if ($status->in_reply_to_status_id) $output .= "<span class=\"in_reply_to\"> <a href=\"status.php?id=$status->in_reply_to_status_id \">对 $status->in_reply_to_screen_name 的回复</a></span>";
					$output .= "		
					 				<span class=\"source\">通过 $status->source</span>
									<span class=\"date\" title=\"$rawdate\"><a href=\"https://twitter.com/$user->screen_name/status/$status->id\" target=\"_blank\">$date</a></span>
							    </span>
							</span>
						</li>";
				echo $output;
			}
		}
		
	} else {
		echo 'error';
	}

?>

