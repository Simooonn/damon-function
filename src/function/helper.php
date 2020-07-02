<?php


/**
 * 过滤字符串
 *
 * @param string $str
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function string_trim($str = '')
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
 * 错误消息
 *
 * @param string $msg
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function msg_error(string $msg)
{
    echo $msg;
    die;
}


/**
 * 时间秒转换成天、小时、分钟
 * hinq 2019 05 22
 *
 */
function time_to_date($time = '' )
{
    $d = floor($time / (3600*24));
    $h = floor(($time % (3600*24)) / 3600);
    $m = floor((($time % (3600*24)) % 3600) / 60);
    if($d>'0'){
        return $d.'天'.$h.'小时'.$m.'分';
    }else{
        if($h!='0'){
            return $h.'小时'.$m.'分';
        }else{
            return $m.'分';
        }
    }
}


/**
 * 后台跳转
 *
 * @param $result
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function echo_error($result)
{
    if ($result['state'] != 0) {
        msg_error($result['msg']);
    }
}

///字符串处理函数
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
function string_underline_to_hump($string,$ucfirst = true,$delimiters = '_')
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
function array_underline_to_hump($array,$ucfirst = true,$delimiters = '_')
{
    if(is_array($array)){
        foreach($array as $k => $v){
            $array[$k]
              = string_underline_to_hump($v,$ucfirst,$delimiters);
        }
    }

    return $array;
}


/**
 * 全国各地城市及车牌代码-字符串
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function plate_whole_str(){
    $str = '京-北京市-A 北京市 城区,B 北京市 出租车,C 北京市 城区,E 北京市 城区,F 北京市 城区,G 北京市 远郊区
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

    return $str;
}

/**
 * 全国各地城市及车牌代码-数组
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function plate_whole_array(){
    $s_plate_whole = plate_whole_str();

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
function plate_city($s_plate_no = ''){
    $s_first = mb_substr($s_plate_no,0,1);
    $s_second = strtoupper(mb_substr($s_plate_no,1,1));
    $arr_data = plate_whole_array();
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
    return $data;
}


function getDistance($lat1, $lng1, $lat2, $lng2){

    // 将角度转为狐度
    $radLat1 = deg2rad($lat1);// deg2rad()函数将角度转换为弧度
    $radLat2 = deg2rad($lat2);
    $radLng1 = deg2rad($lng1);
    $radLng2 = deg2rad($lng2);

    $a = $radLat1 - $radLat2;
    $b = $radLng1 - $radLng2;

    $s = 2 * asin(sqrt(pow(sin($a / 2), 2)+cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137;
    return (string) round( $s , 2);
}

/*********************************************** mysql数据库和视图函数 ***********************************************/

/**
 * 暴力创建视图
 *      如果视图已存在则覆盖
 *
 * @param string $table_name    视图名称 不含表前缀
 * @param string $sql           视图sql语句
 *
 * @return bool
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function wm_create_view_table($table_name = 'test',$sql = ''){
    $db_prefix = env('DB_PREFIX','');
    $result = DB::statement('CREATE OR REPLACE VIEW '.$db_prefix.$table_name.' AS '.$sql);
    return $result;
}

/**
 * 删除视图表
 *
 * @param string $table_name
 *
 * @return bool
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function wm_delete_view_table($table_name = 'test'){
    $db_prefix = env('DB_PREFIX','');
    $result = DB::statement('DROP VIEW '.$db_prefix.$table_name);
    return $result;
}

/***************************************************** 常用公共函数 *****************************************************/

function road_rescue_server_type(){
    $arr_list = [
      [
        'id' => 1,
        'name' => '抢修',
        'image' => '/admin/images/dljy/qiangxiu.png',
        'image_list' => '/admin/images/dljy/qiangxiu2.png'
      ],
      [
        'id' => 2,
        'name' => '换补胎',
        'image' => '/admin/images/dljy/buhuantai.png',
        'image_list' => '/admin/images/dljy/buhuantai2.png'
      ],
      [
        'id' => 3,
        'name' => '开锁',
        'image' => '/admin/images/dljy/kaisuo.png',
        'image_list' => '/admin/images/dljy/kaisuo2.png'
      ],
      [
        'id' => 4,
        'name' => '拖车牵引',
        'image' => '/admin/images/dljy/tuoche.png',
        'image_list' => '/admin/images/dljy/tuoche2.png'
      ],
      [
        'id' => 5,
        'name' => '送油',
        'image' => '/admin/images/dljy/jiayou.png',
        'image_list' => '/admin/images/dljy/jiayou2.png'
      ],
      [
        'id' => 6,
        'name' => '接电',
        'image' => '/admin/images/dljy/jiedian.png',
        'image_list' => '/admin/images/dljy/jiedian2.png'
      ],
      [
        'id' => 7,
        'name' => '救援',
        'image' => '/admin/images/dljy/jiuyuan.png',
        'image_list' => '/admin/images/dljy/jiuyuan2.png'
      ]
    ];
    return $arr_list;
}


/***************************************************** 支付比例函数 *****************************************************/


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

///**
// * 支付数据 分转换成元 1分=0.01元
// *
// * @param $fee
// *
// * @return string
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function number_format_fee($fee){
//    $pay_ratio = common_pay_ratio();
//    $money = $fee / 100 * $pay_ratio;//等比例扩大数据
//    return number_format_money($money);
//}

/***************************************************** 地图函数 *****************************************************/

function gaode_api_key(){
    $gaode_key = '7f4c1c8643860070335762bcc851ef69';
    return $gaode_key;
}

/*高德地图-地理编码-地址转经纬度*/
function gaode_api_address_to_location($s_address = '',$city = ''){
    $gaode_key = gaode_api_key();
    $url = 'https://restapi.amap.com/v3/geocode/geo?address='.$s_address.'&output=JSON&key='.$gaode_key.'&city='.$city;
    $result = curl_get($url);
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
        return  hello_success('查询成功',$data);
    }
    else{
        //查询失败
        $data = [
          'address'=>$s_address,
          'formatted_address'=>$s_formatted_address,
          'longitude'=>$s_longitude,
          'latitude'=>$s_latitude,
        ];

        return hello_error('查询失败',$data,$result['info']);

    }
}


/**
 * Created by PhpStorm.
 * User: wumengmeng <wu_mengmeng@foxmail.com>
 * Date: 2019/4/25 0025
 * Time: 17:46
 */








////////////////////////// 其他 模块 start





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

/**
 * 列表数组转换成键值对的一维数组
 *
 * @param array  $arr_list
 * @param string $s_value
 * @param string $s_key
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function list_array_to_key_value($arr_list = [], $s_value = 'name', $s_key = 'id')
{
    $arr_data = [];
    foreach ($arr_list as $value) {
        $arr_data[$value[$s_key]] = $value[$s_value];
    }
    return $arr_data;
}

/**
 * 将二维列表数组里的某个key对应的value拿出来，放到一维索引数组里
 *
 * @param array  $arr_list
 * @param string $s_value_key
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function arr_value_to_ids($arr_list = [], $s_value_key = 'name')
{
    $arr_data = [];
    foreach ($arr_list as $value) {
        $arr_data[$value[$s_value_key]] = $value[$s_value_key];
    }
    $arr_data = array_values($arr_data);
    return $arr_data;
}

/**
 * 一维数组键变成值
 *
 * @param array  $arr_list
 * @param string $s_value
 * @param string $s_key
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function arr_value_to_key($arr_list = [])
{
    $arr_data = [];
    foreach ($arr_list as $key => $value) {
        $arr_data[] = $key;
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
function ids_arr_to_string($arrIds = [], $s_expend = '', $s_mark = ',')
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
function ids_string_to_arr($s_Ids = '', $s_expend = '', $s_mark = ',')
{
    $res = [];
    if (!empty($s_Ids)) {
        $s_Ids = str_replace($s_expend, '', $s_Ids);
        $res   = explode($s_mark, $s_Ids);
    }
    return $res;
}

/**
 * 一维数组转为二维数组，同时给子数组添加特定索引
 *
 * @param array  $arr      一维数组
 * @param string $s_expend 特定字符
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function arr_one_to_two($arr = [], $s_expend = 'id', $arr_option = [])
{
    $arr_data = [];
    foreach ($arr as $key => $value) {
        $arr_data[] = [$s_expend => $value] + $arr_option;
    }
    return $arr_data;
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
function arr_value_add_string($arr = [], $s_expend = '', $s_location = 'pre')
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
 * 一维数组每个value值加上特定的字符-oss
 *
 * @param array $arr 一维数组
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function oss_arr_value_add_string($arr = [])
{
    foreach ($arr as $key => $value) {
        $arr[$key] = oss_full_url($value);
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
function arr_value_replace_string($arr = [], $s_expend = '', $s_replace = '')
{
    foreach ($arr as $key => $value) {
        $arr[$key] = str_replace($s_expend, $s_replace, $value);
    }
    return $arr;
}

/**
 * 数组重置 - 将键重置成索引的数组
 *
 * @param array $arr
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function arr_reset($arr = [])
{
    $arr_data = [];
    foreach ($arr as $key => $value) {
        $arr_data[] = $value;
    }
    return $arr_data;
}

/**
 * 友好返回错误信息
 *
 * @param string $s_msg
 * @param array  $arr_data
 * @param string $s_error
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function hello_error($s_msg = '', $arr_data = [], $s_error = '')
{
    return ['state' => 1, 'msg' => $s_msg, 'data' => $arr_data, 'error' => $s_error];
}

/**
 * 友好返回错误信息
 *
 * @param string $s_msg
 * @param array  $arr_data
 * @param string $s_error
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function hello_warning($s_msg = '', $n_state = 1, $arr_data = [], $s_error = '')
{
    return ['state' => $n_state, 'msg' => $s_msg, 'data' => $arr_data, 'error' => $s_error];
}

/**
 * 友好返回正确信息
 *
 * @param string $s_msg
 * @param array  $arr_data
 * @param string $s_error
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function hello_success($s_msg = '', $arr_data = [], $s_error = '')
{
    return ['state' => 0, 'msg' => $s_msg, 'data' => $arr_data, 'error' => $s_error];
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
function param_arr_to_url_str($arr_params = [], $type = true)
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
 * 路由全链接-参数路由别名
 *
 * @param string $name
 * @param array  $parameters
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function route_name_url($name = '', $parameters = [])
{
    $oc_route   = collect(cache_permission());
    $route_name = '';
    $res        = $oc_route->where('id', $name)
                           ->first()['route'];
    if (!is_null($res)) {
        $route_name = $res;
    }
    //    else{
    //        $res = $oc_route->where('route',$name)->first()['route'];
    //        if(!is_null($res)){
    //            $route_name = $res;
    //        }
    //    }
    $s_query_params = param_arr_to_url_str($parameters);
    return domain_host() . $route_name . $s_query_params;
}

/**
 * 主域名 host
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function domain_host()
{
    return 'http://' . $_SERVER['HTTP_HOST'] . '/';
}


/**
 * 列表查询数据转换成数组形式
 *
 * @param $data
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function list_page_data($data, $arr_search = [])
{
    $res      = $data->toarray();
    $arr_data = [
      'data'       => $res['data'],
      'page_data'  => [
        'current_page' => $res['current_page'],
        'last_page'    => $res['last_page'],
        'per_page'     => $res['per_page'],
        'total'        => $res['total'],
      ],
      'data_count' => count($res['data']),
      //      'total'=>$res['total'],
      'page_link'  => $data->links(),
      'arr_search' => $arr_search,
    ];

    return $arr_data;
}

/**
 * 列表查询数据转换成数组形式-for api
 *
 * @param $data
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function list_page_data_for_api($data, $arr_search = [])
{

    $arr_data = [
      'data_count' => count($data['data']),
      'page_data'  => [
        'current_page' => $data['current_page'],
        'last_page'    => $data['last_page'],
        'per_page'     => $data['per_page'],
        'total'        => $data['total'],
      ],
      'data'       => $data['data'],
      //      'arr_search'=>$arr_search,
    ];
    return $arr_data;
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
 * 事务开始
 *
 * @throws \Exception
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function shiwu_start()
{
    \Illuminate\Support\Facades\DB::beginTransaction();
}

/**
 * 事务结束
 *
 * @param $res
 *
 * @throws \Exception
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function shiwu_end($res)
{
    if ($res['state'] != 0) {
        \Illuminate\Support\Facades\DB::rollBack();
    }
    else {
        \Illuminate\Support\Facades\DB::commit();
    }
}





/**
 * 获取客户端IP地址
 *
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv  是否进行高级模式获取（有可能被伪装）
 *
 * @return mixed
 */
function get_client_ip($type = 0, $adv = false)
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

////////////////////////// 其他 模块 end


////////////////////////// 时间处理 模块 start


////////////////////////// 时间处理 模块 end


////////////////////////// 数字处理 模块 start

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


////////////////////////// 数字处理 模块 end


////////////////////////// 返回数据处理 模块 start

/**
 * 返回json响应
 *
 * @param array $data
 * @param int   $status
 * @param array $headers
 * @param int   $options
 *
 * @return \Illuminate\Http\JsonResponse
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function response_json($data = [], $status = 200, $headers = [], $options = 0)
{
    return response()->json($data, $status, $headers, $options);
}

////////////////////////// 返回数据处理 模块 end


////////////////////////// 待扩展 模块 start

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
 * oss 填充链接地址
 *
 * @param        $value
 * @param string $s_type
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function oss_full_url($value)
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
 * 本地 填充链接地址
 *
 * @param        $value
 * @param string $s_type
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function local_full_url($value)
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
        $res = domain_host() . $value;
    }
    return $res;
}

/**
 * 逗号分割的图片链接字符串处理成 特定格式的 数组
 *
 * @param $s_img
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function imgurl_string_to_format_array($s_img)
{
    $n_img_count            = 0;
    $s_img_default          = '';
    $arr_img_data_list      = [];
    $arr_img_base_data_list = [];
    if (!empty($s_img)) {
        $arr_img_base_data_list = explode(',', $s_img);
        $n_img_count            = count($arr_img_base_data_list);
        $s_img_default          = oss_full_url($arr_img_base_data_list[0]);
        $arr_img_data_list      = oss_arr_value_add_string($arr_img_base_data_list);
    }
    $arr_data = [
      'count'          => $n_img_count,
      'default'        => $s_img_default,
      'data_list'      => $arr_img_data_list,
      'base_data_list' => $arr_img_base_data_list,
    ];
    return $arr_data;
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
 * 树形数组转换成一维伪树形数组
 *
 * @param $data
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function tree_to_one_tree($data)
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


////////////////////////// 待扩展 模块 end


////////////////////////// 仅对本项目公共 模块 start


////////////////////////// 仅对本项目公共 模块 end


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




/**
 * 字符串过滤空格
 *
 * @param string $s_str
 *
 * @return string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function str_trim($s_str = '')
{
    $s_str = (!isset($s_str)) ? '' : trim($s_str);
    return $s_str;
}

/**
 * 过滤数组里的null字段，同时去掉字符串中的空格
 *
 * @param $arr_input
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function filter_input_data(&$arr_input)
{
    $arr_input = collect($arr_input)
      ->filter(function ($value) {
          if (!is_null($value)) {
              return $value;
          }

      })
      ->map(function ($value) {
          if (is_string($value)) {
              $value = str_trim($value);
          }
          return $value;

      })
      ->toArray();
}

/**
 * 求两个已知经纬度之间的距离
 *
 * @param int $longitude_start 起点经度
 * @param int $latitude_start  起点纬度
 * @param int $longitude_end   终点经度
 * @param int $latitude_end    终点纬度
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function location_distance($longitude_start = 0, $latitude_start = 0, $longitude_end = 0, $latitude_end = 0)
{

    $R = 6378.137;//地球半径

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

/*处理数组变成笛卡尔积*/
function combine_cartesian($data)
{
    $result = [];
    foreach (array_shift($data) as $k => $item) {
        $result[] = [$k => $item];
    }


    foreach ($data as $k => $v) {
        $result2 = [];
        foreach ($result as $k1 => $item1) {
            foreach ($v as $k2 => $item2) {
                $temp      = $item1;
                $temp[$k2] = $item2;
                $result2[] = $temp;
            }
        }
        $result = $result2;
    }
    return $result;
}

/**
 * 密码正则验证字符
 *
 * @param $password
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function preg_password($password, $type = 'simple')
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
        return hello_error($msg);
    }
    return hello_success('密码正则成功');
}

/**
 * 手机号正则验证字符
 *
 * @param $phone
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function preg_phone($phone)
{
    $rule = "/^1[3456789]\d{9}$/";
    $res  = preg_match_all($rule, $phone, $array);
    if (!$res) {
        return hello_error('手机号格式错误');
    }
    return hello_success('手机号正则成功');
}

////////////////////////// 日期处理函数 模块 start




////////////////////////// 日期处理函数 模块 end


////////////////////////// 密码相关函数 模块 start

/**
 * 判断密码安全级别
 *
 * @param $password
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function judge_password_safety($password)
{
    $score   = judge_password_score($password);
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
function judge_password_score($password = '')
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

////////////////////////// 密码相关函数 模块 end







