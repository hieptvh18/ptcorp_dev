<?php

namespace Modules\Cms\Services\Public;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;

class CmsSettingService extends BaseService
{

    public function __construct(\Modules\Cms\Repositories\CmsSettingRepository $cmsBannerRepository)
    {
        $this->baseRepository = $cmsBannerRepository;
    }

    public function getSettingGroup($group){
        $settings = $this->baseRepository->findWhere(['group'=>$group]);
        $settings = $settings->map(function($val) use ($group){
           return [
              $group => [
                  'website_id'=>$val->website_id,
                  'setting'=>$val->setting
              ]
           ] ;
        });
        return $settings;
    }
}
