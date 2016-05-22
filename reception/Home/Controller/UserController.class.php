<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
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
        };
        // 获取当前用户的数据，设置默认值，但是由于隐私等问题，邮箱和手机要隐藏一部分，还有是否羊头
        $uid = session('uid');
        $user = M('user');
        $def = $user->where('uid='.$uid.' and locking = 0 ')->find();
        // 从数据库中获取相应的帐号
        $accounts = M('WoolAccounts');
        $count = $accounts->where('uid = '.$uid.' and accounts_delete = 0 ')->count();
        $Page = new \Think\Page($count,8); 
        $show = $Page->show();
        $accountslist = $accounts->where('uid = '.$uid.' and accounts_delete = 0 ')->page(I('get.p',1),8)->select();
        $this->assign('def',$def);
        // 这是经过分页处理的列表
        $this->assign('accountslist',$accountslist);
        // 分页
        $this->assign('accountspage',$show);// 赋值分页输出
        $this->assign('title','用户信息修改');
        $this->display();
    }
    public function handle(){
        if (!session('uid')) {
            $output = array(
                'title' => '请先登录',
                'waiting_time' => 4,
                'judge_code' => false,
                'error_str' => '请先登录，才能做下面的操作',
                'jump_url' => __ROOT__.'/signin',
            );
            $this->assign('output',$output);
            $this->assign('title','请先登录');
            $this->display('Sign_handle');
            exit();
        };
        $tyle = I('post.tyle');         // 根据类型来判断修改那种资料。
        // 获取用户资料，看下是不是一样的，如果一样就不能改了，
        $user = M('User');
        $uid = session('uid');
        $def = $user->where('uid = '.$uid.' and locking = 0')->find();
        $accounts = M('WoolAccounts');
        $accountslist = $accounts->where('uid = '.$uid.' and accounts_delete = 0')->select();
        $aidlist = array();
        $accountsnamelist = array();
        foreach ($accountslist as $k => $v) {
            $aidlist[] = $v['aid'];
            $accountsnamelist[] = $v['accounts_name'];
        };
        $data = array();
        switch ($tyle) {
            case 'materials':           // 修改资料
                $iemail = I('post.email');
                $iphone = I('post.phone');
                $iis_sheep = I('post.m-is-sheep');
                
                if ($def['email'] !== $iemail) {
                    $data['email'] = $iemail;
                };
                if ($def['phone'] !== $iphone) {
                    $data['phone'] = $iphone;
                };
                if ($def['is_sheep'] !== $iis_sheep) {
                    $data['is_sheep'] = $iis_sheep;
                };
                dump($iphone);
                // 如果为空，则不加入
                if(empty($data)){
                    $output = array(
                        'title' => '修改失败',
                        'waiting_time' => 4,
                        'judge_code' => false,
                        'error_str' => '您所输入的必须和之前的不同',
                        'jump_url' => __ROOT__.'/user/index',
                    );
                    $this->assign('output',$output);
                    $this->assign('title','修改失败');
                    $this->display('Sign_handle');
                    exit();
                }else{
                    if ($user->where('uid='.$uid)->data($data)->save()) {
                        $output = array(
                            'title' => '修改成功',
                            'waiting_time' => 2,
                            'judge_code' => true,
                            'jump_url' => __ROOT__.'/user/index',
                        );
                        $this->assign('output',$output);
                        $this->assign('title','修改成功');
                        $this->display('Sign_handle');
                        exit();
                    }
                }
                break;
            case 'picture':             // 头像设置
                
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     3145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath  =     './Public/avatar/'; // 设置附件上传根目录
                $upload->subName   =     array('date','Ymd');   // 有关于这个参数的详细资料还是要靠百度
                // 上传单个文件 ，$info是所有的上传文件的信息。
                $info   =   $upload->uploadOne($_FILES['photos']);
                if(!$info) {// 上传错误提示错误信息
                    $output = array(
                        'title' => '修改失败',
                        'waiting_time' => 4,
                        'judge_code' => false,
                        'error_str' => $upload->getError(),
                        'jump_url' => __ROOT__.'/user/index',
                    );
                    $this->assign('output',$output);
                    $this->assign('title','修改失败');
                    $this->display('Sign_handle');
                    exit();
                }else{// 上传成功 获取上传文件信息
                    // 写入数据库，并且将头像写入session
                    $user = M('User');
                    $data['avatar'] = '/Public/avatar/'.$info['savepath'].$info['savename'];      // 兼容性的问题我还是不要将__ROOT__写入数据库比较好
                    $user->where('uid = '.$uid.' and locking = 0')->data($data)->save();
                    session('avatar','/Public/avatar/'.$info['savepath'].$info['savename']);
                    $output = array(
                        'title' => '修改成功',
                        'waiting_time' => 2,
                        'judge_code' => true,
                        'jump_url' => __ROOT__.'/user/index',
                    );
                    $this->assign('output',$output);
                    $this->assign('title','修改成功');
                    $this->display('Sign_handle');
                    exit();
                }
                break;           
            case 'pw':                  // 密码更改
                $originalpw = I('originalpw','','md5');
                if ($originalpw === $def['userpw']) {
                    // 所输入的原密码和数据库的密码相同
                    // 看一下新密码是否小于6位
                    if (strlen($_POST['newpw']) < 6) {
                        $output = array(
                            'title' => '修改失败',
                            'waiting_time' => 4,
                            'judge_code' => false,
                            'error_str' => '您所输入的新密码不能小于6位',
                            'jump_url' => __ROOT__.'/user/index',
                        );
                        $this->assign('output',$output);
                        $this->assign('title','修改失败');
                        $this->display('Sign_handle');
                        exit();
                    }
                    $newpw = I('post.newpw','','md5');
                    $again_newpw = I('post.again-newpw','','md5');
                    // 新密码和旧密码是否相同
                    if ($def['userpw'] === $newpw) {
                        $output = array(
                            'title' => '修改失败',
                            'waiting_time' => 4,
                            'judge_code' => false,
                            'error_str' => '您所输入的新密码和旧密码一致，请重新输入新密码',
                            'jump_url' => __ROOT__.'/user/index',
                        );
                        $this->assign('output',$output);
                        $this->assign('title','修改失败');
                        $this->display('Sign_handle');
                        exit();
                    };
                    // 重新输入和新密码是否相同
                    if ($newpw !== $again_newpw) {
                        $output = array(
                            'title' => '修改失败',
                            'waiting_time' => 4,
                            'judge_code' => false,
                            'error_str' => '您所输入的新密码和重新输入新密码不一致',
                            'jump_url' => __ROOT__.'/user/index',
                        );
                        $this->assign('output',$output);
                        $this->assign('title','修改失败');
                        $this->display('Sign_handle');
                        exit();
                    }else{
                        // 写入数据库
                        $data['userpw'] = $newpw;
                        $aa = $user->where('uid = '.$uid.' and locking = 0 ')->data($data)->save();
                        // 判断是否修改成功
                        if ($aa) {
                            $output = array(
                                'title' => '修改成功',
                                'waiting_time' => 2,
                                'judge_code' => true,
                                'jump_url' => __ROOT__.'/user/index',
                            );
                            $this->assign('output',$output);
                            $this->assign('title','修改成功');
                            $this->display('Sign_handle');
                            exit();
                        }else{
                            $output = array(
                                'title' => '修改失败',
                                'waiting_time' => 4,
                                'judge_code' => false,
                                'error_str' => '修改失败，请联系管理员！',
                                'jump_url' => __ROOT__.'/user/index',
                            );
                            $this->assign('output',$output);
                            $this->assign('title','修改失败');
                            $this->display('Sign_handle');
                            exit();
                        };
                    };
                };
                break;                
            case 'addaccountsinput':            // 添加帐号操作
                $accountsname = I('post.accountsname');
                if($accountsname == ""){
                    $output = array(
                        'title' => '添加失败',
                        'waiting_time' => 4,
                        'judge_code' => false,
                        'error_str' => '请输入所需要添加的账号',
                        'jump_url' => __ROOT__.'/user/index',
                    );
                    $this->assign('output',$output);
                    $this->assign('title','添加失败');
                    $this->display('Sign_handle');
                    exit();
                };
                if(in_array($accountsname,$accountsnamelist)){
                    $output = array(
                        'title' => '添加失败',
                        'waiting_time' => 4,
                        'judge_code' => false,
                        'error_str' => '请输入账号已存在！',
                        'jump_url' => __ROOT__.'/user/index',
                    );
                    $this->assign('output',$output);
                    $this->assign('title','添加失败');
                    $this->display('Sign_handle');
                    exit();
                };
                // 运行到这，就可以写入数据库了
                $data['adddate'] = time();
                $data['accounts_name'] = $accountsname;
                $data['uid'] = $uid;
                $xx = $accounts->data($data)->add();
                if ($xx) {
                    $output = array(
                        'title' => '添加成功',
                        'waiting_time' => 2,
                        'judge_code' => ture,
                        'error_str' => '账号添加成功',
                        'jump_url' => __ROOT__.'/user/index',
                    );
                    $this->assign('output',$output);
                    $this->assign('title','添加成功');
                    $this->display('Sign_handle');
                    exit();
                }else{
                    $output = array(
                        'title' => '添加失败',
                        'waiting_time' => 4,
                        'judge_code' => false,
                        'error_str' => '账号添加失败，请联系管理员',
                        'jump_url' => __ROOT__.'/user/index',
                    );
                    $this->assign('output',$output);
                    $this->assign('title','添加失败');
                    $this->display('Sign_handle');
                    exit();
                }
                break;
            case 'accountsdelete':            // 删除账号操作
                $aid = I('post.aid');
                if (!in_array($aid,$aidlist)) {
                    $output = array(
                        'title' => '删除失败',
                        'waiting_time' => 4,
                        'judge_code' => false,
                        'error_str' => '账号删除失败，请不要输入非法的参数',
                        'jump_url' => __ROOT__.'/user/index',
                    );
                    $this->assign('output',$output);
                    $this->assign('title','删除失败');
                    $this->display('Sign_handle');
                    exit();
                }else{
                    $xx = $accounts->where('aid = '.$aid.' and uid = '.$uid)->delete();
                    if ($xx) {
                        $output = array(
                            'title' => '删除成功',
                            'waiting_time' => 2,
                            'judge_code' => true,
                            'jump_url' => __ROOT__.'/user/index',
                        );
                        $this->assign('output',$output);
                        $this->assign('title','删除成功');
                        $this->display('Sign_handle');
                        exit();
                    }else{
                        $output = array(
                            'title' => '删除失败',
                            'waiting_time' => 4,
                            'judge_code' => false,
                            'error_str' => '账号删除失败，请不要输入非法的参数',
                            'jump_url' => __ROOT__.'/user/index',
                        );
                        $this->assign('output',$output);
                        $this->assign('title','删除失败');
                        $this->display('Sign_handle');
                        exit();
                    };
                }
                break;
        }
    }
}