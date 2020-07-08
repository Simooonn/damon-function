# damon-function 常用函数
## 概述
>整个函数库包含3个文件，分别为helper.php、helper-data-type.php、helper-date.php

>helper.php主要存放常用函数
>helper-data-type.php主要存放数据类型相关处理函数
>helper-date.php主要存放日期相关处理函数

## helper.php

| 函数名 | 作用  |
| --- | --- |
| yoo_dump | 打印数据 |
| yoo_debug  | 打印数据 |
| yoo_http_host  |  当前访问链接网址域名|
| yoo_client_ip  | 客户端IP地址 |
| yoo_msg_error | 错误消息 |
| yoo_echo_error | 错误提示 |
| yoo_hello_error | 友好返回错误信息 |
| yoo_hello_fail | 友好返回失败信息 |
| yoo_hello_success | 友好返回成功信息 |
| yoo_preg_password | 密码正则验证字符 |
| yoo_preg_phone | 手机号正则验证字符 |
| yoo_password_judge_safety | 判断密码安全级别 |
| yoo_password_judge_score | 密码安全评分 |
| yoo_plate_no_city | 根据车牌号识别省市信息 |
| yoo_xml_to_array| xml转数组 |
| yoo_param_str | 数组形式的链接参数转换成字符串形式 |
| yoo_curl_get | curl get提交数据发送请求|
| yoo_curl_post| curl post提交数据发送请求 |
| yoo_curl_download | 远程文件下载|
| yoo_api_gaode_geocode | 高德地图-地理编码-地址转经纬度|
| yoo_location_distance| 计算两个经纬度之间的距离|

## helper-data-type.php

| 函数名 | 作用  |
| --- | --- |
| yoo_string_pad| 字符串补位 |
| yoo_number_pad | 数字补位|
| yoo_number_format | 数字格式化|
| yoo_string_trim| 过滤字符串|
| yoo_hide_string | 隐藏字符串中的部分字符串|
| yoo_random_articl_says | 从文章里随机抽取一句话|
| yoo_pad_url| 补充链接地址|
| yoo_take_img| 从html中提取图片地址(使用正则)|
| yoo_random_order_sn| 随机生成唯一订单号|
| yoo_unique_token | 生成唯一token|
| yoo_upper_base64_md5| 字符串转换成大写 base64 md5|
| yoo_make_tree| 一维数组生成树状数组|
| yoo_tree_child_ids| 递归获取所有子级的数据id |
| yoo_tree_ico | 树形前缀ico|
| yoo_tree_list | 树形数组转换成一维伪树形数组|
| yoo_array_remain | 保留数组内指定key值的几个元素 |
| yoo_array_remove | 去除数组内指定key值的几个元素 |
| yoo_array_del_null | 删除数组中值为null的字段 |
| yoo_array_trim| 过滤数组value值里的空格 |
| yoo_string_underline_to_hump | 字符串命名风格转换 【下划线转驼峰】 |
| yoo_array_underline_to_hump | 数组元素字符串命名风格转换 【下划线转驼峰】 |
| yoo_array_kvs| 列表数组转换成键值对的一维关联数组 |
| yoo_str_ids | id集合数组转为标识分隔的字符串 |
| yoo_array_ids | id标识分隔的字符串转为id集合数组 |
| yoo_array_vpad | 一维数组每个value值加上特定的字符 |
| yoo_array_vreplace | 一维数组每个value值公共的字符替换成其他的字符 |
| yoo_array_dikaer | 处理数组变成笛卡尔积 |
| yoo_array_cartesian | 处理数组变成笛卡尔积-多参数|

## helper-date.php

| 函数名 | 作用  |
| --- | --- |
| yoo_seconds_to_daytime| 秒数转成天 小时 分钟 |
| yoo_friendly_date| 友好的时间显示 |
| yoo_ymdhis| 时间戳 转换成 年月日时分秒 |
| yoo_timestring_to_ymdhis| 字符时间日期转为日期格式 |
| yoo_month_days| 指定时间戳月份天数 |
| yoo_month_start_day| 指定时间戳月份第一天|
| yoo_month_end_day| 指定时间戳月份最后一天 |
| yoo_month_start| 指定时间戳月份第一天 精确到秒 |
| yoo_month_end| 指定时间戳月份最后一天 精确到秒|
| yoo_range_format_date| 获取指定日期段内指定格式日期的集合 |
| yoo_mysql_date_format| 日期格式-mysql语句|
| yoo_nearly_date| 获取最近的日期 一周 一月 半年 |
