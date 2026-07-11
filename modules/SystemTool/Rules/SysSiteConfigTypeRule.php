<?php

namespace Modules\SystemTool\Rules;

use Closure;
use Modules\SystemTool\Enum\SiteConfigType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class SysSiteConfigTypeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (SiteConfigType::tryFrom($value) == null) {
            $fail('设置类型不存在！');
        }
    }
}
