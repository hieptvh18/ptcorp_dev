<?php

namespace Modules\Core\Traits\Plan;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Core\Models\Plan;

trait CoreHasBelongsToPlan
{
    /**
     * The model always belongs to a plan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id', 'plan');
    }

    /**
     * Scope models by plan id.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param int                                   $planId
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPlanId(Builder $builder, int $planId): Builder
    {
        return $builder->where('plan_id', $planId);
    }
}
