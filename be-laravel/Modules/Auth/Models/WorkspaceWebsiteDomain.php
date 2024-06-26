<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class WorkspaceWebsiteDomain.
 *
 * @package namespace Modules\Auth\Models;
 */
class WorkspaceWebsiteDomain extends Model implements Transformable
{
    use TransformableTrait, CoreHasUserAudit, SoftDeletes;

    protected $table = "auth_workspace_website_domains";
    protected $connection = "mysql";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'website_id',
        'domain',
        'sub_domain',
        'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function website()
    {
        return $this->belongsTo(WorkspaceWebsite::class, 'website_id');
    }
}
