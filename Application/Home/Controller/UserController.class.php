<?php
namespace Home\Controller;
use Common\Controller\HomeBaseController;
use Common\Model\UserModel ;
class UserController extends HomeBaseController {

    //普通登陆
    public function login(){
        $User = D("User");
        //自动验证
        if (IS_POST){
            //获取前台传过来的值
            $data=I('post.');
            if (!$User->create($data)){
                $this->error($User->getError());
            }
            $userInfo = $User->where(array('username'=>$data['username']))->find();
            if ($userInfo){
                if ($userInfo['password']==$data['password']){
                    $user_data['last_login_time']=time();
                    $user_data['last_login_ip']=get_client_ip(0,true);
                    $User->where(array('username'=>$data['username']))->save($user_data);
                    session('user',$userInfo);
                    $this->success('登录成功',U('Home/Index/index'));
                }else{
                    $this->error('密码错误');
                }
            }else{
                $this->error('用户名不存在');
            }
        }
//        $res = $User->where(array('username'=>'11'))->find();
//        if (!empty($res)){
//            echo $res['username'];
//        }else{
//            echo '查无此人';
//        }
//        var_dump($res['username']) ;
//        $user=array('nickname'=>'zxm','head_img'=>'ddd','id'=>'1');
//        session('user',$user);
//        echo  session('user');
////        $type=I('get.type');
////        $sdk=\ThinkOauth::getInstance($type);
////        redirect($sdk->getRequestCodeURL());
//        $this->success('登录成功',U('Home/Index/index'));
    }
    //注册
    public function register(){
        $User = D("User");
        $data=I('post.');
        if (!$User->create($data)){
            $this->error($User->getError());
        }
        $data['create_time']=time();
        $User->create($data);
        $User->add();
        $this->success('恭喜您注册成功');


    }
    // 第三方平台登录
    public function oauth_login(){
        $type=I('get.type');
        import("Org.ThinkSDK.ThinkOauth");
        $sdk=\ThinkOauth::getInstance($type);
        redirect($sdk->getRequestCodeURL());
    }

    // 第三方平台退出
    public function logout(){
        session('user',null);
        session('admin',null);
    }

    // 判断是否登录
    public function check_login(){
        if(isset($_SESSION['user']['id'])){
            echo 1;
        }else{
            echo 0;
        }
    }


}
