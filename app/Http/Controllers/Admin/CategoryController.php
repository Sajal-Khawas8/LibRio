<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $req)
    {
        $categories = Category::with("books")
            ->when($req->search, fn($q) => $q->whereLike("name", "%$req->search%"))
            ->simplePaginate(9);
        return view("pages.admin.categories.index", compact("categories"));
    }

    public function create()
    {
        return view("pages.admin.categories.add");
    }

    public function store(StoreCategoryRequest $req)
    {
        $validated = $req->validated();

        Category::create(['name' => $validated['category']]);

        return redirect()->route("admin.categories.index")
            ->with("success", $validated['category'] . " category has been added.");
    }

    public function edit(Category $category)
    {
        return view("pages.admin.categories.edit", compact("category"));
    }

    public function update(StoreCategoryRequest $req, Category $category)
    {
        $validated = $req->validated();

        $category->update(['name' => $validated['category']]);

        return redirect()->route("admin.categories.index")
            ->with("success", "Category updated successfully.");
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route("admin.categories.index")
            ->with("success", "Category deleted successfully.");
    }
}
