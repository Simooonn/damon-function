<?php
/**
 * Created by PhpStorm.
 * User: wumengmeng <wu_mengmeng@foxmail.com>
 * Date: 2020/6/30 0030
 * Time: 18:00
 */
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