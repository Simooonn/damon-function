<?php
/**
 * Created by PhpStorm.
 * User: wumengmeng <wu_mengmeng@foxmail.com>
 * Date: 2020/6/30 0030
 * Time: 18:00
 */


/**
 * 根据表名生成 model 文件
 *
 * @param $s_table_name
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function make_one_table_model_file($s_table_name)
{
    $s_file_path           = LARAVEL_APP_DIR.'/app/Common/Model/';
    $s_file_hump_name   = string_underline_to_hump($s_table_name);
    $s_file_name   = $s_file_hump_name;
    $s_file_full_name      = $s_file_path.$s_file_name.'.php';
    $res              = is_file($s_file_full_name);

    //文件数据
    $s_file_data = '<?php
/**
 * common model file Created by PhpStorm.
 * User: wumengmeng
 * Date: '.date('Y/m/d').'
 * Time: '.date('H:i').'
 */

namespace HiCommon\Model;

class '.$s_file_hump_name.' extends Base
{
    
    protected $table = \''.$s_table_name.'\';
    
    protected $guarded = [];
    
    //public $timestamps = false;
    
    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
    ];
    
        /**
         * 获取图片可用链接
         *
         * @return array
         * @author wumengmeng <wu_mengmeng@foxmail.com>
         */
        public function getImgUrlAttribute($value)
        {
            $arr_data = [
              \'src\'=>$value,
              \'full_src\'=>oss_full_url($value),
            ];
            return $arr_data;
        }
        
    /**
     * 扩展信息
     *
     * @return array
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function getExtendAttribute()
    {
        $s_created_at = $this->created_at;
        $arr_data               = $this->arr_state_display_name();
        $arr_data[\'created_at\'] = ymd_friendly_date($s_created_at);
        $arr_data[\'api\'] = $this->table_field_api();

        return $arr_data;
    }


    /**
     * state 状态值数组
     *
     * @return array
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function state_arr()
    {

        //检测状态：0无 1待检测 2检测成功 9检测失败
        $arr_check_state = [
          [\'id\' => -99, \'name\' => \'检测状态\'],
          [\'id\' => 0, \'name\' => \'无\'],
          [\'id\' => 1, \'name\' => \'待检测\'],
          [\'id\' => 2, \'name\' => \'检测成功\'],
          [\'id\' => 9, \'name\' => \'检测失败\'],
        ];

        $arr_data = [
          \'check_state\'        => $arr_check_state,
        ];
        return $arr_data;
    }

    /**
     * 获取state值和注释的集合
     *
     * @return array
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function arr_state_name()
    {
        return $this->hi_arr_state_name($this->state_arr());
    }

    /**
     * 获取state值和注释的集合
     *
     * @return array
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function arr_state_display_name()
    {
        return $this->hi_arr_state_display_name($this->state_arr());
    }



    
  
}';

    if(!$res){
        $result = file_put_contents($s_file_full_name,$s_file_data);
        if($result === false)
        {
            echo 'Model文件生成失败';
            die;
        }
    }
}

/**
 * 根据表名生成 repository 文件
 *
 * @param $s_table_name
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function make_one_table_repository_file($s_table_name)
{
    $s_file_path           = LARAVEL_APP_DIR.'/app/Common/Repository/';
    $s_file_hump_name   = string_underline_to_hump($s_table_name);
    $s_file_name   = $s_file_hump_name.'Repository';
    $s_file_model_name   = $s_file_hump_name;
    $s_file_full_name      = $s_file_path.$s_file_name.'.php';
    $res              = is_file($s_file_full_name);

    //文件数据
    $s_file_data = '<?php
/**
 * common repository file Created by PhpStorm.
 * User: wumengmeng
 * Date: '.date('Y/m/d').'
 * Time: '.date('H:i').'
 */
 
 namespace HiCommon\Repository;

//use HiCommon\Model\\'.$s_file_hump_name.';

class '.$s_file_name.' extends BaseRepository
{
    public function base_model(){
        return new \HiCommon\Model\\'.$s_file_hump_name.'();
    }

}';

    if(!$res){
        $result = file_put_contents($s_file_full_name,$s_file_data);
        if($result === false)
        {
            echo 'Repository 文件生成失败';
            die;
        }
    }
}

/**
 * 根据表名生成 service 文件
 *
 * @param $s_table_name
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function make_one_table_service_file($s_table_name)
{
    $s_file_path           = LARAVEL_APP_DIR.'/app/Common/Service/';
    $s_file_hump_name   = string_underline_to_hump($s_table_name);
    $s_file_name   = $s_file_hump_name.'Service';
    $s_file_model_name   = $s_file_hump_name.'Repository';
    $s_file_full_name      = $s_file_path.$s_file_name.'.php';
    $res              = is_file($s_file_full_name);

    //文件数据
    $s_file_data = '<?php
/**
 * admin service file Created by PhpStorm.
 * User: wumengmeng
 * Date: '.date('Y/m/d').'
 * Time: '.date('H:i').'
 */
 
namespace HiCommon\Service;

use HiCommon\Repository\\'.$s_file_model_name.';

class '.$s_file_name.'
{

    /**
     * 获取所有权限
     *
     * @return array
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function get_all(){
        try {
            $arr_option = [\'order\'=>[\'key\'=>\'id\',\'value\'=>\'asc\']];
            $data = '.$s_file_model_name.'::get_all($arr_option)->toarray();
            return  hello_success(\'成功\',$data);
        } catch (\Exception $exception) {
            return hello_error(\'失败\',[],$exception->getMessage());
        }
    }

    /**
     * 获取分页数据
     *
     * @return array
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function get_list()
    {
        try {

            $arr_option = [\'order\'=>[\'key\'=>\'id\',\'value\'=>\'desc\']];
            $data = '.$s_file_model_name.'::get_list($arr_option);
            $data = list_page_data($data);
            return  hello_success(\'成功\',$data);
        } catch (\Exception $exception) {
            return hello_error(\'失败\',[],$exception->getMessage());
        }
    }

    /**
     * 添加一条数据
     *
     * @param $arr_input
     *
     * @return array|\Illuminate\Http\RedirectResponse
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function add_one($arr_input)
    {
        $arr_input = hi_array_del_null($arr_input);
        try {
            //添加
            $res = '.$s_file_model_name.'::add_one($arr_input)->toarray();
            if(empty($res)){
                return hello_error(\'添加失败\');
            }

            return  hello_success(\'成功\',$res);
        } catch (\Exception $exception) {
            return hello_error(\'失败\',[],$exception->getMessage());
        }
    }

    /**
     * 查询一条数据
     *
     * @param int $n_id
     *
     * @return mixed
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function get_one(int $n_id)
    {
        try {
            $n_id = (int) $n_id;
            if($n_id <= 0) {
                hello_error(\'数据ID不能为空\');
            }

            //查询
            $res = '.$s_file_model_name.'::get_one($n_id)->toarray();
            if(empty($res)){
                return hello_error(\'查询失败\');
            }

            return  hello_success(\'查询成功\',$res);
        } catch (\Exception $exception) {
            return hello_error(\'失败\',[],$exception->getMessage());
        }
    }

    /**
     * 修改一条数据
     *
     * @param array $arr_input
     *
     * @return array|\Illuminate\Http\RedirectResponse
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function edit_one(array $arr_input)
    {
        $arr_input = hi_array_del_null($arr_input);
        try {
            $arr_input[\'id\'] = (int)$arr_input[\'id\'];
            if ($arr_input[\'id\'] <= 0) {
                return hello_error(\'数据id不能为空\');
            }

            $res = '.$s_file_model_name.'::edit_one($arr_input);
            if ($res === false) {
                return hello_error(\'操作失败\');
            }
            return hello_success(\'成功\');
        } catch (\Exception $exception) {
            return hello_error(\'失败\',[],$exception->getMessage());
        }
    }

    /**
     * 修改单个字段
     *
     * @param $arr_input
     *
     * @return array
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function change_one_state($arr_input){
        try {
            $arr_input[\'id\'] = (int)$arr_input[\'id\'];
            if ($arr_input[\'id\'] <= 0) {
                return hello_error(\'数据id不能为空\');
            }

            $res = '.$s_file_model_name.'::edit_one($arr_input);
            if ($res === false) {
                return hello_error(\'操作失败\');
            }
            return hello_success(\'成功\');
        } catch (\Exception $exception) {
            return hello_error(\'失败\',[],$exception->getMessage());
        }
    }

    /**
     * 删除一条数据
     *
     * @param int $n_id
     *
     * @return array|\Illuminate\Http\RedirectResponse
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function delete_one($n_id)
    {
        try {
            if ($n_id <= 0) {
                return hello_error(\'数据id不能为空\');
            }

            $res = '.$s_file_model_name.'::delete_one($n_id);
            if($res === false){
                return hello_error(\'操作失败\');
            }
            return  hello_success(\'成功\');

        } catch (\Exception $exception) {
            return hello_error(\'失败\',[],$exception->getMessage());
        }
    }
}';

    if(!$res){
        $result = file_put_contents($s_file_full_name,$s_file_data);
        if($result === false)
        {
            echo 'service 文件生成失败';
            die;
        }
    }
}

/**
 * 根据表名生成 controller 文件
 *
 * @param $s_table_name
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 */
function make_one_table_controller_file($s_table_name)
{
    $s_file_path           = LARAVEL_APP_DIR.'/Modules/Admin/Http/Controllers/';
    $s_file_hump_name   = string_underline_to_hump($s_table_name);
    $s_file_name   = $s_file_hump_name.'Controller';
    $s_file_model_name   = $s_file_hump_name.'Service';
    $s_file_full_name      = $s_file_path.$s_file_name.'.php';
    $res              = is_file($s_file_full_name);

    //文件数据
    $s_file_data = '<?php
/**
 * controller file Created by PhpStorm.
 * User: wumengmeng
 * Date: '.date('Y/m/d').'
 * Time: '.date('H:i').'
 */
 namespace Modules\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use Modules\Admin\Service\\'.$s_file_model_name.';

class '.$s_file_name.' extends BaseController
{


    /**
     *  XXX 列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function index()
    {
        $res = '.$s_file_model_name.'::get_list();
        echo_error($res);
        return view(\'admin::'.$s_table_name.'.index\', $res[\'data\']);
    }

    /**
     * 添加 XXX 页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function create()
    {
        return view(\'admin::'.$s_table_name.'.create\');
    }

    /**
     * 添加 XXX 操作
     *
     * @return mixed
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function store()
    {
        $arr_input = Request::input();
        //$arr_input[\'operator_id\'] = (int)admin_user_id();
        return '.$s_file_model_name.'::add_one($arr_input);
    }

    /**
     * 修改 XXX 页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function edit()
    {
        $nId = Request::get(\'id\',0);
        $res = '.$s_file_model_name.'::get_one((int)$nId);
        echo_error($res);

        $arr_data = [
          \'arr_data\'=>$res[\'data\'],
        ];
        return view(\'admin::'.$s_table_name.'.edit\',$arr_data);
    }

    /**
     * 修改 XXX 页面操作
     *
     *
     * @return array|\Illuminate\Http\RedirectResponse
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function update()
    {
        $arr_input = Request::input();
        //$arr_input[\'operator_id\'] = (int)admin_user_id();
        return '.$s_file_model_name.'::edit_one($arr_input);
    }


    /**
     * 更改 XXX 状态
     *
     * @return array|\Illuminate\Http\RedirectResponse
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function change_state()
    {
        $arr_input = Request::input();
        return '.$s_file_model_name.'::change_one_state($arr_input);
    }

    /**
     * 删除 XXX 
     *
     * @return array|\Illuminate\Http\RedirectResponse
     * @author wumengmeng <wu_mengmeng@foxmail.com>
     */
    public function delete()
    {
        $n_id = (int)Request::get(\'id\',0);
        return '.$s_file_model_name.'::delete_one($n_id);
    }
}';

    if(!$res){
        $result = file_put_contents($s_file_full_name,$s_file_data);
        if($result === false)
        {
            echo 'controller 文件生成失败';
            die;
        }
    }
}

/**
 * 根据表名生成对应的各种文件 目前包括 model repository service [controller]
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 *
 * @param $s_xiahua_name
 */
function make_one_table_file($s_xiahua_name)
{
    //生成 common model 文件
    make_one_table_model_file($s_xiahua_name);

    //生成 common repository 文件
    make_one_table_repository_file($s_xiahua_name);

    //生成 admin service 文件
    make_one_table_service_file($s_xiahua_name);

    //生成 admin controller 文件
    make_one_table_controller_file($s_xiahua_name);
}

/**
 * 批量生产数据库所有表对应的laravel_model和laravel_service文件
 *
 * @author wumengmeng <wu_mengmeng@foxmail.com>
 * @return string
 */
function creat_common_file()
{
    $db_prefix = env('DB_PREFIX','');
    $db_name = env('DB_DATABASE','');
    //    $a = M()->query('select TABLE_NAME from information_schema.tables where TABLE_SCHEMA="phonelive"');
    $tables = DB::select('show tables');

    foreach($tables as $value){
        $s_replace_name = 'Tables_in_'.$db_name;
        $s_xiahua_name = str_replace($db_prefix,'',$value->$s_replace_name);
        make_one_table_file($s_xiahua_name);
    }
    return 'ok';

}