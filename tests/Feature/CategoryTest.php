<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
	use RefreshDatabase;

    public function testGetEndpoint() {
        $category = Category::factory()->count(50)->create();
        $response = $this->get('/api/categories/');
        $response->assertStatus(200);
    }

    public function testStoreEndpoint()
    {
        $data = [
            'name' => fake()->name()
        ];

        $response = $this->post('/api/categories', $data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('categories', [
            'name' => $data['name']
        ]);
    }

    public function testShowEndpoint()
    {
        $category = Category::factory()->create();
        $response = $this->get('/api/categories/' . $category->id);
        $response->assertStatus(200);
    }

    public function testUpdateEndpoint()
    {
        $category = Category::factory()->create();

        $data = [
            'name' => 'Lorem Ipsum',
        ];
        $response = $this->put('/api/categories/' . $category->id, $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'name' => $data['name']
        ]);
    }

    public function testDeleteEndpoint()
    {
        $category = Category::factory()->create();
        $response = $this->delete('/api/categories/' . $category->id);
        $response->assertStatus(200);

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
            'deleted_at'=> Null
        ]);
    }

    public function testShowNonExistingCategory()
    {
        $response = $this->get('/api/categories/'.rand(99999, 999999));
        $response->assertStatus(404);
    }
}
