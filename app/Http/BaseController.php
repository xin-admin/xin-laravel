<?php

namespace App\Http;

use App\RequestJson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    description: 'XinAdmin [ A Full stack framework ] <br> Copyright (c) 2023~2024 http://xinadmin.cn All rights reserved. <br> Apache License ( http://www.apache.org/licenses/LICENSE-2.0 ) <br> Author: 小刘同学 <2302563948@qq.com> <br>',
    title: 'XinAdmin DOCUMENTS',
)]
abstract class BaseController
{
    use RequestJson;

    /**
     * model
     */
    protected Model $model;

    /**
     * service
     */
    protected mixed $service;

    /**
     * 权限验证白名单
     */
    protected array $noPermission = [];

    /**
     * 查询字符串
     */
    protected array $searchField = [];

    /**
     * 快速搜索字段
     */
    protected array $quickSearchField = [];

    /**
     * 查询响应
     */
    protected function getResponse($id): JsonResponse
    {
        $key = $this->model->getKeyName();
        $data = $this->model->where($key, $id)->first()->toArray();

        return $this->success($data);
    }

    /**
     * 列表响应
     */
    protected function listResponse(): JsonResponse
    {
        [$buildModel, $paginate] = $this->buildSearch();
        // TODO 分页响应优化，去除不需要的参数：page （待完成）
        $data = $buildModel->paginate(
            $paginate['prePage'],
            page: $paginate['page'] ?? 1
        )->toArray();

        return $this->success($data);
    }

    /**
     * 更新响应
     */
    public function editResponse(FormRequest $request): JsonResponse
    {
        $data = $request->validated();
        $key = $this->model->getKeyName();
        $this->model->where($key, $data[$key])->update($data);

        return $this->success('ok');
    }

    /**
     * 新增响应
     *
     * @param  FormRequest  $request  请求
     */
    public function addResponse(FormRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->model->create($data);

        return $this->success('ok');
    }

    /**
     * 删除响应
     */
    public function deleteResponse(): JsonResponse
    {
        $data = request()->all();
        $key = $this->model->getKeyName();
        if (! isset($data[$key])) {
            return $this->error('请输入删除KEY！');
        }
        $delArr = explode(',', $data[$key]);
        $delNum = $this->model->destroy($delArr);
        if ($delNum != 0) {
            return $this->success('删除成功，删除了'.$delNum.'条数据');
        } else {
            return $this->warn('没有删除任何数据');
        }
    }

    /**
     * 构建查询方法
     */
    private function buildSearch(): array
    {
        $params = request()->query();
        $model = $this->model->query();
        // 构建筛选
        if (isset($params['filter']) && $params['filter'] != '') {
            $filter = json_decode($params['filter'], true);
            foreach ($filter as $k => $v) {
                if (! $v) {
                    continue;
                }
                $model->whereIn($k, $v);
            }
        }

        // 构建查询
        foreach ($this->searchField as $key => $op) {
            if (isset($params[$key]) && $params[$key] != '') {
                if (in_array($op, ['=', '>', '<>', '<', '>=', '<='])) {
                    $model->where($key, $op, $params[$key]);

                    continue;
                }
                if ($op == 'like') {
                    $model->where($key, $op, '%'.$params[$key].'%');

                    continue;
                }
                if ($op == 'date') {
                    $date = date('Y-m-d', strtotime($params[$key]));
                    $model->whereDate($key, $date);

                    continue;
                }
                if ($op == 'betweenDate') {
                    if (is_array($params[$key])) {
                        $start = $params[$key][0];
                        $end = $params[$key][1];
                        $model->whereDate($key, '>=', $start);
                        $model->whereDate($key, '<=', $end);
                    }
                }
            }
        }

        // 快速搜索
        if (isset($params['keywordSearch']) && $params['keywordSearch'] != '') {
            $quickSearchArr = $this->quickSearchField;
            if (count($quickSearchArr) > 0) {
                $model->whereAny(
                    $quickSearchArr,
                    'like',
                    '%'.str_replace('%', '\%', $params['keywordSearch']).'%'
                );
            }
        }

        // 构建排序
        if (isset($params['sorter']) && $params['sorter']) {
            $sorter = json_decode($params['sorter'], true);
            if (count($sorter) > 0) {
                $column = array_keys($sorter)[0];
                $direction = $sorter[$column] == 'ascend' ? 'asc' : 'desc';
                $model->orderBy($column, $direction);
            }
        }

        // 构建分页
        $paginate = [
            'prePage' => $params['pageSize'] ?? 10,
            'page' => $params['current'] ?? 1,
        ];

        return [$model, $paginate];
    }
}
