<?php

namespace Modules\Common\Services\Admin\Setting;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Common\Settings\FlagSettings;

class FlagSettingAdminService
{

    public function getFlagSetting(Request $request)
    {
        $flag_config = config('common.flags');
        $data = [
            'data' => $flag_config
        ];
        return $data;
    }

}
