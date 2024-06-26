<?php

namespace Modules\Cms\Services\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Cms\Models\Course;
use Modules\Cms\Models\CourseRequirement;

class AdminCourseRequirementService extends BaseService
{
    protected $baseRepository;

    public function __construct(\Modules\Cms\Repositories\CourseRequirementRepository $courseRequirementRepository)
    {
        $this->baseRepository = $courseRequirementRepository;
    }

    public function save($courseId, Request $request){
        try {
            DB::beginTransaction();
            // delete requirement
            if($this->baseRepository->where('course_id',$courseId)->exists()){
                $requirementIds = $this->baseRepository->where(['course_id'=>$courseId])->pluck('id')->toArray();
                $requirementIdRequest = collect($request->course_requirements)->map(function ($val){
                    return $val['id'] ?? null;
                })->toArray();
                $requiremntIdDeletes = array_diff($requirementIds,$requirementIdRequest);

                foreach ($requiremntIdDeletes as $id){
                    $this->baseRepository->delete($id);
                }
            }
            foreach ($request->course_requirements as $item){
                $this->baseRepository->updateOrCreate(
                    [
                        'id' => $item['id'] ?? null,
                        'course_id'=>$courseId ?? null],
                    [
                        'name'=>$item['name'],
                        'is_active'=>true
                    ]);

            }

            DB::commit();
            return $this->baseRepository->findWhere(['course_id'=>$courseId]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function findRequirementsByCourseId($courseId){
        $dir = request()->query('dir') ?? 'desc';
        $sort = request()->query('sort') ?? 'updated_at';
        $this->limit = request()->query('size') ?? 12;
        $data = $this->baseRepository
            ->where(['course_id'=>$courseId,'is_active'=>true])
            ->orderBy($sort, $dir)
            ->paginate($this->limit);
        return $data;
    }
}
