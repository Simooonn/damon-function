<?php
/**
 * Created by PhpStorm.
 * User: wumengmeng <wu_mengmeng@foxmail.com>
 * Date: 2020/6/30 0030
 * Time: 18:00
 */

/*字符串补位*/
function yoo_string_pad($n_number = '',$n_length = 0,$s_pad = 0,$s_method = 'left'){
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

/*数字补位*/
function yoo_number_pad($n_number = '',$n_length = 0,$s_method = 'left'){
    if(is_float($n_number)){
        $n_length = $n_length + 1;
    }
    return yoo_string_pad($n_number,$n_length,0,$s_method);
}





function number_format_money($money){
    return number_format($money,2,'.','');
}

/**
 * 支付比例系数 = 订单支付：实际支付
 *
 * 1        ------  [设置价格时必须能被0.01整除] 正常
 * 100      ------  [设置价格时必须能被1整除] 100元订单，实际支付1元，支付显示100，退款金额100，实际退款1元，退款显示100
 * 10000    ------  [设置价格时必须能被100整除] 10000元订单，实际支付1元，支付显示10000，退款金额10000，实际退款1元，退款显示10000
 *
 * @return mixed
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function common_pay_ratio(){
    $result = env('PAY_RATIO',1);
    return $result;
}

/*元转分*/
function money_to_fee($money){
    $fee = intval($money * 100) ;
    return $fee;
}

/*分转元*/
function fee_to_money($fee){
    $money = $fee / 100;
    return number_format_money($money);
}

/*支付乘比*/
function pay_ratio_up($n_num){
    $n_pay_ratio = common_pay_ratio();
    return $n_num * $n_pay_ratio;
}

/*支付降比*/
function pay_ratio_down($n_num){
    $n_pay_ratio = common_pay_ratio();
    return $n_num / $n_pay_ratio;
}


/**
 * 小数保留处理
 *
 * 默认四舍五入
 *
 * @param float $n_decimal 小数
 * @param int   $num       保留小数点后的位数
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function decimal_format($n_decimal = 0.01, $num = 0)
{
    return sprintf('%.' . $num . 'f', $n_decimal);
}