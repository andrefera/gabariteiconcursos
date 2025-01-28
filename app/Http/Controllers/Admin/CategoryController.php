<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Modules\Admin\Category\DTO\EditCategoryDTO;
use App\Modules\Admin\Category\Services\Actions\CreateOrUpdateCategory;
use App\Modules\Admin\Category\Services\Actions\GetFilterCategory;
use App\Modules\Admin\Category\Services\Actions\ListCategories;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json(ListCategories::fromRequest($request)->execute());
    }

    public function edit(Category $category): JsonResponse
    {
        return response()->json(EditCategoryDTO::fromCategory($category));
    }

    public function createOrUpdate(Request $request): JsonResponse
    {
        return response()->json(CreateOrUpdateCategory::fromRequest($request)->execute());
    }

    public function destroy(Category $category): JsonResponse
    {
        try {
            if ($category->products()->count() > 0) {
                throw new Exception("A categoria possui produtos atrelados.");
            }

            $category->delete();

            return response()->json(['success' => true]);
        } catch (Exception $exception) {
            return response()->json(['success' => false, 'msg' => $exception->getMessage()]);
        }
    }

    public function filter(): JsonResponse
    {
        return response()->json(GetFilterCategory::instantiate()->execute());
    }
}
