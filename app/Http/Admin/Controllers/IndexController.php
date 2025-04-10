<?php

namespace App\Http\Admin\Controllers;

use App\Attribute\route\GetMapping;
use App\Attribute\route\RequestMapping;
use App\Http\BaseController;
use Illuminate\Http\JsonResponse;

#[RequestMapping('/admin')]
class IndexController extends BaseController
{
    protected array $noPermission = ['index', 'openai'];

    /** 测试接口 */
    #[GetMapping]
    public function index(): JsonResponse
    {
        $webSetting = setting('web');
        return $this->success(compact('webSetting'), '恭喜你已经成功安装 Xin Admin');
    }
}
