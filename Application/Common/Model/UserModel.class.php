<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 登录model
 */
class UserModel extends BaseModel{
    // 自动验证
    protected $_validate=array(
        array('username','require','用户名不能为空',1),
        array('password','require','密码不能为空',1),
        array('repassword','require','确认密码不能为空'),
        array('repassword','password','两次密码不一致',0,'confirm')
    );




}
