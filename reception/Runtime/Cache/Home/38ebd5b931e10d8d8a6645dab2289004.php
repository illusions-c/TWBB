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
        <div class="propose-text" style="display:none;">
            <div class="propose-pub operation-total">
                <div class="propose-operation clearfix">
                    <div class="modify" rid='0'>修改</div>
                    <div class="update-status">更新状态</div>
                    <div class="delete">删除</div>
                </div>
                <div class="propose-result-button" >
                    <a href="javascript:;" title="取消" class="result-reset">取消</a>
                </div>
            </div>
            <div class="propose-pub operation-update" style="display:none;">
                <div class="operation-lower-title">更新状态</div>
                <div class="operation-lower-text">
                    <div class="operation-lower-option clearfix">
                        <div class="option-title">平台已返现</div>
                        <div class="option-text">
                            <div class="option-select" state='1'>是</div>
                            <div  state='0'>否</div>
                        </div>
                    </div>
                </div>
                <div class="propose-result-button" >
                    <a href="javascript:;" title="提交" class="operation-lower-submit">提交</a>
                    <a href="javascript:;" title="上一级" class="operation-lower-button">上一级</a>
                </div>
                <form action="/TWBB/wool/handle" method="post" class="update-form">
                    <input type="hidden" name="wool_type" value="update"/>
                    <input type="hidden" name="rid" value=""/>
                    <input type="hidden" name="state" value="0" />
                </form>
            </div>
            <div class="propose-pub operation-delete" style="display:none;">
                <div class="operation-lower-title">删除记录</div>
                <div class="operation-lower-text">
                    是否删除本记录？
                </div>
                <div class="propose-result-button" >
                    <a href="javascript:;" title="提交" class="operation-lower-submit">是</a>
                    <a href="javascript:;" title="上一级" class="operation-lower-button">上一级</a>
                </div>
                <form action="/TWBB/wool/handle" method="post" class="delete-form">
                    <input type="hidden" name="wool_type" value="delete"/>
                    <input type="hidden" name="rid" value=""/>
                    <input type="hidden" name="delete" value="1" />
                </form>
            </div>
        </div>
        <div class="propose-back"></div>
    </div>
    <div class="center wool-lists margin-30 clearfix">
        <nav class="nav">
    <a href="" title="<?php echo (session('username')); ?>" class="user">
        <img src="/TWBB/<?php echo (session('avatar')); ?>" title="<?php echo (session('username')); ?>" alt="<?php echo (session('username')); ?>" />
    </a>
    <ul>
        <li><a href="/TWBB/wool/index" title="羊毛记录" ><img src="/TWBB/Public/img/nav-wool.png" title="羊毛记录" alt="羊毛记录" /></a></li>
        <li><a href="/TWBB/user/index" title="设置"><img src="/TWBB/Public/img/nav-setting.png" title="设置" alt="设置" /></a></li>
    </ul>
</nav>
        <article class="wool-lists-text twbb-cont clearfix ">
            <h1>羊毛列表</h1>
            <div class="wool-lists-table">
                <?php if(empty($wool_lists)): ?><div class="lists-empty">
                        还没有羊毛记录呢，快去<a href="/TWBB/wool/add" title="羊毛记录点">羊毛记录点</a>记录羊毛吧
                    </div>
                <?php else: ?>
                    <table>
                        <tr>
                            <th>账号</th>
                            <th>平台名</th>
                            <th>投资金额</th>
                            <th class="expire">投资日期<br />到期时间</th>
                            <th>期限</th>
                            <th>平台返款</th>
                            <th>羊头返利</th>
                            <th>平台已回款</th>
                            <th>羊头已返款</th>
                            <th>操作</th>
                        </tr>
                        <?php if(is_array($wool_lists)): foreach($wool_lists as $k=>$v): ?><tr rid='<?php echo ($v["rid"]); ?>'>
                                <td><?php echo ($v["account"]); ?></td>
                                <td><?php echo ($v["platform"]); ?></td>
                                <td><?php echo ($v["investment"]); ?></td>
                                <td class="expire"><?php echo ($v["investment_date"]); ?><br /><?php echo ($v["due_time"]); ?></td>
                                <td><?php echo ($v["term"]); ?> 天</td>
                                <td><?php echo ($v["platform_back"]); ?> 元</td>
                                <td><?php echo ($v["sheep_rebate"]); ?> 元</td>
                                <td><?php echo ($v["is_platform_back"]); ?> </td>
                                <td><?php echo ($v["is_sheep_rebate"]); ?> </td>
                                <td class="operation">操作</td>
                            </tr><?php endforeach; endif; ?>
                    </table>
                    <div class="page"><?php echo ($page); ?></div><?php endif; ?>
                
            </div>
            
        </article>
    </div>
</div>
<script src="/TWBB/Public/js/jquery.js"></script>
<script>
// 根据body的高度判断是否用height:auto
$(function(){
    var hh = $('html').height();
    if (hh <= 880) {
        $('html').css('height','auto');
    }
});
</script>
<script>
$(function(){
    $('.operation').on('click',function(){
        $('.propose').show().find('.propose-text').show();
        var rid = $(this).parent('tr').attr('rid');
        $('.update-form input[name=rid] , .delete-form input[name=rid]').val(rid);
        $('.propose-operation .modify').attr('rid',rid);
    });
    $('.propose-result-button .result-reset').on('click',function(){
        $('.propose').hide().find('.propose-text').hide();
    });
    $('.propose-operation .modify').on('click',function(){
        window.location.href = '/TWBB/wool/list_modify/rid/'+$(this).attr('rid');
    });
    $('.update-status').on('click',function(){
        $('.operation-total').hide();
        $('.operation-update').show();
    });
    $('.operation-lower-button').on('click',function(){
        $('.operation-total').show().siblings().hide();
    });
    $('.option-text div').on('click',function(){
        $(this).addClass('option-select').siblings('div').removeClass('option-select');
        var state = $(this).attr('state');

        $('.update-form input[name=state]').val(state);
    });
    $('.operation-update .propose-result-button .operation-lower-submit').on('click',function(){
        $('.update-form').submit();
    });
    $('.propose-operation .delete').on('click',function(){
        $('.operation-total').hide();
        $('.operation-delete').show();
    });
    $('.operation-delete .operation-lower-submit').on('click',function(){
        $('.delete-form').submit();
    });
})
</script>
</body>
</html>