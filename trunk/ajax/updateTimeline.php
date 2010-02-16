<?php 
	include ('../lib/twitese.php');
	$t = getTwitter();
	if ( isset($_GET['since_id']) ) {
		
		//是否跳过自己发的推
		$isJumped = false;
		if ( isset($_GET['j']) && $_GET['j'] == 1) {
			$isJumped = true;
		}
		
		$statuses = $t->homeTimeline(false, $_GET['since_id']);
		
		$empty = count($statuses) == 0? true: false;
		
		if ($empty) {
			echo "empty";
		} else {
			$count = 0;
			foreach ($statuses as $status) {
			
				$is_rt = isset($status->retweeted_status) && isset($_COOKIE['rt_style']) && $_COOKIE['rt_style'] == 1;
				
				$username = $t->username;
				if ($is_rt) {
					
					if (isset($argsArr['show_rtid'])) $status_id = $status->id;
					else $status_id = $status->retweeted_status->id;
					
					$rtsign = 'rt_sign';
					$user = $status->retweeted_status->user;
					$rtuser = $status->user;
					$date = formatDate($status->created_at);
					$rawdate = formatDate($status->created_at, true);
					$text = formatText($status->retweeted_status->text);
				} else {
					$user = $status->user;
					$date = formatDate($status->created_at);
					$rawdate = formatDate($status->created_at, true);
					$text = formatText($status->text);
					$status_id = $status->id;
					$rtsign = '';
				}
				
				if (!($isJumped && $user->screen_name == $t->username)) {
					
					if(strpos($text, "@$t->username") > -1) {
						if (++$count == count($statuses)) 
							$output = "<li style=\"border-bottom:1px solid #ccc\" class=\"mention\">";
						else 
							$output = "<li class=\"mention\">";
					} else {
						if (++$count == count($statuses)) 
							$output = "<li style=\"border-bottom:1px solid #ccc\">";
						else 
							$output = "<li>";
					}
					
					$output .= "
							<span class=\"status_author\">
								<a href=\"user.php?id=$user->screen_name\" target=\"_blank\"><img src=\"$user->profile_image_url\" title=\"$user->screen_name\" /></a>
							</span>
							<span class=\"status_body\">
								<span class=\"status_id\">$status_id</span>
								<span class=\"status_word\"><a class=\"user_name $rtsign\" href=\"user.php?id=$user->screen_name\" target=\"_blank\">$user->screen_name</a> $text </span>
								"; 
					if ($shorturl = unshortUrl($status->text)) $output .= "<span class=\"unshorturl\">$shorturl</span>";
					
					$output .= "<span class=\"status_info\">";
					$output .= "<a class=\"replie_btn\" href=\"a_reply.php?id=$status->id\">回复</a>";
					$output .= "<a class=\"rt_btn\" href=\"a_rt.php?id=$status->id\">回推</a>";
					if ($user->screen_name != $username) $output .= "<a class=\"ort_btn\" href=\"a_ort.php?id=$status->id\">官方RT</a>";
					$output .= "<a class=\"favor_btn\" href=\"a_favor.php?id=$status->id\">收藏</a>";
					if ($user->screen_name == $username) $output .= "<a class=\"delete_btn\" href=\"a_del.php?id=$status->id&t=s\">删除</a>";
					
					if ($status->in_reply_to_status_id) $output .= "<span class=\"in_reply_to\"> <a href=\"status.php?id=$status->in_reply_to_status_id \">对 $status->in_reply_to_screen_name 的回复</a></span>";
					if ($is_rt) $output .= "RT by <a href=\"user.php?id=$rtuser->screen_name\">$rtuser->screen_name</a>";
					else if (isset($status->retweeted_status)) $output .= "RT from <a href=\"user.php?id=" . $status->retweeted_status->user->screen_name . "\">" . $status->retweeted_status->user->screen_name . "</a>";
					$output .= "		
					 				<span class=\"source\">通过 $status->source</span>
									<span class=\"date\" title=\"$rawdate\"><a href=\"https://twitter.com/$user->screen_name/status/$status->id\" target=\"_blank\">$date</a></span>
							    </span>
							</span>
						</li>";
					echo $output;
				} else {
					$count ++;
				}//end of if jump
			}	//end of for
		}
		
	} else {
		echo 'error';
	}

?>

