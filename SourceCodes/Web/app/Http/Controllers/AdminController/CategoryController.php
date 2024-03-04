<?php

namespace App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CategoryFormRequest;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * View Category page
     * Get the all category from categories table
     */
    public function manageCategories(Request $request)
    {
        try {
            $categories = $this->categoryService->getAllActiveCategory();
            return view('admin.category.index', compact('categories'));
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * View create category page
     */
    public function createCategory()
    {
        return view('admin.category.create');
    }

    /**
     * Store category in categories Table
     * @param [int] user_id
     * @param [string] name
     */
    public function saveCategory(CategoryFormRequest $request)
    {
        $request->validated();
        try {
            $category = $this->categoryService->storeCategory($request);
            if ($category) {
                return Redirect::to("/admin/manage/categories")->with('success', trans('messages.category.success.save'));
            } else {
                return back()->withInput()->with('error', trans('messages.category.error.save'));
            }
        } catch (\Exception $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    /**
     * Edit category Details
     * @param [int] id
     */
    public function editCategory($id)
    {
        try {
            $category = $this->categoryService->getCategoryById($id);
            return view('admin.category.update', compact('category'));
        } catch (\Exception $exception) {
            return Redirect::to("/admin/manage/categories")->with('error', trans('messages.category.error.not_found'));
        }
    }

    /**
     * Update category details by id
     * @param [int] user_id
     * @param [string] name
     */
    public function updateCategory(CategoryFormRequest $request, $id)
    {
        $request->validated();
        try {
            $this->categoryService->updateCategory($request, $id);
            return Redirect::to("/admin/manage/categories")->with('success', trans('messages.category.success.update'));
        } catch (\Exception $exception) {
            return Redirect::back()->with('error', trans('messages.category.error.not_found'));
        }
    }

    /**
     * Delete category Details
     * @param [int] id
     */
    public function deleteCategory($id)
    {
        try {
            $this->categoryService->getCategoryById($id)->delete();
            return response()->json([
                'status' => true,
                'message' => trans('messages.category.success.delete')
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => trans('messages.category.error.not_found')
            ]);
        }
    }

    /**
     * Change category Status by id
     * @param [int] id
     */
    public function changeStatus($id, $status)
    {
        try {
            $this->categoryService->getCategoryById($id)->update(['status' => $status]);
            return Redirect::to("/admin/manage/categories")->with('success', trans('messages.category.success.change_status'));
        } catch (\Exception $exception) {
            return Redirect::to("/admin/manage/categories")->with('error', trans('messages.category.error.not_found'));
        }
    }
}
