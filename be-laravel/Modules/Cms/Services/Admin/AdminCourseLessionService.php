<?php

namespace Modules\Cms\Services\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Cms\Models\Course;

class AdminCourseLessionService extends BaseService
{
    protected $courseRepository;

    protected $baseRepository;
    protected $sectionRepository;

    /**
     * @param \Modules\Cms\Repositories\CourseRepository $courseRepository
     * @param \Modules\Cms\Repositories\CourseLessionRepository $lessionRepository
     * @param \Modules\Cms\Repositories\CourseSectionRepository $sectionRepository
     */
    public function __construct(
        \Modules\Cms\Repositories\CourseRepository $courseRepository,
        \Modules\Cms\Repositories\CourseLessionRepository $lessionRepository,
        \Modules\Cms\Repositories\CourseSectionRepository $sectionRepository
    )
    {
        $this->courseRepository = $courseRepository;
        $this->baseRepository = $lessionRepository;
        $this->sectionRepository = $sectionRepository;
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
            $item = $this->baseRepository->create($data);

            // call update total duration
            if(isset($request->is_active) && $request->is_active){
                $section = $this->sectionRepository->find($request->section_id);
                $section->increment('total_duration_lesson',(int)$request->duration);
                $section->save();

                $course = Course::find($request->course_id);
                $course->increment('total_duration',(int)$request->duration);
                $course->save();
            }

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
            DB::beginTransaction();
            $lesson = $this->baseRepository->find($id);

            $lessonDuration = $lesson->duration;
            $lessonUpdate = $this->baseRepository->update($request->all(),$id);

            // call update total duration
            $course = Course::find($request->course_id);
            $section = $this->sectionRepository->find($request->section_id);

            if($request->is_active != $lesson->is_active){ // enable-disable
                if($request->is_active){
                    $section->increment('total_duration_lesson',(int)$request->duration);
                    $course->increment('total_duration',(int)$request->duration);
                }else{
                    $section->decrement('total_duration_lesson',(int)$lessonDuration);
                    $course->decrement('total_duration',(int)$lessonDuration);
                }
            }else{ // change duration
                $total_duration = ((int)$section->total_duration_lesson - (int)$lessonDuration) + (int)$request->duration;
                $section->total_duration_lesson = $total_duration;

                $total_duration = (int)$request->duration + ((int)$course->total_duration - (int)$lessonDuration);
                $course->total_duration = $total_duration;
            }
            $section->save();
            $course->save();

            DB::commit();
            return $lessonUpdate;
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
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $lesson =  $this->baseRepository->find($id);
            $lessonDuration = $lesson->duration;
            $lessonSectionId = $lesson->section_id;
            $lessonUpdate = $this->baseRepository->delete($id);

            // call update total duration lesson
            $section = $this->sectionRepository->find($lessonSectionId);
            $section->decrement('total_duration_lesson',$lessonDuration);
            $section->save();

            $course = Course::find($lesson->course_id);
            $course->decrement('total_duration',(int)$lessonDuration);
            $course->save();

            DB::commit();
            return $lessonUpdate;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function findLessons($courseId,$sectionId){
        $collection = $this->baseRepository
                    ->findWhere(['course_id'=>$courseId,'section_id'=>$sectionId]);
        return $collection;
    }
}
