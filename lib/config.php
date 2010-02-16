<?php
//=====================================================================
//========================twitese相关设置==============================


//SAE在国内，需要用第三方API proxy，请自行搭建
define('API_URL', 'http://XXXXXXXXX/api');
//“随便看看”与“排行榜”的api地址，由架设在GAE的twitese提供
define('TWITESE_API_URL', 'http://twiteseapi.appspot.com');
//网站名称
define('SITE_NAME', '推特中文圈');

//加密用户名密码用的密匙，随便输入一字符串。
//需要mcrypt模块支持，如果值为空则不加密。视空间支持情况选择开启与否
define('SECURE_KEY', '');

//附加密码，如果密码不为空，登录时会要求用户输入附加密码。
define('TWITESE_PASSWORD', '');


//======================================================================
//=======================SINA SAE相关设置===============================
//SAE access key，在SAE应用的汇总信息中获取
define('AKEY', '');

//SAE security key，在SAE应用的汇总信息中获取
define('SKEY', '');

//SAE应用的名字(???).sinaapp.com，对于绑定域名的童鞋，这里不设置
define('APP_NAME','');

//对于自己绑定域名的童鞋请将".".APP_NAME.".sinaapp.com"换成你自己的域名，没有绑定域名则不需要设置
define('COOKIE_DOMAIN',".".APP_NAME.".sinaapp.com");
?>