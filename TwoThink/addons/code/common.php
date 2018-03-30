<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络  82550565@qq.com <www.twothink.cn> 
// +----------------------------------------------------------------------
/*
 * @title 获取表列表
 */
function table_list(){
    $list  = db()->query('SHOW TABLE STATUS');
    $list  = array_map('array_change_key_case', $list);
    return array_map('table_prefix', $list);
}
function table_prefix(array $input, $case = null){
    $prefix = config('database.prefix');
    $input['name'] = str_replace($prefix,"",$input['name']);
    return $input;
}

/*
 * @title 获取表字段信息
 */