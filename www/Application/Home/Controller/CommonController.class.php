<?php
/**
 * Created by PhpStorm.
 * User: yujian
 * Date: 2017/2/20
 * Time: 8:59
 */
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller{
    public function initialize(){
        $cateModel = M('softs_cate');
        $cate_c = $cateModel->where(array('id' => $cate_id))->find();
        if($cate_c['pid']){
            $pid = $cateModel->where(array('id' => $cate_c['pid']))->find();
            $this->assign('pid',$pid);
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
        $site_config = M('setting')->select();
        $this->assign('cate',$cate);
        $this->assign('site_config',$site_config);
    }
}