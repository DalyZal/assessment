<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
	use RefreshDatabase;

    public function testGetEndpoint() {
        $product = Product::factory()->count(50)->create();
        $response = $this->get('/api/products/');
        $response->assertStatus(200);
    }

    public function testStoreEndpoint()
    {
        $data = [
            'name' => fake()->name(),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat('2',0,2),
            'stock' => fake()->numberBetween(50, 9999)
        ];

        $response = $this->post('/api/products', $data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'name' => $data['name']
        ]);
    }

    public function testShowEndpoint()
    {
        $product = Product::factory()->create();
        $response = $this->get('/api/products/' . $product->id);
        $response->assertStatus(200);
    }

    public function testUpdateEndpoint()
    {
        $product = Product::factory()->create();

        $data = [
            'stock' => fake()->numberBetween(50, 9999),
            'price' => fake()->randomFloat('2',0,2),
        ];
        $response = $this->put('/api/products/' . $product->id, $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'price' => $data['price'],
            'stock' => $data['stock'],
        ]);
    }

    public function testDeleteEndpoint()
    {
        $product = Product::factory()->create();
        $response = $this->delete('/api/products/' . $product->id);
        $response->assertStatus(200);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
            'deleted_at'=> Null
        ]);
    }

    public function testStoreEndpointWithoutDescription()
    {
        $data = [
            'name' => fake()->name(),
            'stock' => fake()->numberBetween(50, 9999),
            'price' => fake()->randomFloat('2',0,2),
        ];

        $response = $this->post('/api/products', $data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'name' => $data['name']
        ]);
    }

    public function testStoreEndpointWithInvalidStock()
    {
        $data = [
            'name' => fake()->name(),
            'stock' => fake()->randomFloat('2',0,2),
        ];

        $response = $this->post('/api/products', $data);
        $response->assertStatus(422);

        $this->assertDatabaseMissing('products', [
            'name' => $data['name'],
            'stock' => 11.11
        ]);
    }

    public function testShowNonExistingProduct()
    {
        $response = $this->get('/api/products/'.rand(99999, 999999));
        $response->assertStatus(404);
    }
}
