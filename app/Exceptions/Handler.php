<?php

namespace App\Exceptions;

use App\Enum\ShowType;
use App\Trait\RequestJson;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use RequestJson;

    /**
     * A list of the exception types that are not reported.
     * 未报告的异常类型列表
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function render($request, Throwable $e): JsonResponse|Response
    {

        if ($e instanceof HttpResponseException) {
            // HTTP Response Exception HTTP 错误响应
            $response = response()->json($e->getResData(), $e->getCode());
        } elseif ($e instanceof MissingAbilityException) {
            // Authorize Exception 权限验证异常
            $response = $this->notification(
                'No Permission',
                __('system.error.no_permission'),
                ShowType::WARN_NOTIFICATION
            );
        } elseif ($e instanceof NotFoundHttpException) {
            // NotFoundHttpException 地址不存在
            $response = $this->notification(
                'Route Not Exist',
                __('system.error.route_not_exist'),
                ShowType::WARN_NOTIFICATION
            );
        } elseif ($e instanceof ValidationException) {
            // ValidationException 数据验证异常
            $response = response()->json([
                'msg' => $e->validator->errors()->first(),
                'showType' => ShowType::WARN_MESSAGE->value,
                'success' => false,
            ]);
        } else {
            $debug = config('app.debug');
            $data = [
                'msg' => $e->getMessage(),
                'showType' => ShowType::ERROR_MESSAGE->value,
                'success' => false,
            ];
            if($debug) {
                $data['file'] = $e->getFile();
                $data['line'] = $e->getLine();
                $data['trace'] = $e->getTrace();
                $data['code'] = $e->getCode();
            }
            $response = response()->json($data);
        }
        return addHeaders($response);
    }
}
