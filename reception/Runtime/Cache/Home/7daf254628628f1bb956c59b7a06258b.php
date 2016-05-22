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
    
    <article class="form-cont login clearfix">
        <img src="/TWBB/Public/img/login-touxiang.png" title="头像" alt="头像" class="login-touxiang" />
        <form class="clearfix" method="post" action="/TWBB/sign/in">
            <ul>
                <li class="form-input clearfix">
                    <div class="form-title">用户名：</div>
                    <input type="text" name="username" placeholder="请输入用户名"/>
                </li>
                <li class="form-input clearfix">
                    <div class="form-title">密　码：</div>
                    <input type="password" name="userpw" placeholder="请输入用户名"/>
                </li>
                <li class="form-submit clearfix">
                    <input type="submit" value="登录" />
                    <input type="reset" value="重置" />
                </li>
            </ul>
            <div class="new-register">
                还没有帐号吗？ <a href="/TWBB/sign/register" title="马上注册吧">马上注册吧</a>
            </div>
        </form>
    </article>
</div>
</div>
<script src="/TWBB/Public/js/jquery.js"></script>
<script>
// 根据body的高度判断是否用height:auto
$(function(){
    var lh = $('.LCXZS').height();
    console.log(lh);
    if (lh >= 880) {
        $('html').css('height','auto');
    }
});    
        !(function(win, doc){
    function setFontSize() {
        // 获取window 宽度
        // zepto实现 $(window).width()就是这么干的
        var winWidth =  window.innerWidth;
        // doc.documentElement.style.fontSize = (winWidth / 640) * 100 + 'px' ;
        
        // 2016-01-13 订正
        // 640宽度以上进行限制 需要css进行配合
        var size = (winWidth / 640) * 100;
        doc.documentElement.style.fontSize = (size < 100 ? size : 100) + 'px' ;
    }
 
    var evt = 'onorientationchange' in win ? 'orientationchange' : 'resize';
    
    var timer = null;
 
    win.addEventListener(evt, function () {
        clearTimeout(timer);
 
        timer = setTimeout(setFontSize, 300);
    }, false);
    
    win.addEventListener("pageshow", function(e) {
        if (e.persisted) {
            clearTimeout(timer);
 
            timer = setTimeout(setFontSize, 300);
        }
    }, false);
 
    // 初始化
    setFontSize();
 
}(window, document));
</script>
</body>
</html>