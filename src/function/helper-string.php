<?php
/**
 * Created by PhpStorm.
 * User: wumengmeng <wu_mengmeng@foxmail.com>
 * Date: 2020/6/30 0030
 * Time: 18:00
 */

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
 * 隐藏手机号中间几位数字并用*代替 [延伸] 可对任何字段的指定位置字段进行隐藏
 *
 * @param        $s_phone
 * @param string $s_hide
 * @param int    $n_start
 * @param int    $n_length
 *
 * @return mixed
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function hide_phone($s_phone, $s_hide = '****', $n_start = 3, $n_length = 4)
{
    $n_end_start = $n_start + $n_length;
    $res         = substr($s_phone, 0, $n_start) . $s_hide . substr($s_phone, $n_end_start);
    //    $s_string = substr($s_phone,$n_start,$n_length);  //获取手机号中间四位
    //    $res = str_replace($s_string,$s_hide,$s_phone);  //用****进行替换
    return $res;
}

function cut_string($s_string, $s_hide = '', $n_start = 0, $n_length = 1)
{
    $n_end_start = $n_start + $n_length;
    $res         = substr($s_string, 0, $n_start) . $s_hide . substr($s_string, $n_end_start);
    return $res;
}

function articl_random_str()
{
    $poems = "从善如登，从恶如崩。 
已知花意，未见其花，已见其花，未闻花名 
如果能不长大就好了啊 可是时光在身后挡住退路。 
或许前路永夜，即便如此我也要前进，因为星光即使微弱也会为我照亮前路 
你驻足于春色中，于那独一无二的春色之中
喜欢的人喜欢别人不是很正常吗。
生活是不公平的；要去适应它。——比尔盖茨
人生就是一列开往坟墓的列车，路途上会有很多站，很难有人可以自始至终陪着走完。当陪你的人要下车时，即使不舍也该心存感激，然后挥手道别。
往者不可谏，来着犹可追。——《论语·微子》
多行不义必自毙。——《左传》
敏而好学，不耻下问。——《论语·公冶长》
避其锐气，击其惰归。——《孙子兵法·军争》
十年树木，百年树人。——《管子·权修》
居安思危，思则有备，有备无患。——《左传》
天时不如地利，地利不如人和。——《孟子·公孙丑》
人谁无过？过而能改，善莫大焉。——《论语》
信言不美，美言不信。——老子
满招损，谦受益。——《尚书·大禹谟》
高岸为谷，深谷为陵。——《诗经·小雅》
天作孽，犹可违，自作孽，不可活。——《尚书》
言之无文，行而不远。——《左传》
三军可夺帅也，匹夫不可夺志也。——《论语·子罕》
天行健，君子以自强不息。——《周易·乾·象》
皮之不存，毛将焉附。——《左传》
路漫漫其修远兮，吾将上下而求索。——屈原《离骚》
长太息以掩涕兮，哀民生之多艰。——屈原《离骚》
人而无仪，不死何为。——《诗经·鄘风》
捐躯赴国难，视死忽如归。——曹植《白马篇》
天下之事常成于困约，而败于奢靡。——陆游
知之者不如好之者，好之者不如乐之者。——《论语·雍也》
志当存高远。——诸葛亮《诫外生书》
不去庆父，鲁难未已。——《左传》
老吾老，以及人之老；幼吾幼，以及人之幼。——《孟子·梁惠王下》
博学之，审问之，慎思之，明辨之，笃行之。——《中庸》
人非圣贤，孰能无过。——《训俗遗规》
亦余心之所善兮，虽九死其犹未悔。——《屈原·离骚》
若要功夫深，铁杵磨成针。——曹学《蜀中广记·上川南道彭山县》
少壮不努力，老大徒悲伤。——汉乐府古辞《长歌行》
穷则独善其身，达则兼济天下。——《孟子·尽心上》
仁者见仁，智者见智。——《易经·系辞上》
青，取之于蓝而青于蓝；冰，水为之而寒于水。——《荀子·劝学》
千羊之皮，不如一狐之腋。——《史记》
余将董道而不豫兮，固将重昏而终身。——《屈原·涉江》
高山仰止，景行行止。——《诗经·小雅·车辖》
锲而舍之，朽木不折；锲而不舍，金石可镂。——《荀子·劝学》
不傲才以骄人，不以宠而作威。——诸葛亮
尺有所短；寸有所长。物有所不足；智有所不明。——屈原《卜居》
言必信，行必果。——《论语·子路》
有志者事竟成。——《后汉书·耿列传》
其身正，不令而行；其身不正，虽令不从。——论语·子路
三人行，必有我师焉：择其善而从之，其不善者而改之。——《论语·述而》
非学无以广才，非志无以成学。——《三国·诸葛亮·诫子书》
绳锯木断，水滴石穿。——罗大经《鹤林玉露》
君子坦荡荡，小人长戚戚。——孔子
老当益壮，宁知白首之心；穷且益坚，不坠青云之志。——王勃
尺有所短，寸有所长。——《史记》
他山之石，可以攻玉。——《诗经·小雅·鹤鸣》
苟余心之端直兮，虽僻远其何伤？——《屈原·涉江》
人有不为也，而后可以有为。——《孟子·离娄下》
路漫漫其修远今，吾将上下而求索。——屈原
孔子登东山而小鲁，登泰山而小天下。——《孟子·尽心上》
积土而为山，积水而为海。——《荀子·儒效》
生于忧患，死于安乐。——《孟子·告子下》
知足不辱，知止不殆。——老子
桃李不言，下自成蹊。——《史记》
傲不可长，欲不可纵，乐不可极，志不可满。——魏徵
既来之，则安之。——《论语·季氏》
知己知彼，百战不殆。——《孙子兵法·谋攻》
真者，精诚之至也，不精不诚，不能动人。——《庄子·渔夫》
独学而无友，则孤陋而寡闻。——《礼记·杂记》
勿以恶小而为之，勿以善小而不为。惟贤惟德，能服于人。——刘备";
    $poems = explode("\n", $poems);
    return $poems[rand(0, count($poems) - 1)];
}

/**
 * 从一篇文章中随机取一段话
 *
 * @return mixed
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function articl_random_says()
{
    $says = articl_random_str();
    return $says;
}

/**
 * 填充链接地址
 *
 * @param        $value
 * @param string $s_type
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function full_url($value, $s_type = 'oss')
{
    if (strpos($value, 'https://') !== false) {
        $res = $value;
    }
    elseif (strpos($value, 'http://') !== false) {
        $res = $value;
    }
    elseif (empty($value)) {
        $res = '';
    }
    else {
        $res = oss_host() . $value;
    }
    return $res;
}

/**
 * 正则从代码中提取图片
 *
 * @param $text
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function take_imgurl_by_preg($text)
{
    $images = [];
    if (preg_match_all('/< *img[^>]*src *= *["\']?([^"\']*)/i', $text, $img)) {
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
 * @param string $s_prefix
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function random_order_sn($s_prefix = '')
{

    /*方法1 一次性生成100条数据 效果很差*/
    //    $str = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);

    /*方法2 一次性生成100条数据 效果不错几乎没有重复 500也还好 1000几乎都会有几条重复数据*/
    $str = date('ymdhis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

    /*方法3 同方法2 效果差别不大*/
    //    $str = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'][intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
    return $s_prefix . $str;
}


/*生成唯一token*/
function make_unique_token($n_uid = 0, $n_length = 11)
{
    if ($n_uid == 0) {
        $n_uid = mt_rand(1, 9999999999);
    }
    $n_id           = str_pad($n_uid, $n_length, "0", STR_PAD_LEFT);
    $s_unique_token = rtrim(base64_encode(uniqid() . '_' . $n_id), '==');
    return $s_unique_token;
}

function str_upper_base64_md5($s_uniqid = '', $header = '')
{
    $result = $header . strtoupper(rtrim(base64_encode(md5($s_uniqid)), '=='));
    return $result;
}

