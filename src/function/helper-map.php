<?php
/**
 * Created by PhpStorm.
 * User: wumengmeng <wu_mengmeng@foxmail.com>
 * Date: 2020/6/30 0030
 * Time: 18:00
 */

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