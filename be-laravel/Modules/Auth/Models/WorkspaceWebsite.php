<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class WorkspaceWebsite.
 *
 * @package namespace Modules\Auth\Models;
 */
class WorkspaceWebsite extends Model implements Transformable
{
    use TransformableTrait, CoreHasUserAudit, SoftDeletes;

    protected $table = "auth_workspace_website";
    protected $connection = "mysql";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'workspace_alias',
        'title',
        'description',
        'slogan',
        'logo_url',
        'favicon',
        'email',
        'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function websiteDomain(){
        return $this->hasMany(WorkspaceWebsiteDomain::class, 'website_id');
    }

}
