<?php
/**
 * Created by PhpStorm.
 * User: wumengmeng <wu_mengmeng@foxmail.com>
 * Date: 2020/6/30 0030
 * Time: 18:00
 */

/*数据类型*/

/************************************** 数字类型操作 **************************************/

/**
 * 字符串补位
 *
 * @param string $n_number  目标字符串
 * @param int    $n_length  期望长度
 * @param int    $s_pad     填充字符
 * @param string $s_method  填充位置 left左侧 right右侧 both两侧
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_string_pad($n_number = '',$n_length = 0,$s_pad = '0',$s_method = 'left'){
    switch ($s_method)
    {
        case 'left':
            $s_result =     str_pad($n_number,$n_length,$s_pad,STR_PAD_LEFT);
            break;
        case 'right':
            $s_result =     str_pad($n_number,$n_length,$s_pad,STR_PAD_RIGHT);
            break;
        case 'both':
            $s_result =     str_pad($n_number,$n_length,$s_pad,STR_PAD_BOTH);
            break;
        default:
            $s_result =     str_pad($n_number,$n_length,$s_pad,STR_PAD_LEFT);
    }

    return $s_result;
}

/**
 * 数字补位
 *
 * @param string $n_number  数字
 * @param int    $n_length  期望长度
 * @param string $s_method  填充位置 left左侧 right右侧 both两侧
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_number_pad($n_number = '',$n_length = 0,$s_method = 'left'){
    if(is_float($n_number)){
        $n_length = $n_length + 1;
    }
    return yoo_string_pad($n_number,$n_length,0,$s_method);
}

/**
 * 数字格式化
 *
 * @param int  $number      目标数字
 * @param int  $decimals    保留小数位数
 * @param bool $type        格式化类型 true-纯数字格式化（例7897677.00） false-千分位格式化（例7,897,677.00）
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_number_format($number = 0, $decimals = 0, $type = true){
    if($type === true){
        $result = number_format($number,$decimals,'.','');
    }
    else{
        $result = number_format($number,$decimals);
    }
    return $result;
}




/************************************** 字符串处理 **************************************/

/**
 * 过滤字符串
 *
 * @param string $str
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_string_trim($str = '')
{
    if(is_string($str)){
        if(isset($str) && (!is_null($str)) && (trim($str) !== '')) {
            $str = trim($str);
        }
        else{
            $str = '';
        }
    }
    else{
        $str = '';
    }
    return $str;
}

/**
 * 隐藏字符串中的部分字符串
 *
 * @param string $s_string  目标字符串
 * @param string $s_hide    隐藏字符 默认*
 * @param int    $n_start   隐藏开始位置
 * @param int    $n_length  隐藏长度
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_hide_string($s_string = '', $s_hide = '*', $n_start = 0, $n_length = 1)
{
    $n_end_start = $n_start + $n_length;
    $s_hide = yoo_string_pad($s_hide,$n_length,$s_hide);
    $res         = substr($s_string, 0, $n_start) . $s_hide . substr($s_string, $n_end_start);
    return $res;
}

/**
 * 从文章里随机抽取一句话
 *
 * @param string $s_article 文章内容 每句话之间用回车分开
 *
 * @return mixed
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_random_articl_says($s_article = '')
{
    $arr_article = explode("\n", $s_article);
    $rand_string = $arr_article[array_rand($arr_article)];
    return $rand_string;
}


/**
 * 补充链接地址
 *
 * @param string $s_url     文件链接
 * @param string $s_host
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_pad_url($s_url = '', $s_host = '')
{
    if (strpos($s_url, 'https://') !== false) {
        $res = $s_url;
    }
    elseif (strpos($s_url, 'http://') !== false) {
        $res = $s_url;
    }
    elseif (empty($s_url)) {
        $res = '';
    }
    else {
        $res = $s_host . $s_url;
    }
    return $res;
}

/**
 * 从html中提取图片地址(使用正则)
 *
 * @param string $s_html
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_take_img($s_html = '')
{
    $images = [];
    if (preg_match_all('/< *img[^>]*src *= *["\']?([^"\']*)/i', $s_html, $img)) {
        foreach ($img[1] as $key => $val) {
            if ($val) {
                $images[] = $val;
            }
        }
    }
    return $images;
}


/**
 * 随机生成唯一订单号
 *
 * @param string $s_prefix  前缀
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_random_order_sn($s_prefix = '')
{

    /*方法1 一次性生成100条数据 效果很差*/
    //    $str = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);

    /*方法2 一次性生成100条数据 效果不错几乎没有重复 500也还好 1000几乎都会有几条重复数据*/
    $str = date('ymdhis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

    /*方法3 同方法2 效果差别不大*/
    //    $str = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'][intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
    return $s_prefix . $str;
}


/**
 * 生成唯一token
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_unique_token()
{
    $n_id           = yoo_string_pad(mt_rand(1, 9999999999), 11);
    $s_unique_token = rtrim(base64_encode(uniqid() . '_' . $n_id), '==');
    return $s_unique_token;
}

/**
 * 字符串转换成大写 base64 md5
 *
 * @param string $s_uniqid
 * @param string $s_prefix
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_upper_base64_md5($s_uniqid = '', $s_prefix = '')
{
    $result = $s_prefix . strtoupper(rtrim(base64_encode(md5($s_uniqid)), '=='));
    return $result;
}




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
function yoo_tree_list($arr_tree)
{
    $arr_data = [];
    if (!empty($arr_tree)) {
        foreach ($arr_tree as $value) {
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
        if (array_key_exists($value,$arr_data)) {
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
function yoo_array_remove($arr_data = [], $arr_except_key = [])
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
        if(is_null($value)){
            $data[$key] = '';
        }
        else{
            $data[$key] = trim($value);
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