<?php

namespace Modules\Lms\Services\Admin;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Lms\Repositories\SubjectRepository;

class AdminSubjectService extends BaseService
{
    public function __construct(SubjectRepository $repository)
    {
        $this->baseRepository = $repository;
    }

    public function getList(Request $request)
    {
        $dir = request()->query('dir') ?? 'desc';
        $sort = request()->query('sort') ?? 'updated_at';
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->with(['teachers'])
            ->orderBy($sort, $dir)
            ->paginate($this->limit);

        $collection->map(function ($val,$idx){
            $pivotData = DB::table('lms_subject_school_level_map')
                ->where('subject_id',$val->id)
                ->get()->pluck('school_level_id');
            $val->level_school_ids = $pivotData;
            return $val;
        });

        return $collection;
    }

    public function create(Request $request)
    {
        try{
            $data = $request->all();
            if($request->avatar_url){
                $data['avatar_url'] = $this->removeTmpFileUpload($request);
            }
            DB::beginTransaction();
            $subject = $this->baseRepository->create($data);
            if(!empty($request->teacher_ids)){
                $subject->teachers()->attach($request->teacher_ids);
            }
            if(!empty($request->level_school_ids)){
                $subject->schoolLevels()->attach($request->level_school_ids);
            }
            DB::commit();

            $subject->teachers = $subject->teachers;
            if(isset($subject->level_school_ids)){
                $subject->level_school_ids = $request->level_school_ids;
            }
            return $subject;
        }catch (\Throwable $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $data = $request->all();
            if($request->avatar_url){
                $avatar_url = $this->removeTmpFileUpload($request);
                if(!$avatar_url){
                    $avatar_url = $request->avatar_url;
                }
                $data['avatar_url'] = $avatar_url;
            }
            DB::beginTransaction();
            $subject = $this->baseRepository->update($data,$id);
            if(!empty($request->teacher_ids)){
                $subject->teachers()->sync($request->teacher_ids);
            }
            if(!empty($request->level_school_ids)){
                $subject->schoolLevels()->sync($request->level_school_ids);
            }
            DB::commit();
            $subject->teachers = $subject->teachers;
            if(isset($subject->level_school_ids)){
                $subject->level_school_ids = $request->level_school_ids;
            }
            return $subject;
        }catch (\Throwable $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function find($id)
    {
        $pivotData = DB::table('lms_subject_school_level_map')
            ->where('subject_id',$id)
            ->get()->pluck('school_level_id');

        $examRoom = $this->baseRepository
            ->with(['teachers'])
            ->where(['lms_subjects.id'=>$id])
            ->first();
        $examRoom->level_school_ids = $pivotData;
        return $examRoom;
    }

    private function removeTmpFileUpload($request)
    {
        $user = auth()->user();
        $alias = $user->currentTeam->teamable->alias;
        $tmps = Storage::disk('s3')->allFiles("workspace/$alias/subject_avatar_tmp");
        $avatar_url = '';
        foreach ($tmps as $tmp) {
            if ($request->avatar_url === $tmp) {
                $avatar_url = str_replace("workspace/$alias/subject_avatar_tmp", "workspace/$alias/subject_avatar", $tmp);
                Storage::disk('s3')->move($tmp, $avatar_url);
                Storage::disk('s3')->deleteDirectory("workspace/$alias/subject_avatar_tmp");
            }
        };

        return $avatar_url;
    }
}
