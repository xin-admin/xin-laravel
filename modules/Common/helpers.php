<?php

use Modules\SystemTool\Services\SysSiteConfigService;

if (! function_exists('site_config')) {
    /**
     * 获取或设置系统配置
     *
     * @param  string|null  $name  配置名称，格式：'group.key' 或 'group'，为null时返回所有配置
     * @param  mixed|null  $default  默认值（仅在获取时使用）
     * @return mixed
     *
     * @example
     *   site_config('site.name')           // 获取配置
     *   site_config('site.name', 'Default') // 带默认值获取
     *   site_config('site')                 // 获取整个组
     *   site_config()                       // 获取所有配置
     */
    function site_config(?string $name = null, mixed $default = null): mixed
    {
        return SysSiteConfigService::getSiteConfig($name, $default);
    }
}

if (! function_exists('web_path')) {
    /**
     * Get the path to the web of the install.
     *
     * @param string $path
     * @return string
     */
    function web_path(string $path = ''): string
    {
        return base_path('web'. DIRECTORY_SEPARATOR . $path);
    }
}

if (! function_exists('getTreeData')) {
    /**
     * 获取树形数据
     *
     * @param array $list
     * @param int $parentId
     * @param string[] $params
     * @return array
     */
    function getTreeData(
        array &$list,
        int $parentId = 0,
        array $params = []
    ): array
    {
        $params = array_merge($params, [
            'id' => 'id',
            'parent_id' => 'parent_id',
            'children' => 'children'
        ]);
        $data = [];
        foreach ($list as $k => $item) {
            if ($item[$params['parent_id']] == $parentId) {
                $children = getTreeData($list, $item[$params['id']]);
                !empty($children) && $item[$params['children']] = $children;
                $data[] = $item;
                unset($list[$k]);
            }
        }
        return $data;
    }
}
