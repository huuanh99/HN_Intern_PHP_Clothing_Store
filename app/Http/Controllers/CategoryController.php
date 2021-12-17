<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function showAddCategoryView()
    {
        $category = Category::where('status', 'active')->orderBy('id')->get();

        return view('admin.category.catadd', compact('category'));
    }

    public function showListCategoryView()
    {
        $category = Category::where('status', 'active')->orderBy('id')->get();

        return view('admin.category.catlist', compact('category'));
    }

    public function showEditCategoryView($id)
    {
        $cat = Category::find($id);
        if ($cat == null) {
            return redirect()->route('admindashboard');
        }
        $category = Category::where('status', 'active')->orderBy('id')->get();

        return view('admin.category.catedit', compact('cat', 'category'));
    }

    public function deleteCategory($id)
    {
        $cat = Category::find($id);
        if ($cat == null) {
            return redirect()->route('admindashboard');
        }
        $cat->status = 'disable';
        $cat->save();
        $childcategories = $cat->childcategories;
        foreach ($childcategories as $key => $value) {
            $value->parent_id = null;
            $value->save();
        }

        return redirect()->route('catlist');
    }

    public function addCategory(AddCategoryRequest $request)
    {
        $cat = new Category();
        $cat->name = $request->name;
        $cat->slug = $request->slug;
        $cat->parent_id = $request->parent;
        $cat->save();
        $request->session()->flash('message', __('insertCategory'));

        return redirect()->route('catadd');
    }

    public function editCategory(AddCategoryRequest $request)
    {
        $cat = Category::find($request->id);
        $cat->name = $request->name;
        $cat->slug = $request->slug;
        $cat->parent_id = $request->parent;
        $cat->save();
        $request->session()->flash('message', __('updateCategory'));
        
        return redirect()->route('catedit', ['id' => $cat->id]);
    }
}
