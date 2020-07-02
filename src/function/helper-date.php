<?php
/**
 * Created by PhpStorm.
 * User: wumengmeng <wu_mengmeng@foxmail.com>
 * Date: 2020/6/30 0030
 * Time: 18:00
 */


/**
 * 友好的时间显示 输入时间戳
 *
 * @param int    $n_time 待显示的时间
 * @param string $type   类型. normal | mohu | full | ymd | other
 *
 * @return string
 */
function friendly_date($n_time, $type = '')
{
    if (!$n_time) {
        return '';
    }
    //sTime=源时间，cTime=当前时间，dTime=时间差

    $c_time = time();
    $d_time = $c_time - $n_time;
    //如果时间在同一年内计算可以  如果跨年了 时间计算就有问题
    //$d_day       =    intval(date("z",$c_time)) - intval(date("z",$n_time));
    $d_day  = intval($d_time / 3600 / 24);
    $d_year = intval(date("Y", $c_time)) - intval(date("Y", $n_time));
    //normal：n秒前，n分钟前，n小时前，日期
    if ($type == 'normal') {
        if ($d_time < 60) {
            if ($d_time < 10) {
                return '刚刚';    //by yangjs
            }
            else {
                return intval(floor($d_time / 10) * 10) . "秒前";
            }
        }
        elseif ($d_time < 3600) {
            return intval($d_time / 60) . "分钟前";
            //今天的数据.年份相同.日期相同.
        }
        elseif ($d_year == 0 && $d_day == 0) {
            //return intval($d_time/3600)."小时前";
            return '今天' . date('H:i', $n_time);
        }
        elseif ($d_year == 0) {
            return date("m月d日 H:i", $n_time);
        }
        else {
            return date("Y-m-d H:i", $n_time);
        }
    }
    elseif ($type == 'mohu') {

        if ($d_time < 60) {
            return $d_time . "秒前";
        }
        elseif ($d_time < 3600) {
            return intval($d_time / 60) . "分钟前";
        }
        elseif ($d_time >= 3600 && $d_day == 0) {
            return intval($d_time / 3600) . "小时前";
        }
        elseif ($d_day > 0 && $d_day <= 7) {
            return intval($d_day) . "天前";
        }
        elseif ($d_day > 7 && $d_day <= 30) {
            return intval($d_day / 7) . '周前';
        }
        elseif ($d_day > 30) {
            return intval($d_day / 30) . '个月前';
        }
    }
    elseif ($type == 'full') {
        return date("Y-m-d , H:i:s", $n_time);
    }
    elseif ($type == 'ymd') {
        return date("Y-m-d", $n_time);
    }
    else {
        if ($d_time < 60) {
            return $d_time . " 秒前";
        }
        elseif ($d_time < 3600) {
            return intval($d_time / 60) . " 分钟前";
        }
        elseif ($d_time >= 3600 && $d_day == 0) {
            return intval($d_time / 3600) . " 小时前";
        }
        elseif ($d_year == 0) {
            return date("Y-m-d H:i:s", $n_time);
        }
        else {
            return date("Y-m-d H:i:s", $n_time);
        }
    }
}

/**
 * 友好的时间显示 输入时间日期格式
 *
 * @param int    $s_time 待显示的时间
 * @param string $type   类型. normal | mohu | full | ymd | other
 *
 * @return string
 */
function ymd_friendly_date($s_time, $type = 'mohu')
{
    if (!$s_time) {
        return '';
    }
    $n_time = strtotime($s_time);
    return friendly_date($n_time, $type);
}

/**
 * 时间戳 转换成 年月日时分秒
 *
 * @param string $n_time
 *
 * @return false|string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function time_to_ymdhis($n_time = '')
{
    if (empty($n_time)) {
        $n_time = time();
    }
    return date('Y-m-d H:i:s', $n_time);

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
function ymdhis_to_time_date($s_date = '')
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


function get_ctime($month)
{
    $month_start = strtotime($month);//指定年月份月初时间戳
    $BeginDate   = date('Y-m-01', $month_start);
    $EndDate     = date('Y-m-d 23:59:59', strtotime("$BeginDate +1 month -1 day"));
    $months      = date('Y-m-d 0:0:0', $month_start) . ' _ ' . $EndDate;
    return $months;
}


/**
 * 获取指定日期段内 指定格式的集合
 *
 * @param array $arr_date
 *
 * string  $arr_date['start'] 开始日期 格式化时间 Y-m-d H:i:s
 * string  $arr_date['end']   结束日期 格式化时间 Y-m-d H:i:s
 * string  $arr_date['date_type']   指定格式 Y 年 Ym 月 Ymd日
 *
 * @return array
 * @throws \Exception
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function get_date_from_range($arr_date = [])
{
    $startdate = $arr_date['start'];
    $enddate   = $arr_date['end'];
    if (empty($startdate)) {
        return [];
    }
    if (empty($enddate)) {
        return [];
    }
    if (strtotime($enddate) < strtotime($startdate)) {
        return [];
    }

    switch ($arr_date['date_type']) {
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

    $startdate = date($date_format, strtotime($startdate));
    $enddate   = date($date_format, strtotime($enddate . '+' . $date_type));

    if ($arr_date['date_type'] == 'Y') {
        for ($i = $startdate; $i < $enddate; $i++) {
            $arr_data[] = strval($i);
        }

    }
    else {
        $start = new \DateTime($startdate);
        $end   = new \DateTime($enddate);

        // 时间间距 这里设置的是一个月
        $interval = \DateInterval::createFromDateString($date_type);
        $period   = new \DatePeriod($start, $interval, $end);

        $arr_data = [];
        foreach ($period as $dt) {
            $arr_data[] = $dt->format($date_format);
        }

    }
    $data = [
      'dates' => $arr_data,
      'days'  => count($arr_data),
    ];
    return $data;
}

/**
 * 格式化日期搜索条件
 *
 * @param $arr_date
 *
 * @return mixed
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function format_date($arr_date)
{
    $startdate = $arr_date['start'];
    $enddate   = $arr_date['end'];
    switch ($arr_date['date_type']) {
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
    $startdate        = date('Y-m-d H:i:s', strtotime($startdate));
    $enddate          = date('Y-m-d H:i:s', strtotime($enddate) + 86400);
    $arr_date_between = [$startdate, $enddate];
    if (empty($startdate)) {
        $arr_date_between = [];
    }
    if (empty($enddate)) {
        $arr_date_between = [];
    }
    if (strtotime($enddate) < strtotime($startdate)) {
        $arr_date_between = [];
    }

    $arr_date['date_format']  = $date_format;
    $arr_date['date_between'] = $arr_date_between;
    return $arr_date;
}

/**
 * 获取最近的日期 比如近7天 或者 近6个月
 *
 * @param string $type
 *
 * @return mixed
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function nearly_date($type = '')
{
    switch ($type) {
        case 'week':
            $arr_date = [
              'start'     => date('Y-m-d', strtotime('-6 day')),
              'end'       => date('Y-m-d'),
              'date_type' => 'Ymd'
            ];
            break;
        case 'month':
            $arr_date = [
              'start'     => date('Y-m') . '-01',
              'end'       => date('Y-m-d'),
              'date_type' => 'Ymd'
            ];
            break;
        case 'half_year':
            $arr_date = [
              'start'     => date('Y-m', strtotime('-5 month')) . '-01',
              'end'       => date('Y-m-d'),
              'date_type' => 'Ym'
            ];
            break;
        default:
            $arr_date = [
              'start'     => date('Y-m-d', strtotime('-6 day')),
              'end'       => date('Y-m-d'),
              'date_type' => 'Ymd'
            ];
    }
    //    $result = format_date($arr_date);
    return $arr_date;

}

/**
 * 获取最近的日期 比如近7天 15天 一个月 或者 近6个月
 *
 * @param string $type
 *
 * @return mixed
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function real_nearly_date($type = '')
{
    switch ($type) {
        case 'week':
            $arr_date = [
              'start'     => date('Y-m-d', strtotime('-6 day')),
              'end'       => date('Y-m-d'),
              'date_type' => 'Ymd'
            ];
            break;
        //        case 'half_month':
        //            $arr_date = [
        //              'start'=>date('Y-m-d',strtotime('-15 day')),
        //              'end'=>date('Y-m-d'),
        //              'date_type'=>'Ymd'
        //            ];
        //            break;
        case 'month':
            $arr_date = [
              'start'     => date('Y-m-d', strtotime('-1 month')),
              'end'       => date('Y-m-d'),
              'date_type' => 'Ymd'
            ];
            break;
        case 'half_year':
            $arr_date = [
              'start'     => date('Y-m', strtotime('-5 month')) . '-01',
              'end'       => date('Y-m-d'),
              'date_type' => 'Ym'
            ];
            break;
        default:
            $arr_date = [
              'start'     => date('Y-m-d', strtotime('-6 day')),
              'end'       => date('Y-m-d'),
              'date_type' => 'Ymd'
            ];
    }
    //    $result = format_date($arr_date);
    return $arr_date;

}