<?php
namespace Home\Model;
use Think\Model;
class WoolRecordModel extends Model{
    protected $_validate = array(    // 必须是$_validate
        // 羊毛输入的验证。
        array('account-number','require','账号不能为空！'), 
        array('platform-name','require','平台名不能为空！'),
        array('investment','require','投资金额不能为空！'),
        array('investment','number','投资金额只能为数字！'),
        array('investment_date','require','投资日期不能为空！'),
        array('rebate-platform','require','平台返利不能为空！'),
        array('rebate-platform','number','平台返利只能为数字！'),
        array('sheep-rebate','require','羊头返利不能为空！'),
        array('sheep-rebate','number','羊头返利只能为数字！')
    );
}
?>