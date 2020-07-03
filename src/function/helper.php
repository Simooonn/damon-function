<?php

function yoo_dump($result){
    var_dump($result);
    die;
}

/*
 * 打印
 * */
function yoo_debug($v) {
    header("Content-type: text/html; charset=utf-8");

    echo "<pre>";
    print_r($v);
    echo "</pre>";
    die;
}

/**
 * 当前访问链接网址域名
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_http_host()
{
    return 'http://' . $_SERVER['HTTP_HOST'] . '/';
}

/**
 * 客户端IP地址
 *
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv  是否进行高级模式获取（有可能被伪装）
 *
 * @return mixed
 */
function yoo_client_ip($type = 0, $adv = false)
{
    $type = $type ? 1 : 0;
    static $ip = null;
    if ($ip !== null) {
        return $ip[$type];
    }
    if ($adv) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) {
                unset($arr[$pos]);
            }
            $ip = trim($arr[0]);
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    }
    elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip   = $long ? [$ip, $long] : ['0.0.0.0', 0];
    return $ip[$type];
}

/************************************** 返回提示 **************************************/

/**
 * 错误消息
 *
 * @param string $msg
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_msg_error($msg = '')
{
    echo $msg;
    die;
}

/*错误提示*/
function yoo_echo_error($result = [])
{
    if(isset($result['state'])){
        $n_state = intval($result['state']);
    }
    else{
        $n_state = 1;
    }
    if(isset($result['msg'])){
        $s_msg = trim($result['msg']);
    }
    else{
        $s_msg = '错误提示';
    }
    if ($n_state !== 200) {
        yoo_msg_error($s_msg);
    }
}

/**
 * 友好返回错误信息
 *
 * @param int    $n_state       错误状态
 * @param string $s_msg         错误提示
 * @param int    $n_error_code  错误状态码
 * @param string $s_error_msg   错误详细描述
 * @param array  $arr_result    返回结果
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_hello_error($n_state = 1,$s_msg = '',$n_error_code = 1,$s_error_msg = '',$arr_result = []){
    if($n_error_code == 1){
        $n_error_code = $n_state;
    }
    if($s_error_msg == ''){
        $s_error_msg = $s_msg;
    }
    return [
      'state'      => $n_state,
      'msg'        => $s_msg,
      'error_code' => $n_error_code,
      'error_msg'  => $s_error_msg,
      'result'       => $arr_result,

    ];
}

/**
 * 友好返回失败信息
 *
 * @param string $s_msg         失败提示
 * @param string $s_error_msg   失败详细描述
 * @param array  $arr_result    返回结果
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_hello_fail($s_msg = '',$s_error_msg = '',$arr_result = []){
    $n_state = 1;
    $n_error_code = 10001;
    if($s_error_msg == ''){
        $s_error_msg = $s_msg;
    }
    return [
      'state'      => $n_state,
      'msg'        => $s_msg,
      'error_code' => $n_error_code,
      'error_msg'  => $s_error_msg,
      'result'       => $arr_result,

    ];
}

/**
 * 友好返回成功信息
 *
 * @param string $s_msg         成功提醒
 * @param array  $arr_result    返回结果
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_hello_success($s_msg = '',$arr_result = []){
    $n_state = 200;
    $n_error_code = 200;
    $s_error_msg = '';
    return [
      'state'      => $n_state,
      'msg'        => $s_msg,
      'error_code' => $n_error_code,
      'error_msg'  => $s_error_msg,
      'result'       => $arr_result,

    ];
}


/************************************** 数据正则验证 **************************************/

/**
 * 密码正则验证字符
 *
 * @param        $password
 * @param string $type
 *
 * @return mixed
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_preg_password($password, $type = 'simple')
{
    //    $rule = "/^[\w`~!@#$%^&*()+-=·~！￥……（）——\[\];'\\\,.\/\{\}:\"|<>?【】；’、‘，。：“”《》？]{6,30}$/";//数字、字母、特殊字符
    if ($type === 'simple') {
        $rule = '/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,18}$/';//密码必须同时包含数字和字母的6-18位字符组成
        $msg  = '密码由6-18位字符组成，必须同时包含数字和字母';
    }
    elseif ($type === 'difficult') {
        $rule = '/^[A-Za-z0-9_\-+=*!@#$%^&()]{6,18}$/';//密码由大小写字母数字和指定特殊符号_\-+=*!@#$%^&()的6-18位字符组成
        $msg  = '密码由6-18位字符组成，只能是数字、字母或者指定特殊字符_\-+=*!@#$%^&()';
    }
    elseif ($type === 'nightmare') {
        $rule = "/^[\w`~!@#$%^&*()+-=·~！￥……（）——\[\];'\\\,.\/\{\}:\"|<>?【】；’、‘，。：“”《》？]{6,18}$/";//数字、字母、特殊字符
        $msg  = '密码由6-18位字符组成，只能是数字、字母或特殊字符';
    }
    else {
        $rule = '/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,18}$/';//密码必须同时包含数字和字母的6-18位字符组成
        $msg  = '密码由6-18位字符组成，必须同时包含数字和字母';
    }

    $res = preg_match_all($rule, $password, $array);
    if (!$res) {
        //        return hello_error('密码只能由数字字母以及非空格的特殊字符组成');
        return yoo_hello_fail($msg);
    }
    return yoo_hello_success('密码正则成功');
}

/**
 * 手机号正则验证字符
 *
 * @param string $phone
 * @param string $rule
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_preg_phone($phone = '',$rule = '')
{
    if($rule == ''){
        $rule = "/^1[3456789]\d{9}$/";
    }
    $res  = preg_match_all($rule, $phone, $array);
    if (!$res) {
        return yoo_hello_fail('手机号格式错误');
    }
    return yoo_hello_success('手机号正则成功');
}

/**
 * 判断密码安全级别
 *
 * @param $password
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_password_judge_safety($password)
{
    $score   = yoo_password_judge_score($password);
    $percent = ($score / 10 * 100) . '%';
    if ($score <= 3) {
        $result = ['safety' => '弱', 'notice' => '太危险了，赶紧设置个安全点的密码！'];
    }
    elseif ($score > 3 && $score <= 6) {
        $result = ['safety' => '中等', 'notice' => '还是有点危险，再接再厉！'];
    }
    elseif ($score > 6 && $score <= 8) {
        $result = ['safety' => '强', 'notice' => '现在你的密码已经非常安全了，奥利给！'];
    }
    elseif ($score > 8 && $score <= 10) {
        $result = ['safety' => '极好', 'notice' => '还有比这更安全的密码吗？你尽管盗，盗走算我输！！！'];
    }
    else {
        $result = ['safety' => '无', 'notice' => '看不懂，赶紧联系超级管理员吧！'];
    }
    $result['score']   = $score;
    $result['percent'] = $percent;
    return $result;

}

/**
 * 密码安全评分
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_password_judge_score($password = '')
{
    $score = 0;
    if (!empty($password)) { //接收的值
        $str = $password;
    }
    else {
        $str = '';
    }
    if (preg_match("/[0-9]+/", $str)) {
        $score++;
    }
    if (preg_match("/[0-9]{2,}/", $str)) {
        $score++;
    }
    if (preg_match("/[a-z]+/", $str)) {
        $score++;
    }
    if (preg_match("/[a-z]{2,}/", $str)) {
        $score++;
    }
    if (preg_match("/[A-Z]+/", $str)) {
        $score++;
    }
    if (preg_match("/[A-Z]{2,}/", $str)) {
        $score++;
    }
    if (preg_match("/[_\-+=*!@#$%^&()]+/", $str)) {
        //  /[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/
        $score += 2;
    }
    if (preg_match("/[_\-+=*!@#$%^&()]{2,}/", $str)) {
        //  /[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]{3,}/
        $score++;
    }
    if (strlen($str) >= 10) {
        $score++;
    }
    return $score;
}






