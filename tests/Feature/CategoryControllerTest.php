<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Str;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function test_index()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get('/category');
        $response->assertViewIs('category.index');
        $response->assertViewHas('categories');
    }

    public function test_index_not_authorized()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get('/category');
        $response->assertRedirect('/funkos');
    }

    public function test_store()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get('/category/create');
        $response->assertViewIs('category.create');
    }

    public function test_store_not_authorized()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get('/category/create');
        $response->assertRedirect('/funkos');
    }

    public function test_create()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->make();
        $response = $this->actingAs($user)->post('/category/create', $category->toArray());
        $response->assertRedirect('/category');
        $this->assertDatabaseHas('categories', [
            'name' => $category->name,
            'is_deleted' => 0, // Modificado aquí
        ]);
    }

    public function test_create_not_authorized()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->make();
        $response = $this->actingAs($user)->post('/category/create', $category->toArray());
        $response->assertRedirect('/funkos');
    }

    public function test_edit()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->get("/category/edit/$category->id");
        $response->assertViewIs('category.edit');
        $response->assertViewHas('category');
    }

    public function test_edit_not_authorized()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->get("/category/edit/$category->id");
        $response->assertRedirect('/funkos');
    }

    public function test_update()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        $category->name = Str::random(10);
        $category->is_deleted = false;
        $response = $this->actingAs($user)->put("/category/edit/$category->id", $category->toArray());
        $response->assertRedirect('/category');
        $this->assertDatabaseHas('categories', [
            'name' => $category->name,
            'is_deleted' => $category->is_deleted,
            'id' => $category->id,
        ]);
    }

    public function test_update_not_authorized()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();
        $category->name = Str::random(10);
        $response = $this->actingAs($user)->put("/category/edit/$category->id", $category->toArray());
        $response->assertRedirect('/funkos');
    }

    public function test_deactivate()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->delete("/category/deactivate/$category->id");
        $response->assertRedirect('/category');
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'is_deleted' => 1,
        ]);
    }

    public function test_deactivate_not_authorized()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->delete("/category/deactivate/$category->id");
        $response->assertRedirect('/funkos');
    }

    public function test_active()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create(['is_deleted' => 1]);
        $response = $this->actingAs($user)->patch("/category/active/$category->id");
        $response->assertRedirect('/category');
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'is_deleted' => 0,
        ]);
    }

    public function test_active_not_authorized()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create(['is_deleted' => 1]);
        $response = $this->actingAs($user)->patch("/category/active/$category->id");
        $response->assertRedirect('/funkos');
    }

    public function test_destroy()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->delete("/category/destroy/$category->id");
        $response->assertRedirect('/category');
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

    public function test_destroy_not_authorized()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->delete("/category/destroy/$category->id");
        $response->assertRedirect('/funkos');
    }
}
