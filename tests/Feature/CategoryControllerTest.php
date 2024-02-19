<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Str;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    /*Route::prefix('category')->group(function () {
    Route::get('/', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.index')->middleware(['auth', 'admin']);

    Route::get('/create', [App\Http\Controllers\CategoryController::class, 'store'])->name('category.store')->middleware(['auth', 'admin']);
    Route::post('/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('category.create')->middleware(['auth', 'admin']);

    Route::get('/edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit')->middleware(['auth', 'admin']);
    Route::put('/edit/{id}', [App\Http\Controllers\CategoryController::class, 'update'])->name('category.update')->middleware(['auth', 'admin']);

    Route::delete('/delete/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('category.destroy')->middleware(['auth', 'admin']);
    Route::patch('/active/{id}', [App\Http\Controllers\CategoryController::class, 'active'])->name('category.active')->middleware(['auth', 'admin']);
});*/
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
        $this->assertDatabaseHas('categories', $category->toArray());
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
        $category->is_deleted = false; // set is_deleted to false
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

    public function test_destroy()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->delete("/category/delete/$category->id");
        $response->assertRedirect('/category');
        $this->assertDatabaseMissing('categories', $category->toArray());
    }

    public function test_destroy_not_authorized()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->delete("/category/delete/$category->id");
        $response->assertRedirect('/funkos');
    }
}
