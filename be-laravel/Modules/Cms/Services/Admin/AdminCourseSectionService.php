<?php

namespace Modules\Cms\Services\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Cms\Models\Course;

class AdminCourseSectionService extends BaseService
{
    /**
     * @var \Modules\Cms\Repositories\CourseSectionRepository
     */
    protected $baseRepository;

    protected $courseRepository;

    /**
     * @param \Modules\Cms\Repositories\CourseSectionRepository $sectionRepository
     */
    public function __construct(
        \Modules\Cms\Repositories\CourseSectionRepository $sectionRepository,
        \Modules\Cms\Repositories\CourseRepository $courseRepository,
    )
    {
        $this->baseRepository = $sectionRepository;
        $this->courseRepository = $courseRepository;
    }

    /**
     * @param $courseId
     * @return mixed
     */
    public function findSections($courseId){
        $sections = $this->baseRepository
            ->with(['lessons'])
            ->findWhere(['course_id'=>$courseId]);

        return $sections;
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
            DB::beginTransaction();
            $data = $request->all();
            $section = $this->baseRepository->update($data,$id);
            $course = $this->courseRepository->find($data['course_id']);

            if($request->is_active != $section->is_active){
                if(!$data['is_active'] && $course->total_duration){
                    $course->decrement('total_duration',$section->total_duration_lesson);
                }else if($data['is_active']){
                    $course->increment('total_duration',$section->total_duration_lesson);
                }
            }

            DB::commit();
            return $section;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param $id
     * @return int
     * @throws Exception
     */
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $section =  $this->baseRepository->find($id);
            $lessonTotalDuration = $section->total_duration_lesson;
            $this->baseRepository->delete($id);

            // call update total duration lesson
            $course = $this->courseRepository->find($section->course_id);
            $course->decrement('total_duration',(int)$lessonTotalDuration);
            $course->save();

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
