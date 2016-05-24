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
        <div class="propose-text">
            <div class="propose-pub propose-result" style="display:none;">
                <h3>2016年3月14日到期列表</h3>
                <!-- 这里会输出各种提示信息 -->
                <table class="propose-result-table">
                    <tr class="table-title">
                        <td>平台名</td>
                        <td>投资日期</td>
                        <td>到期时间</td>
                        <td>投资金额</td>
                        <td>平台回款</td>
                        <td>平台是否回款</td>
                        <td>羊头返现</td>
                        <td>羊头是否返现</td>
                    </tr> 
                    
                </table>
                <div class="propose-result-button">
                    <a href="javascript:;" title="确认" class="result-submit">确认</a>
                    <a href="javascript:;" title="取消" class="result-reset">取消</a>
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
    <div class="center wool-index margin-30 clearfix">
        <nav class="nav">
    <a href="/TWBB/user/index#avatar-box" title="<?php echo (session('username')); ?>" class="user">
        <img src="/TWBB/<?php echo (session('avatar')); ?>" title="<?php echo (session('username')); ?>" alt="<?php echo (session('username')); ?>" />
    </a>
    <ul>
        <li><a href="/TWBB/wool/index" title="羊毛记录" ><img src="/TWBB/Public/img/nav-wool.png" title="羊毛记录" alt="羊毛记录" /></a></li>
        <li><a href="/TWBB/user/index" title="设置"><img src="/TWBB/Public/img/nav-setting.png" title="设置" alt="设置" /></a></li>
    </ul>
</nav>
        <article class="wool-index-text twbb-cont clearfix">
            <div class="wool-index-button clearfix">
                <a href="/TWBB/wool/lists" title="羊毛列表">羊毛列表</a>
                <a href="/TWBB/wool/add" title="添加羊毛">添加羊毛</a>
            </div>
            <div class="total-calendar clearfix">
                <!-- 这里存放数据总和(饼) 和 日历 -->
                <div class="total-data clearfix">
                    <div class="total-data-pie"></div>
                    <?php if(empty($wool_pie)): ?><div id="total-data-text">
                            <ul class="clearfix">
                                <li class="investment">
                                    <div class="total-data-title">投资金额</div>
                                    <div class="total-data-percentage">0%</div>
                                    <div class="total-data-value">0元</div>
                                </li>
                                <li class="platform">
                                    <div class="total-data-title">平台返现</div>
                                    <div class="total-data-percentage">0%</div>
                                    <div class="total-data-value">0元</div>
                                </li>
                                <li class="sheep">
                                    <div class="total-data-title">羊头返现</div>
                                    <div class="total-data-percentage">0%</div>
                                    <div class="total-data-value">0元</div>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div id="total-data-text">
                            <ul class="clearfix">
                                <li class="investment">
                                    <div class="total-data-title">投资金额</div>
                                    <div class="total-data-percentage"><?php echo ($wool_pie["record_investment_per"]); ?>%</div>
                                    <div class="total-data-value"><?php echo ($wool_pie["record_investment"]); ?>元</div>
                                </li>
                                <li class="platform">
                                    <div class="total-data-title">平台返现</div>
                                    <div class="total-data-percentage"><?php echo ($wool_pie["platform_back_per"]); ?>%</div>
                                    <div class="total-data-value"><?php echo ($wool_pie["platform_back"]); ?>元</div>
                                </li>
                                <li class="sheep">
                                    <div class="total-data-title">羊头返现</div>
                                    <div class="total-data-percentage"><?php echo ($wool_pie["sheep_rebate_per"]); ?>%</div>
                                    <div class="total-data-value"><?php echo ($wool_pie["sheep_rebate"]); ?>元</div>
                                </li>
                            </ul>
                        </div><?php endif; ?>
                    

                </div>
                <div class="calendar">
                    <div class="calendar-title">还款日历</div>
                    <div id="calendar-text" /></div>
                </div>
            </div>
            <div class="wool-data-table clearfix">
                <div id="wool-last12" ></div>
                <table id="datatable" style="display:none;">
                    <thead>
                        <tr>
                            <th></th>
                            <th>投资金额</th>
                            <th>投资返利</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($timeorder_list)): $__FOR_START_10533__=1;$__FOR_END_10533__=13;for($ii=$__FOR_START_10533__;$ii < $__FOR_END_10533__;$ii+=1){ ?><tr>
                                    <th><?php echo ($ii); ?>月</th>
                                    <td>0</td>
                                    <td>0</td>
                                </tr><?php } ?>
                        <?php else: ?>
                            <?php if(is_array($timeorder_list)): foreach($timeorder_list as $time=>$v): ?><tr>
                                    <th><?php echo ($time); ?></th>
                                    <td><?php echo ($v["investment"]); ?></td>
                                    <td><?php echo ($v["rebate"]); ?></td>
                                </tr><?php endforeach; endif; endif; ?>
                        

                    </tbody>
                </table>
            </div>
            
        </article>
    </div>
</div>
<script src="/TWBB/Public/js/jquery.js"></script>
<!-- 自适应代码 -->
<script>
// 根据body的高度判断是否用height:auto
$(function(){
    var bh = $('body').height();
    if (bh <= $('.LCXZS').height() && !$('.login').length) {
        $('html').css('height','auto');
    }
});
</script>
<!-- 下面的js文件必须下下来，要不是会加载很慢的 -->
<script type="text/javascript" src="/TWBB/Public/js/highcharts.js"></script>
<script type="text/javascript" src="/TWBB/Public/js/data.js"></script>
<script>
//以后我打算把这些js都整合到js文件中
﻿$(function () {
    var wool_pie = <?php echo ($wool_pie_json); ?>;
    $('.total-data-pie').highcharts({
        chart: {
            type: 'pie',
            height : 215,
        },
        title: {
            text: '羊毛统计图'
        },
        colors:['rgb(244, 91, 91)','#6A5ACD','rgb(43, 144, 143)'],
        plotOptions: {
            pie: {
                innerSize: 70,
                depth: 45,
                dataLabels: {
                    enabled: false,
                },
                showInLegend: false,
            }
        },
        series: [{
            name: '金额',
            data: [
                ['投资金额', wool_pie.record_investment],
                ['平台返现', wool_pie.platform_back],
                ['羊头返现', wool_pie.sheep_rebate],
            ]
        }],
        credits: {
          enabled:false
        },
        dataLabels: {
            enabled: false,
        },
        showInLegend: false,
    });

    $('#wool-last12').highcharts({
        data: {
            table: 'datatable'
        },
         chart: {
            type: 'column',
        },
        title: {
            text: '过去1年统计图'
        },
        credits: {
          enabled:false
        },
        yAxis: {
            allowDecimals: false,
            title: {
                text: ''
            }
        },
        
        plotOptions : {
            column : {
                pointWidth : 10,
            }
        }
    });
    
    // 获取本月的到期时间自定义函数，参数：本月时间，如3月
    var date = new Date();
    var month = date.getMonth()+1;
    var year = date.getFullYear();
    // 应用日历插件
    $('#calendar-text').calendar({
        calendarclick : function(clickymd){
            // 点击日期事件
            clcik_rili(clickymd);
        },
        // 当日期被改动的时候触发
        yearschange : function(y,m){
            due_time_ajax(y,m);
        },
        // 初始化触发事件：
        calendarinitialize : function(y,m){
            due_time_ajax(y,m);
        },
    });

    function due_time_ajax(year,month){
        $.ajax({
            type    :   'post',
            dataType:   'json',
            url     :   '/TWBB/ajax/due_time',
            data    :   'month='+month+'&year='+year+'&t='+Math.random(),
            success :   function(data){
                $(data).each(function(k,v){
                    // 标记
                    $('.calendar-table td[ymd='+v.ymd+']').not('.due-time-select').addClass('due-time-select');
                });
            },
            error   :   function(err){
                console.log('出错了');
            }
        });
    };
    // 当点击日历上的日期将会触发该函数
    function clcik_rili (time){
        var list_str = '';
        var platform_sum = 0;
        $.ajax({
            type    :   'POST',
            dataType:   'json',
            url     :   '/TWBB/ajax/click_rili',
            data    :   'time='+time+'&t='+Math.random(),
            success :   function(data){
                // 下面是有数据的情况下所触发的事件
                if (data.info.length) {
                    $(data.info).each(function(k,v){
                        platform_sum = parseInt(v.platform_back)+parseInt(v.investment);
                        list_str += '<tr><td>'+v.platform+'</td><td>'+v.investment_date+'</td><td>'+v.due_time+'</td><td>'+v.investment+'</td><td>'+platform_sum+'</td><td>';
                        if (v.is_platform_back == "0") {
                            list_str += '否';
                        }else{
                            list_str += '是';
                        }
                        list_str += '</td><td>'+v.sheep_rebate+'</td><td>';
                        if (v.is_sheep_rebate == "0") {
                            list_str += '否';
                        }else{
                            list_str += '是';
                        }
                        list_str += '</td></tr>';
                    });
                }else{
                    list_str += '<tr><td colspan="8" style="font-size:16px;line-height:32px;padding:10px 0;">该天并没有相关的回款！</td></tr>'
                }
                
                $('.propose-result-table tbody').append(list_str);
                $('.propose').propose({
                    'title' : time+' 到期列表',
                    quebutton : false,
                });
            },
        });
    };
});
</script>
<script>
(function ($) {
     $.fn.propose = function(options){
        var def = {
            title   :   '确认信息',
            quebutton : true,
            queval  :   '确认',
            foubutton : true,
            fouval  :   '取消',
        };
        var ops = $.extend(def,options);
        // 插件里面的this代表被调用者，目测是.propose 调用的
        $(this).find('.propose-result').children('h3').text(ops.title);
        if (!ops.quebutton) {
            $('.result-submit').hide();
        }else{
            $('.result-submit').text(ops.queval);
        };
        if (!ops.foubutton) {
            $('.result-reset').hide();
        }else{
            $('.result-reset').text(ops.fouval);
            $('.result-reset').show();
        };
        // 到了这里所有数据都插入成功了，我开始显示出来了。
        $(this).show().children('.propose-back').show();
        $(this).find('.propose-result').show();
        var wh = $(window).height();
        var propose_height = $(this).children('.propose-text').height();
        var wt = ((wh - propose_height) / 2 )-50;
        $(this).children('.propose-text').css('top',wt);
        $(this).find('.result-reset').on('click',function(){
            $(this).hide();
            $(this).parents('.propose').hide();
        });
    }
})(jQuery);
</script>
<!-- 日历插件 -->
<script>
(function ($) {
     $.fn.calendar = function(options){
        var def = {
            // 年月被被改变时触发的事件
            yearschange     :   function(year,month){},
            // 当被点击时触发的事件。
            calendarclick   :   function(clickymd){},
            // 初始化的时候会被触发。
            calendarinitialize : function(year,month){},    
        };
        var _this = $(this);
        var ops = $.extend(def,options);
        // 插件里面的this代表被调用者，目测是#calendar-text 调用的
        var date = new Date();
        var y = date.getFullYear();
        var m = parseInt(date.getMonth())+1;
        var d = date.getDate();
        // 初始化触发事件
        ops.calendarinitialize(y,m);
        var def_table = my_xx(y,m);
        // 插入到指定的元素中
        _this.append(def_table);
        // 当点击last和next按钮后的事件。
        _this.on('click','.last',function(){
            // 计算月和年
            if ((m - 1) <= 0) {
                m = 12;
                y = parseInt(y)-1;
            }else{
                m = m - 1;
            };
            _this.find('.calendar-y-choice').children('span').text(y);
            _this.find('.calendar-m-choice').children('span').text(m);
            ops.yearschange(y,m);
            my_xx(y,m);
        });
        _this.on('click','.next',function(){
            // 计算月和年
            if ((m + 1) >= 13) {
                m = 1;
                y = parseInt(y)+1;
            }else{
                m = m + 1;
            };
            _this.find('.calendar-y-choice').children('span').text(y);
            _this.find('.calendar-m-choice').children('span').text(m);
            ops.yearschange(y,m);
            my_xx(y,m);

        });
        // 当点击calendar-today，返回到本月
        _this.on('click','.calendar-today',function(){
            y = date.getFullYear();
            m = parseInt(date.getMonth()) + 1;
            _this.find('.calendar-y-choice').children('span').text(y);
            _this.find('.calendar-m-choice').children('span').text(m);
            my_xx(y,m);
        });
        // 当点击某个日期时触发的事件
        _this.on('click','tr:not(.calendar-week-title) td',function(){
            var clickymd = $(this).attr('ymd');
            ops.calendarclick(clickymd);
        });
        function maxday (y,m) {
            var xx = new Date(y,m,0);
            return xx.getDate();
        };
        // 月份变更方法：
        function my_xx(year,month){
            // 这个月一共有多少天
            var max = maxday(year,month);
            var table = '';
            var thisdate = new Date();
            var thisy = thisdate.getFullYear();
            var thism = parseInt(thisdate.getMonth())+1;
            var thisd = thisdate.getDate();
            table += '<div class="calendar-ymchoice"><div class="last" title="上一个月"></div><div class="calendar-y-choice"><span>'+year+'</span>年</div><div class="calendar-m-choice"><span>'+month+'</span>月</div><div class="calendar-today"></div><div class="next" title="下一个月"></div></div><table class="calendar-table"><tbody><tr class="calendar-week-title"><td>一</td><td>二</td><td>三</td><td>四</td><td>五</td><td>六</td><td>日</td></tr>';
            for (var i = 1; i <= 35; i++) {
                if ((i == 1) || (i%7 == 1)) {
                    table += '<tr><td ymd="'+year+'-'+month+'-'+i+'">'+i+'</td>';
                }else if(i%7 == 0 && i != 35){
                    table += '<td ymd="'+year+'-'+month+'-'+i+'">'+i+'</td></tr>';
                }else if(i <= max ){
                    table += '<td ymd="'+year+'-'+month+'-'+i+'">'+i+'</td>';
                }else{
                    table += '<td></td>';
                }
            };
            table += '</tbody></table>';
            _this.empty().append(table);
            // 突出今天
            _this.find('td[ymd='+thisy+'-'+thism+'-'+thisd+']').addClass('today');
        };
    }
})(jQuery);
</script>
</body>
</html>