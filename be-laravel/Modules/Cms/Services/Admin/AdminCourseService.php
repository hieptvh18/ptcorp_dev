<?php

namespace Modules\Cms\Services\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Cms\Models\CourseSchedule;

class AdminCourseService extends BaseService
{
    protected $baseRepository;
    protected $lessionRepository;
    protected $sectionRepository;

    public function __construct(
        \Modules\Cms\Repositories\CourseRepository        $courseRepository,
        \Modules\Cms\Repositories\CourseLessionRepository $lessionRepository,
        \Modules\Cms\Repositories\CourseSectionRepository $sectionRepository
    )
    {
        $this->baseRepository = $courseRepository;
        $this->lessionRepository = $lessionRepository;
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
            $data['total_duration']  = $data['total_duration'] ?? 0;
            $data['avatar_url'] = $this->removeTmpAvatarUpload($request->avatar_url);
            if($request->preview_video_type == 'VIDEO' && $request->preview_video_url){
                $data['preview_video_url'] = $this->removeTmpVideoUpload($request->preview_video_url);
            }
            $course = $this->baseRepository->create($data);

            if($request->instructor_ids){
                $course->instructors()->attach($request->instructor_ids);
            }
            if($request->category_ids){
                $course->categories()->attach($request->category_ids);
            }
            if($request->level_ids && is_array($request->level_ids)){
                $course->levels()->attach($request->level_ids);
            }
            // fixed language vn
            $course->languages()->attach([1]);
            // store schedule
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $schedule_days = $request->schedule_days;
            $courseScheduleModel = new CourseSchedule([
                'course_id'=>$course->id,
                'start_date'=>$start_date,
                'end_date'=>$end_date,
                'schedule_days'=>json_encode($schedule_days),
                'is_active'=>$request->is_active ?? true
            ]);
            $course->schedules()->save($courseScheduleModel);

            DB::commit();
            return $course;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     * @throws Exception
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['total_duration']  = $data['total_duration'] ?? 0;
            $avatar_url = $this->removeTmpAvatarUpload($request->avatar_url);
            if(!$avatar_url){
                $avatar_url = $request->avatar_url;
            }
            $data['avatar_url'] = $avatar_url;

            if($request->preview_url_type == 'VIDEO' && $request->preview_video_url){
                $video_url = $this->removeTmpVideoUpload($request->preview_video_url);
                if(!$video_url){
                    $video_url = $request->preview_video_url;
                }
                $data['preview_video_url'] = $video_url;
            }

            $course = $this->baseRepository->update($data,$id);

            if($request->instructor_ids){
                $course->instructors()->sync($request->instructor_ids);
            }
            if($request->category_ids){
                $course->categories()->sync($request->category_ids);
            }
            if($request->language_ids){
                $course->languages()->sync($request->language_ids);
            }
            if($request->level_ids && is_array($request->level_ids)){
                $course->levels()->sync($request->level_ids);
            }
            // store schedule
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $schedule_days = $request->schedule_days;
            $courseSchedule = [
                'course_id'=>$id,
                'start_date'=>$start_date,
                'end_date'=>$end_date,
                'schedule_days'=>json_encode($schedule_days),
                'is_active'=>$request->is_active ?? true,
            ];
            $course->schedules()->update($courseSchedule);

            DB::commit();
            return $course;
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
//            ->with(['instructors','categories','sections.lessons'])
            ->orderBy($sort, $dir)
            ->paginate($this->limit);

        return $collection;
    }

    public function find($id)
    {
        $course = $this->baseRepository
            ->with(['instructors','categories','languages','levels','schedules'])
            ->findWhere(['id'=>$id])->first();

        return $course;
    }

    private function removeTmpAvatarUpload($requestFile){
        $user = auth()->user();
        $alias = $user->currentTeam->teamable->alias;
        $course_avatar_tmps = Storage::disk('s3')->allFiles("workspace/$alias/cms/cms_course_avatar_tmp");
        $image_url = '';
        foreach ($course_avatar_tmps as $course_avatar_tmp) {
            if ($requestFile === $course_avatar_tmp) {
                $image_url = str_replace("workspace/$alias/cms/cms_course_avatar_tmp", "workspace/$alias/cms/course_avatars", $course_avatar_tmp);
                Storage::disk('s3')->move($course_avatar_tmp, $image_url);
                Storage::disk('s3')->deleteDirectory("workspace/$alias/cms/cms_course_avatar_tmp");
            }
        };

        return $image_url;
    }

    private function removeTmpVideoUpload($requestFile){
        $user = auth()->user();
        $alias = $user->currentTeam->teamable->alias;
        $tmps = Storage::disk('s3')->allFiles("workspace/$alias/cms/cms_course_preview_video_tmp");
        $image_url = '';
        foreach ($tmps as $tmp) {
            if ($requestFile === $tmp) {
                $image_url = str_replace("workspace/$alias/cms/cms_course_preview_video_tmp", "workspace/$alias/cms/course_preview_videos", $tmp);
                Storage::disk('s3')->move($tmp, $image_url);
                Storage::disk('s3')->deleteDirectory("workspace/$alias/cms/cms_course_preview_video_tmp");
            }
        };

        return $image_url;
    }
}
