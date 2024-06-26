<?php

namespace Modules\Cms\Services\Admin;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Modules\Cms\Repositories\CmsSettingRepository;

class CmsSettingService extends BaseService
{
    protected $baseRepository;

    public function __construct(CmsSettingRepository $settingRepository)
    {
        $this->baseRepository = $settingRepository;
    }

    public function saveSetting(Request $request)
    {
        try {
            DB::beginTransaction();
            $requestSetting = $request->setting;
            foreach ($requestSetting as $key=>$val){
                if($key == 'logo_url'){
                    $requestSetting[$key] = $this->removeTmpLogoUpload($val);
                }
                if($key == 'favicon') {
                    $requestSetting[$key] = $this->removeTmpFaviconUpload($val);
                }
            }

            $item = $this->baseRepository->updateOrCreate(
                [
                    'group' => $request->group ?? null,
                    'website_id' => $request->website_id ?? null,
            ], [
                'setting' => $requestSetting
            ]);
            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getSetting($websiteId, $group)
    {
        $key = "setting-$group&$websiteId";
        $data = Cache::remember($key, 6000, function () use ($group, $websiteId) {
            return $this->baseRepository->where(['group' => $group, 'website_id' => $websiteId])->first();
        });

        if (!$data) {
            $data = $this->baseRepository->where(['group' => $group, 'website_id' => $websiteId])->first();
        }
        return $data;
    }

    private function removeTmpLogoUpload($image)
    {

        $user = auth()->user();
        $alias = $user->currentTeam->teamable->alias;
        $tmps = Storage::disk('s3')->allFiles("workspace/$alias/cms/cms_course_website_logo_tmp");
        $image_url = '';
        foreach ($tmps as $tmp) {
            if ($image === $tmp) {
                $image_url = str_replace("workspace/$alias/cms/cms_course_website_logo_tmp", "workspace/$alias/cms/website_logo", $tmp);
                Storage::disk('s3')->move($tmp, $image_url);
                Storage::disk('s3')->deleteDirectory("workspace/$alias/cms/cms_course_website_logo_tmp");
            }
        };

        return $image_url;
    }

    private function removeTmpFaviconUpload($image)
    {
        $user = auth()->user();
        $alias = $user->currentTeam->teamable->alias;
        $tmps = Storage::disk('s3')->allFiles("workspace/$alias/cms/cms_course_website_favicon_tmp");
        $image_url = '';
        foreach ($tmps as $tmp) {
            if ($image === $tmp) {
                $image_url = str_replace("workspace/$alias/cms/cms_course_website_favicon_tmp", "workspace/$alias/cms/website_favicon", $tmp);
                Storage::disk('s3')->move($tmp, $image_url);
                Storage::disk('s3')->deleteDirectory("workspace/$alias/cms/cms_course_website_favicon_tmp");
            }
        };

        return $image_url;
    }

}
