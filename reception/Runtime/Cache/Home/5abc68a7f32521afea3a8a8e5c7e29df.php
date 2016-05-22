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
                <?php if($_SESSION["uid"] != ''): ?><a href="/TWBB/user/index" title="<?php echo (session('username')); ?>"><?php echo ($_SESSION["username"]); ?></a>
                    <a href="/TWBB/sign/out" title="退出">退出</a>
                <?php else: ?>
                    <a href="/TWBB/sign/in" title="登录">登录</a>
                    <a href="/TWBB/sign/register" title="注册">注册</a><?php endif; ?>
            </div>
        </div>
    </header>
    
<div class="propose" style="display:none;">
    <div class="propose-text" >
        <div class="propose-pub propose-input addaccountsinput" style="display:none;">
            <h3>请输入账号</h3>
            <div>请输入账号（或手机）</div>
            <form action="/TWBB/user/handle" method="post">
                <input type="text" name="accountsname" autocomplete="off"  disableautocomplete maxlength="17" />
                <input type="hidden" name="tyle" value="addaccountsinput" />
            </form>
            <p></p>
            <a href="javascript:;" title="确认提交" class="propose-confirm">确认提交</a>
        </div>
        <div class="propose-pub accountsdelete" style="display:none;">
            <div class="accountsdelete-text">你确定要删除 <span></span> 该账号吗？</div>
            <div class="propose-result-button" >
                <a href="javascript:;" title="是" class="operation-lower-submit">是</a>
                <a href="javascript:;" title="取消" class="operation-lower-button">取消</a>
            </div>
            <form action="/TWBB/user/handle" method="post" class="accountsdelete-form">
                <input type="hidden" name="tyle" value="accountsdelete" />
                <input type="hidden" name="aid" value="">
            </form>
        </div>
    </div>
    <div class="propose-back"></div>
</div>
<div class="center wool-lists margin-30 clearfix">

    <nav class="nav">
    <a href="/TWBB/user/index#avatar-box" title="<?php echo (session('username')); ?>" class="user">
        <img src="/TWBB/<?php echo (session('avatar')); ?>" title="<?php echo (session('username')); ?>" alt="<?php echo (session('username')); ?>" />
    </a>
    <ul>
        <li><a href="/TWBB/wool/index" title="羊毛记录" ><img src="/TWBB/Public/img/nav-wool.png" title="羊毛记录" alt="羊毛记录" /></a></li>
        <li><a href="/TWBB/user/index" title="设置"><img src="/TWBB/Public/img/nav-setting.png" title="设置" alt="设置" /></a></li>
    </ul>
</nav>
    <article class="user-modify form-cont clearfix ">
        <h1>用户信息修改</h1>
        <div class="user-modify-tab clearfix">
            <h3 class="materials">更改资料</h3>
            <h3 class="avatar">更改头像</h3>
            <h3 class="pw">更改密码</h3>
            <h3 class="accounts">账号操作</h3>
        </div>
        <div class="user-modify-text">
            <div class="materials-text">
                <form method="post" action="/TWBB/user/handle">
                    <ul>
                        <li class="form-input clearfix">
                            <div class="form-title">帐号名：</div>
                            <div class="form-def"><?php echo ($def["username"]); ?></div>
                        </li>
                        <li class="form-input clearfix">
                            <div class="form-title">注册时间：</div>
                            <div class="form-def"><?php echo (date("Y-m-d",$def["registertimes"])); ?></div>
                        </li>
                        <li class="form-input clearfix">
                            <div class="form-title">上次登录时间：</div>
                            <div class="form-def"><?php echo (date("Y-m-d",$def["lasttimes"])); ?></div>
                        </li>
                        <li class="form-input clearfix">
                            <div class="form-title">上次登录IP：</div>
                            <div class="form-def"><?php echo ($def["lastip"]); ?></div>
                        </li>
                        <li class="form-input clearfix">
                            <div class="form-title">邮箱：</div>
                            <input type="text" name="email" placeholder="请输入修改的邮箱" class="form-input-no" autocomplete="off"  disableautocomplete value="<?php echo ($def["email"]); ?>" />
                        </li>
                        <li class="form-input clearfix">
                            <div class="form-title">手机号：</div>
                            <input type="text" name="phone" placeholder="请输入修改的手机号" class="form-input-no" autocomplete="off"  disableautocomplete value="<?php echo ($def["phone"]); ?>" maxlength="11" />
                        </li>
                        <li class="form-input clearfix">
                            <div class="form-title">是否被锁定：</div>
                            <?php if($def["locking"] == 1): ?><div class="form-def">是</div>
                            <?php else: ?>
                                <div class="form-def">否</div><?php endif; ?>
                        </li>
                        <li class="form-choice clearfix">
                            <div class="form-title">是否羊头：</div>
                            <!-- 这里也是 选项卡 -->
                            <div class="choice clearfix">
                                <div choiceid="0" class="choice-select">否</div>
                                <div choiceid="1" >是</div>
                            </div>
                            <input type="hidden" name="m-is-sheep" class="choice-hidden" value="0" />
                        </li>
                        <li class="form-submit clearfix ">
                            <input type="hidden" name="tyle" value="materials">
                            <input type="submit" value="提交" />
                            <input type="reset" value="重置" />
                        </li>
                    </ul>  
                </form>
            </div>
            <div class="avatar-text clearfix" style="display:none;" id="avatar-box">
                <label for="file_input" class="filebuttom">请点击上传</label>
                <div class="clearfix" style="clear:both;">
                    <div class="old">
                        <div class="avatar-title">原来的头像</div>
                        <img src="/TWBB/<?php echo ($def["avatar"]); ?>" title="<?php echo ($def["username"]); ?>" alt="<?php echo ($def["username"]); ?>" />
                    </div>
                    <div id="upload">
                        <div class="avatar-title">新头像</div>
                        <form action="/TWBB/user/handle" enctype="multipart/form-data" method="post" id="imgform" style="display:none;">   
                            <input type='file'  name='photos' class="upfile" id="file_input">
                            <input type="hidden" name="tyle" value="picture" />
                            <input type="reset" value="重置" style="display:none;" id="file_reset" />
                        </form>
                        <div id="preview" style="display:none;"></div>
                        <div class="upload-buttom" style="display:none;">
                            <div class="submitupload">上传</div>
                            <label class="reset" for="file_reset" >重置</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pw-text" style="display:none;">
                <form action="/TWBB/user/handle" method="post">
                    <ul>
                        <li class="form-input clearfix">
                            <div class="form-title">原密码：</div>
                            <input type="password" name="originalpw" placeholder="请输入原密码" class="form-input-no" autocomplete="off"  disableautocomplete />
                            <div class="form-prompt" style="display:none;">不能为空</div>
                        </li>
                        <li class="form-input clearfix">
                            <div class="form-title">新密码：</div>
                            <input type="password" name="newpw" placeholder="请输入新密码" class="form-input-no" autocomplete="off"  disableautocomplete />
                            <div class="form-prompt" style="display:none;">不能为空</div>
                        </li>
                        <li class="form-input clearfix">
                            <div class="form-title">再输新密码：</div>
                            <input type="password" name="again-newpw" placeholder="请再输入新密码" class="form-input-no" autocomplete="off"  disableautocomplete />
                            <div class="form-prompt" style="display:none;">不能为空</div>
                        </li>
                        <li class="form-submit clearfix ">
                            <input type="hidden" name="tyle" value="pw">
                            <input type="submit" value="提交" />
                            <input type="reset" value="重置" />
                        </li>
                    </ul>
                </form>
            </div>
            <div class="accounts-text" style="display:none;">
                <div class="addaccounts clearfix">添加帐号</div>
                <table class="accountslist">
                    <tbody>
                        <tr class="accountslist-title">
                            <td>帐号</td>
                            <td>帐号添加时间</td>
                            <td>操作</td>
                        </tr>
                        <?php if(is_array($accountslist)): foreach($accountslist as $k=>$v): ?><tr aid='<?php echo ($v["aid"]); ?>'>
                                <td class="accountsname"><?php echo ($v["accounts_name"]); ?></td>
                                <td><?php echo (date('Y-m-d',$v["adddate"])); ?></td>
                                <td class="operation"><div>删除</div></td>
                            </tr><?php endforeach; endif; ?>
                        <?php if((count($accountslist)) > 8): ?><tr>
                                <td colspan="4"><?php echo ($accountspage); ?></td>
                            </tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
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
<script>
$(function(){
    $('.user-modify-tab h3').on('click',function(){
        var xx = $(this).attr('class');
        var bcolor = $(this).css('background-color');
        $(this).css('z-index',5).next('h3').css('z-index',4).next('h3').css('z-index',3).next('h3').css('z-index',2);
        $(this).prev('h3').css('z-index',4).prev('h3').css('z-index',3).prev('h3').css('z-index',2)
        $('.user-modify-text .'+xx+'-text').show().siblings().hide();
        $('.user-modify-text').css('border-color',bcolor);
    });
    // 当点击添加账号触发事件。
    $('.accounts-text .addaccounts').on('click',function(){
        $('.propose , .addaccountsinput').show();
    });
    $('.addaccountsinput .propose-confirm').on('click',function(){
        if ($(this).siblings('form').children('input[name=accountsname]').val() == "") {
            $(this).siblings('p').text('账号不能为空！').css('color','red').show();
        }else{
            $(this).siblings('form').submit();
        };
    });
    $('.addaccountsinput input[name=accountsname]').on('focus',function(){
        $(this).parent('form').siblings('p').hide();
    });
    // 删除操作
    $('.operation').on('click',function(){
        var accountsname = $(this).siblings('.accountsname').text();
        var aid = $(this).parent('tr').attr('aid');
        console.log(aid);
        $('.accountsdelete-form input[name=aid]').val(aid);
        $('.propose .accountsdelete .accountsdelete-text span').text(accountsname);
        $('.propose , .accountsdelete').show();
    });
    // 提交和取消删除操作
    $('.accountsdelete .operation-lower-submit').on('click',function(){
        $('.accountsdelete-form').submit();
    });
    $('.accountsdelete .operation-lower-button').on('click',function(){
        $('.propose , .accountsdelete').hide();
    });
    // 这部分是从网上查到的，要好好看看
    var input = document.getElementById("file_input");      // 获取file的input
    var imageType = /image.*/;                              // 上传类型。
    var getOnloadFunc = function(aImg) {                    // base64(内容)事件
        return function(evt) {
            aImg.src = evt.target.result;
        };
    };
    // 监听事件
    input.addEventListener("change", function(evt) {
        $('.imgerror').hide();
        for (var i = 0, numFiles = this.files.length; i < numFiles; i++) {      // 多文件预览
            var file = this.files[i];
            if (!file.type.match(imageType)) {
                continue;
            };
            var img = document.createElement("img");    // 创建img对象
            // document.body.appendChild(img);
            // 只能有一张相，通过判断进行// 预览图存放的位置并且展示图片。
            if($('#preview img').length == 0){
                $('#preview').append(img);
            }else if($('#preview img').length == 1){
                $('#preview').empty().append(img);
            };
            $('.upload-buttom , #preview').show();
            var reader = new FileReader();
            reader.onload = getOnloadFunc(img);
            reader.readAsDataURL(file);
        };
    }, false);
    $('#file_reset').on('click',function(){
        $('#preview , .upload-buttom').hide();
    });
    $('.submitupload').on('click',function(){
        if ($('#file_input').val() !== "") {
            $('#imgform').submit();
        }else{
            $('.avatar-text').append('<p class="imgerror">请选择头像</p>');
        };
    });
    // // 文件上传（图片上传），先试着做出来先
    // // 初始化Web Uploader
    // var uploader = WebUploader.create({
    //     // 选完文件后，是否自动上传。
    //     auto: true,
    //     // swf文件路径
    //     swf: '/TWBB/Public/js/webuploader/Uploader.swf',
    //     // 文件接收服务端。
    //     server: '/TWBB/ajax/avatar_up',
    //     // 选择文件的按钮。可选。
    //     // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    //     pick: '#filePicker',
    //     // 只允许选择图片文件。
    //     accept: {
    //         title: 'Images',
    //         extensions: 'gif,jpg,jpeg,bmp,png',
    //         mimeTypes: 'image/*'
    //     }
    // });
    // // 当有文件添加进来的时候
    // uploader.on( 'fileQueued', function( file ) {

    //     var $li = $(
    //             '<div id="' + file.id + '" class="file-item thumbnail">' +
    //                 '<img>' +
    //                 '<div class="info">' + file.name + '</div>' +
    //             '</div>'
    //             ),
    //         $img = $li.find('img');
    //     // $list为容器jQuery实例
    //     $('#fileList').append( $li );

    //     // 创建缩略图
    //     // 如果为非图片文件，可以不用调用此方法。
    //     // thumbnailWidth x thumbnailHeight 为 100 x 100
    //     uploader.makeThumb( file, function( error, src ) {
    //         if ( error ) {
    //             $img.replaceWith('<span>不能预览</span>');
    //             return;
    //         }
    //         $img.attr( 'src', src );
    //     }, 120 , 120 );
    // });
    // // 文件上传过程中创建进度条实时显示。
    // uploader.on( 'uploadProgress', function( file, percentage ) {
    //     var $li = $( '#'+file.id ),
    //         $percent = $li.find('.progress span');

    //     // 避免重复创建
    //     if ( !$percent.length ) {
    //         $percent = $('<p class="progress"><span></span></p>')
    //                 .appendTo( $li )
    //                 .find('span');
    //     };
    //     $percent.css( 'width', percentage * 100 + '%' );
    // });

    // // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    // uploader.on( 'uploadSuccess', function( file, xx ) {
    //     $( '#'+file.id ).addClass('upload-state-done');
    //     console.log(xx);
    // });

    // // 文件上传失败，显示上传出错。
    // uploader.on( 'uploadError', function( file ) {
    //     var $li = $( '#'+file.id ),
    //         $error = $li.find('div.error');

    //     // 避免重复创建
    //     if ( !$error.length ) {
    //         $error = $('<div class="error"></div>').appendTo( $li );
    //     }

    //     $error.text('上传失败');
    // });

    // // 完成上传完了，成功或者失败，先删除进度条。
    // uploader.on( 'uploadComplete', function( file ) {
    //     $( '#'+file.id ).find('.progress').remove();
    // });
});
</script>