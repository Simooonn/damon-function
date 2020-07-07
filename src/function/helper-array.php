<?php

/**
 * Created by PhpStorm.
 * User: wumengmeng <wu_mengmeng@foxmail.com>
 * Date: 2020/6/30 0030
 * Time: 18:00
 */
//TODO ok

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

/**
 * 树形数组转换成一维伪树形数组
 *
 * @param $data
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_tree_to_one_tree($data)
{
    $arr_data = [];
    if (!empty($data)) {
        foreach ($data as $value) {
            $arr_child = $value['_child'];
            if (!empty($arr_child)) {
                $value['_child'] = 1;
                $arr_data[]      = $value;
                $a               = tree_to_one_tree($arr_child);
                $arr_data        = array_merge($arr_data, $a);
            }
            else {
                $value['_child'] = 0;
                $arr_data[]      = $value;
            }
        }
    }
    return $arr_data;
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
function yoo_array_remain($arr_data = [], $arr_remain_key = [])
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
function yoo_array_except($arr_data = [], $arr_except_key = [])
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
function yoo_array_del_null($arr_data = [])
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
function yoo_array_trim($arr_data = [])
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


/************************************** 下划线转驼峰 **************************************/

/**
 * 字符串命名风格转换 【下划线转驼峰】
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 *
 * @param string $string     字符串
 * @param bool   $ucfirst    首字母是否大写（驼峰规则）
 * @param string $delimiters 分割字符      _ - ~ 等
 *
 * @return string
 */
function yoo_string_underline_to_hump($string,$ucfirst = true,$delimiters = '_')
{
    if(is_string($string)){
        //字符串里单词首字母大写 然后将分割字符去除
        $string
          = str_replace($delimiters,'',ucwords($string,$delimiters));

        //字符串首字母是否大写
        if(!$ucfirst){
            $string = lcfirst($string);
        }
    }
    return $string;
}

/**
 * 数组元素字符串命名风格转换 【下划线转驼峰】
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 *
 * @param array  $array      数组
 * @param bool   $ucfirst    首字母是否大写（驼峰规则）
 * @param string $delimiters 分割字符      _ - ~ 等
 *
 * @return array
 */
function yoo_array_underline_to_hump($array,$ucfirst = true,$delimiters = '_')
{
    if(is_array($array)){
        foreach($array as $k => $v){
            $array[$k]
              = yoo_string_underline_to_hump($v,$ucfirst,$delimiters);
        }
    }

    return $array;
}

/************************************** 数组操作 **************************************/

/**
 * 列表数组转换成键值对的一维关联数组
 *
 * @param array  $arr_list
 * @param string $s_value
 * @param string $s_key
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_array_kvs($arr_list = [], $s_value = 'name', $s_key = 'id')
{
    $arr_data = [];
    foreach ($arr_list as $value) {
        $arr_data[$value[$s_key]] = $value[$s_value];
    }
    return $arr_data;
}

/**
 * id集合数组转为标识分隔的字符串
 *
 * @param array  $arrIds
 * @param string $s_expend
 * @param string $s_mark
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_str_ids($arrIds = [], $s_mark = ',', $s_expend = '')
{
    $res = '';
    if (is_array($arrIds) && count($arrIds) > 0) {
        foreach ($arrIds as $value) {
            $s_full_field = $s_expend . $value;

            if ($res === '') {
                $res = $s_full_field;
            }
            else {
                $res .= $s_mark . $s_full_field;
            }
        }
    }
    return $res;
}

/**
 * id标识分隔的字符串转为id集合数组
 *
 * @param string $s_Ids
 * @param string $s_expend
 * @param string $s_mark
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_array_ids($s_Ids = '', $s_mark = ',', $s_expend = '')
{
    $res = [];
    if (!empty($s_Ids)) {
        $s_Ids = str_replace($s_expend, '', $s_Ids);
        $res   = explode($s_mark, $s_Ids);
    }
    return $res;
}



/**
 * 一维数组每个value值加上特定的字符
 *
 * @param array  $arr        一维数组
 * @param string $s_expend   特定字符
 * @param string $s_location pre前 end后
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_array_vpad($arr = [], $s_expend = '', $s_location = 'pre')
{
    if ($s_location === 'pre') {
        foreach ($arr as $key => $value) {
            $arr[$key] = $s_expend . $value;
        }
    }
    else {
        foreach ($arr as $key => $value) {
            $arr[$key] = $value . $s_expend;
        }
    }
    return $arr;
}


/**
 * 一维数组每个value值公共的字符替换成其他的字符
 *
 * @param array  $arr       一维数组
 * @param string $s_expend  公共字符
 * @param string $s_replace 替换字符
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_array_vreplace($arr = [], $s_expend = '', $s_replace = '')
{
    foreach ($arr as $key => $value) {
        $arr[$key] = str_replace($s_expend, $s_replace, $value);
    }
    return $arr;
}

function combineArray($arr1, $arr2)
{
    $result = array();
    foreach ($arr1 as $item1) {
        foreach ($arr2 as $item2) {
            $temp = $item1;
            $temp[] = $item2;
            $result[] = $temp;
        }
    }
    return $result;
}

/**
 * 处理数组变成笛卡尔积
 *
 * @param array $data 多个一维数组组成的二维数组
 *
 * @return array|mixed
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_array_dikaer($data)
{
    $result = array_shift($data);
    while ($arr2 = array_shift($data)) {
        $arr1 = $result;
        $result = [];
        foreach ($arr1 as $v) {
            foreach ($arr2 as $v2) {
                if (!is_array($v)) {
                    $v = [$v];
                }
                if (!is_array($v2)) {
                    $v2 = [$v2];
                }
                $result[] = array_merge_recursive($v, $v2);
            }
        }
    }
    return $result;
}

/**
 * 处理数组变成笛卡尔积
 *
 * @param mixed ...$arr_data 不限制参数数量 参数为一维数组
 *
 * @return array|mixed
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_array_cartesian(...$arr_data)
{
    $data = func_get_args();
    $result = array_shift($data);
    while ($arr2 = array_shift($data)) {
        $arr1 = $result;
        $result = [];
        foreach ($arr1 as $v) {
            foreach ($arr2 as $v2) {
                if (!is_array($v)) {
                    $v = [$v];
                }
                if (!is_array($v2)) {
                    $v2 = [$v2];
                }
                $result[] = array_merge_recursive($v, $v2);
            }
        }
    }
    return $result;
}

