<?php
/**
 * Created by PhpStorm.
 * User: wumengmeng <wu_mengmeng@foxmail.com>
 * Date: 2020/6/30 0030
 * Time: 18:00
 */

/**
 * 获取公共配置
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function common_config()
{
    $arr_data = [
      'with'         => [],//默认关联
      'where'        => [],//默认查询条件
      'field'        => ['*'],//默认查询字段
      'order'        => ['key' => 'id', 'value' => 'desc'],//默认排序方式
      'n_per_page'   => 15,//默认每页查询条数
      'api_take_num' => 10,//接口查询数量
      'withCount'    => [],//默认关联统计

    ];
    return $arr_data;
}

/**
 * api接口取出数据条数
 *
 * @return mixed
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function api_take_num()
{
    return common_config()['api_take_num'];
}





/**
 * @todo敏感词过滤，返回结果
 * @paramarray $list 定义敏感词一维数组
 * @paramstring $string 要过滤的内容
 * @returnstring $log 处理结果
 */

function sensitive($string)
{
    //    $sensitivity = \Redis::get('sensitivity');
    //    $list = explode('*' , $sensitivity );
    $list = [];
    //获取后台配置的敏感词库
    $where               = ['status' => 1, 'type' => 1];
    $arr_option['field'] = ['content'];
    $arr_list            = \HiCommon\Repository\SensitivityRepository::get_one_where((array)$where, (array)$arr_option);
    if (empty($arr_list->first())) {  //没有设置敏感词  直接返回
        return false;
    }
    $arr_list = $arr_list->toarray()['content'];
    $list     = explode('*', $arr_list);

    $string  = htmlentities($string, ENT_COMPAT);   //放在js注入
    $string  = preg_replace('# #', '', $string);  //删除字符串中的空格
    $pattern = "/" . implode("|", $list) . "/i"; //定义正则表达式a
    if (preg_match_all($pattern, $string, $matches)) { //匹配到了结果
        $patternList   = $matches[0]; //匹配到的数组
        $count         = count($patternList);
        $sensitiveWord = implode(',', $patternList); //敏感词数组转字符串
        $replaceArray  = array_combine($patternList, array_fill(0, count($patternList), '*')); //把匹配到的数组进行合并，替换使用
        $stringAfter   = strtr($string, $replaceArray); //结果替换
    }
    //    $log = "原句为 [ {$string} ]";
    if ($count == 0) {
        return false;
        //        $log .= "暂未匹配到敏感词！";
    }
    else {
        return true;
        //        $log .= "匹配到 [ {$count} ]个敏感词：[ {$sensitiveWord} ]" . "替换后为：[ {$stringAfter} ]";
    }
    //    return $log;
}





/**
 *  生成签名
 *
 **/
function makeSign(array $arr, string $appsecret)
{
    return MD5($arr['illegalid'] . $arr['mobile'] . $arr['outorderno'] . $appsecret);
}




////////////////////////////微信公众号




/**
 * 微信退款失败错误信息
 *
 * @param string $s_err_code
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function wechat_refund_error_code($s_err_code = '')
{
    //退款错误返回的代码
    switch ($s_err_code) {
        case 'SYSTEMERROR':
            $sMsg = '接口返回错误,请再次提交';
            break;
        case 'BIZERR_NEED_RETRY':
            $sMsg = '退款业务流程错误,请再次提交';
            break;
        case 'TRADE_OVERDUE':
            $sMsg = '订单已经超过退款期限';
            break;
        case 'ERROR':
            $sMsg = '业务错误';
            break;
        case 'USER_ACCOUNT_ABNORMAL':
            $sMsg = '退款请求失败';
            break;
        case 'INVALID_REQ_TOO_MUCH':
            $sMsg = '无效请求过多';
            break;
        case 'NOTENOUGH':
            $sMsg = '余额不足';
            break;
        case 'INVALID_TRANSACTIONID':
            $sMsg = '无效transaction_id8';
            break;
        case 'PARAM_ERROR':
            $sMsg = '参数错误';
            break;
        case 'APPID_NOT_EXIST':
            $sMsg = 'APPID不存在';
            break;
        case 'MCHID_NOT_EXIST':
            $sMsg = 'MCHID不存在';
            break;
        case 'REQUIRE_POST_METHOD':
            $sMsg = '请使用post方法';
            break;
        case 'SIGNERROR':
            $sMsg = '签名错误';
            break;
        case 'XML_FORMAT_ERROR':
            $sMsg = 'XML格式错误';
            break;
        case 'FREQUENCY_LIMITED':
            $sMsg = '频率限制';
            break;
        default:
            $sMsg = '退款失败';
    }

    return $sMsg;
}