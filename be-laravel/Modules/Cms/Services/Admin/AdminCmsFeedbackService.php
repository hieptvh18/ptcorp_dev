<?php

namespace Modules\Cms\Services\Admin;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminCmsFeedbackService extends BaseService
{
    protected $baseRepository;

    public function __construct(\Modules\Cms\Repositories\CmsFeedbackRepository $cmsFeedRepository)
    {
        $this->baseRepository = $cmsFeedRepository;
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
            DB::beginTransaction();
            $data = $request->all();
            $data['student_avatar_url'] = $this->removeTmpFileUpload($request);
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
                $image_url = $request->student_avatar_url;
            }
            DB::beginTransaction();
            $data = $request->all();
            $data['student_avatar_url'] = $image_url;
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
        $cms_feedback_tmps = Storage::disk('s3')->allFiles("workspace/$alias/cms/cms_feedback_student_avatar_url_tmp");
        $image_url = '';
        foreach ($cms_feedback_tmps as $cms_feedback_tmp) {
            if ($request->student_avatar_url === $cms_feedback_tmp) {
                $image_url = str_replace("workspace/$alias/cms/cms_feedback_student_avatar_url_tmp", "workspace/$alias/cms/cms_feedback_student_avatar_url", $cms_feedback_tmp);
                Storage::disk('s3')->move($cms_feedback_tmp, $image_url);
                Storage::disk('s3')->deleteDirectory("workspace/$alias/cms/cms_feedback_student_avatar_url_tmp");
            }
        };
        return $image_url;
    }
}
