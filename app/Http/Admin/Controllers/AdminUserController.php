<?php

namespace App\Http\Admin\Controllers;

use App\Attribute\AdminController;
use App\Attribute\route\GetMapping;
use App\Attribute\route\PostMapping;
use App\Attribute\route\PutMapping;
use App\Attribute\route\RequestMapping;
use App\Enum\FileType;
use App\Http\BaseController;
use App\Service\impl\AdminUserService;
use App\Service\impl\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 管理员用户控制器
 */
#[AdminController]
#[RequestMapping('/admin')]
class AdminUserController extends BaseController
{
    protected array $noPermission = ['refreshToken', 'login'];

    public function __construct()
    {
        $this->service = new AdminUserService;
    }

    /** 会员登录 */
    #[PostMapping('/login')]
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'username' => 'required|min:4|alphaDash',
            'password' => 'required|min:4|alphaDash',
        ]);

        return $this->service->login($validated);
    }

    /** 刷新 Token */
    #[PostMapping('/refreshToken')]
    public function refreshToken(): JsonResponse
    {
        return $this->service->refreshToken();
    }

    /** 退出登录 */
    #[PostMapping('/logout')]
    public function logout(): JsonResponse
    {
        return $this->service->logout();
    }

    /** 获取管理员信息 */
    #[GetMapping('/info')]
    public function getAdminInfo(): JsonResponse
    {
        return $this->service->getAdminInfo();
    }

    /** 更新管理员信息 */
    #[PutMapping]
    public function updateAdmin(Request $request): JsonResponse
    {
        return $this->service->updateAdmin($request);
    }

    /** 修改密码 */
    #[PutMapping('/updatePassword')]
    public function updatePassword(Request $request): JsonResponse
    {
        return $this->service->updatePassword($request);
    }

    /** 上传头像 */
    #[PostMapping('/uploadAvatar')]
    public function uploadAvatar(): JsonResponse
    {
        $service = new FileService();
        $data = $service->upload(FileType::IMAGE, 1, 'public');
        return $this->success($data);
    }
}
