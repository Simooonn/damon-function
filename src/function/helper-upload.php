<?php
/**
 * Created by PhpStorm.
 * User: wumengmeng <wu_mengmeng@foxmail.com>
 * Date: 2020/6/30 0030
 * Time: 18:00
 */

function upload_single_file($file, $file_dir = 'file', $type = 'oss')
{
    return upload_one_file($file, ['project' => 'xinda']);
}

/**
 * 二进制流上传单个文件
 *
 * @param        $file
 * @param string $file_dir
 * @param string $type
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function upload_single_file_by_binarystream($file, $file_dir = 'file', $type = 'oss')
{
    return upload_one_file($file, ['project' => 'xinda']);
}

/**
 * 上传文件
 *
 * @param $file
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function upload_one_file($file, $arr_option = [])
{
    if (empty($arr_option['file_dir'])) {
        $file_dir = 'file';
    }
    else {
        $file_dir = trim($arr_option['file_dir']);
    }
    if (empty($arr_option['upload_type'])) {
        $type = 'oss';
    }
    else {
        $type = trim($arr_option['upload_type']);
    }
    if (empty($arr_option['project'])) {
        $s_project = 'xinda';
    }
    else {
        $s_project = trim($arr_option['project']);
    }
    if (empty($arr_option['size'])) {
        $n_size = 10;
    }
    else {
        $n_size = intval($arr_option['size']);
    }

    if (!empty($file)) {
        $file_size      = $file['size'];// 10758
        $file_name      = $file['name'];
        $file_error     = $file['error'];//0
        $file_error_msg = 'unknow';// The file "a8.jpg" was not uploaded due to an unknown error.
        $tmppath        = $file['tmp_name'];//获取上传图片的临时地址
        $s_type         = $file['type'];//文件类型
        if ($file_error > 0) {
            return hello_error($file_error_msg);
        }
        elseif ($file_size > 1024 * 1024 * $n_size) {
            return hello_error('上传文件不能大于' . $n_size . 'MB');
        }
        else {
            $s_file_extension = 'unknow';
            if (!empty($file_name)) {
                $arr_file_extension = explode('.', $file_name);
                $s_file_extension   = end($arr_file_extension);
            }
            //            if(empty($file['type'])){
            //                $arr_file_extension = explode('.',$file_name);
            //            }
            //            else {
            //                $arr_file_extension = explode('/',$s_type);
            //            }

            //生成文件名
            $fileName = date('ymdhis') . '_' . uniqid() . '.' . $s_file_extension;

            //拼接上传的文件夹路径(按照日期格式1810/17/xxxx.jpg)
            $pathName = $s_project . '/' . $file_dir . '/' . date('Y-m/d') . '/' . $fileName;
        }

        //上传图片到阿里云OSS
        return upload_file_to_oss($pathName, $tmppath, ['ContentType' => $file['type']]);
    }
    else {
        return hello_error('没有文件被上传');
    }
}

/**
 * 上传文件到oss
 *
 * @param $pathName
 * @param $tmppath
 * @param $arr_option
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function upload_file_to_oss($pathName, $tmppath, $arr_option)
{
    //上传图片到阿里云OSS
    \HiCommon\Service\Oss::upload($pathName, $tmppath, $arr_option);

    //获取上传图片的Url链接
    $oss_url = \HiCommon\Service\Oss::getUrl($pathName);
    if ($oss_url) {

        //oss文件添加历史
        oss_file_add_history($pathName);

        $arr_data = ['src' => $pathName, 'url' => $oss_url];
        return hello_success('文件上传成功', $arr_data);
    }
    else {
        return hello_error('文件上传失败');
    }
}

/**
 * base64上传单个文件
 *
 * @param string $base64_str
 * @param string $file_dir
 * @param string $type
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function upload_single_file_by_base64($base64_str = '', $file_dir = 'file', $type = 'oss')
{
    if (!empty($base64_str)) {
        $file           = base64_to_arr($base64_str);
        $file_size      = $file['size'];// 10758
        $file_ext       = $file['ext'];// png
        $s_file         = $file['file'];// base64图片
        $s_content_type = $file['content_type'];// ContentType image/png
        if ($file_size > 1024 * 1024 * 10) {
            return ['state' => 1, 'msg' => '上传文件不能大于10MB', 'data' => [], 'error' => ''];
        }
        else {
            //生成文件名 + 拼接上传的文件夹路径(按照日期格式1810/17/xxxx.jpg)
            $file_name = date('ymdhis') . '_' . uniqid() . '.' . $file_ext;
            $path_name = 'xinda/' . $file_dir . '/' . date('Y-m/d') . '/' . $file_name;
        }
        $file_name = 'tmp/' . $file_name;
        file_put_contents($file_name, base64_decode($s_file));

        //上传图片到阿里云OSS + 获取上传图片的Url链接
        $res = upload_file_to_oss($path_name, $file_name, ['ContentType' => $s_content_type]);

        if ($res['state'] == 0) {
            unlink($file_name);
        }
        return $res;


    }
    else {
        return ['state' => 1, 'msg' => '没有文件被上传', 'data' => [], 'error' => ''];
    }
}

/**
 * 二进制流上传多个文件
 *
 * @param        $file
 * @param string $file_dir
 * @param string $type
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function upload_multiple_files_by_base64($file, $file_dir = 'file', $type = 'oss')
{
    if (count($file) <= 0) {
        return hello_error('没有文件被上传');
    }
    else {
        $arr_data = [];
        foreach ($file as $value) {
            $res = upload_single_file_by_base64($value, $file_dir, $type);
            if ($res['state'] != 0) {
                return hello_error($res['msg']);
            }
            $arr_data[] = [
              'src' => $res['data']['src'],
              'url' => $res['data']['url'],
            ];
        }

        return hello_success('成功', $arr_data);
    }

}

function get_file_by_url($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    $file = curl_exec($ch);
    return $file;
}

/**
 * 根据图片url链接上传文件
 *
 * @param string $base64_str
 * @param string $file_dir
 * @param string $type
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function upload_wxavator_by_url($img_url = '', $file_dir = 'wx')
{
    $file_ext       = 'png';// png
    $s_content_type = 'image/png';// ContentType image/png
    //生成文件名 + 拼接上传的文件夹路径(按照日期格式1810/17/xxxx.jpg)
    $file_name     = date('ymdhis') . '_' . uniqid() . '.' . $file_ext;
    $path_name     = 'xinda/' . $file_dir . '/' . date('Y-m/d') . '/' . $file_name;
    $tmp_file_name = 'tmp/' . $file_name;
    $file          = get_file_by_url($img_url);
    file_put_contents($tmp_file_name, $file);

    //上传图片到阿里云OSS + 获取上传图片的Url链接
    $res = upload_file_to_oss($path_name, $tmp_file_name, ['ContentType' => $s_content_type]);

    if ($res['state'] == 0) {
        unlink($tmp_file_name);
    }
    return $res;
}

/**
 * oss文件添加历史
 *
 * @param string $s_file_name
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function oss_file_add_history($s_file_name = '')
{
    $arr_data = ['file_name' => $s_file_name, 'is_delete' => 0, 'is_use' => 0];
    \HiCommon\MongodbModel\MongoOssFileUploadHistory::create($arr_data);
}

/**
 * oss文件使用历史
 *
 * @param string $s_file_name
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function oss_file_use_history($s_file_name = '')
{
    $arr_where = ['file_name' => $s_file_name];
    $arr_data  = ['is_delete' => 0, 'is_use' => 1];
    \HiCommon\MongodbModel\MongoOssFileUploadHistory::where($arr_where)
                                                    ->update($arr_data);
}

/**
 * oss文件删除历史
 *
 * @param string $s_file_name
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function oss_file_delete_history($s_file_name = '')
{
    $arr_where = ['file_name' => $s_file_name];
    $arr_data  = ['is_delete' => 1, 'is_use' => 0];
    \HiCommon\MongodbModel\MongoOssFileUploadHistory::where($arr_where)
                                                    ->update($arr_data);
}

/**
 * base64数据转换成数组
 *
 * @param $s_base64_file
 *
 * @return array
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function base64_to_arr($s_base64_file)
{
    $arr_base64_file      = explode('base64,', $s_base64_file);
    $arr_base64_file_type = explode(':', $arr_base64_file[0]);
    $s_base64_file_type   = rtrim($arr_base64_file_type[1], ';');
    $s_file_type          = explode('/', $s_base64_file_type)[1];
    $s_file               = $arr_base64_file[1];
    $img_len              = strlen($s_file);
    $file_size            = $img_len - ($img_len / 8) * 2;
    $arr_data             = [
      'content_type' => $s_base64_file_type,
      'ext'          => $s_file_type,
      'file'         => $s_file,
      'size'         => $file_size,
    ];
    return $arr_data;
}