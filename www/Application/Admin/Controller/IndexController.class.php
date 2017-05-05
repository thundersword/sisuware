<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display('login');
       
    }

    public function Login()
    {
    	$db=M('adminlist');
    	if (trim($_POST['username'])=='' || trim($_POST['password'])=='' ) {
    		$this->error('请填全登录信息');
    		return;
    	}

    	$admin=$db->where('username='."'".trim($_POST['username'])."'")->find();
    	if ($admin==NULL) {
    		$this->error('登录失败');
    		return;
    	}
    	if ($_POST['password'] == $admin['password']) {
            // var_dump($_POST['password'],$admin['password']);
    		session(array('name'=>'admin','expire'=>3600));
            session('admin',$admin);
    		$this->success('登录成功','/admin.php/Admin/index',1);
    		// $this->display('Admin/index');
    	}else{
    		$this->error('登录失败');
    	}
    }


    public function Logout()
    {
    	session('[destroy]');
   		$this->success('退出成功','/admin.php',1);

    	// $this->display('login');
    }

}