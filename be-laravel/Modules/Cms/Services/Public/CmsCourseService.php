<?php

namespace Modules\Cms\Services\Public;

use App\Services\BaseService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Cms\Models\Course;
use Modules\Cms\Models\CourseReview;
use function Laravel\Prompts\select;

class CmsCourseService extends BaseService
{
    protected $baseRepository;
    protected $categoryRepository;
    protected $instructorRepository;
    protected $levelRepository;
    protected $languageRepository;

    public function __construct(
        \Modules\Cms\Repositories\CourseRepository $cmsCourseRepository,
        \Modules\Cms\Repositories\CmsCategoryRepository $cmsCategoryRepository,
        \Modules\Cms\Repositories\CourseInstructorRepository $courseInstructorRepository,
        \Modules\Cms\Repositories\CourseLevelRepository $courseLevelRepository,
        \Modules\Cms\Repositories\CourseLanguageRepository $courseLanguageRepository,
    ) {
        $this->baseRepository = $cmsCourseRepository;
        $this->categoryRepository = $cmsCategoryRepository;
        $this->instructorRepository = $courseInstructorRepository;
        $this->levelRepository = $courseLevelRepository;
        $this->languageRepository = $courseLanguageRepository;
    }

    /**
     * Get list course publish
     * @param Request $request
     * @return mixed
     */
    public function getCoursesPublish(Request $request)
    {
        $dir = request()->query('dir') ?? 'desc';
        $sort = request()->query('sort') ?? 'updated_at';
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->select([
                'id', 'name', 'alias', 'code', 'short_description', 'description', 'avatar_url',
                'regular_price', 'sale_price', 'preview_video_url', 'total_duration', 'type', 'address', 'status'
            ])
            ->withCount(['sections', 'lessons', 'ratings'])
            ->with([
                'levels' => function ($q) {
                    $q->select(
                        'lms_cms_course_level.id',
                        'lms_cms_course_level.name',
                        'lms_cms_course_level.description',
                        'lms_cms_course_level.code',
                        'lms_cms_course_level.alias',
                        'lms_cms_course_level.is_active',
                        'lms_cms_course_level.created_at',
                        'lms_cms_course_level.updated_at'
                    );
                }, 'learns',
                'instructors' => function ($q) {
                    $q->select('lms_course_instructors.id', 'lms_course_instructors.name', 'lms_course_instructors.avatar_url');
                }
            ])
            ->where('status', 'PUBLISH')
            ->orderBy($sort, $dir)
            ->paginate($this->limit);

        foreach ($collection as $item) {
            $item->ratings_average = $item->averageRating(1) ?? 0;
        }

        return $collection;
    }

    /**
     * Get course detail by courseId
     * @param $id
     * @return mixed
     */
    public function getCourse($id)
    {
        $course = $this->baseRepository
            ->select(
                'id',
                'name',
                'alias',
                'code',
                'short_description',
                'description',
                'regular_price',
                'avatar_url',
                'sale_price',
                'preview_video_url',
                'preview_video_type',
                'total_duration',
                'type',
                'address',
                'status',
                'created_at',
                'updated_at'
            )
            ->where('id', $id)
            ->withCount(['sections', 'lessons'])
            ->with([
                'instructors' => function ($q) {
                    $q->select(
                        'lms_course_instructors.id',
                        'lms_course_instructors.name',
                        'lms_course_instructors.avatar_url',
                        'lms_course_instructors.description'
                    );
                    $q->withCount('courses');
                }, 'sections.lessons' => function ($q) {
                    $q->select(
                        'lms_course_section_lessons.id',
                        'lms_course_section_lessons.course_id',
                        'lms_course_section_lessons.section_id',
                        'lms_course_section_lessons.name',
                        'lms_course_section_lessons.description',
                        'lms_course_section_lessons.preview_video_url',
                        'lms_course_section_lessons.duration',
                        'lms_course_section_lessons.is_active'
                    );
                }, 'learns' => function ($q) {
                    $q->select('lms_course_learns.id', 'lms_course_learns.course_id', 'lms_course_learns.name', 'lms_course_learns.is_active');
                }, 'requirements' => function ($q) {
                    $q->select('lms_course_requirements.id', 'lms_course_requirements.course_id', 'lms_course_requirements.name', 'lms_course_requirements.is_active');
                }, 'languages' => function ($q) {
                    $q->select('lms_course_languages.id', 'lms_course_languages.name', 'lms_course_languages.code', 'lms_course_languages.flag');
                }, 'levels' => function ($q) {
                    $q->select(
                        'lms_cms_course_level.id',
                        'lms_cms_course_level.name',
                        'lms_cms_course_level.description',
                        'lms_cms_course_level.code',
                        'lms_cms_course_level.alias',
                        'lms_cms_course_level.is_active'
                    );
                }, 'categories' => function ($q) {
                    $q->select(
                        'lms_cms_categories.id',
                        'lms_cms_categories.name',
                        'lms_cms_categories.description',
                        'lms_cms_categories.code',
                        'lms_cms_categories.alias',
                        'lms_cms_categories.is_active'
                    );
                },
                'schedules' => function ($q) {
                    $q->select('lms_course_schedules.id', 'lms_course_schedules.course_id', 'lms_course_schedules.start_date', 'lms_course_schedules.end_date', 'lms_course_schedules.schedule_days');
                }
            ])
            ->first();
        if ($course->schedules) {
            $course->schedules->schedule_days = json_decode($course->schedules->schedule_days);
        }
        $course->ratings_average = $course->averageRating(1) ?? 0;
        $course->reviews_count = $course->countRating();

        $course->ratings_statis = $this->statisRatingReview($id);

        //        $course->ratings_percent = $course->ratingPercent();
        return $course;
    }

    /**
     * Get list filterable
     * @return array
     */
    public function getListFilterable(Request $request)
    {
        $category_ids  = request()->query('category_ids');
        $instructor_ids  = request()->query('instructor_ids');
        $level_ids  = request()->query('level_ids');
        $language_ids  = request()->query('language_ids');
        $type_select = request()->query('type_select');
        if ($type_select == 'category') {
            $category = $this->categoryRepository
                ->select('id', 'name')
                ->withCount(['courses' => function ($q) {
                    $q->where('status', 'PUBLISH');
                }])
                ->where('type', 'COURSE')->where('is_active', true)->get();
            $levels = $this->levelRepository->select('id', 'name')

                ->where('is_active', true)->courseCountMasterData('category', $category_ids)->get();
            $instructors = $this->instructorRepository->select('id', 'name')
                ->courseCountMasterData('category', $category_ids)
                ->get();
            $langs = $this->languageRepository->select('id', 'name', 'code')
                ->courseCountMasterData('category', $category_ids)
                ->get();
            $priceType = ['all', 'free', 'paid'];
        }
        if ($type_select == 'level') {
            $category = $this->categoryRepository
                ->select('id', 'name')
                ->courseCountMasterData('level', $level_ids)
                ->where('type', 'COURSE')->where('is_active', true)->get();
            $levels = $this->levelRepository->select('id', 'name')
                ->withCount(['courses' => function ($q) {
                    $q->where('status', 'PUBLISH');
                }])
                ->where('is_active', true)->get();
            $instructors = $this->instructorRepository->select('id', 'name')
                ->courseCountMasterData('level', $level_ids)
                ->get();
            $langs = $this->languageRepository->select('id', 'name', 'code')
                ->courseCountMasterData('level', $level_ids)
                ->get();
            $priceType = ['all', 'free', 'paid'];
        }
        if ($type_select == 'instructor') {
            $category = $this->categoryRepository
                ->select('id', 'name')
                ->courseCountMasterData('instructor', $instructor_ids)
                ->where('type', 'COURSE')->where('is_active', true)->get();
            $levels = $this->levelRepository->select('id', 'name')
                ->courseCountMasterData('instructor', $instructor_ids)
                ->where('is_active', true)->get();
            $instructors = $this->instructorRepository->select('id', 'name')
                ->withCount(['courses' => function ($q) {
                    $q->where('status', 'PUBLISH');
                }])
                ->get();
            $langs = $this->languageRepository->select('id', 'name', 'code')
                ->courseCountMasterData('instructor', $instructor_ids)
                ->get();
            $priceType = ['all', 'free', 'paid'];
        }
        if ($type_select == 'language') {
            $category = $this->categoryRepository
                ->select('id', 'name')
                ->courseCountMasterData('language', $language_ids)
                ->where('type', 'COURSE')->where('is_active', true)->get();
            $levels = $this->levelRepository->select('id', 'name')
                ->courseCountMasterData('language', $language_ids)
                ->where('is_active', true)->get();
            $instructors = $this->instructorRepository->select('id', 'name')
                ->courseCountMasterData('language', $language_ids)
                ->get();
            $langs = $this->languageRepository->select('id', 'name', 'code')
                ->withCount(['courses' => function ($q) {
                    $q->where('status', 'PUBLISH');
                }])
                ->get();
            $priceType = ['all', 'free', 'paid'];
        }else{
            $category = $this->categoryRepository
                ->select('id', 'name')
                ->withCount(['courses' => function ($q) {
                    $q->where('status', 'PUBLISH');
                }])
                ->where('type', 'COURSE')->where('is_active', true)->get();
            $levels = $this->levelRepository->select('id', 'name')
            ->withCount(['courses' => function ($q) {
                $q->where('status', 'PUBLISH');
            }])
                ->where('is_active', true)->get();
            $instructors = $this->instructorRepository->select('id', 'name')
            ->withCount(['courses' => function ($q) {
                $q->where('status', 'PUBLISH');
            }])
                ->get();
            $langs = $this->languageRepository->select('id', 'name', 'code')
                ->withCount(['courses' => function ($q) {
                    $q->where('status', 'PUBLISH');
                }])
                ->get();
            $priceType = ['all', 'free', 'paid'];
        }


        return [
            'categories' => $category,
            'levels' => $levels,
            'instructors' => $instructors,
            'priceType' => $priceType,
            'languages' => $langs,
        ];
    }

    /**
     * Get list rating percent
     * @return mixed
     */
    private function statisRatingReview($courseId)
    {
        $totalRatings = CourseReview::select(DB::raw("count('id') as rating_count"))
            ->first();
        $countRatings = CourseReview::select('rating',  DB::raw("count('id') as rating_count"))
            ->groupBy('rating')
            ->orderBy('rating', 'DESC')
            ->whereHasMorph('reviewrateable', Course::class)
            ->where('reviewrateable_id',$courseId)
            ->get()->map(function ($val) use ($totalRatings) {
                $val['percent'] = (float)number_format(($val->rating_count / (int)$totalRatings->rating_count) * 100, 2);
                return $val;
            });

        return $countRatings;
    }

    /**
     * Get recommend courses
     * @param $course_id
     * @return void
     */
    public function getRecommendCourses($course_id)
    {
        $dir = request()->query('dir') ?? 'desc';
        $sort = request()->query('sort') ?? 'updated_at';
        $limit = request()->query('size') ?? 12;
        $course = $this->baseRepository->findOrFail($course_id);
        $category_ids = $course->categories()->pluck('category_id')->toArray();
        $instructor_ids = $course->instructors()->pluck('instructor_id')->toArray();
        $collection = $this->baseRepository
            //            ->select('id','name','short_description','regular_price','sale_price','avatar_url','total_duration')
            ->where('id', '<>', 23)
            ->where('status', 'PUBLISH')
            ->whereHas('categories', function ($query) use ($category_ids, $instructor_ids) {
                $query->whereIn('lms_cms_categories.id', $category_ids);
            })
            ->whereHas('instructors', function ($query) use ($category_ids, $instructor_ids) {
                $query->whereIn('lms_course_instructors.id', $instructor_ids);
            })
            ->with(['levels' => function ($q) {
                $q->select(
                    'lms_cms_course_level.id',
                    'lms_cms_course_level.name',
                    'lms_cms_course_level.description',
                    'lms_cms_course_level.code',
                    'lms_cms_course_level.alias',
                    'lms_cms_course_level.is_active'
                )->where('lms_cms_course_level.is_active', true);
            }, 'instructors' => function ($q) {
                $q->select('lms_course_instructors.id', 'lms_course_instructors.name', 'lms_course_instructors.avatar_url');
            }])
            ->withCount(['ratings', 'lessons'])
            ->orderBy($sort, $dir)
            ->limit($limit)->get();

        foreach ($collection as $item) {
            $item->ratings_average = $item->averageRating(1) ?? 0;
        }

        return $collection;
    }
}
