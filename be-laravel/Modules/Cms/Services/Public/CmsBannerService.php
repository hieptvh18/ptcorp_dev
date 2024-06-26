<?php

namespace Modules\Cms\Services\Public;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;

class CmsBannerService extends BaseService
{

    public function __construct(\Modules\Cms\Repositories\CmsBannerRepository $cmsBannerRepository)
    {
        $this->baseRepository = $cmsBannerRepository;
    }

    public function getListBannerPublish(){
        $data = $this->baseRepository->select('id','name','type','image_url','video_url','link_redirect','position','start_date','end_date','is_active')
            ->where([['is_active',true],['start_date', '<', Carbon::now('Asia/Ho_Chi_Minh')],
                    ['end_date', '>', Carbon::now('Asia/Ho_Chi_Minh')]])
            ->orWhere([['is_active',true],['start_date', '<', Carbon::now('Asia/Ho_Chi_Minh')],
                ['end_date', '=', null]])
                ->limit(10)->get();

        return $data;
    }
}
