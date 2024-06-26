<?php

namespace Modules\Lms\Services\Admin;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Models\WorkspaceInfo;
use Modules\Lms\Models\Member;
use Modules\Lms\Repositories\ClassRoomRepository;

class AdminClassroomService extends BaseService
{
    public function __construct(ClassRoomRepository $repository)
    {
        $this->baseRepository = $repository;
    }

    public function saveClassroom(Request $request)
    {
        try {
            $classrooms = $request->input('classrooms');
            DB::beginTransaction();
            foreach ($classrooms as $classroom) {
                $new_classroom = $this->baseRepository->updateOrCreate(
                    ['id' => $classroom['id'] ?? null],
                    [
                        'name' => $classroom['name'],
                        'type' => $classroom['type'],
                        'status' => $classroom['status'],
                        'parent_id' => 0,
                        'is_active' => $classroom['is_active']
                    ]
                );
                $child_classrooms = $classroom['child_classrooms'];
                foreach ($child_classrooms as $child_classroom) {
                    $this->baseRepository->updateOrCreate(
                        ['id' => $child_classroom['id'] ?? null],
                        [
                            'name' => $child_classroom['name'],
                            'type' => $child_classroom['type'],
                            'status' => $child_classroom['status'],
                            'parent_id' => $new_classroom->id,
                            'is_active' => $child_classroom['is_active']
                        ]
                    );
                }
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function searchClassroom(Request $request)
    {
        try {
            $keywork = $request->input('keywork');
            $classroom_ids = $this->baseRepository->where('name', 'LIKE', "%$keywork%")->orWhere('code', 'LIKE', "%$keywork%")->orWhere('alias', 'LIKE', "%$keywork%")->pluck('id')->toArray();
            return $classroom_ids;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteClassroom(Request $request)
    {
        try {
            $classroom_ids = $request->input('classroom_ids');
            DB::beginTransaction();
            $this->baseRepository->whereIn('id', $classroom_ids)->orWhereIn('parent_id', $classroom_ids)->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function noteClassroom($classroom_id, Request $request)
    {
        try {
            $classroom = $this->baseRepository->find($classroom_id);
            $note = $request->input('note');
            DB::beginTransaction();
            $classroom->update([
                'note' => $note
            ]);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateClassroom(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $item = $this->baseRepository->update($data, $id);
            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
