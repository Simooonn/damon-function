<?php
/**
 * Created by PhpStorm.
 * User: wumengmeng <wu_mengmeng@foxmail.com>
 * Date: 2020/6/30 0030
 * Time: 18:00
 */

////////////////////////// redis 模块 start

/**
 * redis连接
 *
 * @param int $n_db
 *
 * @return \Predis\Client
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function predis_connection($n_db = 0)
{
    //    ini_set('default_socket_timeout', -1);
    $n_env_db = env('REDIS_DB', 0);
    $n_db     = $n_db + $n_env_db;
    $server   = [
      'host'     => env('REDIS_HOST', '127.0.0.1'),
      'password' => env('REDIS_PASSWORD', null),
      'port'     => env('REDIS_PORT', 6379),
      'database' => $n_db
    ];
    $client   = new Predis\Client($server);
    return $client;
}

/**
 * redis存字符串
 *
 * @param     $key
 * @param     $value
 * @param int $time
 * @param int $db
 *
 * @return int
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function predis_str_set($key, $value, $time = 0, $db = 0)
{
    $redis = predis_connection($db);
    $value = json_encode($value);

    if ($time === 0) {
        //永久存储
        $re = $redis->set($key, $value);
    }
    else {
        //临时存储-有效期
        $re = $redis->setex($key, $time, $value);
    }
    $redis->disconnect();
    return $re;
}

/**
 * redis取字符串
 *
 * @param     $key
 * @param int $db
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function predis_str_get($key, $db = 0)
{
    $redis = predis_connection($db);
    $re    = $redis->get($key);
    $re    = json_decode($re, true);
    $redis->disconnect();
    return $re;
}

/**
 * redis删除字符串
 *
 * @param     $key
 * @param int $db
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function predis_str_del($key, $db = 0)
{
    $redis = predis_connection($db);
    $re    = $redis->del($key);
    $redis->disconnect();
    return $re;
}

/************* redis-Hash表操作 *************/

/**
 * redis 存入hash字段
 *
 * @param     $table
 * @param     $key
 * @param     $value
 * @param int $db
 *
 * @return int
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function predis_hash_set($table, $key, $value, $db = 0)
{
    $table  = 'hash_' . $table;
    $value  = json_encode($value);
    $redis  = predis_connection($db);
    $result = $redis->hset($table, $key, $value);
    $redis->disconnect();
    return $result;
}

/**
 * redis 存入hash字段-字段累加
 *
 * @param     $table
 * @param     $key
 * @param     $step
 * @param int $db
 *
 * @return int
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function predis_hash_key_increment($table, $key, $step, $db = 0)
{
    $table  = 'hash_' . $table;
    $redis  = predis_connection($db);
    $result = $redis->hincrby($table, $key, $step);
    $redis->disconnect();
    return $result;
}

/**
 * redis 存入hash字段-字段递减
 *
 * @param     $table
 * @param     $key
 * @param     $step
 * @param int $db
 *
 * @return int
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function predis_hash_key_decrement($table, $key, $step, $db = 0)
{
    $table  = 'hash_' . $table;
    $redis  = predis_connection($db);
    $result = $redis->hincrby($table, $key, -$step);
    $redis->disconnect();
    return $result;
}

/**
 * redis 取出hash字段
 *
 * @param     $table
 * @param     $key
 * @param int $db
 *
 * @return mixed|string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function predis_hash_get($table, $key, $db = 0)
{
    $table  = 'hash_' . $table;
    $redis  = predis_connection($db);
    $result = $redis->hget($table, $key);
    $result = json_decode($result, true);
    $redis->disconnect();
    return $result;
}

/**
 * redis 删除hash字段
 *
 * @param     $table
 * @param     $key
 * @param int $db
 *
 * @return int
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function predis_hash_del($table, $key, $db = 0)
{
    $table  = 'hash_' . $table;
    $redis  = predis_connection($db);
    $result = $redis->hdel($table, $key);
    $redis->disconnect();
    return $result;
}

/**
 * redis 删除整个hash表
 *
 * @param     $table
 * @param int $db
 *
 * @return int
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function predis_hash_del_all($table, $db = 0)
{
    $table  = 'hash_' . $table;
    $redis  = predis_connection($db);
    $result = $redis->del($table);
    $redis->disconnect();
    return $result;
}

/************* redis-队列操作 *************/
function predis_queue_connection()
{
    $db    = 2;
    $redis = predis_connection($db);
    return $redis;
}

/*redis 队列 左侧插入数据*/
function predis_queue_lpush($table, $value)
{
    $table  = 'queue_' . $table;
    $redis  = predis_queue_connection();
    $result = $redis->lpush($table, $value);
    $redis->disconnect();
    return $result;
}

/*redis 队列 左侧取出数据-取出一条并删除*/
function predis_queue_lpop($table)
{
    $table  = 'queue_' . $table;
    $redis  = predis_queue_connection();
    $result = $redis->lpop($table);
    $redis->disconnect();
    return $result;
}

/*redis 队列 左侧取出指定数量数据-取出多条不删除*/
function predis_queue_lrange($table, $num = 1)
{
    $table  = 'queue_' . $table;
    $redis  = predis_queue_connection();
    $result = $redis->lrange($table, 0, $num);
    $redis->disconnect();
    return $result;
}


/*redis 队列 右侧插入数据*/
function predis_queue_rpush($table, $value)
{
    $table  = 'queue_' . $table;
    $redis  = predis_queue_connection();
    $result = $redis->rpush($table, $value);
    $redis->disconnect();
    return $result;
}

/*redis 队列 右侧取出数据-取出一条并删除*/
function predis_queue_rpop($table)
{
    $table  = 'queue_' . $table;
    $redis  = predis_queue_connection();
    $result = $redis->rpop($table);
    $redis->disconnect();
    return $result;
}


/*redis 队列 插入数据 默认模式是【右进左出】*/
function predis_queue_in($table, $value)
{
    $result = predis_queue_rpush($table, $value);
    return $result;
}

/*redis 队列 取出数据 默认模式是【右进左出】*/
function predis_queue_out($table, $num = 1)
{
    $arr_data = [];
    for ($i = 0; $i < $num; $i++) {
        $result = predis_queue_lpop($table);
        if (!is_null($result)) {
            $arr_data[] = json_decode($result, true);
        }
    }
    return $arr_data;
}

function queue_in($table, $data)
{
    $json_data = json_encode($data);
    $result    = predis_queue_in($table, $json_data);
    return $result;
}

function queue_out($table, $num = 10)
{
    $result = predis_queue_out($table, $num);
    return $result;
}


/**
 * redis连接
 *
 * @param int $n_db
 *
 * @return \Predis\Client
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function connection_redis($n_db = 0)
{
    //    ini_set('default_socket_timeout', -1);
    $server = [
      'host'     => env('REDIS_HOST', '127.0.0.1'),
      'password' => env('REDIS_PASSWORD', null),
      'port'     => env('REDIS_PORT', 6379),
      'database' => $n_db
    ];
    $client = new Predis\Client($server);
    return $client;
}

/**
 * redis存字符串
 *
 * @param     $key
 * @param     $value
 * @param int $time
 * @param int $db
 *
 * @return int
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function redis_string_set($key, $value, $time = 0, $db = 0)
{
    $redis = connection_redis($db);
    $value = json_encode($value);
    if ($time === 0) {
        //永久存储
        $re = $redis->set($key, $value);
    }
    else {
        //临时存储-有效期
        $re = $redis->setex($key, $time, $value);
    }
    $redis->disconnect();
    return $re;
}

/**
 * redis取字符串
 *
 * @param     $key
 * @param int $db
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function redis_string_get($key, $db = 0)
{
    $redis = connection_redis($db);
    $re    = $redis->get($key);
    $re    = json_decode($re);
    $redis->disconnect();
    return $re;
}

/**
 * redis删除字符串
 *
 * @param     $key
 * @param int $db
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function redis_string_del($key, $db = 0)
{
    $redis = connection_redis($db);
    $re    = $redis->del($key);
    $redis->disconnect();
    return $re;
}


/**************** 消息通知队列 ****************/


/*通知队列-塞入数据*/
function predis_notice_queue_in($data)
{
    //$data['notice_type'] 通知消息类型 自己定义

    $json_data = json_encode($data);

    $table  = 'notice';
    $result = predis_queue_in($table, $json_data);
    return $result;
}

/*通知队列-取出数据*/
function predis_notice_queue_out()
{
    $table  = 'notice';
    $result = predis_queue_out($table, 10);
    return $result;
}

/**
 * 通知队列-塞入订单支付成功通知
 *
 * @param string $s_order_sn   订单编号
 * @param string $s_order_type 订单类型 njyy wxfw wxby dljy ptshp
 * @param array  $arr_extend
 *
 * @return int
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function queue_in_notice_order_pay_success($s_order_sn = '', $s_order_type = '', $arr_extend = [])
{
    $arr_data = [
      'order_sn'    => $s_order_sn,
      'notice_type' => $s_order_type . '_pay_success',
    ];
    return predis_notice_queue_in($arr_data);

}

/**
 * 通知队列-塞入车辆子单检测结果通知 - 成功 失败 故障
 *
 * @param int    $n_order_id
 * @param int    $n_order_vehicle_id
 * @param string $check_type ok not_ok fail
 *
 * @return int
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function queue_in_notice_order_check($n_order_id = 0, $n_order_vehicle_id = 0, $check_type = '')
{
    $arr_data = [
      'order_id'         => $n_order_id,
      'order_vehicle_id' => $n_order_vehicle_id,
      'notice_type'      => 'njyy_check_' . $check_type,
    ];
    return predis_notice_queue_in($arr_data);
}

/**
 * 通知队列-塞入退款成功通知
 *
 * @param string $s_order_sn
 * @param string $s_order_type
 * @param string $s_refund_sn
 * @param array  $arr_extend
 *
 * @return int
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function queue_in_notice_order_refund($s_order_sn = '', $s_order_type = '', $s_refund_sn = '', $arr_extend = [])
{
    $arr_data = [
      'order_sn'    => $s_order_sn,
      'refund_sn'   => $s_refund_sn,
      'notice_type' => $s_order_type . '_refund_success',
    ];
    return predis_notice_queue_in($arr_data);
}

/**************** 返还预约数量队列 ****************/

/*通知队列-塞入数据*/
function predis_appoint_num_queue_in($data)
{

    $json_data = json_encode($data);

    $table  = 'appoint_num';
    $result = predis_queue_in($table, $json_data);
    return $result;
}

/*通知队列-取出数据*/
function predis_appoint_num_queue_out()
{
    $table  = 'appoint_num';
    $result = predis_queue_out($table, 10);
    return $result;
}


/**************** 年检预约提醒队列 ****************/

/*通知队列-塞入数据*/
function predis_njyy_remind_queue_in($data)
{
    //$data['notice_type'] 通知消息类型 自己定义

    $json_data = json_encode($data);

    $table  = 'njyy_remind';
    $result = predis_queue_in($table, $json_data);
    return $result;
}

/*通知队列-取出数据*/
function predis_njyy_remind_queue_out()
{
    $table  = 'njyy_remind';
    $result = predis_queue_out($table, 10);
    return $result;
}