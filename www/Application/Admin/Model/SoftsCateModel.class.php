<?php
/**
 * Created by PhpStorm.
 * User: yujian
 * Date: 2017/4/13
 * Time: 9:06
 */
namespace Admin\Model;

use Think\Model;

class SoftsCateModel extends Model
{
    protected $_validate = array(
        array('classname', 'require', '名称重复或为空，请核对！',1,'unique'),
    );
}