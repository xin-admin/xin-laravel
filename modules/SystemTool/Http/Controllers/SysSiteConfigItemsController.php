<?php

namespace Modules\SystemTool\Http\Controllers;

use App\Exceptions\RepositoryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\AnnoRoute\Attribute\DeleteRoute;
use Modules\AnnoRoute\Attribute\GetRoute;
use Modules\AnnoRoute\Attribute\PostRoute;
use Modules\AnnoRoute\Attribute\PutRoute;
use Modules\AnnoRoute\Attribute\RequestAttribute;
use Modules\Common\Http\Controllers\BaseController;
use Modules\SystemTool\Http\Requests\SysSiteConfigItemsFormRequest;
use Modules\SystemTool\Models\SysSiteConfigItemsModel;
use Modules\SystemTool\Services\SysSiteConfigService;

/**
 * 系统设置
 */
#[RequestAttribute('/system/config/items', 'system.config.items')]
class SysSiteConfigItemsController extends BaseController
{
    protected array $searchField = [
        'group_id' => '=',
    ];

    /** 查询设置项列表 */
    #[GetRoute(authorize: 'query')]
    public function query(Request $request): JsonResponse
    {
        $params = $request->all();
        if (empty($params['group_id'])) {
            throw new RepositoryException('请选择设置分组');
        }
        $query = SysSiteConfigItemsModel::query();
        $data = $this->buildSearch($params, $query)
            ->orderBy('sort', 'desc')
            ->get()
            ->toArray();
        return $this->success($data);
    }

    /** 创建设置项 */
    #[PostRoute(authorize: 'create')]
    public function create(SysSiteConfigItemsFormRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $model = SysSiteConfigItemsModel::create($validated);
        if (empty($model)) {
            return $this->error();
        }
        return $this->success();
    }

    /** 编辑设置项 */
    #[PutRoute(
        route: '/{id}',
        authorize: 'update',
        where: ['id' => '[0-9]+']
    )]
    public function update(int $id, SysSiteConfigItemsFormRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $model = SysSiteConfigItemsModel::find($id);
        if (empty($model)) {
            return $this->error();
        }
        $model->update($validated);
        return $this->success();
    }

    /** 删除设置项 */
    #[DeleteRoute(
        route: '/{id}',
        authorize: 'delete',
        where: ['id' => '[0-9]+']
    )]
    public function delete(int $id): JsonResponse
    {
        $model = SysSiteConfigItemsModel::find($id);
        if (empty($model)) {
            return $this->error();
        }
        $model->delete();
        return $this->success();
    }

    /** 批量保存设置 */
    #[PutRoute('/save', 'save')]
    public function save(): JsonResponse
    {
        $configs = request()->input('configs');
        if (empty($configs) || !is_array($configs)) {
            return $this->error('请提供设置数据');
        }

        $result = SysSiteConfigService::batchSaveSiteConfig($configs);

        if ($result['success']) {
            SysSiteConfigService::refreshSiteConfig();
            return $this->success();
        }
        $message = '设置保存失败：' . $result['message'];
        return $this->error($message);
    }

    /** 刷新设置 */
    #[PostRoute('/refreshCache', 'refresh')]
    public function refreshCache(): JsonResponse
    {
        SysSiteConfigService::refreshSiteConfig();
        return $this->success();
    }
}
