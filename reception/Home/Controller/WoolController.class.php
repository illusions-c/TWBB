<?php
namespace Home\Controller;
use Think\Controller;
class WoolController extends Controller {
    public function add(){
        if (!session('uid')) {
            $output = array(
                'title' => '请先登录',
                'waiting_time' => 4,
                'judge_code' => false,
                'error_str' => '请先登录，才能做下面的操作',
                'jump_url' => __ROOT__.'/signin',
            );
            $this->assign('output',$output);
            $this->display('Sign_handle');
            exit();
        }
        // 根据当前的用户获取他的帐号信息
        $userid = session('uid');
        $accounts = M('wool_accounts');
        $accounts_list = $accounts->where('accounts_delete = 0 and uid='.$userid)->order('aid desc')->field('accounts_name')->select();
        $this->assign('accounts_list',$accounts_list);
        $this->assign('title','羊毛登记点');
        $this->assign('wool_type','add');
        $this->display();
    }
    public function handle(){
        // 将这个处理分成添加的，修改状态的，修改其他信息的，删除的，都是通过一个叫wool_type来区分
        $wool_type = I('post.wool_type');
        if($wool_type == 'add'){
            // 添加羊毛数据
            // 接受所有的数据并进行判断是否为空，我想用自动验证方法。WoolRecordModel.class.php
            $record = D("WoolRecord");
            if (!$record->create()){
                // 如果创建失败 表示验证没有通过 输出错误提示信息
                $output_str = "写入错误";
                $waiting_time = 4;
                $judge_code = false;
                $error_str = $record->getError();
                // 设置跳转url
                $jump_url = __ROOT__."/wool/add";
            }
            // 过滤数据，并写入数据。
            $account_number = I('post.account-number');
            $platform_name = I('post.platform-name');
            $investment = I('post.investment','','number_int');
            $investment_date = I('post.investment_date');
            $investment_date = strtotime($investment_date);
            $investment_period = I('post.investment-period','','number_int');
            $rebate_platform = I('post.rebate-platform','','number_int');
            $sheep_rebate = I('post.sheep-rebate','','number_int');
            $sheep_rebate_choice = I('post.sheep-rebate-choice','','number_int');
            $uid = session('uid');
            // 到期时间
            $due_time = strtotime('+'.$investment_period.' day',$investment_date);
            // 写入数据
            $data = array('uid' => $uid, 'account' => $account_number , 'platform' => $platform_name , 'investment' => $investment , 'investment_date' => $investment_date , 'due_time' => $due_time , 'term' => $investment_period , 'platform_back' => $rebate_platform , 'sheep_rebate' => $sheep_rebate , 'is_sheep_rebate' => $sheep_rebate_choice , 'recording_time' => time());
            if ($record->data($data)->add()) {
                $output_str = "添加成功";
                $waiting_time = 2;
                $judge_code = true ;
                $jump_url = __ROOT__.'/wool/index';
                $this->assign('title','添加成功');
            }else{
                $output_str = "添加失败";
                $waiting_time = 4;
                $judge_code = false ;
                $jump_url = __ROOT__.'/wool/add';
                $error_str = '输入的信息错误，请确认后再添加';
                $this->assign('title','添加错误');
            };
        }elseif($wool_type == 'update'){
            // 过滤相关的数据
            $rid = I('post.rid');
            $uid = session('uid');
            $state = I('post.state');
            // 实例化类
            $record = M('WoolRecord');
            $data = array();
            $data['is_platform_back'] = $state;
            $xx = $record->where('uid = '.$uid.' and rid = '.$rid)->data($data)->save();
            if ($xx) {
                $output_str = "修改成功";
                $waiting_time = 2;
                $judge_code = true ;
                $jump_url = __ROOT__.'/wool/lists';
                $this->assign('title','修改成功');
            }else{
                // 插入失败
                $output_str = "修改失败";
                $waiting_time = 4;
                $judge_code = false ;
                $jump_url = __ROOT__.'/wool/lists';
                $error_str = '修改失败，请联系管理员！';
                $this->assign('title','修改失败');
            };
        }elseif($wool_type == 'delete'){
            $rid = I('post.rid');
            $uid = session('uid');
            // 实例化类
            $record = M('WoolRecord');
            $xx = $record->where('uid = '.$uid.' and rid = '.$rid)->delete();
            if ($xx) {
                $output_str = "删除成功";
                $waiting_time = 2;
                $judge_code = true ;
                $jump_url = __ROOT__.'/wool/lists';
                $this->assign('title','删除成功');
            }else{
                // 插入失败
                $output_str = "删除失败";
                $waiting_time = 4;
                $judge_code = false ;
                $jump_url = __ROOT__.'/wool/lists';
                $error_str = '删除失败，请联系管理员！';
                $this->assign('title','删除失败');
            };
        }elseif($wool_type == 'modify'){
            // 收集数据
            $data = array();
            $data['account'] = I('post.account-number');    // 帐号
            $data['platform'] = I('post.platform-name');   // 平台名
            $data['investment'] = I('post.investment');   // 投资金额
            $data['investment_date'] = strtotime(I('post.investment_date'));   // 投资时间
            $data['due_time'] = strtotime('+'.I('post.investment-period').' day',$data['investment_date']);   // 投资到期时间
            $data['term'] = I('post.investment-period');   // 投资期限
            $data['platform_back'] = I('post.rebate-platform');   // 平台返利
            $data['sheep_rebate'] = I('post.sheep-rebate');   // 羊头返利
            $data['is_sheep_rebate'] = I('post.sheep-rebate-choice');   // 羊头返利
            $uid = session('uid');
            $rid = I('post.rid');
            $record = M('WoolRecord');
            $x = $record->data($data)->where('uid = '.$uid.' and rid = '.$rid)->save();
            if ($x) {
                // 成功插入
                $output_str = "修改成功";
                $waiting_time = 2;
                $judge_code = true ;
                $jump_url = __ROOT__.'/wool/lists';
                $this->assign('title','修改成功');
            }else{
                // 插入失败
                $output_str = "修改失败";
                $waiting_time = 4;
                $judge_code = false ;
                $jump_url = __ROOT__.'/wool/list_modify/rid/'.$rid;
                $error_str = '输入的信息错误，请确认后再修改';
                $this->assign('title','修改失败');
            };
        };
        // 输出
        $output = array(
            'title' => $output_str,
            'waiting_time' => $waiting_time,
            'judge_code' => $judge_code,
            'error_str' => $error_str,
            'jump_url' => $jump_url,
        );
        $this->assign('output',$output);
        $this->display('Sign_handle');
    }
    public function index(){
        if (!session('uid')) {
            $output = array(
                'title' => '请先登录',
                'waiting_time' => 4,
                'judge_code' => false,
                'error_str' => '请先登录，才能做下面的操作',
                'jump_url' => __ROOT__.'/signin',
            );
            $this->assign('output',$output);
            $this->display('Sign_handle');
            exit();
        }
        // 暂时不用ajax，因为当数据多了之后，可能会影响页面的速度
        $uid = session('uid');
        $record = D("WoolRecord");
        $record_list = $record->where('uid='.$uid)->select();
        // 对获取到的数据进行处理，如百分比什么的
        $record_investment = 0 ;    // 投资金额
        $platform_back = 0 ;        // 平台返现
        $sheep_rebate = 0 ;         // 羊头返现
        // 获取所有的数据。
        foreach ($record_list as $k => $v) {        
            $record_investment += $v['investment'];
            $platform_back += $v['platform_back'];
            $sheep_rebate += $v['sheep_rebate'];
        }
        $record_sum = $record_investment + $platform_back + $sheep_rebate;
        $record_investment_per = round(($record_investment / $record_sum) * 100 , 2);
        $platform_back_per = round(($platform_back / $record_sum) * 100 , 2);
        $sheep_rebate_per = 100 - $record_investment_per - $platform_back_per;
        $wool_pie = array('record_investment' => $record_investment , 'record_investment_per' => $record_investment_per , 'platform_back' => $platform_back , 'platform_back_per' => $platform_back_per , 'sheep_rebate' => $sheep_rebate , 'sheep_rebate_per' => $sheep_rebate_per);
        $wool_pie_json = json_encode($wool_pie);
        // 根据时间排序，以后要考虑服务器的性能和耗时问题。
        $where_time = date('Y-m-1' ,strtotime("-11 month"));
        $where_time = strtotime($where_time);
        $timeorder_ww = $record->where('uid='.$uid.' and investment_date >= '.$where_time)->order('investment_date asc')->select();
        $timeorder_list = array();
        $ii = array();
        foreach ($timeorder_ww as $k => $v) {
            $investment_date = $v['investment_date'];
            for ($last = $where_time , $next = strtotime('+1 month', $last); $last <= time() ; $next = strtotime('+1 month', $next),$last = strtotime('+1 month', $last)) {
                if ($last <= $investment_date and $investment_date < $next) {
                    $ii[$last]['num'] += 1;
                    $ii[$last]['investment'] += (int)$v['investment'];
                    $ii[$last]['platform_back'] += (int)$v['platform_back'];
                    $ii[$last]['sheep_rebate'] += (int)$v['sheep_rebate'];
                }else{
                    $ii[$last]['num'] += 0;
                    $ii[$last]['investment'] += 0;
                    $ii[$last]['platform_back'] += 0;
                    $ii[$last]['sheep_rebate'] += 0;
                }
            }
        }
        // 对数组内的数据再进行处理。减少处理的次数
        foreach ($ii as $k => $v) {
            $cc = date('m月',$k);
            $timeorder_list[$cc]['investment'] = $v['investment'];
            $timeorder_list[$cc]['rebate'] = $v['sheep_rebate'] + $v['platform_back'];
            $timeorder_list[$cc]['num'] = $v['num'];
        }
        $this->assign('timeorder_list',$timeorder_list);
        $this->assign('wool_pie',$wool_pie);
        $this->assign('wool_pie_json',$wool_pie_json);
        $this->assign('title','羊毛首页');
        // 加载视图
        $this->display();
    }
    public function lists(){
        if (!session('uid')) {
            $output = array(
                'title' => '请先登录',
                'waiting_time' => 4,
                'judge_code' => false,
                'error_str' => '请先登录，才能做下面的操作',
                'jump_url' => __ROOT__.'/signin',
            );
            $this->assign('output',$output);
            $this->display('Sign_handle');
            exit();
        }
        $uid = session('uid');
        // 按照是否回款排序，和羊头是否回款排序，最后按时间排序
        $record = D("WoolRecord");
        // 获取页码
        $page = I('get.p','1');
        // 根据get进入的page
        $lists = $record->where('uid = '.$uid.' and record_delete = 0')->order('is_platform_back asc , is_sheep_rebate asc , due_time desc')->page($page.',10')->select();
        foreach ($lists as $k => $v) {
            $lists[$k]['investment_date'] = date('Y-m-d',$v['investment_date']);
            $lists[$k]['due_time'] = date('Y-m-d',$v['due_time']);
            $lists[$k]['is_platform_back'] = $v['is_platform_back'] ? '是' : '否';
            $lists[$k]['is_sheep_rebate'] = $v['is_sheep_rebate'] ? '是' : '否';
        }
        $count = $record->where('uid = '.$uid.' and record_delete = 0')->count();
        $page = new \Think\Page($count,10);
        // 页面
        $show = $page->show();
        $this->assign('wool_lists',$lists);
        $this->assign('page',$show);
        $this->assign('title','羊毛列表');
        $this->display();
    }
    // 还差一个修改信息的页面
    public function list_modify(){
        $rid = I('get.rid','');
        if ($rid == "") {
            $output = array(
                'title' => '操作错误',
                'waiting_time' => 4,
                'judge_code' => false,
                'error_str' => '错误的操作，请输入正确的参数',
                'jump_url' => __ROOT__.'/wool/lists',
            );
            $this->assign('output',$output);
            $this->display('Sign_handle');
            exit();
        };
        $uid = session('uid');
        $record = M('WoolRecord');
        $xx = $record->where('uid='.$uid.' and rid = '.$rid)->find();
        if ($xx) {
            $accounts = M('WoolAccounts');
            $ii = $accounts->where('uid='.$uid.' and accounts_delete=0 and accounts_name != '.$xx['account'])->select();
            foreach ($ii as $k => $v) {
                $aa[] = $v['accounts_name'];
            };
            array_unshift($aa,$xx['account']);
            // 帐号
            $accounts_list = $aa;
            $xx['investment_date'] = date('Y-m-d',$xx['investment_date']);
            $modification_list = $xx;
            $this->assign('accounts_list',$accounts_list);
            $this->assign('modification_list',$modification_list);
            $this->assign('title','羊毛修改点');
            $this->assign('wool_type','modify');
            $this->display('add');
            exit;
        }else{
            // 试图想修改get的参数来看别人的数据。
            $output = array(
                'title' => '操作错误',
                'waiting_time' => 4,
                'judge_code' => false,
                'error_str' => '错误的操作，请输入正确的参数',
                'jump_url' => __ROOT__.'/wool/lists',
            );
            $this->assign('output',$output);
            $this->display('Sign_handle');
            exit();
        };
        
    }
}