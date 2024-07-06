<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function index(): JsonResponse {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(CategoryRequest $request): JsonResponse {
        $category = new Category();
        $category->name = $request->input('name');
        $category->save();
        return response()->json($category, 201);
    }

    public function show($id): JsonResponse {
        $category = Category::find($id);
        if($category) {
            return response()->json($category);
        } else {
            return response()->json(['message' => 'Category not found.'], 404);
        }
    }

    public function update(CategoryRequest $request, $id): JsonResponse {
        $category = Category::find($id);
        if($category) {
            $category->name = $request->input('name') ?? $category->name;
            $category->save();
            return response()->json($category, 200);
        } else {
            return response()->json(['message' => 'Category not found.'], 404);
        }
    }

    public function destroy($id): JsonResponse {
        $category = Category::find($id);
        if($category) {
            $category->delete();
            return response()->json(['message' => 'Category deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Category not found.'], 404);
        }
    }
}
