<?php

namespace Modules\Lms\Services\Admin;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Modules\Lms\Repositories\ExamRoomRepositoryEloquent;

class AdminExamRoomService extends BaseService
{
    public function __construct(ExamRoomRepositoryEloquent $repository)
    {
        $this->baseRepository = $repository;
    }

    public function getList(Request $request)
    {
        $dir = request()->query('dir') ?? 'desc';
        $sort = request()->query('sort') ?? 'updated_at';
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->with(['editor','classrooms'])
            ->orderBy($sort, $dir)
            ->paginate($this->limit);

//        $collection->each(function ($val,$idx){
//            $val->exam=[
//               'id'=>$val->exam_id,
//               'name'=>$this->findExam($val->exam_id) ? $this->findExam($val->exam_id)['name'] : []
//           ];
//            $val->subject=[
//                'id'=>$val->subject_id,
//                'name'=>$this->findSubject($val->subject_id) ? $this->findSubject($val->subject_id)['name']: []
//            ];
//        });

        return $collection;
    }

    /**
     * @throws \Throwable
     */
    public function create(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $examRoom = $this->baseRepository->create($data);

            if(!empty($request->class_room_ids)){
                $examRoom->classrooms()->attach($request->class_room_ids);
            }
            if(!empty($request->member_ids)){
                $examRoom->members()->attach($request->member_ids);
            }
            DB::commit();

            $examRoom->classrooms = $examRoom->classrooms;
            $examRoom->members = $examRoom->members;
            return $examRoom;
        }catch(\Throwable $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function find($id)
    {
        $examRoom = $this->baseRepository
            ->with(['classrooms','members'])
            ->where('id',$id)->first();

//        $examRoom->exam=[
//            'id'=>$examRoom->exam_id,
//            'name'=>$this->findExam($examRoom->exam_id) ? $this->findExam($examRoom->exam_id)['name'] : []
//        ];
//        $examRoom->subject=[
//            'id'=>$examRoom->subject_id,
//            'name'=>$this->findSubject($examRoom->subject_id) ? $this->findSubject($examRoom->subject_id)['name']: []
//        ];

        return $examRoom;
    }

    public function update(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $examRoom = $this->baseRepository->update($data,$id);

            if(!empty($request->class_room_ids)){
                $examRoom->classrooms()->sync($request->class_room_ids);
            }
            if(!empty($request->member_ids)){
                $examRoom->members()->sync($request->member_ids);
            }
            DB::commit();

            $examRoom->classrooms = $examRoom->classrooms;
            $examRoom->members = $examRoom->members;
            return $examRoom;
        }catch(\Throwable $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function getExamRoomByIds(Request $request){
        $exam_room_ids = request()->query('exam_room_ids');
        $collection = $this->baseRepository->whereIn('id', $exam_room_ids)->get();
        return $collection;
    }

    private function findSubject($subjectId){
        try{
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => request()->header('Authorization')
            ])->get(config('lms.service_url.eduquiz') . "/quiz/api/v1/public/major-subjects/$subjectId",[
                'parameters' => []
            ]);
            return $response->json('data');
        }catch (\Throwable $e){
            return null;
        }
    }

    private function findExam($examId){
        try{
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => request()->header('Authorization')
            ])->get(config('lms.service_url.eduquiz') . "/quiz/api/v1/public/exams/$examId",[
                'parameters' => []
            ]);
            return $response->json('data');
        }catch(\Throwable $e){
            return null;
        }
    }
}
