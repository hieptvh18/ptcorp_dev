<?php

namespace Modules\Cms\Services\Admin;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Auth\Events\EventWorkspaceInfoServiceCreateAfter;

class AdminCmsCategoryService extends BaseService
{
    protected $baseRepository;

    public function __construct(\Modules\Cms\Repositories\CmsCategoryRepository $cmsCategoryRepository)
    {
        $this->baseRepository = $cmsCategoryRepository;
    }

    /**
     *
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function create(Request $request)
    {
        try {
            // remove tmp file upload
            $image_url = $this->removeTmpFileUpload($request);
            DB::beginTransaction();
            $data = $request->all();
            $data['thumbnail_url'] = $image_url;
            $item = $this->baseRepository->create($data);
            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     *
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function update(Request $request,$id)
    {
        try {
            // remove tmp file upload
            $image_url = $this->removeTmpFileUpload($request);
            if(!$image_url){
                $image_url = $request->thumbnail_url;
            }
            DB::beginTransaction();
            $data = $request->all();
            $data['thumbnail_url'] = $image_url;
            $item = $this->baseRepository->update($data,$id);
            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function getList(Request $request)
    {
        $dir = request()->query('dir') ?? 'desc';
        $sort = request()->query('sort') ?? 'updated_at';
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->orderBy($sort, $dir)
            ->paginate($this->limit);
        return $collection;
    }

    private function removeTmpFileUpload($request){
        $user = auth()->user();
        $alias = $user->currentTeam->teamable->alias;
        $image_tmps = Storage::disk('s3')->allFiles("workspace/$alias/cms/cms_category_thumbnail_url_tmp");
        $image_url = '';
        foreach ($image_tmps as $image_tmp) {
            if ($request->thumbnail_url === $image_tmp) {
                $image_url = str_replace("workspace/$alias/cms/cms_category_thumbnail_url_tmp", "workspace/$alias/cms/cms_category_thumbnail_url", $image_tmp);
                Storage::disk('s3')->move($image_tmp, $image_url);
                Storage::disk('s3')->deleteDirectory("workspace/$alias/cms/cms_category_thumbnail_url_tmp");
            }
        };
        return $image_url;
    }
}
