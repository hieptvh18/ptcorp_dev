<?php

namespace Modules\Common\Http\Controllers;

use App\Http\Controllers\ApiController;
use Modules\Common\Http\Requests\TagCreateRequest;
use Modules\Common\Repositories\TagRepository;
use Modules\Common\Services\TagService;
use Modules\Common\Validators\TagValidator;

/**
 * Class TagsController.
 *
 * @package namespace Modules\Common\Http\Controllers;
 */

class TagsController extends ApiController
{
    protected $tagService;
    /**
     * TagsController constructor.
     *
     * @param TagRepository $repository
     * @param TagValidator $validator
     */

     public function __construct(TagService $tagService)
     {
        $this->tagService = $tagService;
     }

     public function index() {
        // dd($this->tagService);
        $data = $this->tagService->getList();
        return $this->json($data);
     }

     public function store(TagCreateRequest $tagCreateRequest) {
        $item = $this->tagService->create($tagCreateRequest);
        $data = [
            'message' => __('common::message.create_success'),
            'data' => $item
        ];
        return $this->json($data);
     }

     public function update(TagCreateRequest $tagCreateRequest, $id) {
        $item = $this->tagService->update($tagCreateRequest,$id);
        $data = [
            'message' => __('common::message.updated_success'),
            'data' => $item
        ];
        return $this->json($data);
     }

     public function show($id){
        $data = $this->tagService->find($id);
        return $this->json(['data' => $data]);
    }

    public function destroy($id){
        $deleted = $this->tagService->delete($id);
        $data = [
            'message' => __('common::message.deleted_success'),
            'deleted' => $deleted
        ];
        return $this->json($data);
    }
}
