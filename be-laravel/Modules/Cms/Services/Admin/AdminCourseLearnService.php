<?php

namespace Modules\Cms\Services\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Modules\Cms\Models\Course;
use Modules\Cms\Models\CourseLearn;

class AdminCourseLearnService extends BaseService
{
    protected $baseRepository;

    public function __construct(
        \Modules\Cms\Repositories\CourseLearnRepository $courseLearnRepository,
    )
    {
        $this->baseRepository = $courseLearnRepository;
    }

    public function save($courseId, Request $request){
        try {
            DB::beginTransaction();
            // delete learn
            if($this->baseRepository->where('course_id',$courseId)->exists()){
                $learnIds = $this->baseRepository->where(['course_id'=>$courseId])->pluck('id')->toArray();
                $learnIdRequest = collect($request->course_learns)->map(function ($val){
                    return $val['id'] ?? null;
                })->toArray();
                $learnIdDeletes = array_diff($learnIds,$learnIdRequest);
                foreach ($learnIdDeletes as $id){
                    $this->baseRepository->delete($id);
                }
            }

            foreach ($request->course_learns as $item){
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

    public function findLearnsByCourseId($courseId){
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
