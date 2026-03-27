<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Category\CreateCategoryAction;
use App\Actions\Admin\Category\DeleteCategoryAction;
use App\Actions\Admin\Category\UpdateCategoryAction;
use App\DTOs\Admin\CategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Category::with('parent')->orderBy('level')->orderBy('sort_order');

        if ($request->filled('parent_id')) {
            $query->where('parent_id', $request->input('parent_id'));
        }

        $categories = $query->paginate(50)->withQueryString();
        $roots      = Category::whereNull('parent_id')->orderBy('sort_order')->get();

        return view('admin.categories.index', compact('categories', 'roots'));
    }

    public function create(): View
    {
        $parents = Category::whereNull('parent_id')->orderBy('sort_order')->get();

        return view('admin.categories.create', compact('parents'));
    }

    public function store(StoreCategoryRequest $request, CreateCategoryAction $action): RedirectResponse
    {
        $action->execute(CategoryDTO::fromRequest($request));

        return redirect()->route('admin.categories.index')
            ->with('success', __t('admin.category_created'));
    }

    public function edit(Category $category): View
    {
        $parents = Category::whereNull('parent_id')->orderBy('sort_order')->get();

        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(UpdateCategoryRequest $request, Category $category, UpdateCategoryAction $action): RedirectResponse
    {
        $action->execute($category, CategoryDTO::fromRequest($request));

        return redirect()->route('admin.categories.index')
            ->with('success', __t('admin.category_updated'));
    }

    public function destroy(Category $category, DeleteCategoryAction $action): RedirectResponse
    {
        try {
            $action->execute($category);

            return redirect()->route('admin.categories.index')
                ->with('success', __t('admin.category_deleted'));
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
    }
}
