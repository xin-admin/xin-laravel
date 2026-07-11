<?php

namespace Modules\SystemTool\Http\Requests;

use Illuminate\Validation\Rules\Exists;
use Modules\Common\Http\Requests\BaseFormRequest;
use Modules\SystemTool\Models\SysSiteConfigGroupModel;
use Modules\SystemTool\Models\SysSiteConfigItemsModel;
use Modules\SystemTool\Rules\SysSiteConfigTypeRule;

class SysSiteConfigItemsFormRequest extends BaseFormRequest
{
    protected $stopOnFirstFailure = true;

    public function rules(): array
    {
        $rules = [
            'title' => 'required|string',
            'key' => ['required', 'string', 'min:2', 'max:255'],
            'group_id' => ['required', 'integer', new Exists(SysSiteConfigGroupModel::class, 'id')],
            'type' => ['required', 'string', new SysSiteConfigTypeRule],
            'describe' => 'nullable|string',
            'options' => [
                'sometimes',
                'nullable',
                'string',
                'regex:/^(?:[^=\n]+=[^=\n]+)(?:\n[^=\n]+=[^=\n]+)*$/',
            ],
            'props' => [
                'sometimes',
                'nullable',
                'string',
                'regex:/^(?:[^=\n]+=[^=\n]+)(?:\n[^=\n]+=[^=\n]+)*$/',
            ],
            'sort' => 'nullable|integer',
            'values' => 'nullable|string',
        ];

        if (!$this->isUpdate()) {
            $rules['key'][] = function ($attribute, $value, $fail) {
                $groupId = $this->input('group_id');
                $exists = SysSiteConfigItemsModel::query()
                    ->where('group_id', $groupId)
                    ->where('key', $value)
                    ->exists();
                if ($exists) {
                    $fail('该键名在此分组中已存在');
                }
            };
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => '标题字段是必填的',
            'title.string' => '标题字段必须是字符串',
            'key.required' => '键名字段是必填的',
            'key.string' => '键名字段必填是字符串',
            'key.min' => '键名至少需要 :min 个字符',
            'key.max' => '键名不能超过 :max 个字符',
            'group_id.required' => '分组ID是必填的',
            'group_id.exists' => '选择的分组不存在',
            'type.required' => '类型字段是必填的',
            'describe.string' => '描述必须是字符串',
            'options.regex' => '选项格式不正确，应为 key=value 格式，多个用换行分隔',
            'props.regex' => '属性格式不正确，应为 key=value 格式，多个用换行分隔',
            'sort.integer' => '排序必须是整数',
            'values.string' => '值必须是字符串',
        ];
    }
}
