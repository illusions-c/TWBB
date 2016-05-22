<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	// 判断一下是否登录了
    	if(SESSION('uid')){
    		// 载入视图
        	$this->display();
    	}else{
    		$this->display('sign_in');
    	};
        
    }
}