<?php

namespace Modules\Cms\Services\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Codebyray\ReviewRateable\Models\Rating;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\throwException;

class AdminCourseReviewService extends BaseService
{
    protected $baseRepository;
    protected $courseRepository;

    public function __construct(
        \Modules\Cms\Repositories\CourseRepository $courseRepository,
        \Modules\Cms\Repositories\CmsReviewRepository $cmsReviewRepository,
    )
    {
        $this->courseRepository = $courseRepository;
        $this->baseRepository = $cmsReviewRepository;
    }

    public function getListReview(Request $request){
        $dir = request()->query('dir') ?? 'desc';
        $sort = request()->query('sort') ?? 'updated_at';
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->with(['course'])
            ->orderBy($sort, $dir)
            ->paginate($this->limit);

        return $collection;
    }

    public function createReview(Request $request){
        try{
            $requestData = $request->all();
            $requestData['approved'] = 1;
            DB::beginTransaction();
            $course = $this->courseRepository->findOrFail($request->course_id);
            $rating = $course->rating($requestData,auth()->user());

            DB::commit();
            return $rating;
        }catch(Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function getReviewById($id){
        $review = $this->baseRepository->findOrFail($id);
        $course = $this->courseRepository->find($review->reviewrateable_id);
        $review->course = $course;
        return $review;
    }

    public function updateReview($request,$id){
        try{
            $requestData = $request->all();
            DB::beginTransaction();
//            $course = $this->courseRepository->findOrFail($request->course_id);
//            $rating = $course->updateRating($id,$requestData);
            $requestData['reviewrateable_id'] = $request->course_id;
            $rating = $this->baseRepository->update($requestData,$id);

            DB::commit();
            return $rating;
        }catch(Exception $e){
            DB::rollback();
            throw $e;
        }
    }
}
