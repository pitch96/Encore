<?php

namespace App\Services;

use App\Models\Admin\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CategoryService
{
    /**
     * View Category page service
     * Get the all category from categories table
     */
    public function getAllActiveCategory()
    {
        $categories = Category::getAllActiveCategory()
            ->orderBy('id', 'desc')
            ->get();
        return $categories;
    }

    /**
     * Store category in categories table service
     * @param [int] user_id
     * @param [string] name
     */
    public function storeCategory($request)
    {
        $category = Category::create([
            'user_id'   => Auth::user()->id,
            'name'      => $request->name,
        ]);
        return $category;
    }

    /**
     * get category by id service
     * @param [int] id
     */
    public function getCategoryById($id)
    {
        $category = Category::findOrFail(Crypt::decrypt($id));
        return $category;
    }

    /**
     * Update category details by id service
     * @param [int] user_id
     * @param [string] name
     */
    public function updateCategory($request, $id)
    {
        $category = Category::findOrFail(Crypt::decrypt($id))->update([ 'name' => $request->name ]);
        return $category;
    }
}
