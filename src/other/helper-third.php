<?php
///**
// * Created by PhpStorm.
// * User: wumengmeng <wu_mengmeng@foxmail.com>
// * Date: 2020/6/30 0030
// * Time: 18:00
// */
//
//////////////////////// 阿里云云市场api接口的Appcode
//
///**
// * APPCODE
// *
// * 阿里云云市场api接口
// *
// * @return string
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function alicloudapi_appcode()
//{
//    return env('ALICLOUDAPI_APPCODE', '');
//}
//
//
//////////////////////// 行驶证识别
//
///**
// * 天眼识别行驶证
// *
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function ocr_vehicle_for_tianyan($s_img)
//{
//    $host    = "http://vehicleocr.shumaidata.com";
//    $path    = "/vehicleocr";
//    $appcode = alicloudapi_appcode();
//    $headers = [];
//    array_push($headers, "Authorization:APPCODE " . $appcode);
//    //根据API的要求，定义相对应的Content-Type
//    //    array_push($headers, "Content-Type".":"."application/x-www-form-urlencoded; charset=UTF-8");
//    $url      = $host . $path;
//    $arr_data = [
//      'image' => $s_img
//    ];
//
//    $res    = curl_request_post($url, $arr_data, ['header' => $headers]);
//    $result = json_decode($res, true);
//    if ($result['success'] === true && $result['code'] == 200) {
//        $arr_data                  = $result['data']['result'];
//        $arr_data['brand_model']   = $arr_data['model'];
//        $arr_data['issue_date']    = str_replace('-', '', $arr_data['issue_date']);
//        $arr_data['register_date'] = str_replace('-', '', $arr_data['register_date']);
//        return hello_success('成功', $arr_data);
//    }
//    else {
//        if (empty($res)) {
//            return hello_warning('接口暂未开通', 999);
//
//        }
//
//        return hello_warning($result['msg'], $result['code']);
//    }
//}
//
//
//////////////////////// 快递查询
//
///**
// * 四川涪擎大数据-快递查询
// *
// * 阿里云市场（全国快递物流查询-快递查询接口） 四川涪擎大数据技术有限公司
// *
// * @param string $s_no
// * @param string $s_company_type
// * @param array  $arr_option
// *
// * @return bool|string
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function kuaidi_search($s_no = '', $s_company_type = '', $arr_option = [])
//{
//    $host    = "https://wuliu.market.alicloudapi.com";//api访问链接
//    $path    = "/kdi";//API访问后缀
//    $appcode = alicloudapi_appcode();//替换成自己的阿里云appcode
//    //    dd($appcode);
//    $headers = [];
//    array_push($headers, "Authorization:APPCODE " . $appcode);
//    //    if(strtoupper($s_company_type) == 'SFEXPRESS'){
//    //        if($s_phone == ''){
//    //            return json_encode(['status'=>999,'msg'=>'顺丰快递需要辅助手机号查询']);
//    //        }
//    //        $s_no = $s_no.':'.$s_phone;
//    //    }
//
//    $querys = "no=" . $s_no . "&type=" . $s_company_type;  //参数写在这里
//    $url    = $host . $path . "?" . $querys;//url拼接
//    $result = curl_get($url, ['header' => $headers]);
//    return $result;
//}
//
//
//////////////////////// 车型大全
//
///**
// * 极速数据-接口域名
// *
// * 阿里云市场（极速数据-车型大全接口）
// *
// * @return string
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function jisu_host()
//{
//    return "https://jisucxdq.market.alicloudapi.com";
//}
//
///**
// * 极速数据-车型大全-获取所有品牌接口
// *
// * 阿里云市场（极速数据-车型大全接口）
// *
// * @return bool|string
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function jisu_car_brand()
//{
//    $host    = jisu_host();
//    $path    = "/car/brand";
//    $appcode = alicloudapi_appcode();
//    $headers = [];
//    array_push($headers, "Authorization:APPCODE " . $appcode);
//    $url    = $host . $path;
//    $result = curl_get($url, ['header' => $headers]);
//    return $result;
//}
//
///**
// * 极速数据-车型大全-根据品牌获取所有车型接口
// *
// * 阿里云市场（极速数据-车型大全接口）
// *
// * @return bool|string
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function jisu_car_carlist($n_pid)
//{
//    $host    = jisu_host();
//    $path    = "/car/carlist";
//    $appcode = alicloudapi_appcode();
//    $headers = [];
//    array_push($headers, "Authorization:APPCODE " . $appcode);
//    $querys = "parentid=" . $n_pid;
//    $url    = $host . $path . "?" . $querys;
//    $result = curl_get($url, ['header' => $headers]);
//    return $result;
//
//}
//
///**
// * 极速数据-车型大全-根据ID获取车型详情接口
// *
// * 阿里云市场（极速数据-车型大全接口）
// *
// * @return bool|string
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function jisu_car_detail($n_carid)
//{
//    $host    = jisu_host();
//    $path    = "/car/detail";
//    $appcode = alicloudapi_appcode();
//    $headers = [];
//    array_push($headers, "Authorization:APPCODE " . $appcode);
//    $querys = "carid=" . $n_carid;
//    $url    = $host . $path . "?" . $querys;
//    $result = curl_get($url, ['header' => $headers]);
//    return $result;
//}
//
///**
// * 品牌获取所有车型树形数组转为列表数组
// *
// * @param $arr_model_tree
// *
// * @return array
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function vehicle_model_tree_to_list($arr_model_tree)
//{
//    $arr_list = [];
//    if (isset($arr_model_tree)) {
//        foreach ($arr_model_tree as $value) {
//            $arr_car = $value;
//            unset($arr_car['carlist']);
//            $arr_car['logo']            = '';
//            $arr_car['salestate']       = '';
//            $arr_car['yeartype']        = '';
//            $arr_car['productionstate'] = '';
//            $arr_car['sizetype']        = '';
//            $arr_list[]                 = $arr_car;
//            if (isset($value['carlist'])) {
//                foreach ($value['carlist'] as $vv) {
//                    $arr_car = $vv;
//                    unset($arr_car['list']);
//                    $arr_car['yeartype']        = '';
//                    $arr_car['productionstate'] = '';
//                    $arr_car['sizetype']        = '';
//                    $arr_list[]                 = $arr_car;
//                    if (isset($vv['list'])) {
//                        foreach ($vv['list'] as $vaa) {
//                            $arr_car             = $vaa;
//                            $arr_car['fullname'] = '';
//                            $arr_list[]          = $arr_car;
//                        }
//                    }
//
//                }
//            }
//        }
//    }
//    return $arr_list;
//}
//
///**
// * 创建车型大全表
// *
// * @param $s_full_table
// *
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function create_vehicle_model_table($s_full_table)
//{
//    $s_sql = "DROP TABLE IF EXISTS " . $s_full_table;
//    DB::statement($s_sql);
//    $s_sql = "CREATE TABLE `jinchen_car_test`.`" . $s_full_table . "`  (
//  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
//  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '名称',
//  `fullname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '全名',
//  `initial` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '首字母',
//  `parentid` int(11) NOT NULL DEFAULT 0 COMMENT '上级id',
//  `logo` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'logo',
//  `depth` tinyint(4) NOT NULL DEFAULT 100 COMMENT '深度 1品牌 2子公司 3车型 4具体车型',
//  `salestate` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '销售状态',
//  `price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '官方指导价',
//  `yeartype` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '年款',
//  `productionstate` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '生产状态',
//  `sizetype` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '尺寸类型',
//  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
//  `updated_at` timestamp(0) NULL DEFAULT NULL,
//  `deleted_at` timestamp(0) NULL DEFAULT NULL,
//  PRIMARY KEY (`id`) USING BTREE
//) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '车型大全表' ROW_FORMAT = Dynamic";
//    DB::statement($s_sql);
//}
//
///*更新车型大全数据*/
//function refresh_vehicle_model()
//{
//    try {
//        $s_prefix     = DB::getConfig('prefix');
//        $s_table      = 'vehicle_model';
//        $s_full_table = $s_prefix . $s_table;
//
//        //新建车型大全表
//        create_vehicle_model_table($s_full_table);
//        dd(9);
//
//        //接口查询数据 同时存入数据库
//        $res    = jisu_car_brand();
//        $result = json_decode($res, true);
//        if ($result['status'] != 0) {
//            return hello_error($result['msg']);
//        }
//
//        $arr_car_brand = $result['result'];
//        foreach ($arr_car_brand as $value) {
//            $res                      = jisu_car_carlist($value['id']);
//            $result                   = json_decode($res, true);
//            $value['salestate']       = '';
//            $value['yeartype']        = '';
//            $value['productionstate'] = '';
//            $value['sizetype']        = '';
//            $value['fullname']        = '';
//            $value['price']           = 0;
//
//            if ($result['status'] != 0) {
//                //                return hello_error($result['msg']);
//                $arr_car_list   = [];
//                $arr_car_list[] = $value;
//
//            }
//            else {
//
//                $arr_car_list   = vehicle_model_tree_to_list($result['result']);
//                $arr_car_list[] = $value;
//            }
//
//            //            \HiCommon\MongodbModel\MongoTest::insert($arr_car_list);
//            $res = \HiCommon\Model\CarModel::insert($arr_car_list);
//            if ($res === false) {
//                return hello_error('添加失败');
//            }
//            sleep(2);
//        }
//
//        return hello_success('添加成功');
//
//    } catch (\Exception $exception) {
//        return hello_error('失败', [], $exception->getMessage());
//    }
//
//}
//
//
//
//////////////////////////// 手机验证码 模块 start
//
///**
// * 发送验证码
// *
// * @param int    $mobile 手机号
// * @param int    $code   验证码
// * @param string $s_type 短信业务服务商
// *
// * @return array
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function send_code($mobile, int $code, $s_type = 'cr_cloud')
//{
//    switch ($s_type) {
//        case 'ihuyi':
//
//            /* 互亿无线 */
//            $arr_gets = send_code_by_ihuyi($mobile, $code);
//            if ($arr_gets['SubmitResult']['code'] == 2) {
//                $res = ['state' => 0, 'msg' => '发送成功', 'data' => [], 'error' => ''];
//            }
//            else {
//                $res = ['state' => 1, 'msg' => $arr_gets['SubmitResult']['msg'], 'data' => [], 'error' => ''];
//            }
//            break;
//
//        case 'cr_cloud':
//
//            /* 创瑞云 */
//            $re = send_code_by_cr_cloud($mobile, $code);
//            if ($re['code'] == 0) {
//                $res = ['state' => 0, 'msg' => '发送成功', 'data' => [], 'error' => ''];
//            }
//            else {
//                $res = ['state' => 1, 'msg' => $re['msg'], 'data' => [], 'error' => ''];
//            }
//            break;
//        default:
//            return [];
//    }
//
//    return $res;
//
//}
//
///**
// * 发送验证码-创瑞云
// *
// * @param int $mobile 手机号
// * @param int $code   验证码
// *
// * @return array
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function send_code_by_cr_cloud($mobile, int $code)
//{
//    /* 创瑞云 */
//    $config['cr_cloud_accesskey']   = config('system.sms.cr_cloud.cr_cloud_accesskey', 0);
//    $config['cr_cloud_secret']      = config('system.sms.cr_cloud.cr_cloud_secret', 0);
//    $config['cr_cloud_sign_id']     = 136169;  //32243
//    $config['cr_cloud_template_id'] = 49244;
//    $post_data                      = "accesskey=" . $config['cr_cloud_accesskey'] .
//      "&secret=" . $config['cr_cloud_secret'] .
//      "&sign=" . $config['cr_cloud_sign_id'] .
//      "&templateId=" . $config['cr_cloud_template_id'] .
//      "&mobile=" . $mobile .
//      "&content=" . rawurlencode($code);
//    $target                         = "http://api.1cloudsp.com/api/v2/single_send";
//    $re                             = curl_post($target, $post_data);
//    $re                             = json_decode($re, true);
//    return $re;
//}
//
///**
// * 发送验证码-互亿无线
// *
// * @param int $mobile 手机号
// * @param int $code   验证码
// *
// * @return array
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function send_code_by_ihuyi($mobile, int $code)
//{
//    $config['ihuyi_account'] = config('system.sms.ihuyi.ihuyi_account', 0);
//    $config['ihuyi_ps']      = config('system.sms.ihuyi.ihuyi_ps', 0);
//
//    $target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
//
//    $post_data = "account=" . $config['ihuyi_account'] . "&password=" . $config['ihuyi_ps'] . "&mobile=" . $mobile . "&content=" . rawurlencode("您的验证码是：" . $code
//        . "。请不要把验证码泄露给其他人。");
//
//    //密码可以使用明文密码或使用32位MD5加密
//    $arr_gets = xml_to_array(curl_post($target, $post_data));
//    return $arr_gets;
//}
//
///**
// * 发送手机号验证码-单个手机号
// *
// * @param $s_phone
// *
// * @return array
// * @throws \Exception
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function send_phone_code($s_phone)
//{
//    //查询短信剩余数量
//    $n_remain_num = intval(duanxin_num_get());
//    if ($n_remain_num <= 0) {
//        return hello_error('短信接口欠费');
//    }
//
//    $s_phone        = str_trim($s_phone);
//    $n_phone_length = strlen($s_phone);
//    if ($n_phone_length <= 0) {
//        return ['state' => 1, 'msg' => '手机号不能为空', 'data' => [], 'error' => ''];
//    }
//    if ($n_phone_length != 11) {
//        return ['state' => 1, 'msg' => '请输入11位手机号', 'data' => [], 'error' => ''];
//    }
//    $res = preg_phone($s_phone);
//    if ($res['state'] != 0) {
//        return $res;
//    }
//    //    $s_phone = (int)$s_phone;
//    $n_code = random_int(100000, 999999);//生成验证码
//    $result = send_code($s_phone, $n_code);
//    if ($result['state'] === 0) {
//        $s_key = redis_key_phone_code($s_phone);//创建redis验证码存储key
//        redis_string_set($s_key, $n_code, 5 * 60, 5);
//
//        //扣除短信数量
//        duanxin_num_deduct();
//
//        //TODO 正式上线时把数据返回的验证码去掉
//        //        return ['state'=>0,'msg'=>'发送成功','data'=>['code'=>$n_code],'error'=>''];
//        return ['state' => 0, 'msg' => '发送成功', 'data' => [], 'error' => ''];
//    }
//    return $result;
//}
//
///**
// * 生成手机验证码redis key值
// *
// * @param $s_phone
// *
// * @return mixed
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// *
// */
//function redis_key_phone_code($s_phone)
//{
//    return 'YZM_phone_code_' . $s_phone;
//}
//
///**
// * 获取redis里的手机验证码
// *
// * @param $s_phone
// *
// * @return mixed
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// *
// */
//function redis_phone_code($s_phone)
//{
//    return redis_string_get(redis_key_phone_code($s_phone), 5);
//}
//
///**
// * 销毁redis里的手机验证码
// *
// * @param $s_phone
// *
// * @return mixed
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// *
// */
//function unset_redis_phone_code($s_phone)
//{
//    return redis_string_del(redis_key_phone_code($s_phone), 5);
//}
//
///**
// * 验证手机验证码
// *
// * @param $s_phone
// * @param $code
// *
// * @return array
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function check_phone_code($s_phone, $s_code)
//{
//    //获取redis存储的手机验证码
//    $s_real_code = redis_phone_code($s_phone);
//
//    //查询手机验证码发送记录
//    $s_date    = time_to_ymdhis(time() - 30 * 60);
//    $arr_where = ['phone' => $s_phone];
//    $n_count   = HiCommon\MongodbModel\MongoPhoneCodeLog::where($arr_where)
//                                                        ->where('send_at', '>=', $s_date)
//                                                        ->count();
//    if ($n_count <= 0) {
//        return hello_error('请发送验证码');
//    }
//    if (empty($s_real_code)) {
//        return hello_error('验证码已过期');
//    }
//    if ($s_real_code != $s_code) {
//        return hello_error('验证码错误');
//    }
//    return ['state' => 0, 'msg' => '验证成功', 'data' => [], 'error' => ''];
//
//}
//
//
///*短信数量重置*/
//function duanxin_num_reset($n_num = 300)
//{
//    predis_hash_set('xinda', 'duanxin_remain_num', $n_num);
//
//}
//
///*短信充值*/
//function duanxin_num_recharge($n_num = 0)
//{
//    return predis_hash_key_increment('xinda', 'duanxin_remain_num', $n_num);
//}
//
///*短信扣除*/
//function duanxin_num_deduct($n_num = 1)
//{
//    return predis_hash_key_decrement('xinda', 'duanxin_remain_num', $n_num);
//}
//
///*短信剩余数量*/
//function duanxin_num_get()
//{
//
//    $result = predis_hash_get('xinda', 'duanxin_remain_num');
//    return $result;
//}
//
//////////////////////////// 手机验证码 模块 end
//
//
//
//
//
///**
// *  获取交管局接口
// *
// *
// **/
//function jisuapi_api_url_carorg()
//{
//    return "https://api.jisuapi.com/illegal/carorg2?appkey=" . config('system.jssj_app_key');
//}
//
///**
// *  获取车牌类型接口
// *
// **/
//function jisuapi_api_url_lstype()
//{
//    return "https://api.jisuapi.com/illegal/lstype?appkey=" . config('system.jssj_app_key');
//}
//
///**
// *  违章查询接口
// *
// **/
//function jisuapi_api_url_illegal()
//{
//    return "https://api.jisuapi.com/illegal/query?appkey=" . config('system.jssj_app_key');
//}
//
///**
// *  违章代办提交接口
// *
// **/
//function jisuapi_api_url_entrust()
//{
//    return "https://api.jisuapi.com/illegalhandle/handle?appkey=" . config('system.jssj_app_key');
//}
//
///**
// *  违章代办提交接口
// *
// **/
//function jisuapi_api_url_entrust_list()
//{
//    return "https://api.jisuapi.com/illegalhandle/orderlist?appkey=" . config('system.jssj_app_key');
//}
//
//
//////////////////////////////百度云
//
///**
// * 行驶证-图文识别
// *
// * @param string $s_img
// * @param string $s_type
// *
// * @return bool|mixed|string
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function cloud_orc_vehicle_license($s_img = '', $s_type = 'tianyan')
//{
//    //    $s_img = base64_img();
//    $arr_img    = explode('base64,', $s_img);
//    $s_deal_img = $arr_img[1];
//    switch ($s_type) {
//        case 'baidu_cloud':
//            $res = ocr_vehicle_for_baidu($s_deal_img);
//            break;
//        case 'tianyan':
//            $res = ocr_vehicle_for_tianyan($s_img);
//            break;
//
//        default:
//            $res = ['state' => 1, 'msg' => '未知错误'];
//    }
//
//    return $res;
//
//}
//
///**
// * 百度云 图文识别获取access_token
// *
// * @return false|mixed|string
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function cloud_baidu_ocr_oauth_token()
//{
//    $arr_third_config           = third_config();
//    $url                        = 'https://aip.baidubce.com/oauth/2.0/token';
//    $post_data['grant_type']    = 'client_credentials';
//    $post_data['client_id']     = $arr_third_config['cloud_baidu_ocr']['api_key'];
//    $post_data['client_secret'] = $arr_third_config['cloud_baidu_ocr']['secret_key'];
//    $res                        = curl_post($url, $post_data);
//    $res                        = json_decode($res, true);
//    return $res;
//}
//
///**
// * 百度云-自动识别机动车行驶证
// *
// * @param string $s_img
// *
// * @return bool|mixed|string
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function ocr_vehicle_for_baidu($s_img = '')
//{
//    $arr_access_token = cloud_baidu_ocr_oauth_token();
//    $access_token     = $arr_access_token['access_token'];
//    $api              = 'https://aip.baidubce.com/rest/2.0/ocr/v1/vehicle_license?access_token=' . $access_token;
//    //    $header = ['Content-Length: application/x-www-form-urlencoded'];
//    $post = [
//      'image'                => $s_img,
//      'detect_direction'     => 'true',
//      'accuracy'             => 'normal',
//      'vehicle_license_side' => 'front',
//    ];
//    $res  = curl_post($api, $post);
//    $res  = json_decode($res, true);
//    if ($res['words_result_num'] > 0) {
//        $data     = $res['words_result'];
//        $arr_data = [
//          'plate_no'      => $data['号牌号码']['words'],
//          'vin'           => $data['车辆识别代号']['words'],
//          'vehicle_type'  => $data['车辆类型']['words'],
//          'owner'         => $data['所有人']['words'],
//          'address'       => $data['住址']['words'],
//          'use_character' => $data['使用性质']['words'],
//          'brand_model'   => $data['品牌型号']['words'],
//          'engine_no'     => $data['发动机号码']['words'],
//          'register_date' => $data['注册日期']['words'],
//          'issue_date'    => $data['发证日期']['words'],
//        ];
//        return hello_success('成功', $arr_data);
//    }
//    else {
//        return hello_error($res['error_msg'], [], $res['error_code']);
//    }
//}
//
//
//////////////////////////////微信小程序
//
///**
// * 获取微信小程序配置
// *
// * @return mixed
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function small_wechat_congfig()
//{
//    return third_config()['wechat_mini_program'];
//}
//
///**
// * 对微信小程序用户加密数据的解密示例代码
// *
// * 检验数据的真实性，并且获取解密后的明文.
// *
// * @param $encryptedData string 加密的用户数据
// * @param $iv            string 与用户数据一同返回的初始向量
// * @param $data          string 解密后的原文
// *
// * @return array 成功0，失败返回对应的错误码
// * @author wumengmeng <wu_mengmeng@foxmail.com>
// */
//function small_wechat_biz_data_crypt($sessionKey, $encryptedData, $iv, &$data)
//{
//    $appid = third_config()['wechat_mini_program']['app_id'];
//
//    /**
//     * error code 说明.
//     * <ul>
//     *    <li>-41001: encodingAesKey 非法</li>
//     *    <li>-41002: iv 非法</li>
//     *    <li>-41003: aes 解密失败</li>
//     *    <li>-41004: 解密后得到的buffer非法</li>
//     *    <li>-41005: base64加密失败</li>
//     *    <li>-41016: base64解密失败</li>
//     * </ul>
//     */
//
//    //      $sessionKey = stripslashes($sessionKey);
//    if (strlen($sessionKey) != 24) {
//        return hello_error('encodingAesKey 非法', [], '-41001');
//    }
//    $aesKey = base64_decode($sessionKey);
//
//
//    if (strlen($iv) != 24) {
//        return hello_error('iv 非法', [], '-41002');
//    }
//    $aesIV     = base64_decode($iv);
//    $aesCipher = base64_decode($encryptedData);
//    $result    = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
//    $dataObj   = json_decode($result);
//    if ($dataObj == null) {
//        return hello_error('网络不好，请重新登录', [], '-41003');
//        //          return hello_error('aes 解密失败',[],'-41003');
//    }
//    if ($dataObj->watermark->appid != $appid) {
//        return hello_error('网络不好，请重新登录', [], '-41003');
//        //          return hello_error('aes 解密失败',[],'-41003');
//    }
//    $data = $result;
//    return hello_success('成功', [], 0);
//}