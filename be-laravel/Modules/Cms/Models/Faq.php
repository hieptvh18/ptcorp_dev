<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Faq.
 *
 * @package namespace Modules\Cms\Models;
 */
class Faq extends Model implements Transformable
{
    use TransformableTrait,CoreHasUserAudit, SoftDeletes;

    protected $table =  'lms_cms_faqs';

   protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'faq_category_id',
        'question',
        'answer',
        'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function faqCategory(){
        return $this->belongsTo(FaqCategory::class,'faq_category_id');
    }
}
