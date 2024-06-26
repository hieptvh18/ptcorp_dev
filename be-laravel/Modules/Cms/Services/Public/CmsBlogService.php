<?php

namespace Modules\Cms\Services\Public;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Cms\Repositories\CmsBlogRepository;

class CmsBlogService extends BaseService
{

    public function __construct(CmsBlogRepository $cmsBlogRepository)
    {
        $this->baseRepository = $cmsBlogRepository;
    }

    public function getListBlog(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository->where([
            ['status', 'PUBLISHED'],
            ['bizapp', 'EDUCMS'],
            ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
            ['finished_at', '>', Carbon::now('Asia/Ho_Chi_Minh')]
        ])
            ->orWhere([
                ['status', 'PUBLISHED'],
                ['bizapp', 'EDUCMS'],
                ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
                ['finished_at', '=', null]
            ])
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $collection;
    }

    public function findPublicBlog($alias)
    {
        $blog = $this->baseRepository
            ->where([
                ['status', 'PUBLISHED'],
                ['alias', $alias],
                ['bizapp', 'EDUCMS'],
                ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
                ['finished_at', '>', Carbon::now('Asia/Ho_Chi_Minh')]
            ])
            ->orWhere([
                ['status', 'PUBLISHED'],
                ['alias', $alias],
                ['bizapp', 'EDUCMS'],
                ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
                ['finished_at', '=', null]
            ])->firstOrFail();
        $blog->load(['creator', 'categories:id,name,alias,is_active', 'tags:id,name,is_active']);

        // get previous blog id
        $previousId = $this->baseRepository->where('id', '<', $blog->id)->where(['status' => 'PUBLISHED', 'bizapp' => 'EDUCMS'])->max('id');

        // get next blog id
        $nextId = $this->baseRepository->where('id', '>', $blog->id)->where(['status' => 'PUBLISHED', 'bizapp' => 'EDUCMS'])->min('id');
        $blog->previous = $this->baseRepository->select('id', 'name', 'alias', 'status')->find($previousId);
        $blog->next = $this->baseRepository->select('id', 'name', 'alias', 'status')->find($nextId);

        return $blog;
    }

    public function getRelatedBlog($blog_id)
    {
        $limit = request()->query('limit', 10);
        $blog = $this->baseRepository->where([
            ['status', 'PUBLISHED'],
            ['id', $blog_id],
            ['bizapp', 'EDUCMS'],
            ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
            ['finished_at', '>', Carbon::now('Asia/Ho_Chi_Minh')]
        ])
            ->orWhere([
                ['status', 'PUBLISHED'],
                ['id', $blog_id],
                ['bizapp', 'EDUCMS'],
                ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
            ])->firstOrFail();
        $category_blog_ids = $blog->categories->pluck('id');
        $tag_blog_ids = $blog->tags->pluck('id');
        $related_blog = $this->baseRepository->where([
            ['status', 'PUBLISHED'],
            ['bizapp', 'EDUCMS'],
            ['id', '<>', $blog_id],
            ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
            ['finished_at', '>', Carbon::now('Asia/Ho_Chi_Minh')]
        ])
            ->orWhere([
                ['status', 'PUBLISHED'],
                ['bizapp', 'EDUCMS'],
                ['id', '<>', $blog_id],
                ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
                ['finished_at', '=', null]
            ])->whereHas('categories', function ($query) use ($category_blog_ids) {
                $query->whereIn('category_id', $category_blog_ids);
            })
            ->whereHas('tags', function ($query) use ($tag_blog_ids) {
                $query->whereIn('tag_id', $tag_blog_ids);
            })
            ->inRandomOrder()->limit($limit)->get();
        return $related_blog;
    }
}
