<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SysDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = date('Y-m-d H:i:s');
        // 系统设置初始数据
        DB::table('sys_site_config_group')->insert([
             ['id' => 1, 'title' => '网站设置', 'key' => 'web', 'remark' => '网站基础设置', 'created_at' => $date, 'updated_at' => $date]
        ]);
        DB::table('sys_site_config_items')->insert([
            ['id' => 1, 'group_id' => 1, 'key' => 'title', 'title' => '网站标题', 'describe' => '网站标题，用于展示在网站logo旁边和登录页面以及网页title中', 'values' => 'Xin Admin', 'type' => 'Input','options' => "", 'sort' => 0, 'created_at' => $date, 'updated_at' => $date,],
            ['id' => 2, 'group_id' => 1, 'key' => 'logo', 'title' => '网站LOGO', 'describe' => '网站的LOGO，用于标识网站', 'values' => 'https://file.xinadmin.cn/file/favicons.ico', 'type' => 'Input','options' => "", 'sort' => 1, 'created_at' => $date, 'updated_at' => $date,],
            ['id' => 3, 'group_id' => 1, 'key' => 'subtitle', 'title' => '网站副标题', 'describe' => '网站副标题，展示在登录页面标题的下面', 'values' => 'Xin Admin 快速开发框架', 'type' => 'Input','options' => "", 'sort' => 2, 'created_at' => $date, 'updated_at' => $date,],
            ['id' => 4, 'group_id' => 1, 'key' => 'describe', 'title' => '网站描述', 'describe' => '网站的基本描述', 'values' => '没有描述', 'type' => 'TextArea','options' => "", 'sort' => 2, 'created_at' => $date, 'updated_at' => $date,],
        ]);
        // 字典类型初始数据
        DB::table('sys_dict')->insert([
            ['id' => 1, 'name' => '用户性别', 'code' => 'sys_user_sex', 'describe' => '用户性别字典', 'status' => 0, 'sort' => 1, 'created_at' => $date, 'updated_at' => $date],
            ['id' => 2, 'name' => '菜单状态', 'code' => 'sys_show_hide', 'describe' => '菜单状态字典', 'status' => 0, 'sort' => 2, 'created_at' => $date, 'updated_at' => $date],
            ['id' => 3, 'name' => '系统开关', 'code' => 'sys_normal_disable', 'describe' => '系统开关字典', 'status' => 0, 'sort' => 3, 'created_at' => $date, 'updated_at' => $date],
            ['id' => 4, 'name' => '权限类型', 'code' => 'sys_rule_type', 'describe' => '系统权限类型字典', 'status' => 0, 'sort' => 4, 'created_at' => $date, 'updated_at' => $date],
        ]);
        // 字典数据初始数据
        DB::table('sys_dict_item')->insert([
            // 用户性别
            ['id' => 1, 'dict_id' => 1, 'label' => '男', 'value' => '0', 'color' => 'blue', 'status' => 0, 'sort' => 1, 'created_at' => $date, 'updated_at' => $date],
            ['id' => 2, 'dict_id' => 1, 'label' => '女', 'value' => '1', 'color' => 'magenta', 'status' => 0, 'sort' => 2, 'created_at' => $date, 'updated_at' => $date],
            ['id' => 3, 'dict_id' => 1, 'label' => '未知', 'value' => '2', 'color' => 'default', 'status' => 0, 'sort' => 3, 'created_at' => $date, 'updated_at' => $date],
            // 菜单状态
            ['id' => 4, 'dict_id' => 2, 'label' => '显示', 'value' => '0', 'color' => 'green', 'status' => 0, 'sort' => 1, 'created_at' => $date, 'updated_at' => $date],
            ['id' => 5, 'dict_id' => 2, 'label' => '隐藏', 'value' => '1', 'color' => 'red', 'status' => 0, 'sort' => 2, 'created_at' => $date, 'updated_at' => $date],
            // 系统开关
            ['id' => 6, 'dict_id' => 3, 'label' => '正常', 'value' => '0', 'color' => 'green', 'status' => 0, 'sort' => 1, 'created_at' => $date, 'updated_at' => $date],
            ['id' => 7, 'dict_id' => 3, 'label' => '停用', 'value' => '1', 'color' => 'red', 'status' => 0, 'sort' => 2, 'created_at' => $date, 'updated_at' => $date],
            // 权限类型
            ['id' => 8, 'dict_id' => 4, 'label' => '路由', 'value' => 'route', 'color' => 'blue', 'status' => 0, 'sort' => 1, 'created_at' => $date, 'updated_at' => $date],
            ['id' => 9, 'dict_id' => 4, 'label' => '菜单项', 'value' => 'menu', 'color' => 'green', 'status' => 0, 'sort' => 2, 'created_at' => $date, 'updated_at' => $date],
            ['id' => 10, 'dict_id' => 4, 'label' => '权限', 'value' => 'rule', 'color' => 'orange', 'status' => 0, 'sort' => 3, 'created_at' => $date, 'updated_at' => $date],
        ]);
        // 文件初始化数据
        DB::table('sys_file_group')->insert([
            ['id' => 1, 'name' => '默认分组', 'sort' => 0, 'describe' => '默认分组', 'created_at' => $date, 'updated_at' => $date],
            ['id' => 2, 'name' => '用户头像', 'sort' => 1, 'describe' => '用户头像分组', 'created_at' => $date, 'updated_at' => $date],
            ['id' => 3, 'name' => '系统图片', 'sort' => 2, 'describe' => '系统图片分组', 'created_at' => $date, 'updated_at' => $date],
            ['id' => 4, 'name' => '用户上传', 'sort' => 3, 'describe' => '用户上传分组', 'created_at' => $date, 'updated_at' => $date],
            ['id' => 5, 'name' => '系统附件', 'sort' => 4, 'describe' => '系统附件分组', 'created_at' => $date, 'updated_at' => $date],
            ['id' => 6, 'name' => '其他文件', 'sort' => 5, 'describe' => '其他文件分组', 'created_at' => $date, 'updated_at' => $date],
            ['id' => 7, 'name' => '临时文件', 'sort' => 6, 'describe' => '临时文件分组，用于存放临时上传的文件', 'created_at' => $date, 'updated_at' => $date],
        ]);
    }
}
