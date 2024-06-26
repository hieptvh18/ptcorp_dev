<?php

namespace Modules\Cms\Services\Admin;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Modules\Cms\Repositories\SettingRepository;

class AdminCmsSettingService extends BaseService
{
    protected $baseRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->baseRepository = $settingRepository;
    }

    public function saveSetting(Request $request)
    {
        try {
            DB::beginTransaction();
            $item = $this->baseRepository->updateOrCreate([
                'group' => $request->group,
                'name' => $request->name,
            ], [

                'payload' => $request->payload
            ]);;
            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getSetting($group, $name)
    {
        $key = "setting-$group&$name";
        $data = Cache::remember($key, 6000, function () use ($group, $name) {
            return $this->baseRepository->where(['group' => $group, 'name' => $name])->first();
        });

        if (!$data) {
            $data = $this->baseRepository->where(['group' => 'group', 'name' => 'name'])->first();
        }
        return $data;
    }

}
