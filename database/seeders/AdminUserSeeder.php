<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = date('Y-m-d H:i:s');
        DB::table('admin_user')->insert([
            'user_id' => 1,
            'username' => 'admin',
            'nickname' => 'admin',
            'email' => Str::random(10).'@example.com',
            'password' => Hash::make('password'),
            'dept_id' => 1,
            'role_id' => 1,
            'avatar_id' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        DB::table('admin_role')->insert([
            ['role_id' => 1, 'name' => '超级管理员', 'rules' => '*', 'created_at' => $date, 'updated_at' => $date],
            ['role_id' => 2, 'name' => '财务', 'rules' => '1,2,3,4', 'created_at' => $date, 'updated_at' => $date],
            ['role_id' => 3, 'name' => '电商总监', 'rules' => '1,2,3,4', 'created_at' => $date, 'updated_at' => $date],
            ['role_id' => 4, 'name' => '市场运营', 'rules' => '5,6,7,8,9,10,11', 'created_at' => $date, 'updated_at' => $date],
        ]);
        DB::table('admin_dept')->insert([
            ['dept_id' => 1, 'name' => '小刘快跑网络科技有限公司', 'parent_id' => 0, 'sort' => 0, 'created_at' => $date, 'updated_at' => $date],
            ['dept_id' => 2, 'name' => '小刘洛阳分公司', 'parent_id' => 1, 'sort' => 0, 'created_at' => $date, 'updated_at' => $date],
            ['dept_id' => 3, 'name' => '小刘郑州分公司', 'parent_id' => 1, 'sort' => 1, 'created_at' => $date, 'updated_at' => $date],
            ['dept_id' => 4, 'name' => '小刘南阳分公司', 'parent_id' => 1, 'sort' => 2, 'created_at' => $date, 'updated_at' => $date],
        ]);
        DB::table('admin_rule')->insert([
            ['rule_id' => 1 , 'parent_id' => 0 , 'type' => '0', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '仪表盘', 'path' => '/dashboard', 'icon' => 'PieChartOutlined', 'key' => 'dashboard', 'local' => 'menu.dashboard'],
            ['rule_id' => 2 , 'parent_id' => 1 , 'type' => '1', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '分析页', 'path' => '/dashboard/analysis', 'icon' => 'StockOutlined', 'key' => 'dashboard.analysis', 'local' => 'menu.dashboard.analysis'],
            ['rule_id' => 3 , 'parent_id' => 1 , 'type' => '1', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '监控页', 'path' => '/dashboard/monitor', 'icon' => 'BarChartOutlined', 'key' => 'dashboard.monitor', 'local' => 'menu.dashboard.monitor'],
            ['rule_id' => 4 , 'parent_id' => 1 , 'type' => '1', 'sort' => 2, 'created_at' => $date, 'updated_at' => $date, 'name' => '工作台', 'path' => '/dashboard/workplace', 'icon' => 'RadarChartOutlined', 'key' => 'dashboard.workplace', 'local' => 'menu.dashboard.workplace'],
            ['rule_id' => 5 , 'parent_id' => 0 , 'type' => '0', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '示例组件', 'path' => '/data', 'icon' => 'GoldOutlined', 'key' => 'data', 'local' => 'menu.components'],
            ['rule_id' => 6 , 'parent_id' => 5 , 'type' => '1', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '单选卡片', 'path' => '/data/checkcard', 'icon' => 'CreditCardOutlined', 'key' => 'data.checkcard', 'local' => 'menu.components.checkcard'],
            ['rule_id' => 7 , 'parent_id' => 5 , 'type' => '1', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '定义列表', 'path' => '/data/descriptions', 'icon' => 'BarsOutlined', 'key' => 'data.descriptions', 'local' => 'menu.components.descriptions'],
            ['rule_id' => 8 , 'parent_id' => 5 , 'type' => '1', 'sort' => 2, 'created_at' => $date, 'updated_at' => $date, 'name' => '高级表单', 'path' => '/data/form', 'icon' => 'BarsOutlined', 'key' => 'data.form', 'local' => 'menu.components.form'],
            ['rule_id' => 9 , 'parent_id' => 5 , 'type' => '1', 'sort' => 3, 'created_at' => $date, 'updated_at' => $date, 'name' => '图标选择', 'path' => '/data/icon', 'icon' => 'SmileOutlined', 'key' => 'data.icon', 'local' => 'menu.components.iconForm'],
            ['rule_id' => 10, 'parent_id' => 5 , 'type' => '1', 'sort' => 4, 'created_at' => $date, 'updated_at' => $date, 'name' => '高级列表', 'path' => '/data/list', 'icon' => 'ProfileOutlined', 'key' => 'data.list', 'local' => 'menu.components.list'],
            ['rule_id' => 11, 'parent_id' => 5 , 'type' => '1', 'sort' => 5, 'created_at' => $date, 'updated_at' => $date, 'name' => '高级表格', 'path' => '/data/table', 'icon' => 'ProfileOutlined', 'key' => 'data.table', 'local' => 'menu.components.table'],
            ['rule_id' => 12, 'parent_id' => 0 , 'type' => '0', 'sort' => 2, 'created_at' => $date, 'updated_at' => $date, 'name' => '会员管理', 'path' => '/user', 'icon' => 'UserOutlined', 'key' => 'user', 'local' => 'menu.user'],
            ['rule_id' => 13, 'parent_id' => 12, 'type' => '1', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '会员列表', 'path' => '/user/list', 'icon' => 'TeamOutlined', 'key' => 'user.list', 'local' => 'menu.user.list'],
            ['rule_id' => 14, 'parent_id' => 13, 'type' => '2', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '会员列表查询', 'path' => '', 'icon' => '', 'key' => 'user.list.list', 'local' => ''],
            ['rule_id' => 15, 'parent_id' => 13, 'type' => '2', 'sort' => 2, 'created_at' => $date, 'updated_at' => $date, 'name' => '会员列表编辑', 'path' => '', 'icon' => '', 'key' => 'user.list.edit', 'local' => ''],
            ['rule_id' => 16, 'parent_id' => 13, 'type' => '2', 'sort' => 4, 'created_at' => $date, 'updated_at' => $date, 'name' => '会员重置密码', 'path' => '', 'icon' => '', 'key' => 'user.list.resetPassword', 'local' => ''],
            ['rule_id' => 17, 'parent_id' => 0 , 'type' => '0', 'sort' => 3, 'created_at' => $date, 'updated_at' => $date, 'name' => '管理员', 'path' => '/admin', 'icon' => 'SafetyCertificateOutlined', 'key' => 'admin', 'local' => 'menu.admin'],
            ['rule_id' => 18, 'parent_id' => 17, 'type' => '1', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '用户列表', 'path' => '/admin/list', 'icon' => 'TeamOutlined', 'key' => 'admin.list', 'local' => 'menu.admin.list'],
            ['rule_id' => 19, 'parent_id' => 18, 'type' => '2', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '用户列表查询', 'path' => '', 'icon' => '', 'key' => 'admin.list.list', 'local' => ''],
            ['rule_id' => 20, 'parent_id' => 18, 'type' => '2', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '用户列表新增', 'path' => '', 'icon' => '', 'key' => 'admin.list.add', 'local' => ''],
            ['rule_id' => 21, 'parent_id' => 18, 'type' => '2', 'sort' => 2, 'created_at' => $date, 'updated_at' => $date, 'name' => '用户列表编辑', 'path' => '', 'icon' => '', 'key' => 'admin.list.edit', 'local' => ''],
            ['rule_id' => 22, 'parent_id' => 18, 'type' => '2', 'sort' => 3, 'created_at' => $date, 'updated_at' => $date, 'name' => '用户列表删除', 'path' => '', 'icon' => '', 'key' => 'admin.list.delete', 'local' => ''],
            ['rule_id' => 23, 'parent_id' => 18, 'type' => '2', 'sort' => 4, 'created_at' => $date, 'updated_at' => $date, 'name' => '重置用户密码', 'path' => '', 'icon' => '', 'key' => 'admin.list.resetPassword', 'local' => ''],
            ['rule_id' => 24, 'parent_id' => 17, 'type' => '1', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '角色管理', 'path' => '/admin/role', 'icon' => 'DeploymentUnitOutlined', 'key' => 'admin.role', 'local' => 'menu.admin.role'],
            ['rule_id' => 25, 'parent_id' => 24, 'type' => '2', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '角色管理查询', 'path' => '', 'icon' => '', 'key' => 'admin.role.list', 'local' => ''],
            ['rule_id' => 26, 'parent_id' => 24, 'type' => '2', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '角色管理详情', 'path' => '', 'icon' => '', 'key' => 'admin.role.get', 'local' => ''],
            ['rule_id' => 27, 'parent_id' => 24, 'type' => '2', 'sort' => 2, 'created_at' => $date, 'updated_at' => $date, 'name' => '角色管理新增', 'path' => '', 'icon' => '', 'key' => 'admin.role.add', 'local' => ''],
            ['rule_id' => 28, 'parent_id' => 24, 'type' => '2', 'sort' => 3, 'created_at' => $date, 'updated_at' => $date, 'name' => '角色管理编辑', 'path' => '', 'icon' => '', 'key' => 'admin.role.edit', 'local' => ''],
            ['rule_id' => 29, 'parent_id' => 24, 'type' => '2', 'sort' => 4, 'created_at' => $date, 'updated_at' => $date, 'name' => '角色管理删除', 'path' => '', 'icon' => '', 'key' => 'admin.role.delete', 'local' => ''],
            ['rule_id' => 30, 'parent_id' => 17, 'type' => '1', 'sort' => 2, 'created_at' => $date, 'updated_at' => $date, 'name' => '部门管理', 'path' => '/admin/dept', 'icon' => 'ClusterOutlined', 'key' => 'admin.dept', 'local' => 'menu.admin.dept'],
            ['rule_id' => 31, 'parent_id' => 30, 'type' => '2', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '部门管理查询', 'path' => '', 'icon' => '', 'key' => 'admin.dept.list', 'local' => ''],
            ['rule_id' => 32, 'parent_id' => 30, 'type' => '2', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '部门管理新增', 'path' => '', 'icon' => '', 'key' => 'admin.dept.add', 'local' => ''],
            ['rule_id' => 33, 'parent_id' => 30, 'type' => '2', 'sort' => 2, 'created_at' => $date, 'updated_at' => $date, 'name' => '部门管理编辑', 'path' => '', 'icon' => '', 'key' => 'admin.dept.edit', 'local' => ''],
            ['rule_id' => 34, 'parent_id' => 30, 'type' => '2', 'sort' => 3, 'created_at' => $date, 'updated_at' => $date, 'name' => '部门管理删除', 'path' => '', 'icon' => '', 'key' => 'admin.dept.delete', 'local' => ''],
            ['rule_id' => 35, 'parent_id' => 17, 'type' => '1', 'sort' => 3, 'created_at' => $date, 'updated_at' => $date, 'name' => '权限管理', 'path' => '/admin/rule', 'icon' => 'IdcardOutlined', 'key' => 'admin.rule', 'local' => 'menu.admin.rule'],
            ['rule_id' => 36, 'parent_id' => 35, 'type' => '2', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '权限管理查询', 'path' => '', 'icon' => '', 'key' => 'admin.rule.list', 'local' => ''],
            ['rule_id' => 37, 'parent_id' => 35, 'type' => '2', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '权限管理新增', 'path' => '', 'icon' => '', 'key' => 'admin.rule.add', 'local' => ''],
            ['rule_id' => 38, 'parent_id' => 35, 'type' => '2', 'sort' => 2, 'created_at' => $date, 'updated_at' => $date, 'name' => '权限管理编辑', 'path' => '', 'icon' => '', 'key' => 'admin.rule.edit', 'local' => ''],
            ['rule_id' => 39, 'parent_id' => 35, 'type' => '2', 'sort' => 3, 'created_at' => $date, 'updated_at' => $date, 'name' => '权限管理删除', 'path' => '', 'icon' => '', 'key' => 'admin.rule.delete', 'local' => ''],
            ['rule_id' => 40, 'parent_id' => 0 , 'type' => '0', 'sort' => 4, 'created_at' => $date, 'updated_at' => $date, 'name' => '系统管理', 'path' => '/system', 'icon' => 'SettingOutlined', 'key' => 'system', 'local' => 'menu.system'],
            ['rule_id' => 41, 'parent_id' => 40, 'type' => '1', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '字典管理', 'path' => '/system/dict', 'icon' => 'SortAscendingOutlined', 'key' => 'system.dict', 'local' => 'menu.system.dict'],
            ['rule_id' => 42, 'parent_id' => 41, 'type' => '2', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '字典管理查询', 'path' => '', 'icon' => '', 'key' => 'system.dict.list', 'local' => ''],
            ['rule_id' => 43, 'parent_id' => 41, 'type' => '2', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '字典管理新增', 'path' => '', 'icon' => '', 'key' => 'system.dict.add', 'local' => ''],
            ['rule_id' => 44, 'parent_id' => 41, 'type' => '2', 'sort' => 2, 'created_at' => $date, 'updated_at' => $date, 'name' => '字典管理编辑', 'path' => '', 'icon' => '', 'key' => 'system.dict.edit', 'local' => ''],
            ['rule_id' => 45, 'parent_id' => 41, 'type' => '2', 'sort' => 3, 'created_at' => $date, 'updated_at' => $date, 'name' => '字典管理删除', 'path' => '', 'icon' => '', 'key' => 'system.dict.delete', 'local' => ''],
            ['rule_id' => 46, 'parent_id' => 41, 'type' => '2', 'sort' => 4, 'created_at' => $date, 'updated_at' => $date, 'name' => '字典项查询', 'path' => '', 'icon' => '', 'key' => 'system.dict.item.list', 'local' => ''],
            ['rule_id' => 47, 'parent_id' => 41, 'type' => '2', 'sort' => 5, 'created_at' => $date, 'updated_at' => $date, 'name' => '字典项新增', 'path' => '', 'icon' => '', 'key' => 'system.dict.item.add', 'local' => ''],
            ['rule_id' => 48, 'parent_id' => 41, 'type' => '2', 'sort' => 6, 'created_at' => $date, 'updated_at' => $date, 'name' => '字典项编辑', 'path' => '', 'icon' => '', 'key' => 'system.dict.item.edit', 'local' => ''],
            ['rule_id' => 49, 'parent_id' => 41, 'type' => '2', 'sort' => 7, 'created_at' => $date, 'updated_at' => $date, 'name' => '字典项删除', 'path' => '', 'icon' => '', 'key' => 'system.dict.item.delete', 'local' => ''],
            ['rule_id' => 50, 'parent_id' => 40, 'type' => '1', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '系统详情', 'path' => '/system/info', 'icon' => 'InfoCircleOutlined', 'key' => 'system.info', 'local' => 'menu.system.info'],
            ['rule_id' => 51, 'parent_id' => 40, 'type' => '1', 'sort' => 3, 'created_at' => $date, 'updated_at' => $date, 'name' => '系统设置', 'path' => '/system/setting', 'icon' => 'ToolOutlined', 'key' => 'system.setting', 'local' => 'menu.system.setting'],
            ['rule_id' => 52, 'parent_id' => 51, 'type' => '2', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '系统设置查询', 'path' => '', 'icon' => '', 'key' => 'system.setting.list', 'local' => ''],
            ['rule_id' => 53, 'parent_id' => 51, 'type' => '2', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '系统设置新增', 'path' => '', 'icon' => '', 'key' => 'system.setting.add', 'local' => ''],
            ['rule_id' => 54, 'parent_id' => 51, 'type' => '2', 'sort' => 2, 'created_at' => $date, 'updated_at' => $date, 'name' => '系统设置编辑', 'path' => '', 'icon' => '', 'key' => 'system.setting.edit', 'local' => ''],
            ['rule_id' => 55, 'parent_id' => 51, 'type' => '2', 'sort' => 3, 'created_at' => $date, 'updated_at' => $date, 'name' => '系统设置删除', 'path' => '', 'icon' => '', 'key' => 'system.setting.delete', 'local' => ''],
            ['rule_id' => 56, 'parent_id' => 51, 'type' => '2', 'sort' => 4, 'created_at' => $date, 'updated_at' => $date, 'name' => '系统设置分组查询', 'path' => '', 'icon' => '', 'key' => 'system.setting.group.list', 'local' => ''],
            ['rule_id' => 57, 'parent_id' => 51, 'type' => '2', 'sort' => 5, 'created_at' => $date, 'updated_at' => $date, 'name' => '系统设置分组新增', 'path' => '', 'icon' => '', 'key' => 'system.setting.group.add', 'local' => ''],
            ['rule_id' => 58, 'parent_id' => 51, 'type' => '2', 'sort' => 6, 'created_at' => $date, 'updated_at' => $date, 'name' => '系统设置分组编辑', 'path' => '', 'icon' => '', 'key' => 'system.setting.group.edit', 'local' => ''],
            ['rule_id' => 59, 'parent_id' => 51, 'type' => '2', 'sort' => 7, 'created_at' => $date, 'updated_at' => $date, 'name' => '系统设置分组删除', 'path' => '', 'icon' => '', 'key' => 'system.setting.group.delete', 'local' => ''],
            ['rule_id' => 60, 'parent_id' => 0 , 'type' => '0', 'sort' => 5, 'created_at' => $date, 'updated_at' => $date, 'name' => '文件管理', 'path' => '/file', 'icon' => 'FolderOutlined', 'key' => 'file', 'local' => 'menu.file'],
            ['rule_id' => 61, 'parent_id' => 60, 'type' => '1', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '文件列表', 'path' => '/file/list', 'icon' => 'FileSearchOutlined', 'key' => 'file.list', 'local' => 'menu.file.list'],
            ['rule_id' => 62, 'parent_id' => 61, 'type' => '2', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '文件列表查询', 'path' => '', 'icon' => '', 'key' => 'file.list.list', 'local' => ''],
            ['rule_id' => 63, 'parent_id' => 61, 'type' => '2', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '文件列表删除', 'path' => '', 'icon' => '', 'key' => 'file.list.delete', 'local' => ''],
            ['rule_id' => 64, 'parent_id' => 61, 'type' => '2', 'sort' => 2, 'created_at' => $date, 'updated_at' => $date, 'name' => '文件列表编辑', 'path' => '', 'icon' => '', 'key' => 'file.list.edit', 'local' => ''],
            ['rule_id' => 65, 'parent_id' => 61, 'type' => '2', 'sort' => 3, 'created_at' => $date, 'updated_at' => $date, 'name' => '文件列表下载', 'path' => '', 'icon' => '', 'key' => 'file.list.download', 'local' => ''],
            ['rule_id' => 66, 'parent_id' => 60, 'type' => '1', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '文件分组', 'path' => '/file/group', 'icon' => 'FolderOpenOutlined', 'key' => 'file.group', 'local' => 'menu.file.group'],
            ['rule_id' => 67, 'parent_id' => 66, 'type' => '2', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '文件分组查询', 'path' => '', 'icon' => '', 'key' => 'file.group.list', 'local' => ''],
            ['rule_id' => 68, 'parent_id' => 66, 'type' => '2', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '文件分组新增', 'path' => '', 'icon' => '', 'key' => 'file.group.add', 'local' => ''],
            ['rule_id' => 69, 'parent_id' => 66, 'type' => '2', 'sort' => 2, 'created_at' => $date, 'updated_at' => $date, 'name' => '文件分组编辑', 'path' => '', 'icon' => '', 'key' => 'file.group.edit', 'local' => ''],
            ['rule_id' => 70, 'parent_id' => 66, 'type' => '2', 'sort' => 3, 'created_at' => $date, 'updated_at' => $date, 'name' => '文件分组删除', 'path' => '', 'icon' => '', 'key' => 'file.group.delete', 'local' => ''],
            ['rule_id' => 71, 'parent_id' => 17, 'type' => '1', 'sort' => 4, 'created_at' => $date, 'updated_at' => $date, 'name' => '用户设置', 'path' => '/admin/setting', 'icon' => 'UserOutlined', 'key' => 'admin.setting', 'local' => 'menu.personal'],
            ['rule_id' => 72, 'parent_id' => 0 , 'type' => '0', 'sort' => 6, 'created_at' => $date, 'updated_at' => $date, 'name' => 'AI 助理', 'path' => '/ai', 'icon' => 'OpenAIFilled', 'key' => 'ai', 'local' => 'menu.ai'],
            ['rule_id' => 73, 'parent_id' => 72, 'type' => '2', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '添加用户会话', 'path' => '', 'icon' => '', 'key' => 'ai.add', 'local' => ''],
            ['rule_id' => 74, 'parent_id' => 72, 'type' => '2', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '获取会话列表', 'path' => '', 'icon' => '', 'key' => 'ai.list', 'local' => ''],
            ['rule_id' => 75, 'parent_id' => 72, 'type' => '2', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '获取对话详情', 'path' => '', 'icon' => '', 'key' => 'ai.list.uuid', 'local' => ''],
            ['rule_id' => 76, 'parent_id' => 72, 'type' => '2', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '发送AI消息', 'path' => '', 'icon' => '', 'key' => 'ai.send', 'local' => ''],
            ['rule_id' => 77, 'parent_id' => 40, 'type' => '1', 'sort' => 4, 'created_at' => $date, 'updated_at' => $date, 'name' => 'AI 会话记录', 'path' => '/system/conversation', 'icon' => 'OpenAIFilled', 'key' => 'system.conversation', 'local' => 'menu.system.conversation'],
            ['rule_id' => 78, 'parent_id' => 77, 'type' => '2', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '会话记录查询', 'path' => '', 'icon' => '', 'key' => 'system.conversation.group.list', 'local' => ''],
            ['rule_id' => 79, 'parent_id' => 77, 'type' => '2', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '会话记录删除', 'path' => '', 'icon' => '', 'key' => 'system.conversation.group.delete', 'local' => ''],
            ['rule_id' => 80, 'parent_id' => 77, 'type' => '2', 'sort' => 2, 'created_at' => $date, 'updated_at' => $date, 'name' => '消息记录查询', 'path' => '', 'icon' => '', 'key' => 'system.conversation.list', 'local' => ''],
            ['rule_id' => 81, 'parent_id' => 77, 'type' => '2', 'sort' => 3, 'created_at' => $date, 'updated_at' => $date, 'name' => '消息记录删除', 'path' => '', 'icon' => '', 'key' => 'system.conversation.delete', 'local' => ''],
            ['rule_id' => 82, 'parent_id' => 0 , 'type' => '0', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '示例菜单', 'path' => '/menu', 'icon' => 'BarsOutlined', 'key' => 'menu', 'local' => 'menu.example'],
            ['rule_id' => 83, 'parent_id' => 82, 'type' => '1', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '二级子菜单', 'path' => '/menu/one', 'icon' => 'BarsOutlined', 'key' => 'menu.one', 'local' => 'menu.example.one'],
            ['rule_id' => 84, 'parent_id' => 83, 'type' => '1', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '三级子菜单', 'path' => '/menu/two', 'icon' => 'BarsOutlined', 'key' => 'menu.two', 'local' => 'menu.example.two'],
            ['rule_id' => 85, 'parent_id' => 84, 'type' => '1', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '四级子路由', 'path' => '/menu/three', 'icon' => 'BarsOutlined', 'key' => 'menu.three', 'local' => 'menu.example.three'],
            ['rule_id' => 86, 'parent_id' => 82, 'type' => '1', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '二级子路由', 'path' => '/menu/child', 'icon' => 'AppstoreOutlined', 'key' => 'menu.child', 'local' => 'menu.example.child'],
            ['rule_id' => 87, 'parent_id' => 83, 'type' => '1', 'sort' => 1, 'created_at' => $date, 'updated_at' => $date, 'name' => '三级子路由', 'path' => '/menu/child2', 'icon' => 'AppstoreOutlined', 'key' => 'menu.child2', 'local' => 'menu.example.child2'],
            ['rule_id' => 88, 'parent_id' => 40, 'type' => '1', 'sort' => 5, 'created_at' => $date, 'updated_at' => $date, 'name' => '登录日志', 'path' => '/system/loginlog', 'icon' => 'FieldTimeOutlined', 'key' => 'system.loginlog', 'local' => 'menu.system.loginlog'],
            ['rule_id' => 89, 'parent_id' => 88, 'type' => '2', 'sort' => 0, 'created_at' => $date, 'updated_at' => $date, 'name' => '登录日志查询', 'path' => '', 'icon' => '', 'key' => 'admin.loginlog.list', 'local' => ''],
        ]);
    }
}
