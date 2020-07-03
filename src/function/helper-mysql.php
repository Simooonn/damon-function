<?php
/**
 * Created by PhpStorm.
 * User: wumengmeng <wu_mengmeng@foxmail.com>
 * Date: 2020/6/30 0030
 * Time: 18:00
 */



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
