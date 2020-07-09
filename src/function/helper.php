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




/************************************** 环境配置变量处理 **************************************/

/**
 * 读取配置文件
 *
 * @param $resoure
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_read_ini_file($resoure){

    $str_ini = file_get_contents($resoure);
    $arr_ini = explode("\n", $str_ini);
    $arr_data = [];
    $s_prifx = '';
    foreach ($arr_ini as $key=>$value)
    {
        $value = trim($value);
        if(!empty($value)){
            if (strpos($value, '[') !== false) {

                $s_prifx = trim(str_replace(['[',']','\'',"\n",'"'], '', $value));
            }
            else{
                $arr_value = explode('=',$value);

                $s_env_key = trim($arr_value[0]);
                $s_env_value = trim($arr_value[1]);


                if($s_prifx == ''){
                    $arr_data[$s_env_key] = $s_env_value;
                }
                else{
                    $arr_data[$s_prifx][$s_env_key] = $s_env_value;

                }

            }
        }




    }
    return $arr_data;
}

/**
 * 加载配置文件
 *
 * @param $resoure
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_load_ini_file($resoure){
    if (is_file($resoure)) {
        $env = parse_ini_file($resoure, true);
        $arr_read_env = yoo_read_ini_file($resoure);
        foreach ($env as $key => $val) {
            $name =  $key;
            if (is_array($val)) {
                //2级配置
                foreach ($val as $k => $v) {
                    $item = $name . '.' . $k;
                    switch ($v)
                    {
                        case '':
                            $v = $arr_read_env[$key][$k];
                            break;
                        case 1:
                            $v = $arr_read_env[$key][$k];
                            break;
                        default:
                    }

                    putenv("$item=$v");
                }
            }
            else {
                //1级配置
                switch ($val)
                {
                    case '':
                        $val = $arr_read_env[$key];
                        break;
                    case 1:
                        $val = $arr_read_env[$key];
                        break;
                    default:
                }
                putenv("$name=$val");
            }
        }
    }

}

if (! function_exists('env')) {
    /**
     * 获取环境配置变量
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);
        if($value !== false){
            //删除字符串两边的 " 和 '
            $result = trim( trim($value,"'"),'"');
        }
        else{
            $result = $default;
        }

        switch (strtolower($result)) {
            case 'true':
                return true;
            case '(true)':
                return true;
            case 'false':
                return false;
            case '(false)':
                return false;
            case 'empty':
                return '';
            case '(empty)':
                return '';
            case 'null':
                return null;
            case '(null)':
                return null;
        }
        return $result;
    }
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
      'data'       => $arr_result,
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
      'data'       => $arr_result,
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
      'data'       => $arr_result,
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




/************************************** 车牌号 **************************************/

/**
 * 全国各地城市及车牌代码-数组
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_plate_no(){
    $s_plate_whole = '京-北京市-A 北京市 城区,B 北京市 出租车,C 北京市 城区,E 北京市 城区,F 北京市 城区,G 北京市 远郊区
津-天津市-A 天津市 天津市,B 天津市 天津市,C 天津市 天津市,E 天津市 出租车
沪-上海市-A 上海市 市区,B 上海市 市区,C 上海市 远郊区,D 上海市 市区
渝-重庆市-A 重庆市 市区（江南）,B 重庆市 市区（江北）,C 重庆市 永川区,F 重庆市 万州区,G 重庆市 涪陵区,H 重庆市 黔江区
冀-河北省-A 石家庄 石家庄,B 唐山 唐山,C 秦皇岛 秦皇岛,D 邯郸 邯郸,E 邢台 邢台,F 保定 保定,G 张家口 张家口,H 承德 承德,J 沧州 沧州,R 廊坊 廊坊,T 衡水 衡水
豫-河南省-A 郑州 郑州,B 开封 开封,C 洛阳 洛阳,D 平顶山 平顶山,E 安阳 安阳,F 鹤壁 鹤壁,G 新乡 新乡,H 焦作 焦作,J 濮阳 濮阳,K 许昌 许昌,L 漯河 漯河,M 三门峡 三门峡,N 商丘 商丘,P 周口 周口,Q 驻马店 驻马店,R 南阳 南阳,S 信阳 信阳,U 济源 济源
云-云南省-A 昆明 昆明,B 东川 东川,C 昭通 昭通,D 曲靖 曲靖,E 楚雄彝族 楚雄彝族,F 玉溪 玉溪,G 红河哈尼族 红河哈尼族,H 文山壮族苗 文山壮族苗,J 思茅 思茅,L 大理白族 大理白族,K 西双版纳 西双版纳,M 保山 保山,N 德宏傣族 德宏傣族,P 丽江 丽江,Q 怒江傈族 怒江傈族,R 迪庆藏族 迪庆藏族,S 临沧 临沧
辽-辽宁省-A 沈阳 沈阳,B 大连 大连,C 鞍山 鞍山,D 抚顺 抚顺,E 本溪 本溪,F 丹东 丹东,G 锦州 锦州,H 营口 营口,J 阜新 阜新,K 辽阳 辽阳,L 盘锦 盘锦,M 铁岭 铁岭,N 朝阳 朝阳,P 葫芦岛 葫芦岛,V 省直机关 省直机关
黑-黑龙江省-A 哈尔滨 哈尔滨,B 齐齐哈尔 齐齐哈尔,C 牡丹江 牡丹江,D 佳木斯 佳木斯,E 大庆 大庆,F 伊春 伊春,G 鸡西 鸡西,H 鹤岗 鹤岗,J 双鸭山 双鸭山,K 七台河 七台河,L 松花江行署 松花江行署,M 绥化 绥化,N 黑河 黑河,P 大兴安岭 大兴安岭
湘-湖南省-A 长沙 长沙,B 株洲 株洲,C 湘潭 湘潭,D 衡阳 衡阳,E 邵阳 邵阳,F 岳阳 岳阳,G 大庸 大庸,H 益阳 益阳,J 常德 常德,K 娄底 娄底,L 郴州 郴州,M 零陵 零陵,N 怀化 怀化,P 湘西州 湘西州
皖-安徽省-A 合肥 合肥,B 芜湖 芜湖,C 蚌埠 蚌埠,D 淮南 淮南,E 马鞍山 马鞍山,F 淮北 淮北,G 铜陵 铜陵,H 安庆 安庆,J 黄山 黄山,K 阜阳 阜阳,L 宿州 宿州,M 滁州 滁州,N 六安 六安,P 宣城 宣城,Q 巢湖 巢湖,R 池州 池州
鲁-山东省-A 济南 济南,B 青岛 青岛,C 淄博 淄博,D 枣庄 枣庄,E 东营 东营,F 烟台 烟台,G 潍坊 潍坊,H 济宁 济宁,J 泰安 泰安,K 威海 威海,L 日照 日照,M 莱芜 莱芜,N 德州 德州,P 聊城 聊城,Q 临沂 临沂,R 荷泽 荷泽,U 青岛开发区 青岛开发区
新-新疆维吾尔-A 乌鲁木齐 乌鲁木齐,B 昌吉回族 昌吉回族,C 石河子 石河子,D 奎屯 奎屯,E 博尔塔拉 博尔塔拉,F 伊犁哈萨 伊犁哈萨,G 塔城 塔城,H 阿勒泰 阿勒泰,J 克拉玛依 克拉玛依,K 吐鲁番 吐鲁番,L 哈密 哈密,M 巴音郭愣 巴音郭愣,N 阿克苏 阿克苏,P 克孜勒苏柯 克孜勒苏柯,Q 喀什 喀什,R 和田 和田
苏-江苏省-A 南京 南京,B 无锡 无锡,C 徐州 徐州,D 常州 常州,E 苏州 苏州,F 南通 南通,G 连云港 连云港,H 淮阴 淮阴,J 盐城 盐城,K 扬州 扬州,L 镇江 镇江,M 泰州 泰州,N 宿迁 宿迁
浙-浙江省-A 杭州 杭州,B 宁波 宁波,C 温州 温州,D 绍兴 绍兴,E 湖州 湖州,F 嘉兴 嘉兴,G 金华 金华,H 衢州 衢州,J 台州 台州,K 丽水 丽水,L 舟山 舟山
赣-江西省-A 南昌 南昌,B 赣州 赣州,C 宜春 宜春,D 吉安 吉安,E 上饶 上饶,F 抚州 抚州,G 九江 九江,H 景德镇 景德镇,J 萍乡 萍乡,K 新余 新余,L 鹰潭 鹰潭
鄂-湖北省-A 武汉 武汉,B 黄石 黄石,C 十堰 十堰,D 沙市 沙市,E 宜昌 宜昌,F 襄樊 襄樊,G 鄂州 鄂州,H 荆门 荆门,J 黄岗 黄岗,K 孝感 孝感,L 咸宁 咸宁,M 荆州 荆州,N 郧阳 郧阳,P 宜昌 宜昌,Q 鄂西州 鄂西州
桂-广西壮族-A 南宁 南宁,B 柳州 柳州,C 桂林 桂林,D 梧州 梧州,E 北海 北海,F 南宁 南宁,G 柳州 柳州,H 桂林 桂林,J 梧州 梧州,K 玉林 玉林,M 河池 河池,L 百色 百色,N 钦州 钦州,P 防城 防城
甘-甘肃省-A 兰州 兰州,B 嘉峪关 嘉峪关,C 金昌 金昌,D 白银 白银,E 天水 天水,F 酒泉 酒泉,G 张掖 张掖,H 武威 武威,J 定西 定西,K 陇南 陇南,L 平凉 平凉,M 庆阳 庆阳,N 临夏回族 临夏回族,P 甘南藏族 甘南藏族
晋-山西省-A 太原 太原,B 大同 大同,C 阳泉 阳泉,D 长治 长治,E 晋城 晋城,F 朔州 朔州,H 忻州 忻州,J 吕梁 吕梁,K 晋中 晋中,L 临汾 临汾,M 运城 运城
蒙-内蒙古-A 呼和浩特 呼和浩特,B 包头 包头,C 乌海 乌海,D 赤峰 赤峰,E 呼伦贝尔盟 呼伦贝尔盟,F 兴安盟 兴安盟,G 锡林郭勒盟 锡林郭勒盟,H 乌兰察布盟 乌兰察布盟,J 伊克昭盟 伊克昭盟,K 巴彦淖尔盟 巴彦淖尔盟,L 阿拉善盟 阿拉善盟
陕-陕西省-A 西安 西安,B 铜川 铜川,C 宝鸡 宝鸡,D 威阳 威阳,E 渭南 渭南,F 汉中 汉中,G 安康 安康,H 商洛 商洛,J 延安 延安,K 榆林 榆林,U 省直机关 省直机关
吉-吉林省-A 长春 长春,B 吉林 吉林,C 四平 四平,D 辽源 辽源,E 通化 通化,F 白山 白山,G 白城 白城,H 延边朝鲜族 延边朝鲜族
闽-福建省-A 福州 福州,B 莆田 莆田,C 泉州 泉州,D 厦门 厦门,E 漳州 漳州,F 龙岩 龙岩,G 三明 三明,H 南平 南平,J 宁德 宁德,K 省直机关 省直机关
贵-贵州省-A 贵阳 贵阳,B 六盘水 六盘水,C 遵义 遵义,D 铜仁 铜仁,E 黔西南州 黔西南州,F 毕节 毕节,G 安顺 安顺,H 黔东南州 黔东南州,J 黔南州 黔南州
粤-广东省-A 广州 广州,B 深圳 深圳,C 珠海 珠海,D 汕头 汕头,E 佛山 佛山,F 韶关 韶关,G 湛江 湛江,H 肇庆 肇庆,J 江门 江门,K 茂名 茂名,L 惠州 惠州,M 梅州 梅州,N 汕尾 汕尾,P 河源 河源,Q 阳江 阳江,R 清远 清远,S 东莞 东莞,T 中山 中山,U 潮州 潮州,V 揭阳 揭阳,W 云浮 云浮,X 顺德 顺德,Y 南海 南海,Z 港澳进入内地车辆 港澳进入内地车辆
青-青海省-A 西宁 西宁,B 海东 海东,C 海北 海北,D 黄南 黄南,E 海南州 海南州,F 果洛州 果洛州,G 玉树州 玉树州,H 海西州 海西州
藏-西藏-A 拉萨 拉萨,B 昌都 昌都,C 山南 山南,D 日喀则 日喀则,E 那曲 那曲,F 阿里 阿里,G 林芝 林芝
川-四川省-A 成都 成都,B 绵阳 绵阳,C 自贡 自贡,D 攀枝花 攀枝花,E 泸州 泸州,F 德阳 德阳,H 广元 广元,J 遂宁 遂宁,K 内江 内江,L 乐山 乐山,Q 宜宾 宜宾,R 南充 南充,S 达县 达县,T 雅安 雅安,U 阿坝藏族 阿坝藏族,V 甘孜藏族 甘孜藏族,W 凉山彝族 凉山彝族
宁-宁夏回族-A 银川 银川,B 石嘴山 石嘴山,C 银南 银南,D 固原 固原
琼-海南省-A 海口 海口,B 三亚 三亚,C 琼北 琼北';

    $arr_plate_whole = explode("\r\n",$s_plate_whole);
    $arr_data = [];
    foreach ($arr_plate_whole as $value)
    {
        $province = explode("-",$value);
        $city = explode(",",$province[2]);
        $arr_child = [];
        foreach ($city as $vv)
        {
            $vv = explode(" ",$vv);
            $arr_child[] =  [
              'initial'=>$vv[0],
              'city'=>$vv[1],
              'info'=>$vv[2],
            ];
        }
        $arr_data[] = [
          'plate'=>$province[0],
          'province'=>$province[1],
          'child'=>$arr_child,
        ];

    }

    return $arr_data;
}

/**
 * 根据车牌号识别省市信息
 *
 * @param string $s_plate_no
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_plate_no_city($s_plate_no = ''){

    $s_first = mb_substr($s_plate_no,0,1);
    $s_second = strtoupper(mb_substr($s_plate_no,1,1));
    $arr_data = yoo_plate_no();
    $data = [];
    $data['plate'] = '';
    $data['province'] = '';
    $data['initial'] = '';
    $data['city'] = '';
    $data['info'] = '';
    foreach ($arr_data as $value)
    {
        if($s_first == $value['plate']){
            $data['plate'] = $value['plate'];
            $data['province'] = $value['province'];

            foreach ($value['child'] as $vv)
            {
                if($s_second == $vv['initial']){
                    $data['initial'] = $vv['initial'];
                    $data['city'] = $vv['city'];
                    $data['info'] = $vv['info'];
                }
                $arrIDs[] = $value;
            }
        }
    }
    return $data;
/*
    $s_first = mb_substr($s_plate_no,0,1);
    $s_second = strtoupper(mb_substr($s_plate_no,1,1));
    $arr_data = yoo_plate_no();

    $province = collect($arr_data)->where('plate',$s_first)->first();
    $data = [];
    $data['plate'] = '';
    $data['province'] = '';
    $data['initial'] = '';
    $data['city'] = '';
    $data['info'] = '';
    if (!is_null($province)){
        $data['plate'] = $province['plate'];
        $data['province'] = $province['province'];

        $city = collect($province['child'])->where('initial',$s_second)->first();
        if (!is_null($city)){
            $data['initial'] = $city['initial'];
            $data['city'] = $city['city'];
            $data['info'] = $city['info'];
        }
    }
    return $data;*/
}




/************************************** curl **************************************/

/**
 * xml转数组
 *
 * @param $xml
 *
 * @return mixed
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_xml_to_array($xml)
{
    $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
    if (preg_match_all($reg, $xml, $matches)) {
        $count = count($matches[0]);
        for ($i = 0; $i < $count; $i++) {
            $subxml = $matches[2][$i];
            $key    = $matches[1][$i];
            if (preg_match($reg, $subxml)) {
                $arr[$key] = yoo_xml_to_array($subxml);
            }
            else {
                $arr[$key] = $subxml;
            }
        }
    }
    return $arr;
}

/**
 * 数组形式的链接参数转换成字符串形式
 *
 * @param array $arr_params
 * @param bool  $type true 带? false 不带?
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_param_str($arr_params = [], $type = true)
{
    $s_query_params = '';
    foreach ($arr_params as $key => $value) {
        $param = $key . '=' . $value;
        if (empty($s_query_params)) {
            $s_query_params = $param;
        }
        else {
            $s_query_params .= '&' . $param;
        }
        if ($type) {
            $s_query_params = '?' . $s_query_params;
        }
    }
    return $s_query_params;
}

/**
 * curl get提交数据发送请求
 *
 * @param string $url
 * @param array  $data
 * @param array  $arr_option
 *
 * @return bool|string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_curl_get($url = '', $data = [], $arr_option = [])
{

    $url = $url.yoo_param_str($data);

    $curl = curl_init();
    //    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);//需要获取的URL地址，也可以在PHP的curl_init()函数中设置
    if (isset($arr_option['header'])) {
        $headers = $arr_option['header'];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);//设置一个header中传输内容的数组。
    }
    curl_setopt($curl, CURLOPT_FAILONERROR, false);//显示HTTP状态码，默认行为是忽略编号小于等于400的HTTP信息
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//设定是否显示头信息
    //    curl_setopt($curl, CURLOPT_HEADER, true);//启用时会将头文件的信息作为数据流输出。

    /*最后发现自己调用的api的接口地址是ssl协议的，然后加上下面两个就可以了 - 即https*/
    if (1 == strpos("$" . $url, "https://")) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }

    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

/**
 * curl post提交数据发送请求
 *
 * @param string $url
 * @param string $data
 * @param array  $arr_option
 *
 * @return bool|string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_curl_post($url = '', $data = [], $arr_option = [])
{
    if (empty($url) || empty($post_data)) {
        return false;
    }
    $curl = curl_init();
    //    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_POST, true); //设置POST请求

    curl_setopt($curl, CURLOPT_URL, $url);
    if (isset($arr_option['header'])) {
        $headers = $arr_option['header'];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);//设置一个header中传输内容的数组。
    }
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_NOBODY, true);

    /*最后发现自己调用的api的接口地址是ssl协议的，然后加上下面两个就可以了*/
    if (1 == strpos("$" . $url, "https://")) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);// 信任任何证书
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_TIMEOUT, (int)40);
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

/**
 * 远程文件下载
 *
 * @param string $url           远程文件地址
 * @param string $file_path     本地保存路径
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_curl_download($url = '', $file_path = '')
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    $file = curl_exec($ch);
    curl_close($ch);

    $file_name = date('ymdhis').'_'.uniqid();
    $tmp_file_name = $file_path.$file_name;

    file_put_contents($tmp_file_name, $file);
    //    $resource = file_put_contents($absolute_path, $file);
    //    fwrite($resource, $file);
    //    fclose($resource);
}



/************************************** 地图函数 **************************************/

/*高德地图-地理编码-地址转经纬度*/
function yoo_api_gaode_geocode($s_address = '',$city = ''){
    $gaode_key = env('GAODE_API_KEY','7f4c1c8643860070335762bcc851ef69');
    $url = 'https://restapi.amap.com/v3/geocode/geo?address='.$s_address.'&output=JSON&key='.$gaode_key.'&city='.$city;
    $result = yoo_curl_get($url);
    $result = json_decode($result,true);

    $s_formatted_address = '北京天安门';
    $s_longitude = '116.403694';
    $s_latitude = '39.914714';

    if($result['status'] == 1 && $result['count'] > 0){
        $arr_location = explode(',',$result['geocodes'][0]['location']);

        //查询成功
        $data = [
          'address'=>$s_address,
          'formatted_address'=>$result['geocodes'][0]['formatted_address'],
          'longitude'=>$arr_location[0],
          'latitude'=>$arr_location[1],
        ];
        return  yoo_hello_success('查询成功',$data);
    }
    else{
        //查询失败
        $data = [
          'address'=>$s_address,
          'formatted_address'=>$s_formatted_address,
          'longitude'=>$s_longitude,
          'latitude'=>$s_latitude,
        ];

        return yoo_hello_fail('查询失败',$result['info'],$data);

    }
}


/**
 * 计算两个经纬度之间的距离
 *
 * @param int $longitude_start 起点经度
 * @param int $latitude_start  起点纬度
 * @param int $longitude_end   终点经度
 * @param int $latitude_end    终点纬度
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function yoo_location_distance($longitude_start = 0, $latitude_start = 0, $longitude_end = 0, $latitude_end = 0)
{

    $R = 6378.137;//地球半径 单位千米

    //方法1
    $rad_lat_start = deg2rad($latitude_start); //deg2rad()函数将角度转换为弧度
    $rad_lat_end   = deg2rad($latitude_end);
    $rad_lon_start = deg2rad($longitude_start);
    $rad_lon_end   = deg2rad($longitude_end);
    $x_lat         = $rad_lat_start - $rad_lat_end;
    $x_lon         = $rad_lon_start - $rad_lon_end;
    $result        = 2 * asin(sqrt(pow(sin($x_lat / 2), 2) + cos($rad_lat_start) * cos($rad_lat_end) * pow(sin($x_lon / 2), 2))) * $R;
    $n_mi          = number_format($result * 1000, 0, '', '');

    $n_km = number_format($result, 2);
    if ($n_mi >= 1000) {
        $s_default    = $n_km . '公里';
        $s_en_default = $n_km . 'km';
    }
    else {
        $s_default    = $n_mi . '米';
        $s_en_default = $n_mi . 'm';
    }
    return ['m' => $n_mi, 'km' => $n_km, 'default' => $s_default, 'en_default' => $s_en_default];


    /* //方法2
     $lon_x = $longitude_start - $longitude_end;
     $lat_x = $latitude_start - $latitude_end;
     $rad_lon_x = pow(sin(pi()*($lon_x)/360),2);
     $rad_lat_x = pow(sin(pi()*($lat_x)/360),2);
     $rad_lan_s = cos(pi()*$latitude_start/180);
     $rad_lan_e = cos($latitude_end * pi()/180);
     $result = 2 * $R * asin(sqrt($rad_lon_x + $rad_lan_s * $rad_lan_e *$rad_lat_x));
     $n_mi = number_format($result*1000,2);
     $n_km = number_format($result,2);
     return ['m'=>$n_mi,'km'=>$n_km];*/
}

