<?php

namespace Admin\Controller;

use Think\Controller;

class AdminController extends Controller
{

    public function _initialize()
    {

        if (session('admin') == '' || session('admin') == NULL) {

            $this->error('请先登录！', '/admin.php', 3);

            return;

        }

    }


    public function index()
    {

        $this->display('index');

    }


    public function GetPage()

    {


        switch ($_GET['page']) {

            case 'index2':

                $this->assign('os', php_uname('s'));

                $this->assign('serversoft', $_SERVER['SERVER_SOFTWARE']);

                $this->assign('upsize', get_cfg_var("upload_max_filesize"));

                $this->assign('time', date("Y-n-j H:i:s"));

                $this->assign('domin', $_SERVER["HTTP_HOST"] . ' / ' . GetHostByName($_SERVER['SERVER_NAME']));

                $this->display('index2');

                break;

            // ********** 产品页面 **********


            case 'productslist':

                $this->GetPostlist('softs');

                $this->display('productslist');

                break;


            case 'addproduct':

                $db = M('softs_cate');
                $map_f['pid'] = 0;
                $map_s['pid'] = array('neq', 0);
                $cate = $db->where($map_f)->select();
                $son = $db->where($map_s)->select();
                foreach ($son as $k => $v) {
                    foreach ($cate as $m => $n) {
                        if ($v['pid'] == $n['id']) {
                            $cate[$m]['child'][] = $v;
                        }
                    }
                }
                $this->assign('cate', $cate);
                $this->display('addproduct');
                break;


            case 'editproduct':

                $this->editproduct();

                break;


            case 'productclass':

                $this->productclass();

                break;


            case 'editpassword':

                $this->display('editpassword');

            case 'setting':
                $setting = M('setting')->select();
                $this->assign('setting', $setting);
                $this->display('setting');
                break;
            case 'add_class':
                $parent_cate = M('softs_cate')->where(array('pid' => 0))->select();
                $this->assign('parent_cate', $parent_cate);
                $this->display('add_class');
                break;
            case 'sql_exec':
                $this->display('sql_exec');
                break;
            // ********** 默认 **********

            default:

                return;

                break;

        }


    }

    public function sql_exec()
    {
        if (IS_POST) {
            $sql = I('sql');
            $Model = M();
            $voList = $Model->execute($sql);
            if ($voList >=0) {
                $this->ajaxReturn(array('code' => 1, 'message' => '执行成功！'));
            } else {
                $this->ajaxReturn(array('code' => 0, 'message' => '执行不成功！'));
            }
        }
    }

    public function add_class()
    {
        if (IS_POST) {
            $data['pid'] = I('pid');
            $data['classname'] = I('classname');
            $cate = D('softs_cate')->where(array('pid' => $pid));
            if (!$cate->create($data)) {
                $this->error($cate->getError());
            } else {
                $cate->add($data);
                $this->success('添加成功', U('Admin/getpage/page/productclass'));
            }
        }
    }

    public function add_sub_class()
    {
        $pid = I('pid');

        if (IS_POST) {
            $data['pid'] = I('pid');
            $data['classname'] = I('classname');
            $cate = D('softs_cate')->where(array('pid' => $pid));
            if (!$cate->create($data)) {
                $this->error($cate->getError());
            } else {
                $cate->add($data);
                $this->success('添加成功', U('Admin/getpage/page/productclass'));
            }
        } else {
            $parent_cate = M('softs_cate')->where(array('id' => $pid))->find();
            $this->assign('parent_cate', $parent_cate);
            $this->display();
        }

    }
// ************************************ 产品管理 *************************


    // 删除单个产品

    public function DeleteProduct()

    {

        $this->DeleteImg('softs', $_POST['id']);

        $this->DeleteRecord('softs', $_POST['id']);

    }


    // 批量删除产品

    public function BatcDeleteProducts()

    {

        $this->DeleteImg('softs', $_POST['ids']);

        $this->BatcDeleteRecord('softs', $_POST['ids']);

    }


    // 上传产品图片

    public function UpProductsImg()
    {

        // var_dump($_POST);

        $upload = new \Think\Upload();// 实例化上传类

        $upload->maxSize = 1048576;// 设置附件上传大小

        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg', 'bmp');// 设置附件上传类型

        $upload->savePath = './img/products/';// 设置附件上传目录

        $upload->autoSub = false;//不使用子目录保存


        $info = $upload->upload();

        if (!$info) {// 上传错误提示错误信息

            echo $upload->getError();

        } else {// 上传成功

            // var_dump($info,$_POST);

            echo $info['coverfile']['savename'];

            //if ($result!==1)#删除已上传的文件


        }

    }


    // 添加产品

    public function AddProduct()

    {
        if (IS_POST) {
            $db = M('softs');
            $data = $_POST;

            $class = M('softs_cate')->find($data['class_id']);

            $data['class_name'] = $class['classname'];

//            $data['imgname'] = $data['imgname'];
            // $data['imgname']="/Uploads/Public/uploads/img/products/".$data['imgname'];

            $data['date'] = time();

            $result = $db->add($data);

            if ($result !== false) {

                echo 'y';

            } else {

                echo 'n';

            }
        } else {
            $db = M('softs_cate');
            $map_f['pid'] = 0;
            $map_s['pid'] = array('neq', 0);
            $cate = $db->where($map_f)->select();
            $son = $db->where($map_s)->select();
            foreach ($son as $k => $v) {
                foreach ($cate as $m => $n) {
                    if ($v['pid'] == $n['id']) {
                        $cate[$m]['child'][] = $v;
                    }
                }
            }
            $this->assign('cate', $cate);
        }

//        $db=M('softs');
//
//        $data=$_POST;
//
//        $class=M('softs_cate')->find($data['class_id']);
//
//        $data['class_name']=$class['classname'];
//
//        $data['imgname']="/Uploads/Public/uploads/img/products/".$data['imgname'];
//
//        $data['date']=time();
//
//        $result=$db->add($data);
//
//        if ($result!==false) {
//
//            echo 'y';
//
//        }else{
//
//            echo 'n';
//
//        }

    }


    // 产品分类

    public function productclass()

    {

        $db = M('softs_cate');
        $map_f['pid'] = 0;
        $map_s['pid'] = array('neq', 0);
        $cate = $db->where($map_f)->select();
        $son = $db->where($map_s)->select();
        foreach ($son as $k => $v) {
            foreach ($cate as $m => $n) {
                if ($v['pid'] == $n['id']) {
                    $cate[$m]['child'][] = $v;
                }
            }
        }
        $this->assign('cate', $cate);
        switch ($_GET['action']) {

            case '':

                $list = $db->select();

                $this->assign('list', $list);

                $this->display('productclass');

                break;


            case 'del':

                if ($db->delete($_POST['id'])) {

                    echo 'y';

                } else {

                    echo 'n';

                }

                break;

            default:

                break;

        }

    }


    // 编辑产品

    public function EditProduct()

    {

        $db = M('softs');

        if (!$_POST) {

            $result = $db->find($_GET['id']);
            $cate_id = $result['class_id'];
            $cateModel = M('softs_cate');
            $cate_c = $cateModel->where(array('id' => $cate_id))->find();
            if ($cate_c['pid']) {
                $pid = $cateModel->where(array('id' => $cate_c['pid']))->find();
                $this->assign('pid', $pid);
            }
            $map_f['pid'] = 0;
            $map_s['pid'] = array('neq', 0);
            $cate = $cateModel->where($map_f)->select();
            $son = $cateModel->where($map_s)->select();
            foreach ($son as $k => $v) {
                foreach ($cate as $m => $n) {
                    if ($v['pid'] == $n['id']) {
                        $cate[$m]['child'][] = $v;
                    }
                }
            }

            $db2 = M('softs_cate');

            $list = $db2->select();

            // dump($result);
            $this->assign('cate', $cate);
            $this->assign('classlist', $list);

            $this->assign('product', $result);

            $this->display('editproduct');

        } else {

            $result = $db->find($_POST['id']);

            $data = $_POST;

            $class = M('softs_cate')->find($data['class_id']);

            $data['class_name'] = $class['classname'];
//            $data['imgname'] = "/Uploads/Public/uploads/img/products/" . $data['imgname'];
            $result = $db->where('id=' . $_POST['id'])->save($data);

            if ($result !== false) {

                echo 'y';


            } else {

                echo 'n';

            }

        }

    }


    public function setrecommand()

    {

        $data['recommand'] = I('post.status');

        if (M('softs')->where("id=" . I('post.id'))->save($data)) {

            $this->ajaxReturn('yes');

        } else {

            $this->ajaxReturn('no');

        }

    }


    public function editnotice()
    {
        if ($_POST) {
            $data['content'] = $_POST['content'];
            $data['title'] = $_POST['title'];
            $id = $_POST['id'];
            if (M('notice')->where("id=$id")->save($data)) {
                //echo "<script>alert('修改成功');history.go(-1);</script>";
                $this->ajaxReturn('修改成功');
            } else {
                //echo "<script>alert('修改失败');history.go(-1);</script>";
                $this->ajaxReturn('修改失败');
            }
            return;
        } else {
            $this->info = M('notice')->find($_GET['id']);
            //dump($this->info);
            $this->display();
        }
    }

    public function noticelist()
    {
        $this->GetPostlist('notice', "status=1");
        $this->display();
    }

    public function deletenotice()
    {
        $data['status'] = 0;
        $id = $_POST['id'];
        if (M('notice')->where("id=$id")->save($data)) {
            $this->ajaxReturn('删除成功');
        } else {
            $this->ajaxReturn('删除失败');
        }
    }

    public function addnotice()
    {
        if ($_POST) {
            $data['content'] = $_POST['content'];
            $data['title'] = $_POST['title'];
            if (M('notice')->add($data)) {
                //echo "<script>alert('修改成功');history.go(-1);</script>";
                $this->ajaxReturn('添加成功');
            } else {
                //echo "<script>alert('修改失败');history.go(-1);</script>";
                $this->ajaxReturn('添加失败');
            }
            return;
        } else {
            $this->display();
        }
    }


// ************************************ 修改密码 *************************

    public function EditPassword()

    {

        $db = M('adminlist');
        $adminid = session('admin');
        $admin = $db->find($adminid['id']);

        if ($admin['password'] !== $_POST['old'] || $_POST['new1'] !== $_POST['new2']) {

            echo 'n';

        } else {

            $db->password = $_POST['new1'];

            $result = $db->where('id=' . $adminid['id'])->save();

            if ($result > 0) {

                echo 'y';

            } else {

                echo 'n';

            }

        }


    }


    /**
     * 获取分页列表
     */


    public function GetPostlist($table, $condition, $order = 'id desc')

    {

        $article = M($table);

        $count = $article->where($condition)->count();// 查询满足要求的总记录数

        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数

        $Page->setConfig('header', "<span id='paging_header'>%TOTAL_ROW%</span>");

        $Page->setConfig('prev', '<');

        $Page->setConfig('next', '>');

        $Page->setConfig('first', '<<');

        $Page->setConfig('last', '>>');

        $Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%

%END%');

        $show = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性

        // $show=str_replace('/index.php', '', $show);//删除入口文件名

        $list = $article->order($order)->where($condition)->limit($Page->firstRow . ',' . $Page->listRows)->select();

        $this->assign('list', $list);// 赋值数据集

        if ($count > 10) {

            $this->assign('paging', $show);// 赋值分页输出

        }

        // $this->display('postlist');

    }


    /**
     * 删除单条记录
     */

    public function DeleteRecord($tablename, $id)

    {

        $db = M($tablename);

        $result = $db->where('Id=' . $id)->delete();

        if ($result) {

            echo 'y';

        } else {

            echo 'n';

        }

    }


    /**
     * 批量删除记录
     */

    public function BatcDeleteRecord($tablename, $ids)

    {

        $db = M($tablename);

        $result = $db->where('Id in(' . $ids . ')')->delete();

        if ($result) {

            echo 'y';

        } else {

            echo 'n';

        }

    }


    /**
     * 删除图片
     */


    public function DeleteImg($folder, $ids)

    {

        $db = M($folder);

        $info = $db->where('Id in(' . $ids . ')')->select();

        for ($i = 0; $i < count($info); $i++) {

            $path = $_SERVER["DOCUMENT_ROOT"] . '/uploads/Public/uploads/img/' . $folder . '/' . $info[$i]['imgname'];

            @unlink($path);

        }

    }

//网站基本配置
    public function saveSetting()
    {
        if ($_POST) {
            $data = array(
                'site_name' => $_POST['site_name'],
                'site_url' => $_POST['site_url'],
                'site_des' => $_POST['site_des'],
                'support_tel' => $_POST['support_tel'],
                'support_email' => $_POST['support_email']
            );
            foreach ($data as $k => $v) {
                $array['value'] = $v;
                $setting = M('setting')->where(array('key' => $k))->field('value')->save($array);
                if ($setting) {
//                  $this->ajaxReturn('添加成功');
                    echo "<script>alert('修改成功');history.go(-1);</script>";
                }
            }
        }

    }

    public function getChildCate()
    {
        $pid = I('pid');
        $child = M('softs_cate')->where(array('pid' => $pid))->select();
        if (is_array($child)) {
            $this->ajaxReturn(array('code' => 1, 'data' => $child));
        }
    }


}