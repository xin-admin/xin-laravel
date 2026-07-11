<?php
namespace Modules\SystemTool\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class SiteConfig Group
 */
class SysSiteConfigGroupModel extends Model
{
    protected $table = 'sys_site_config_group';

    protected $fillable = [
        'title',
        'key',
        'remark',
    ];

    /**
     * 关联设置项目
     * @return HasMany
     */
    public function configs(): HasMany
    {
        return $this->hasMany(SysSiteConfigItemsModel::class ,'group_id', 'id');
    }

}
