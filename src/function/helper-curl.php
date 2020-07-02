<?php
/**
 * Created by PhpStorm.
 * User: wumengmeng <wu_mengmeng@foxmail.com>
 * Date: 2020/6/30 0030
 * Time: 18:00
 */

/**
 * xml转数组
 *
 * @param $xml
 *
 * @return mixed
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function xml_to_array($xml)
{
    $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
    if (preg_match_all($reg, $xml, $matches)) {
        $count = count($matches[0]);
        for ($i = 0; $i < $count; $i++) {
            $subxml = $matches[2][$i];
            $key    = $matches[1][$i];
            if (preg_match($reg, $subxml)) {
                $arr[$key] = xml_to_array($subxml);
            }
            else {
                $arr[$key] = $subxml;
            }
        }
    }
    return $arr;
}


/**
 * curl get提交数据发送请求
 *
 * @param $curlPost
 * @param $url
 *
 * @return bool|string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function curl_request($url = '', $arr_option = [])
{
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
 * curl get提交数据发送请求
 *
 * @param $curlPost
 * @param $url
 *
 * @return bool|string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function curl_get($url = '', $arr_option = [])
{
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
 * curl get提交数据发送请求
 *
 * @param $curlPost
 * @param $url
 *
 * @return bool|string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function curl_request_post($url = '', $data = '', $arr_option = [])
{
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
 * curl post提交数据发送请求
 *
 * @param string $url
 * @param string $post_data
 * @param array  $headers
 *
 * @return bool|string
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function curl_post($url = '', $post_data = '', $headers = [])
{
    if (empty($url) || empty($post_data)) {
        return false;
    }

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_NOBODY, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    /*最后发现自己调用的api的接口地址是ssl协议的，然后加上下面两个就可以了*/
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    curl_setopt($curl, CURLOPT_POST, true); //设置POST请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($curl, CURLOPT_TIMEOUT, (int)40);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); //添加httpheader

    $return_str = curl_exec($curl);
    curl_close($curl);
    return $return_str;
}

function curl_data_to_url_data($s_url, $arr_data)
{
    $s_data = '';
    foreach ($arr_data as $key => $value) {
        $s_data .= $key . '=' . $value . '&';
    }
    $s_data = trim($s_data, '&');

    $url = $s_url . '?' . $s_data;
    return $url;

}

/**
 * 远程文件下载
 *
 * @param        $url
 * @param string $absolute_path
 */
function download($url, $absolute_path = '')
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    $file = curl_exec($ch);
    curl_close($ch);
    $resource = file_put_contents($absolute_path, $file);
    //    fwrite($resource, $file);
    //    fclose($resource);
}


/**
 *  极数数据官方提供的curl方法  调用到时候既然可以请求到
 *
 **/
function curlOpen($url, $config = [])
{
    $arr
         = ['post' => false, 'referer' => $url, 'cookie' => '', 'useragent' => 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; customie8)', 'timeout' => 20, 'return' => true, 'proxy' => '', 'userpwd' => '', 'nobody' => false, 'header' => [], 'gzip' => true, 'ssl' => false, 'isupfile' => false];
    $arr = array_merge($arr, $config);
    $ch  = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, $arr['return']);
    curl_setopt($ch, CURLOPT_NOBODY, $arr['nobody']);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $arr['useragent']);
    curl_setopt($ch, CURLOPT_REFERER, $arr['referer']);
    curl_setopt($ch, CURLOPT_TIMEOUT, $arr['timeout']);
    //curl_setopt($ch, CURLOPT_HEADER, true);//获取header
    if ($arr['gzip']) {
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    }
    if ($arr['ssl']) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }
    if (!empty($arr['cookie'])) {
        curl_setopt($ch, CURLOPT_COOKIEJAR, $arr['cookie']);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $arr['cookie']);
    }

    if (!empty($arr['proxy'])) {
        //curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
        curl_setopt($ch, CURLOPT_PROXY, $arr['proxy']);
        if (!empty($arr['userpwd'])) {
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $arr['userpwd']);
        }
    }

    //ip比较特殊，用键值表示
    if (!empty($arr['header']['ip'])) {
        array_push($arr['header'], 'X-FORWARDED-FOR:' . $arr['header']['ip'], 'CLIENT-IP:' . $arr['header']['ip']);
        unset($arr['header']['ip']);
    }
    $arr['header'] = array_filter($arr['header']);

    if (!empty($arr['header'])) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arr['header']);
    }

    if ($arr['post'] != false) {
        curl_setopt($ch, CURLOPT_POST, true);
        if (is_array($arr['post']) && $arr['isupfile'] === false) {
            $post = http_build_query($arr['post']);
        }
        else {
            $post = $arr['post'];
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    $result = curl_exec($ch);
    //var_dump(curl_getinfo($ch));
    curl_close($ch);

    return $result;
}