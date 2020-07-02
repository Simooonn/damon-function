<?php

/**
 * Created by PhpStorm.
 * User: wumengmeng <wu_mengmeng@foxmail.com>
 * Date: 2020/6/30 0030
 * Time: 18:00
 */


/************************************** 树形数组 **************************************/

/**
 * 一维数组生成树状数组
 *
 * @param array  $arr_list  一维数组
 * @param string $pk        数据主键键名
 * @param string $s_pid_key 数据父级ID键名
 * @param string $child     子级数组
 * @param int    $n_pid     父级ID
 * @param int    $n_level   数据层级
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_make_tree($arr_list = [],$pk = 'id',$s_pid_key = 'pid',$child = '_child',$n_pid = 0,$n_level = 0)
{
    //    $tree     = [];
    //    $packData = [];
    //    foreach($arr_list as $data){
    //        $packData[$data[$pk]] = $data;
    //    }
    //    foreach($packData as $key => $val){
    //        if($val[$s_pid_key] == $n_pid){
    //            //代表跟节点, 重点一
    //            $tree[] = &$packData[$key];
    //        }
    //        else{
    //            //找到其父类,重点二
    //            $packData[$val[$s_pid_key]][$child][] = &$packData[$key];
    //        }
    //    }
    //    return $tree;

    $tree = [];

    foreach($arr_list as $key => $val){
        if($val[$s_pid_key] == $n_pid){
            //获取当前$s_pid_key所有子类

            unset($arr_list[$key]);
            $val['level'] = $n_level;

            if(!empty($arr_list)){
                $child = yoo_make_tree($arr_list,$pk,$s_pid_key,$child,$val[$pk],$n_level + 1);

                if(!empty($child)){
                    $val['_child'] = $child;
                }
            }
            $tree[] = $val;
        }
    }

    return $tree;
}

/**
 * 递归获取所有子级的数据id
 *
 * @param array  $arr_tree      树状数组
 * @param int    $n_pid         父级ID
 * @param string $pk            数据主键键名
 * @param string $s_pid_key     数据父级ID键名
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_tree_child_ids($arr_tree = [],$n_pid = 0,$pk = 'id',$s_pid_key = 'pid')
{
    /*    if(is_array($arr_tree)){
            $arr_tree = collect($arr_tree);
        }
        $tree = [];
        if(is_array($n_pid)){
            $ids = $arr_tree->whereIn('pid',$n_pid)->pluck('id')->all();
            $tree = array_merge($tree,$n_pid);
        }
        else{
            $ids  = $arr_tree->where('pid',$n_pid)->pluck('id')->all();
            $tree[] = $n_pid;
        }
    //    $tree = array_merge($tree,$ids);
        if(!empty($ids)){
            $a = get_childrens_ids($arr_tree,$ids);
            if(!empty($a)) {
                $tree =  array_merge($tree,$a);
            }
        }

        return $tree;*/

    $tree[] = $n_pid;
    foreach($arr_tree as $key => $val){
        if($val[$s_pid_key] == $n_pid){
            //获取当前$s_pid_key所有子类
            unset($arr_tree[$key]);
            $child = yoo_tree_child_ids($arr_tree,$val[$pk],$pk,$s_pid_key);
            if(!empty($child)){
                $tree = array_merge($tree,$child);
            }
        }
    }

    return $tree;
}

/**
 * 树形前缀ico
 *
 * @param int  $n_level
 * @param bool $end
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_tree_ico($n_level = 0,$end = false)
{
    $a= ' │';
    $b = ' ├';
    $c = ' └';
    $s_left = '';
    $s_all = '';

    if($n_level > 0)
    {
        for($i = 1 ;$i< $n_level;$i++)
        {
            $s_left .=$a;
        }

        if($end)
        {
            $s_all = $s_left.$c;
        }
        else
        {
            $s_all = $s_left.$b;

        }
    }
    return $s_all;

}


/************************************** 数组过滤 **************************************/

/**
 * 保留数组内指定key值的几个元素
 *
 * @param array $arr_data       目标数组
 * @param array $arr_remain_key 保留元素的key
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_arr_remain($arr_data = [], $arr_remain_key = [])
{
    $data = [];
    foreach ($arr_remain_key as $value) {
        if (isset($arr[$value])) {
            $data[$value] = $arr_data[$value];
        }
    }
    return $data;
}

/**
 * 去除数组内指定key值的几个元素
 *
 * @param array $arr_data       目标数组
 * @param array $arr_except_key 去除元素的key
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_arr_except($arr_data = [], $arr_except_key = [])
{
    foreach ($arr_except_key as $value) {
        unset($arr_data[$value]);
    }
    return $arr_data;
}

/**
 * 删除数组中值为null的字段
 *
 * @param array $arr_data
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_arr_del_null($arr_data = [])
{
    foreach ($arr_data as $key=>$value)
    {
        if(is_null($value))
        {
            unset($arr_data[$key]);
        }
    }
    return $arr_data;
}

/**
 * 过滤数组value值里的空格
 *
 * @param array $arr_data
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_arr_trim($arr_data = [])
{
    $data = [];
    foreach ($arr_data as $key=>$value)
    {
        if(isset($arr_data[$key]) && (!is_null($value)) && (trim($value) !== ''))
        {
            if(is_string($value)){
                $data[$key] = trim($value);
            }
        }
    }
    return $data;
}

