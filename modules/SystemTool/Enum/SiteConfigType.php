<?php

namespace Modules\SystemTool\Enum;

/**
 * 系统设置类型枚举
 */
enum SiteConfigType: string
{
    // 前端表单组件类型（新版，与前端保持一致）
    case INPUT = 'Input';                // 输入框
    case TEXTAREA = 'TextArea';          // 文本域
    case INPUT_NUMBER = 'InputNumber';   // 数字输入框
    case SWITCH = 'Switch';              // 开关
    case RADIO = 'Radio';                // 单选框
    case CHECKBOX = 'Checkbox';          // 复选框

    /**
     * 从字符串创建枚举实例（宽松匹配）
     */
    public static function fromString(string $type): ?self
    {
        return self::tryFrom($type);
    }

    /**
     * 根据类型自动转换值
     *
     * @param mixed $value 原始值
     * @return mixed 转换后的值
     */
    public function castValue(mixed $value): mixed
    {
        // 如果值为 null，直接返回 null
        if ($value === null) {
            return null;
        }

        return match($this) {
            // 数字类型：转换为整数或浮点数
            self::INPUT_NUMBER => $this->castToNumber($value),

            // 布尔类型：转换为布尔值
            self::SWITCH => $this->castToBoolean($value),

            // 数组类型：转换为数组
            self::CHECKBOX => $this->castToArray($value),

            // 默认：保持字符串（去除首尾空白）
            self::INPUT, self::TEXTAREA, self::RADIO => $value,
        };
    }

    /**
     * 转换为数字（整数或浮点数）
     */
    private function castToNumber(mixed $value): int|float|null
    {
        // 如果是数字字符串或数字
        if (is_numeric($value)) {
            // 如果包含小数点，转换为浮点数，否则转换为整数
            return str_contains((string)$value, '.')
                ? (float)$value
                : (int)$value;
        }

        // 如果是布尔值
        if (is_bool($value)) {
            return (int)$value;
        }

        // 其他情况返回 null 或 0？这里返回 null 表示无效转换
        return null;
    }

    /**
     * 转换为布尔值
     */
    private function castToBoolean(mixed $value): bool
    {
        // 如果是字符串
        if (is_string($value)) {
            $lowerValue = strtolower(trim($value));
            // 检查是否为 true 相关的字符串
            if (in_array($lowerValue, ['true', '1', 'on', 'yes', 'y'], true)) {
                return true;
            }
            // 检查是否为 false 相关的字符串
            if (in_array($lowerValue, ['false', '0', 'off', 'no', 'n', ''], true)) {
                return false;
            }
            // 默认转换为布尔值
            return (bool)$value;
        }

        // 如果是数字
        if (is_numeric($value)) {
            return (bool)$value;
        }

        // 其他类型直接转换为布尔值
        return (bool)$value;
    }

    /**
     * 转换为数组
     */
    private function castToArray(mixed $value): array
    {
        // 如果已经是数组，直接返回
        if (is_array($value)) {
            return $value;
        }

        // 如果是 JSON 字符串
        if (is_string($value)) {
            $trimmed = trim($value);
            // 检查是否为 JSON 数组格式
            if ((str_starts_with($trimmed, '[') && str_ends_with($trimmed, ']')) ||
                (str_starts_with($trimmed, '{') && str_ends_with($trimmed, '}'))) {
                $decoded = json_decode($trimmed, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    return $decoded;
                }
            }

            // 尝试按逗号分割（支持中文逗号和英文逗号）
            if (str_contains($trimmed, ',') || str_contains($trimmed, '，')) {
                $separator = str_contains($trimmed, '，') ? '，' : ',';
                return array_map('trim', explode($separator, $trimmed));
            }

            // 单个值转为数组
            return [$trimmed];
        }

        // 其他类型转为数组
        return (array)$value;
    }

    /**
     * 转换为字符串
     */
    private function castToString(mixed $value): string
    {
        if (is_array($value)) {
            // 数组转为 JSON 字符串
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if ($value === null) {
            return '';
        }

        return trim((string)$value);
    }
}
