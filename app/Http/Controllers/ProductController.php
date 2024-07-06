<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index(): JsonResponse {
        $products = Product::paginate(24);
        return response()->json($products);
    }

    public function store(ProductRequest $request): JsonResponse {
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->save();
        return response()->json($product, 201);
    }

    public function show($id): JsonResponse {
        $product = Product::find($id);
        if($product) {
            return response()->json($product);
        } else {
            return response()->json(['message' => 'Product not found.'], 404);
        }
    }

    public function update(ProductRequest $request, $id): JsonResponse {
        $product = Product::find($id);
        if($product) {
            $product->name = $request->input('name') ?? $product->name;
            $product->description = $request->input('description') ?? $product->description;
            $product->price = $request->input('price') ?? $product->price;
            $product->stock = $request->input('stock') ?? $product->stock;
            $product->save();
            return response()->json($product, 200);
        } else {
            return response()->json(['message' => 'Product not found.'], 404);
        }
    }

    public function destroy($id): JsonResponse {
        $product = Product::find($id);
        if($product) {
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Product not found.'], 404);
        }
    }

    public function getPorductsByCategory($categoryId): JsonResponse {
        $category = Category::find($categoryId);
        if($category) {
            $products = $category->products();
            return response()->json($products, 200);
        } else {
            return response()->json(['message' => 'Category not found.'], 404);
        }
    }

    public function setCategory($productId, $categoryId): JsonResponse {
        $product = Product::find($productId);
        if($product) {
            $category = Category::find($categoryId);
            if($category) {
                $product->categories()->syncWithoutDetaching($category->id);
                return response()->json(['message' => 'Product assigned to category successfully.'], 200);
            } else {
                return response()->json(['message' => 'Category not found.'], 404);
            }
        } else {
            return response()->json(['message' => 'Product not found.'], 404);
        }
    }
}
