<?php

namespace Xin\AnnoRoute\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class PutMapping
{
    /**
     * @param string $route 路由
     * @param string | array $middleware 中间件
     */
    public function __construct(
        public string $route = '',
        public string | array $middleware = '',
    )
    {
    }
}