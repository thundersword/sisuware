<?php

namespace Home\Controller;

class IndexController extends CommonController  {

    public function _initialize()
    {
        parent::initialize();
        $username = session('username');
        d
        $this->assign('username',$username);
    }



    public function index(){

        $cate_id = I('cate_id');
        $where['recommand'] = 1;
        if($cate_id){
            $where['class_id'] = $cate_id;
        }
        //显示首页默认显示应用

        $this->softs = M('softs')->where($where)->order('date desc')->select();
        //最近更新软件

        $this->latest_softs = M('softs')->order('date desc')->limit(5)->select();

        $this->display();

    }





    /**
     * 详情页
     */
    public function detail(){
        $id = I('id');
        $this->soft_detail = M('softs')->find($id);
        $cateModel = M('softs_cate');
        $detail = $this->soft_detail;
        $cate = $cateModel->where(array('id' => $detail['class_id']))->find();
        $p_cate = $cateModel->where(array('id' => $cate['pid']))->find();
        $this->os = $p_cate['classname'];
        $this->display();
    }



    /**
     * 获取分页列表
     */
    public function GetPostlist($table,$condition,$pagenum=10,$order='id desc')

    {

        $article=M($table);

        $count = $article->where($condition)->count();// 查询满足要求的总记录数

        $Page = new \Think\Page($count,$pagenum);// 实例化分页类 传入总记录数和每页显示的记录数

        $Page->setConfig('header',"<span id='paging_header'>%TOTAL_ROW%</span>");

        $Page->setConfig('prev','<');

        $Page->setConfig('next','>');

        $Page->setConfig('first','<<');

        $Page->setConfig('last','>>');

        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%

%END%');

        $show = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性

        $list = $article->order($order)->where($condition)->limit($Page->firstRow.','.$Page->listRows)->select();
        // dump($list);

        $this->assign('list',$list);// 赋值数据集

        if ($count>$pagenum) {

            $this->assign('paging',$show);// 赋值分页输出

        }

    }

    public function search()
    {
        $this->softs_cate = M('softs_cate')->select();
        $name=I('search');

		if(I('os')){
			$map['os']=array('eq',I('os'));
		}
        $map['name'] = array('like','%'.$name.'%');
        $search=$this->GetPostlist('softs',$map,5);
        $this->assign('search',$search);
		$this->win=U('Index/search',array('search'=>$name,'os'=>'windows'));
		$this->mac=U('Index/search',array('search'=>$name,'os'=>'mac'));
        $this->display();

    }

    /*
    *单点登录系统CAS
    */
    public function loginCAS(){
		
		if(session('referer')==NULL){
			session('referer',$_SERVER['HTTP_REFERER']);
		}

		
//		if(session('username')){
//			redirect(session('referer'));
//			return;
//		}


        Vendor("phpCAS.CAS");
        //echo \phpCAS::getVersion();
        // Enable debugging
        \phpCAS::setDebug();
        // Enable verbose error messages. Disable in production!
        \phpCAS::setVerbose(true);
        \phpCAS::client(CAS_VERSION_3_0,'sso.shisu.edu.cn',443,'/sso');
        \phpCAS::setNoCasServerValidation();
        // \phpCAS::setServerLoginUrl("https://sso.shisu.edu.cn/sso/login");  

        // \phpCAS::handleLogoutRequests();

        // force CAS authentication
        \phpCAS::forceAuthentication();

		
        // \phpCAS::forceAuthentication();
        if(\phpCAS::checkAuthentication()){
			session('username',\phpCAS::getUser());
            $this->redirect(session('referer'));
        }


    }
	
	public function logout(){
		Vendor("phpCAS.CAS");
        //echo \phpCAS::getVersion();
        // Enable debugging
        //\phpCAS::setDebug();
        // Enable verbose error messages. Disable in production!
        //\phpCAS::setVerbose(true);
        \phpCAS::client(CAS_VERSION_3_0,'sso.shisu.edu.cn',443,'/sso');
        \phpCAS::setNoCasServerValidation();
        // \phpCAS::setServerLoginUrl("https://sso.shisu.edu.cn/sso/login");  

        // \phpCAS::handleLogoutRequests();

        // force CAS authentication
        //\phpCAS::forceAuthentication();
		
		\phpCAS::setNoCasServerValidation();
		$param=array("service"=>"https://sso.shisu.edu.cn/sso/login");  
        \phpCAS::logout($param); 
		
		session('username',NULL);
		//redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	public function download(){
		$soft_id=I('id');
		session('download_id',$soft_id);
		//echo $soft_id;
		if(!session('username')){
			$this->loginCAS();
			return;
		}
		$soft=M('softs')->find(session('download_id'));
		echo "<script>open('".$soft['download']."')</script>";
		return;
	}








}