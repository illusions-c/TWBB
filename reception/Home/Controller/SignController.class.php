<?php
namespace Home\Controller;
use Think\Controller;
class SignController extends Controller {
    public function in(){
        // 如果已经登录了，将会直接跳转到wool/index
        if (SESSION('uid')) {
            $output = array(
                'title' => '您已经登录',
                'waiting_time' => 4,
                'judge_code' => false,
                'error_str' => '您已经登录，请不要重复操作！',
                'jump_url' => __ROOT__.'/wool/index'
            );
            $this->assign('output',$output);
            $this->display('handle');
            return;
        }
        if (IS_POST) {
            // 进行判断是否为空
            if (($_POST['username'] == "") || ($_POST['userpw'] == "")) {
                $judge_code = false;
                $output_str = "登录失败";
                $waiting_time = 4 ;
                $error_str = "用户名或密码不能为空！";
            }else{
                $username = I('post.username');
                $userpw = I('post.userpw',"","md5");
                // 为了以后的扩展性，决定了加入email登录
                if (I('username',0,'validate_email')) {
                    $_where = 'email = "'.$username.'"';
                }else{
                    $_where = 'username = "'.$username.'"';
                }
                // 锁定
                $_where .= ' and locking = 0';
                // 设置登录次数，暂时没想到
                // $login_number = 5 ;
                // 获取数据库的数据，从而判断是否正确，并且加上一系列的参数
                $user = M('user');
                $db_user = $user->where($_where)->field('uid,username,userpw,username,thistimes,thisip,avatar')->limit(1)->find();
                if ($db_user['userpw'] === $userpw) {
                    // 登录成功，先实现跳转页面，到最后再实现ajax，并且还有设置session，暂时先设置uid，username，上次登录时间，上次登录IP，本次登录时间（用于计算本次在线时间）
                    // 输出
                    $output_str = "成功登录";
                    // 等待时间
                    $waiting_time = 2;
                    // 当前时间作为登录时间,时间戳，或者当前ip写入thisip
                    $data['thisip'] = get_client_ip();
                    $data['thistimes'] = time();
                    // 将之前的登录time和ip替换成上次登录时间和ip
                    $data['lasttimes'] = $db_user['thistimes'];
                    $data['lastip'] = $db_user['thisip'];
                    $user->where('uid = '.$db_user['uid'])->data($data)->save();
                    // 写入session，有效期为1小时，由于session的局限所以，只设置uid和uname
                    // 写入session
                    session('uid',$db_user['uid']);
                    session('username',$db_user['username']);
                    session('avatar',$db_user['avatar']);
                    // 用于判断登录是否成功
                    $judge_code = true;
                    // 跳转地址
                    $jump_url = __ROOT__.'/wool/index';
                    $this->assign('title','登录成功');
                }else{
                    // 登录失败
                    $output_str = '登录失败';
                    $waiting_time = 4;
                    $error_str = "该账号不存在或密码错误，请查实后再是登录！";
                    // $login_number--;
                    $judge_code = false;
                    // 跳转地址
                    $jump_url = __ROOT__.'/signin';
                    $this->assign('title','登录失败');
                }
            }
            // 现在开始做页面
            $output = array(
                'title' => $output_str,
                'waiting_time' => $waiting_time,
                'judge_code' => $judge_code,
                // 'login_number' => $login_number,
                'error_str' => $error_str,
                'jump_url' => $jump_url
            );
            $this->assign('output',$output);
            $this->display('handle');
        }else{
            // 载入视图,并设置标题
            $this->assign('title','登录');
            $this->display();
        }
    }
    public function register(){
        $uid = session('uid');
        if (IS_POST) {
            // 接受所有的数据并进行判断是否为空，我想用自动验证方法。UserModel.class.php
            $user = D("User");
            if (!$user->create()){
                $output = array(
                    'title' => '注册失败',
                    'waiting_time' => '4',
                    'judge_code' => false,
                    'error_str' => $user->getError(),
                    'jump_url' => __ROOT__."/sign/register"
                );
                $this->assign('title','注册失败');
            }else{
                // 过滤
                $username = I('post.username');
                $userpw = I('post.userpw','','md5');
                $email = I('post.email','','validate_email');
                $phone = I('post.userphone','','number_int');
                $is_sheep = I('post.is_sheep','','number_int');
                // 这里头像考虑到以后的可迁移性，所以只写到public目录，之前的请自己补充
                $data = array('username'=>$username , 'userpw'=>$userpw , 'registertimes'=>time() , 'email'=>$email , 'thistimes'=>time() , 'thisip'=>get_client_ip() , 'phone'=>$phone , 'locking'=>0 , 'is_sheep'=> $is_sheep , 'avatar' => 'public/img/login-touxiang.png');
                if ($user->data($data)->add()) {
                    $output_str = "注册成功";
                    $waiting_time = 2;
                    $judge_code = true ;
                    $jump_url = __ROOT__.'/sign/in';
                    $this->assign('title','注册成功');
                }else{
                    $output_str = "注册失败";
                    $waiting_time = 4;
                    $judge_code = false ;
                    $jump_url = __ROOT__.'/sign/register';
                    $error_str = '输入的信息错误，请确认后再添加';
                    $this->assign('title','注册错误');
                };
                $output = array(
                    'title' => $output_str,
                    'waiting_time' => $waiting_time,
                    'judge_code' => $judge_code,
                    'error_str' => $error_str,
                    'jump_url' => $jump_url
                );
            };
            $this->assign('output',$output);
            $this->display('handle');
        }elseif ($uid) {
            // 判断是否已经登录过了，如果已经登陆过了，就直接转到羊毛首页中
            $output = array(
                'title' => '注册失败',
                'waiting_time' => '4',
                'judge_code' => false,
                'error_str' => '您在登录状态，请退出后，在注册！',
                'jump_url' => __ROOT__.'/wool/index'
            );
            $this->assign('output',$output);
            $this->assign('title','注册失败');
            $this->display('handle');
        }else{
            // 标题和视图
            $this->assign('title','TWBB注册');
            $this->display();
        }
    }
    public function out(){
        // 将所有的session清空
        session('uid',null);
        session('username',null);
        session('avatar',null);
        session('[destroy]'); // 销毁session
        $output = array(
            'title' => '退出成功！',
            'waiting_time' => 2,
            'judge_code' => true,
            'error_str' => '退出成功',
            'jump_url' => __ROOT__.'/sign/in'
        );
        $this->assign('output',$output);
        $this->display('handle');
    }
}