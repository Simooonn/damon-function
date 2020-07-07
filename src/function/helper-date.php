<?php
/**
 * Created by PhpStorm.
 * User: wumengmeng <wu_mengmeng@foxmail.com>
 * Date: 2020/6/30 0030
 * Time: 18:00
 */
//TODO ok
//"1970-01-01 08:00:00";

/**
 * 秒数转成天 小时 分钟
 *
 * @param int $seconds
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_seconds_to_daytime($seconds = 0 )
{
    if($seconds <= 0){
        return '';
    }
    $day = floor($seconds / (3600*24));
    $hour = floor(($seconds % (3600*24)) / 3600);
    $minute = floor((($seconds % (3600*24)) % 3600) / 60);
    $second = floor(((($seconds % (3600*24)) % 3600) % 60));

    $s_day = $day == 0 ?'':$day.'天';
    $s_hour = $hour == 0 ?'':$hour.'小时';
    $s_minute = $minute == 0 ?'':$minute.'分';
    $s_second = $second == 0 ?'':$second.'秒';
    $s_result = $s_day.$s_hour.$s_minute.$s_second;

    return $s_result;
}

/**
 * 友好的时间显示
 *
 * @param int    $n_timestamp 输入时间戳
 * @param string $type   类型. normal | mohu | full | ymd | other
 *
 * @return string
 */
function yoo_friendly_date($n_timestamp = 0, $type = '')
{
    if (!$n_timestamp) {
        return '';
    }
    //sTime=源时间，cTime=当前时间，dTime=时间差

    $c_time = time();
    $d_time = $c_time - $n_timestamp;
    //如果时间在同一年内计算可以  如果跨年了 时间计算就有问题
    //$d_day       =    intval(date("z",$c_time)) - intval(date("z",$n_timestamp));
    $d_day  = intval($d_time / 3600 / 24);
    $d_year = intval(date("Y", $c_time)) - intval(date("Y", $n_timestamp));
    //normal：n秒前，n分钟前，n小时前，日期

    $s_result = '';
    if ($type == 'normal') {
        if ($d_time < 60) {
            if ($d_time < 10) {
                $s_result = '刚刚';    //by yangjs
            }
            else {
                $s_result = intval(floor($d_time / 10) * 10) . "秒前";
            }
        }
        elseif ($d_time < 3600) {
            $s_result = intval($d_time / 60) . "分钟前";
            //今天的数据.年份相同.日期相同.
        }
        elseif ($d_year == 0 && $d_day == 0) {
            //return intval($d_time/3600)."小时前";
            $s_result = '今天' . date('H:i', $n_timestamp);
        }
        elseif ($d_year == 0) {
            $s_result = date("m月d日 H:i", $n_timestamp);
        }
        else {
            $s_result = date("Y-m-d H:i", $n_timestamp);
        }
    }
    elseif ($type == 'mohu') {

        if ($d_time < 60) {
            if ($d_time < 10) {
                $s_result = '刚刚';    //by yangjs
            }
            else {
                $s_result = intval(floor($d_time / 10) * 10) . "秒前";
            }
        }
        elseif ($d_time < 3600) {
            $s_result = intval($d_time / 60) . "分钟前";
        }
        elseif ($d_time >= 3600 && $d_day == 0) {
            $s_result = intval($d_time / 3600) . "小时前";
        }
        elseif ($d_day > 0 && $d_day <= 7) {
            $s_result = intval($d_day) . "天前";
        }
        elseif ($d_day > 7 && $d_day <= 30) {
            $s_result = intval($d_day / 7) . '周前';
        }
        elseif ($d_day > 30) {
            $s_result = intval($d_day / 30) . '个月前';
        }
    }
    elseif ($type == 'full') {
        $s_result = date("Y-m-d , H:i:s", $n_timestamp);
    }
    elseif ($type == 'ymd') {
        $s_result = date("Y-m-d", $n_timestamp);
    }
    else {
        if ($d_time < 60) {
            $s_result = $d_time . " 秒前";
        }
        elseif ($d_time < 3600) {
            $s_result = intval($d_time / 60) . " 分钟前";
        }
        elseif ($d_time >= 3600 && $d_day == 0) {
            $s_result = intval($d_time / 3600) . " 小时前";
        }
        elseif ($d_year == 0) {
            $s_result = date("Y-m-d H:i:s", $n_timestamp);
        }
        else {
            $s_result = date("Y-m-d H:i:s", $n_timestamp);
        }
    }

    return $s_result;

}

/**
 * 时间戳 转换成 年月日时分秒
 *
 * @param int $n_timestamp
 *
 * @return false|string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_ymdhis($n_timestamp = 0)
{
    if (empty($n_timestamp)) {
        $n_timestamp = time();
    }
    return date('Y-m-d H:i:s', $n_timestamp);

}

/**
 * 字符时间日期转为日期格式
 *  例如：201909191751626 转为 2019-09-19 17:51:62
 *
 * @param string $s_date
 *
 * @return false|string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_timestring_to_ymdhis($s_date = '')
{
    if (strlen($s_date) < 14) {
        $time_ymdhis = date('Y-m-d H:i:s', 0);
    }
    else {
        $y           = substr($s_date, 0, 4);
        $m           = substr($s_date, 4, 2);
        $d           = substr($s_date, 6, 2);
        $h           = substr($s_date, 8, 2);
        $i           = substr($s_date, 10, 2);
        $s           = substr($s_date, 12, 2);
        $time_ymdhis = $y . '-' . $m . '-' . $d . ' ' . $h . ':' . $i . ':' . $s;
    }
    return $time_ymdhis;

}

/*月份天数*/
function yoo_month_days($n_timestamp = 0){
    $n_timestamp = intval($n_timestamp);
    return date('t',$n_timestamp);
}

/*月份第一天*/
function yoo_month_start_day($n_timestamp = 0){
    $n_timestamp = intval($n_timestamp);
    return date('Y-m-01', $n_timestamp);
}

/*月份最后一天*/
function yoo_month_end_day($n_timestamp = 0){
    $n_timestamp = intval($n_timestamp);
    $day = yoo_number_pad(yoo_month_days($n_timestamp),2);
    return date('Y-m-', $n_timestamp).$day;
}

/*月份第一天 精确到秒*/
function yoo_month_start($n_timestamp = 0){
    return yoo_month_start_day( $n_timestamp).' 00:00:01';
}

/*月份最后一天 精确到秒*/
function yoo_month_end($n_timestamp = 0){
    return yoo_month_end_day($n_timestamp).' 23:59:59';
}

/**
 * 获取指定日期段内指定格式日期的集合
 *
 * @param int    $timestamp_start   开始时间戳
 * @param int    $timestamp_end     结束时间戳
 * @param string $format_type       格式类型 Y-年为单位 Ym-月为单位 Ymd-天为单位
 *
 * 例：Y [2019,2020] Ym [2020-01,2020-02,2020-03,2020-04]
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_range_format_date($timestamp_start = 0,$timestamp_end = 0,$format_type = 'Ymd')
{
    $timestamp_start = intval($timestamp_start);
    $timestamp_end = intval($timestamp_end);
    if ($timestamp_end < $timestamp_start) {
        return [];
    }

    switch ($format_type) {
        //精确到日
        case 'Ymd':
            $date_type   = '1 day';//时间间距
            $date_format = 'Y-m-d';//日期格式
            break;

        //精确到月
        case 'Ym':
            $date_type   = '1 month';//时间间距
            $date_format = 'Y-m';//日期格式
            break;

        //精确到年
        case 'Y':
            $date_type   = '1 year';//时间间距
            $date_format = 'Y';//日期格式
            break;

        //默认精确到日
        default:
            $date_type   = '1 day';//时间间距
            $date_format = 'Y-m-d';//日期格式
    }


    $date_start = date($date_format, $timestamp_start);
    $date_end   = date($date_format, strtotime(date('Y-m-d H:i:s',$timestamp_end) . '+' . $date_type));
    if ($format_type == 'Y') {
        for ($i = $date_start; $i < $date_end; $i++) {
            $arr_data[] = strval($i);
        }

    }
    else {

        try {
            $start = new \DateTime($date_start);
            $end   = new \DateTime($date_end);
        }
        catch (\Exception $exception) {
            return [];
        }

        // 时间间距 这里设置的是一个月
        $interval = \DateInterval::createFromDateString($date_type);
        $period   = new \DatePeriod($start, $interval, $end);

        $arr_data = [];
        foreach ($period as $dt) {
            $arr_data[] = $dt->format($date_format);
        }

    }
    return $arr_data;
}

/**
 * 日期格式-mysql语句
 *
 * @param string $format_type Y-日期格式按年 Ym-日期格式按月 Ymd-日期格式按天
 *
 * @return mixed
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_mysql_date_format($format_type = 'Ymd')
{
    switch ($format_type) {
        //精确到日
        case 'Ymd':
            $date_type   = '1 day';//时间间距
            $date_format = '%Y-%m-%d';//日期格式
            break;

        //精确到月
        case 'Ym':
            $date_type   = '1 month';//时间间距
            $date_format = '%Y-%m';//日期格式
            break;

        //精确到年
        case 'Y':
            $date_type   = '1 year';//时间间距
            $date_format = '%Y';//日期格式
            break;

        //默认精确到日
        default:
            $date_type   = '1 day';//时间间距
            $date_format = '%Y-%m-%d';//日期格式
    }

    return $date_format;
}

/**
 * 获取最近的日期 一周 一月 半年
 *
 * @param string $type  日期类型
 * @param bool   $reset 初始日期 true-周一起 月初1号起 半年前月初1号起 false-七天前起 一个月前起 半年前起
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_nearly_date($type = '',$reset = false)
{
    switch ($type) {
        case 'week':
            if($reset === true){
                //周一
                $s_start = date('Y-m-d',time()-(date('N') - 1) * 24 *60 *60);
            }
            else{
                //7天前
                $s_start = date('Y-m-d', strtotime('-6 day'));
            }

            break;
        case 'month':
            if($reset === true){
                //月初1号
                $s_start = date('Y-m') . '-01';
            }
            else{
                //一个月前
                $s_start = date('Y-m-d', strtotime('-1 month'));
            }

            break;
        case 'half_year':

            if($reset === true){
                //6个月前月初1号
                $s_start = date('Y-m', strtotime('-6 month')) . '-01';
            }
            else{
                //6个月前
                $s_start = date('Y-m-d', strtotime('-6 month'));
            }
            break;
        default:
            if($reset === true){
                //周一
                $s_start = date('Y-m-d',time()-(date('N') - 1) * 24 *60 *60);
            }
            else{
                //7天前
                $s_start = date('Y-m-d', strtotime('-6 day'));
            }
    }

    $s_end = date('Y-m-d');
    $arr_date = [
      'start'     => $s_start,
      'end'       => $s_end,
    ];
    //    $result = format_date($arr_date);
    return $arr_date;

}
