<?php
/**
 * Created by PhpStorm.
 * User: yujian
 * Date: 1/14/17
 * Time: 8:53 PM
 */
/**
 * 获取环境变量
 * @param $key
 * @param null $default
 * @return null|string
 */
function env($key, $default = null)
{
    $value = getenv($key);
    if ($value === false) {
        return $default;
    }
    return $value;
}