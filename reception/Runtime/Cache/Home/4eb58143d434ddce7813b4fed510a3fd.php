<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" type="text/css" href="/TWBB/Public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/TWBB/Public/css/LCXZS.css">
    <link href="/TWBB/Public/img/LCXZS-icon.png" rel="shortcut icon">
</head>
<body>
<div class="LCXZS">
    <header class="header">
        <div class="center clearfix">
            <a href="/TWBB/" title="TWBB记事本" class="logo">
                <img src="/TWBB/Public/img/LCXZS-icon.png" title="TWBB记事本" alt="TWBB记事本" /> 
                <h1>TWBB</h1>
            </a>
            <div class="user-information">
                <?php if($_SESSION["uid"] != ''): ?><a href="" title="<?php echo (session('username')); ?>"><?php echo ($_SESSION["username"]); ?></a>
                    <a href="/TWBB/sign/out" title="退出">退出</a>
                <?php else: ?>
                    <a href="/TWBB/sign/in" title="登录">登录</a>
                    <a href="/TWBB/sign/register" title="注册">注册</a><?php endif; ?>
            </div>
        </div>
    </header>
    
    <!-- 注册页面 -->
    <div class="center sign-register margin-30 clearfix">
        <article class="form-cont sign-register-form clearfix">
            <h1>TWBB注册</h1>
            <form method="post">
                <ul>
                    <li class="form-input clearfix">
                        <div class="form-title">用 户 名：</div>
                        <input type="text" name="username" placeholder="请输入用户名" autofocus="autofocus" class="form-input-no" autocomplete="off"  disableautocomplete  />
                    </li>
                    <li class="form-input clearfix">
                        <div class="form-title">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码：</div>
                        <input type="password" name="userpw" placeholder="请输入密码" autofocus="autofocus" class="form-input-no" autocomplete="off"  disableautocomplete  />
                    </li>
                    <li class="form-input clearfix">
                        <div class="form-title">手 机 号：</div>
                        <input type="text" name="userphone" placeholder="请输入手机号" autofocus="autofocus" class="form-input-no" autocomplete="off"  disableautocomplete maxlength="11" />
                    </li>
                    <li class="form-input clearfix">
                        <div class="form-title">邮 箱 号：</div>
                        <input type="text" name="email" placeholder="请输入邮箱号" autofocus="autofocus" class="form-input-no" autocomplete="off"  disableautocomplete  />
                    </li>
                    <li class="form-select clearfix">
                        <div class="form-title">是否羊头：</div>
                        <select name="is_sheep">
                        <!-- 这里需要用php从数据库中获取相关的信息 -->
                            <option value="0">否</option>
                            <option value="1">是</option>
                        </select>
                    </li>
                    <li class="form-submit clearfix ">
                        <input type="submit" value="提交" />
                        <input type="reset" value="重置" />
                    </li>
                </ul>
            </form>
        </article>
    </div>
</div>
<script src="/TWBB/Public/js/jquery.js"></script>
<script>
 (function (doc, win) {
    var docEl = doc.documentElement,
        resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
        recalc = function () {
            var clientWidth = docEl.clientWidth;
            if (!clientWidth) return;
            if(clientWidth>=640){
                docEl.style.fontSize = '10px';
            }else{
                docEl.style.fontSize = 10 * (clientWidth / 640) + 'px';
            }
        };

    if (!doc.addEventListener) return;
    win.addEventListener(resizeEvt, recalc, false);
    doc.addEventListener('DOMContentLoaded', recalc, false);
})(document, window);
</script>
<script>
$(function(){
    var rh = $('.sign-register').height();
    var hh = $('html').height();
    if (hh > 750) {
        $('.sign-register').css('top',((hh - rh)/2)-100);
    };
    console.log(hh);
    
    // 验证输入：
    $('.sign-register-form').verification({
        list:[
            ['username','not_null','请输入用户名'],
            ['userpw','not_null','请输入用密码'],
            ['userphone','not_null','请输入手机号'],
            ['email','not_null','请输入邮箱号'],
        ],
    });
})
</script>
<script>
(function ($) {
    $.fn.verification = function(options){
        var def = {
            list : [],
        }
        var ops = $.extend(def,options);
        var tishi ='';
        var tongguo = true;
        $(this).find('input[type=submit]').on('click',function(e){
            e.preventDefault();
            e.stopPropagation();
            tishi += '<div class="propose"><div class="propose-text" style="padding:30px 75px;"><div class="propose-pub propose-result" style="width:200px; min-width:inherit;"><h3>下列表单出错</h3><ul class="propose-result-list" style="font-size:16px; color:red;">';
            $(ops.list).each(function(k,v){
                var this_val = $('input[name='+v[0]+']').val();
                switch(v[1]){
                    case 'not_null':
                        if (this_val == '') {
                            $('input[type=submit]').css('cursor','not-allowed');
                            tongguo = false ;
                            tishi +='<li>'+v[2]+'</li>';
                        }else{
                            tongguo = true ;
                        };
                        break;
                }
            });
            tishi += '</ul><div class="propose-result-button"><a href="javascript:;" title="确认" class="result-submit">确认</a></div></div></div><div class="propose-back"></div></div>';
            if (!tongguo) {
                $('body').prepend(tishi);
                $(this).attr('disabled','disabled');
            }else{
                $(this).parents('form').submit();
            };
            $('.result-submit').on('click',function(){
                // 删除
                $('.propose').remove();
                $('input[type=submit]').removeAttr('disabled').css('cursor','pointer');
                tishi ='';
            });
        });
        
    };
})(jQuery);
</script>