<?php include ('lib/twitese.php') ?>
<?php $title = "登录" ?>
<?php include ('inc/header.php') ?>

<div id="login_area">
	<?php if (!function_exists('curl_init')) { ?>
	<div id="description">
		<p style="text-align: center; color:red;">空间不支持curl，无法使用twitese</p>
	</div>
	<?php } else {?>
	<div id="description">
		<p>Twitese推特中文圈旨在帮助中国twitter使用者寻找国内优秀twitter用户，同时让大陆用户无需翻墙即可更新状态和浏览好友消息。</p>
		<p>Twitese有两个版本，其一架设在Google App Engine上，由java语言编写，另一个PHP版本开源，可由任何人自由架设在自己服务器上，<a href="http://blog.webbang.net/?p=1000" target="_blank">详细</a>。开源主页：<a href="http://code.google.com/p/twitese/">http://code.google.com/p/twitese/</a></p>
	</div>
	<form id="login" method="post" action="login_action.php">
		<div><label class="login_label" for="username">用户名：</label><input type="text" id="username" name="username" /></div>
		<div><label class="login_label" for="password">密码：</label><input type="password" id="password" name="password" /></div>
		<?php if (TWITESE_PASSWORD != '') {?>
		<div><label class="login_label" for="twitese_password">附加密码：</label><input type="password" id="password" name="twitese_password" /></div>
		<?php }?>
		<div id="remember"><input type="checkbox" name="remember" id="remember_input" value="1" /><label for="remember_input">记住我</label></div>
		<input type="submit" id="login_btn" value="登录" />
	</form>
	<?php }?>
</div>	

<?php include ('inc/footer.php') ?>
