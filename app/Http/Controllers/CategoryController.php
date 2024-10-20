<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        return view('categories.index', compact('categories'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
           'name' => 'required|max:255',
           'parent_category' => 'numeric',
           'is_active' => 'string',
        ]);

        Category::create($data);

        return redirect()->route('categories.index')
                         ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): View
    {
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $categories = Category::orderBy('name')->get();

        return view('categories.edit', compact('category', 'categories'));
    }

    public function update(Category $category, Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'parent_category' => 'numeric',
            'is_active' => 'string',
        ]);

        $category->update($data);

        return redirect()->route('categories.index')
                         ->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
                         ->with('success', 'Category deleted successfully');
    }
}
