<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
    protected $_validate = array(    // 必须是$_validate
        // 羊毛输入的验证。
        array('username','require','用户名不能为空！'), 
        array('username','','帐号名称已经存在！',0,'unique',1),
        array('userpw','require','密码不能为空！'),
        array('email','require','邮箱不能为空！'),
        array('email','email','邮箱格式不对！'),
        array('phone','require','手机号不能为空！'),
        array('phone','number','手机号必须为数字！'),
        array('phone',11,'手机号格式不正确！',0,'length'),      // 这里的length不知道为什么不行
        array('is_sheep','number','请输入正确的数据'),
    );
}
?>