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
    
    <div class="propose" style="display:none;">
        <div class="propose-text">
            <div class="propose-pub propose-result" style="display:none;">
                <h3></h3>
                <!-- 这里会输出各种提示信息 -->
                <ul class="propose-result-list"></ul>
                <div class="propose-result-button">
                    <a href="javascript:;" title="确认提交" class="result-submit">确认提交</a>
                    <a href="javascript:;" title="重置数据" class="result-reset">重置数据</a>
                </div>
            </div>
            <div class="propose-pub propose-input" style="display:none;">
                <h3>请输入期限天数</h3>
                <div>请输入投资期限，以天为单位。</div>
                <input type="text" name="input-other" autocomplete="off"  disableautocomplete /><span>（天）</span>
                <p></p>
                <a href="javascript:;" title="确认提交" class="propose-confirm">确认提交</a>
            </div>
        </div>
        <div class="propose-back"></div>
    </div>
    <div class="center wool-add margin-30 clearfix">
        <nav class="nav">
    <a href="" title="<?php echo (session('username')); ?>" class="user">
        <?php if(empty($$Think["session"]["avatar"])): ?><img src="/TWBB/Public/img/login-touxiang.png" title="<?php echo (session('username')); ?>" alt="<?php echo (session('username')); ?>" />
        <?php else: ?>
            <img src="<?php echo (session('avatar')); ?>" title="<?php echo (session('username')); ?>" alt="<?php echo (session('username')); ?>" /><?php endif; ?>
    </a>
    <ul>
        <li><a href="/TWBB/wool/index" title="羊毛记录" ><img src="/TWBB/Public/img/nav-wool.png" title="羊毛记录" alt="羊毛记录" /></a></li>
        <li><a href="/TWBB/user/index" title="设置"><img src="/TWBB/Public/img/nav-setting.png" title="设置" alt="设置" /></a></li>
    </ul>
</nav>
        <article class="form-cont wool-add-form clearfix">
            <form method="post" action="/TWBB/wool/handle">
                <h1>羊毛记录添加</h1>
                <ul>
                    <li class="form-select clearfix">
                        <div class="form-title">账号名（或手机号）：</div>
                        <select name="account-number">
                            <?php if($wool_type == add): ?><!-- 这里需要用php从数据库中获取相关的信息 -->
                                <?php if(is_array($accounts_list)): foreach($accounts_list as $key=>$v): ?><option value="<?php echo ($v["accounts_name"]); ?>"><?php echo ($v["accounts_name"]); ?></option><?php endforeach; endif; ?>
                            <?php elseif($wool_type == modify): ?>
                                <!-- 这是修改时出现的页面，讲数据库中设置成第一位 -->
                                <?php if(is_array($accounts_list)): foreach($accounts_list as $key=>$v): ?><option value="<?php echo ($v); ?>"><?php echo ($v); ?></option><?php endforeach; endif; endif; ?>
                        </select>
                    </li>
                    <li class="form-input clearfix">
                        <div class="form-title">平台名：</div>
                        <!-- 这里以后可能会写一个自动补全的H5来代替现在的输入，规范输入，并且出现跑路等情况，会即时提醒 -->
                        <input type="text" name="platform-name" placeholder="请输入平台名" autofocus="autofocus" class="form-input-no" autocomplete="off"  disableautocomplete <?php if($wool_type == modify): ?>value="<?php echo ($modification_list["platform"]); ?>"<?php endif; ?> />
                        <div class="form-prompt" style="display:none;">请输入平台名</div>
                    </li>
                    <li class="form-input clearfix">
                        <div class="form-title">投资金额：</div>
                        <input type="text" name="investment" placeholder="请输入投资金额" class="form-input-number" autocomplete="off"  disableautocomplete <?php if($wool_type == modify): ?>value="<?php echo ($modification_list["investment"]); ?>"<?php endif; ?> />
                        <!-- 不能为负数，并且必须为正整数，当通过后将会数字化一下，方便用户看 -->
                        <div class="form-prompt" style="display:none;">请输入正整数的投资金额</div>
                    </li>
                    <li class="form-input clearfix">
                        <div class="form-title">投资日期：</div>
                        <!-- 这里会使用jquery_ui来设置日期插件，不使用html5的日期input的原因是暂时还不是支持得很好。 -->
                        <input type="text" name="investment_date" placeholder="请输入投资日期" id="investment-date" class="form-input-time" autocomplete="off"  disableautocomplete <?php if($wool_type == modify): ?>value="<?php echo ($modification_list["investment_date"]); ?>"<?php endif; ?> />
                        <div class="form-prompt" style="display:none;">请输入投资日期</div>
                    </li>
                    <li class="form-choice clearfix">
                        <div class="form-title">投资期限：</div>
                        <!-- 这里我打算用选项卡的形式进行设置，分别是1天，15天，1个月，3个月，6个月和其他，当出现其他时会弹出一个输入框用于输入设置的日期 -->
                        <div class="choice clearfix">
                            <div choiceid="1" class="choice-select">1天</div>
                            <div choiceid="15">15天</div>
                            <div choiceid="30">1个月</div>
                            <div choiceid="other">其他</div>
                        </div>
                        <input type="hidden" name="investment-period" class="choice-hidden" value="1" />
                    </li>
                    <li class="form-input clearfix">
                        <div class="form-title">平台返利：</div>
                        <input type="text" name="rebate-platform" placeholder="请输入平台返利金额" class="form-input-number" autocomplete="off"  disableautocomplete <?php if($wool_type == modify): ?>value="<?php echo ($modification_list["platform_back"]); ?>"<?php endif; ?> />
                        <!-- 这里可以是小数点后一位。 -->
                        <div class="form-prompt" style="display:none;">请输入平台返利金额</div>
                    </li>
                    <li class="form-input clearfix">
                        <div class="form-title">羊头返利：</div>
                        <input type="text" name="sheep-rebate" placeholder="请输入羊头返利金额" class="form-input-number" autocomplete="off"  disableautocomplete <?php if($wool_type == modify): ?>value="<?php echo ($modification_list["sheep_rebate"]); ?>"<?php endif; ?> />
                        <!-- 这里可以是小数点后一位。 -->
                        <div class="form-prompt" style="display:none;">请输入羊头返利金额</div>
                    </li>
                    <li class="form-choice clearfix sheep-rebate-choice">
                        <div class="form-title">羊头是否已返利：</div>
                        <!-- 这里也是 选项卡 -->
                        <div class="choice clearfix">
                            <div choiceid="1" class="choice-select">是</div>
                            <div choiceid="0">否</div>
                        </div>
                        <input type="hidden" name="sheep-rebate-choice" class="choice-hidden" value="1" />
                    </li>
                    <li class="form-submit clearfix ">
                        <input type="hidden" name="other-input" value="">
                        <input type="hidden" name="wool_type" value="<?php echo ($wool_type); ?>">
                        <?php if($wool_type == modify): ?><input type="hidden" name="rid" value="<?php echo ($_GET['rid']); ?>"><?php endif; ?>
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
<script src="/TWBB/Public/js/laydate/laydate.js"></script>
<script>
//以后我打算把这些js都整合到js文件中
$(function(){
    $('.form-choice .choice div').on('click',function(){
        $(this).addClass('choice-select');
        $(this).siblings().removeClass('choice-select');
        var choiceid = $(this).attr('choiceid');
        $(this).parent('.choice').next('.choice-hidden').val(choiceid);
        //当出现其他的选项时，需要弹出输入框
        if ($(this).attr('choiceid') == "other") {
            $('.propose-input div').text('请输入投资期限，以天为单位。');
            $('.propose-input span').text('（天）');
            $('.propose-input , .propose').show();
        };
    });
    // 当检验弹出对话框内的内容。
    $('.propose-input input').on('blur',function(){
        //正整数正则
        var regular = /^[0-9]*[1-9][0-9]*$/;
        var aa = $(this).val();
        if (!regular.test(aa)) {
            $(this).siblings('p').html('请输入正确投资期限，<br/>以天（正整数）为单位。');
            $(this).siblings('.propose-confirm').attr('disabled','true').css('cursor','not-allowed');
        }else{
            $(this).siblings('p').hide();
            $(this).siblings('.propose-confirm').removeAttr('disabled').css('cursor','pointer');
            $(this).siblings('.propose-confirm').on('click',function(){
                $('.form-submit input[name=other-input]').val(aa);
                $('.propose-input , .propose').hide();
            });
        }
    });
    $('.form-submit input[type=reset]').on('click',function(){
        $('.form-choice .choice div:first-child').addClass('choice-select').siblings().removeClass('choice-select');
    });
    // 根据不同的类型（class）检测输入框是否为空和是否输入正确。
    testing();
    function testing (){
        var regular = "";
        $('.form-input input').on('blur',function(){
            if ($(this).val() === "" && !$(this).hasClass('form-input-time')) {
                $(this).siblings('.form-prompt').show();
                $('.form-submit input[type=submit]').attr('disabled','true').css('cursor','not-allowed');
            }else if(!$(this).hasClass('form-input-time') && !$(this).hasClass('form-input-no')){
                // 分3钟情况，中文，数字，时间
                if ($(this).hasClass('form-input-number')) {
                    regular = /^[0-9]*[1-9]*$/;
                }else if($(this).hasClass('form-input-chinese')){
                    regular = /^([\u4E00-\u9FA5]+，?)+$/;
                }
                if (regular.test($(this).val())) {
                    $(this).siblings('.form-prompt').hide();
                    if ($('.form-input .form-prompt:visible').length == 0) {
                        $('.form-submit input[type=submit]').removeAttr('disabled').css('cursor','pointer');
                    };
                }else{
                    $(this).siblings('.form-prompt').show();
                    $('.form-submit input[type=submit]').attr('disabled','true').css('cursor','not-allowed');
                }
            }else if($(this).hasClass('form-input-no')){
                $(this).siblings('.form-prompt').hide();
                if ($('.form-input .form-prompt:visible').length == 0) {
                    $('.form-submit input[type=submit]').removeAttr('disabled').css('cursor','pointer');
                };
            }
        });
    };
    // 加入时间插件
    laydate({
        elem: '#investment-date',
        format: 'YYYY-MM-DD', // 分隔符可以任意定义，该例子表示只显示年月
        festival: true, //显示节日
        istime : true
    });
    // 当提交时，先弹出一个提示框确认后再提交
    $('.wool-add-form form input[type=submit]').click(function(even){
        even.preventDefault();
        var account_number = $('select[name=account-number]').val();
        var platform_name = $('input[name=platform-name]').val();
        var investment = $('input[name=investment]').val();
        var investment_date = $('input[name=investment_date]').val();
        var investment_period = $('input[name=investment-period]').val();
        if (investment_period == "other") {
            investment_period = $('input[name=other-input]').val();
        };
        var rebate_platform = $('input[name=rebate-platform]').val();
        var sheep_rebate = $('input[name=sheep-rebate]').val();
        var sheep_rebate_choice = $('input[name=sheep-rebate-choice]').val();
        // 设置标题
        $('.propose , .propose-result').show().children('h3').text('确认信息');
        var list_str = '<li><div>帐号：</div><p>'+account_number+'</p></li><li><div>平台名：</div><p>'+platform_name+'</p></li><li><div>投资金额：</div><p>'+investment+' 元</p></li><li><div>投资日期：</div><p>'+investment_date+'</p></li><li><div>投资期限：</div><p>'+investment_period+' 天</p></li><li><div>平台返利：</div><p>'+rebate_platform+' 元</p></li><li><div>羊头返利：</div><p>'+sheep_rebate+' 元</p></li><li><div>羊头是否已返利：</div><p>';
        if (sheep_rebate_choice == 1) {
            list_str += '是';
        }else{
            list_str += '否';
        }
        list_str +='</p></li>';
        $('.propose-text').css('top','17%');
        $('.propose-result-list').empty().append(list_str);
    });
    // 当点击确认后提交表单，当点击重置后重置表单
    $('.result-submit').on('click',function(){
        $('.wool-add-form form').submit();

    });
    $('.result-reset').on('click',function(){
        $('.wool-add-form form input[type=text]').val('');
        $('.form-choice .choice div:first-child').addClass('choice-select').siblings().removeClass('choice-select');
        $('.propose , .propose-result').hide();
    });
})
</script>
<?php if($wool_type == modify): ?><script >
// 这是在修改的时候才会出现
$(function(){
    var term = '<?php echo ($modification_list["term"]); ?>';
    var is_sheep_rebate = '<?php echo ($modification_list["is_sheep_rebate"]); ?>';
    $('input[name=investment-period]').val(term).prev('.choice').children('div').removeClass('choice-select');
    $('input[name=investment-period]').prev('.choice').children('div[choiceid='+term+']').addClass('choice-select');
    $('input[name=sheep-rebate-choice]').val(is_sheep_rebate).prev('.choice').children('div').removeClass('choice-select');
    $('input[name=sheep-rebate-choice]').prev('.choice').children('div[choiceid='+is_sheep_rebate+']').addClass('choice-select');
});
</script><?php endif; ?>
</body>
</html>