<?php

namespace Modules\Common\Http\Controllers;

use App\Http\Controllers\ApiController;
use Modules\Common\Http\Requests\CategoryCreateRequest;
use Modules\Common\Http\Requests\CategoryUpdateRequest;
use Modules\Common\Repositories\CategoryRepository;
use Modules\Common\Services\CategoryService;

/**
 * Class TagsController.
 *
 * @package namespace Modules\Common\Http\Controllers;
 */

 class CategoriesController extends ApiController
 {
    protected $categoryService;
      /**
     * TagsController constructor.
     *
     * @param CategoryRepository $repository
     * @param CategoryValidator $validator
     */

     public function __construct(CategoryService $categoryService)
     {
        $this->categoryService = $categoryService;
     }

     public function index() {
        $data = $this->categoryService->getList();
        return $this->json($data);
     }

     public function store(CategoryCreateRequest $categoryCreateRequest) {
        $item = $this->categoryService->create($categoryCreateRequest);
        $data = [
            'message' => __('common::message.create_category_success'),
            'data' => $item
        ];
        return $this->json($data);
     }

     public function update(CategoryUpdateRequest $categoryUpdateRequest, $id) {
        $item = $this->categoryService->update($categoryUpdateRequest, $id);
        $data = [
            'message' => __('common::message.update_category_success'),
            'data' => $item
        ];
        return $this->json($data);
     }

     public function show($id) {
        $data = $this->categoryService->find($id);
        return $this->json(['data' => $data]);
     }

    public function destroy($id) {
        $deleted = $this->categoryService->delete($id);
        $data = [
            'message' => __('common::message.deleted_category_success'),
            'delete' => $deleted
        ];
        return $this->json($data);
    }
 }
