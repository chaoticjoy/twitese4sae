﻿$(function(){
	timelineFocus();
	$(".rt_btn").click(function(e){
		e.preventDefault();
		if ($("#textbox").length > 0) {
			onInfoRT($(this));
		} else {
			$("#info_head").before('<h2>发推</h2>' + formHTML);
			formFunc();
			onInfoRT($(this));
		}
	});
	
	$(".replie_btn").click(function(e){
		e.preventDefault();
		if ($("#textbox").length > 0) {
			onInfoReplie($(this));
		} else {
			$("#info_head").before('<h2>发推</h2>' + formHTML);
			formFunc();
			onInfoReplie($(this));
		}
	});
	
	$("#info_reply_btn").click(function(){
		var replie_id = $("#info_name").text();
		if ($("#textbox").length > 0) {
			$("#textbox").val($("#textbox").val() + "@" + replie_id + " ");
			$("#textbox").focus();
			leaveWord();
		} else {
			$("#info_head").before('<h2>给' + replie_id + '留言</h2>' + formHTML);
			formFunc();
			$("#textbox").val($("#textbox").val() + "@" + replie_id + " ");
			$("#textbox").focus();
			leaveWord();
		}
	});
	
	if (getCookie("infoShow") == "hide") {
		onHide();
	}
	
	
	$("#info_hide_btn").live("click", function(){
		onHide();
	});
	
	
	$(".favor_btn").live("click", function(){
		e.preventDefault();
		onFavor($(this));
	});
	$(".ort_btn").live("click", function(e){
		e.preventDefault();
		onORT($(this));
	});

	$("#info_follow_btn").live("click", function(e){
		e.preventDefault();
		var $this = $(this);
		var id = $("#info_name").text();

		tipStart("正在关注" + id + "...");
		
		$.ajax({
			url: "ajax/relation.php",
			type: "POST",
			data: "action=create&id=" + id,
			success: function(msg) {
				if (msg.indexOf("success") >= 0) {
					tipEnd("关注" + id + "成功");
					$this.after('<a class="info_btn_hover" id="info_block_btn" href="javascript:void(0)">取消关注</a>');
					$this.remove();
				} else {
					tipEnd("关注" + id + "失败，请重试", true);
				}
			},
			error: function(msg) {
				tipEnd("关注" + id + "失败，请求无响应", true);
			}
		});
	});
	
	$("#info_block_btn").live("click", function(e){
		e.preventDefault();
		var $this = $(this);
		var id = $("#info_name").text();

		tipStart("正在取消关注" + id + "...");;
		$.ajax({
			url: "ajax/relation.php",
			type: "POST",
			data: "action=destory&id=" + id,
			success: function(msg) {
				if (msg.indexOf("success") >= 0) {
					tipEnd("取消关注" + id + "成功");
					$this.after('<a class="info_btn" id="info_follow_btn" href="javascript:void(0)">关注此人</a>');
					$this.remove();
				} else {
					tipEnd("取消关注" + id + "失败，请重试", true);
				}
			},
			error: function(msg) {
				tipEnd("取消关注" + id + "失败，请求无响应", true);
			}
		});
		
	});
	
	$("#block_btn").live("click", function(){
		var id = $("#info_name").text();
		var confirm = window.confirm("确定要把" + id + "拉入黑名单?");
		if (confirm) {
			tipStart("正在把" + id + "拉入黑名单...");
			
			$.ajax({
				url: "/block",
				type: "POST",
				data: "action=create&id=" + id,
				success: function(msg) {
					if (msg.indexOf("success") >= 0) {
						tipEnd("成功把" + id + "拉入黑名单");
					} else {
						tipEnd("把" + id + "拉入黑名单失败，请重试", true);
					}
				},
				error: function(msg) {
					tipEnd("把" + id + "拉入黑名单失败，请求无响应", true);
				}
			});
		}
	});
	
	$("#unblock_btn").live("click", function(){
		var id = $("#info_name").text();
		var confirm = window.confirm("确定解除黑名单?");
		if (confirm) {

			tipStart("正在解除黑名单...");
			$.ajax({
				url: "/block",
				type: "POST",
				data: "action=destory&id=" + id,
				success: function(msg) {
					if (msg.indexOf("success") >= 0) {
						tipEnd("成功解除黑名单");
					} else {
						tipEnd("解除黑名单失败，请重试", true);
					}
				},
				error: function(msg) {
					tipEnd("解除黑名单失败，请求无响应", true);
				}
			});
		}
	});
});

function onInfoReplie($this) {
	var replie_id = $("#info_name").text();
	$("#textbox").val("@" + replie_id + " ");
	$("#textbox").focus();
	$("#in_reply_to").val($this.parent().parent().find(".status_id").text());
	leaveWord();
}

function onInfoRT($this) {
	var replie_id = $("#info_name").text();
	$("#textbox").val("RT @" + replie_id + ":" + $this.parent().parent().find(".status_word").text());
	$("#textbox").focus();
	leaveWord();
}
function getCookie(name){
     var strCookie=document.cookie;
     var arrCookie=strCookie.split("; ");
     for(var i=0;i<arrCookie.length;i++){
           var arr=arrCookie[i].split("=");
           if(arr[0]==name)return unescape(arr[1]);
     }
     return "";
}
function setCookie(name,value,expireHours){
	var cookieString=name+"="+escape(value);
	if(expireHours>0){
		var date=new Date();
		date.setTime(date.getTime+expireHours*3600*1000);
		cookieString=cookieString+"; expire="+date.toGMTString();
	}
     document.cookie=cookieString;
} 
function onHide(){
	$this = $("#info_hide_btn");
	$this.after('<a class="info_btn_hover" id="info_show_btn" href="javascript:void(0)">显示@</a>');
	$this.remove();
	
	$("#info_show_btn").click(function(){
		$(".timeline li").each(function(i,o) {
			$(this).show();
		});
		$(this).after('<a class="info_btn" id="info_hide_btn" href="javascript:void(0)">隐藏@</a>');
		$(this).remove();
		$("#info_hide_btn").live("click", function(){
			onHide();
		});
		setCookie("infoShow","show");
	});
	
	$(".timeline li").each(function(i,o) {
		if ($(this).find(".status_word").text().indexOf("@") > -1) {
			$(this).hide();
		}
	});
	setCookie("infoShow","hide");
}
