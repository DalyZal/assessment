<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductCategoryTest extends TestCase
{
	use RefreshDatabase;

    public function testAssignCategoryToProductEndpoint()
    {
        $product = Product::factory()->create();
        $category = Category::factory()->create();
        $response = $this->get('/api/products/'.$product->id.'/set-category/'.$category->id);
        $response->assertStatus(200); 
        $this->assertTrue($product->categories->contains($category));
        $this->assertTrue($category->products->contains($product));
    }

    public function testAssignNonExistingCategoryToProductEndpoint()
    {
        $product = Product::factory()->create();
        $response = $this->get('/api/products/'.$product->id.'/set-category/'.rand(99999, 999999));
        $response->assertStatus(404);
    }

    public function testGetProductsByCategoryEndpoint()
    {
        $product = Product::factory()->create();
        $category = Category::factory()->create();
        $product->categories()->attach([$category->id]);
        $response = $this->get('/api/category/'.$category->id.'/get-products');
        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $this->assertTrue($category->products->count() == 1);
    }
}
