<?php

namespace Modules\Auth\Traits;

use Modules\Auth\Models\Teamwork;

trait HasTeamwork
{
    /**
     * Get the team.
     */
    public function team()
    {
        return $this->morphOne(Teamwork::class, 'teamable');
    }
}
