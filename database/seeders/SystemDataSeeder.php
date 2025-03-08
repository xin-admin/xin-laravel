<?php

namespace Database\Seeders;

use App\Models\DictItemModel;
use App\Models\DictModel;
use App\Models\FileGroupModel;
use App\Models\SettingGroupModel;
use App\Models\SettingModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = date('Y-m-d H:i:s');
        // 系统设置初始数据
        DB::table('setting_group')->insert([
             ['id' => 1, 'title' => '网站设置', 'key' => 'web', 'remark' => '网站基础设置', 'created_at' => $date, 'updated_at' => $date],
             ['id' => 2, 'title' => '邮件设置', 'key' => 'email', 'remark' => '邮件设置', 'created_at' => $date, 'updated_at' => $date]
        ]);
        DB::table('setting')->insert([
            ['id' => 1, 'group_id' => 1, 'key' => 'title', 'title' => '网站标题', 'describe' => '网站标题，用于展示在网站logo旁边和登录页面以及网页title中', 'values' => 'Xin Admin', 'type' => 'input', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date,],
            ['id' => 2, 'group_id' => 1, 'key' => 'logo', 'title' => '网站LOGO', 'describe' => '网站的LOGO，用于标识网站', 'values' => 'https://file.xinadmin.cn/file/favicons.ico', 'type' => 'input', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date,],
            ['id' => 3, 'group_id' => 1, 'key' => 'subtitle', 'title' => '网站副标题', 'describe' => '网站副标题，展示在登录页面标题的下面', 'values' => 'Xin Admin 快速开发框架', 'type' => 'input', 'sort' => 2, 'created_at' => $date, 'updated_at' => $date,],
            ['id' => 4, 'group_id' => 2, 'key' => 'login', 'title' => '邮箱登录', 'describe' => '是否开启邮箱登录', 'values' => '0', 'type' => 'switch', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date,],
            ['id' => 5, 'group_id' => 2, 'key' => 'Port', 'title' => '服务器端口', 'describe' => '邮箱服务器端口', 'values' => '465', 'type' => 'input', 'sort' => 2, 'created_at' => $date, 'updated_at' => $date,],
            ['id' => 6, 'group_id' => 2, 'key' => 'SMTPSecure', 'title' => '邮箱协议', 'describe' => '邮箱协议 TLS 或者ssl协议', 'values' => 'ssl', 'type' => 'input', 'sort' => 3, 'created_at' => $date, 'updated_at' => $date,],
            ['id' => 7, 'group_id' => 2, 'key' => 'username', 'title' => 'SMTP 用户名', 'describe' => '邮箱 SMTP 用户名', 'values' => '', 'type' => 'input', 'sort' => 4, 'created_at' => $date, 'updated_at' => $date,],
            ['id' => 8, 'group_id' => 2, 'key' => 'password', 'title' => 'SMTP 密码', 'describe' => '邮箱 SMTP 密码', 'values' => '', 'type' => 'input', 'sort' => 5, 'created_at' => $date, 'updated_at' => $date,],
            ['id' => 9, 'group_id' => 2, 'key' => 'smtp', 'title' => 'SMTP服务器', 'describe' => 'SMTP服务器 地址', 'values' => '', 'type' => 'input', 'sort' => 6, 'created_at' => $date, 'updated_at' => $date,],
            ['id' => 10, 'group_id' => 2, 'key' => 'char', 'title' => '邮件编码', 'describe' => '邮件编码，UTF-8', 'values' => 'UTF-8', 'type' => 'input', 'sort' => 5, 'created_at' => $date, 'updated_at' => $date,],
        ]);
        // 字典初始数据
        DB::table('dict')->insert([
            ['id' => 1, 'name' => '性别', 'type' => 'default', 'describe' => '性别字典', 'code' => 'sex', 'created_at' => $date, 'updated_at' => $date,],
            ['id' => 2, 'name' => '状态', 'type' => 'default', 'describe' => '状态字典', 'code' => 'status', 'created_at' => $date, 'updated_at' => $date,],
            ['id' => 3, 'name' => '权限类型', 'type' => 'default', 'describe' => '系统权限类型字典', 'code' => 'ruleType', 'created_at' => $date, 'updated_at' => $date,],
        ]);
        DB::table('dict_item')->insert([
            ['id' => 1, 'dict_id' => 1, 'label' => '男', 'value' => '0', 'switch' => '1', 'status' => 'default', 'created_at' => $date, 'updated_at' => $date],
            ['id' => 2, 'dict_id' => 1, 'label' => '女', 'value' => '1', 'switch' => '1', 'status' => 'default', 'created_at' => $date, 'updated_at' => $date],
            ['id' => 3, 'dict_id' => 1, 'label' => '其它', 'value' => '2', 'switch' => '1', 'status' => 'default', 'created_at' => $date, 'updated_at' => $date],
            ['id' => 4, 'dict_id' => 2, 'label' => '开启', 'value' => '1', 'switch' => '1', 'status' => 'success', 'created_at' => $date, 'updated_at' => $date],
            ['id' => 5, 'dict_id' => 2, 'label' => '关闭', 'value' => '0', 'switch' => '1', 'status' => 'error', 'created_at' => $date, 'updated_at' => $date],
            ['id' => 6, 'dict_id' => 3, 'label' => '一级菜单', 'value' => '0', 'switch' => '1', 'status' => 'processing', 'created_at' => $date, 'updated_at' => $date],
            ['id' => 7, 'dict_id' => 3, 'label' => '子菜单', 'value' => '1', 'switch' => '1', 'status' => 'success', 'created_at' => $date, 'updated_at' => $date],
            ['id' => 8, 'dict_id' => 3, 'label' => '按钮/API', 'value' => '2', 'switch' => '1', 'status' => 'default', 'created_at' => $date, 'updated_at' => $date],
        ]);
        // 文件初始化数据
        DB::table('file_group')->insert([
            ['group_id' => 1, 'name' => '默认分组', 'sort' => 0, 'describe' => '默认分组', 'created_at' => $date, 'updated_at' => $date]
        ]);
    }
}