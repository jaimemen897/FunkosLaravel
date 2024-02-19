<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Funko;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FunkosControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function test_index()
    {
        $response = $this->get('/funkos');

        $response->assertViewIs('funkos.index');
    }

    public function test_index_request()
    {
        $name = Funko::first()->name;

        $response = $this->get('/funkos?search=' . $name);

        $response->assertViewIs('funkos.index');
        $response->assertViewHas('funkos', function ($funkos) use ($name) {
            return $funkos->first()->name === $name;
        });
    }

    public function test_show()
    {
        $funko = Funko::first();
        $response = $this->get('/funkos/' . $funko->id);

        $response->assertViewIs('funkos.show');
    }

    public function test_show_not_found()
    {
        $response = $this->get('/funkos/1000');

        $response->assertRedirect('/funkos');
    }

    public function test_store()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $response = $this->get('/funkos/create');

        $response->assertViewIs('funkos.create');
    }

    public function test_create()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $funko = Funko::factory()->make();
        $category = Category::first();
        $funko->category_id = $category->id;
        $response = $this->post('/funkos/create', $funko->toArray());

        $response->assertRedirect('/funkos');
    }

    public function test_create_not_admin()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);
        $response = $this->get('/funkos/create');

        $response->assertRedirect('/funkos');
    }

    public function test_edit()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $funko = Funko::first();
        $response = $this->get('/funkos/edit/' . $funko->id);

        $response->assertViewIs('funkos.edit');
    }

    public function test_update()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $funko = Funko::first();
        $funko->name = 'Funko updated';
        $response = $this->put('/funkos/edit/' . $funko->id, $funko->toArray());

        $response->assertRedirect('/funkos');
    }

    public function test_update_not_admin()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);
        $funko = Funko::first();
        $funko->name = 'Funko updated';
        $response = $this->put('/funkos/edit/' . $funko->id, $funko->toArray());

        $response->assertRedirect('/funkos');
    }

    public function test_update_not_authenticated()
    {
        $funko = Funko::first();
        $funko->name = 'Funko updated';
        $response = $this->put('/funkos/edit/' . $funko->id, $funko->toArray());

        $response->assertRedirect('/login');
    }

    public function test_update_not_found()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $funko = Funko::first();
        $funko->name = 'Funko updated';
        $response = $this->put('/funkos/edit/1000', $funko->toArray());

        $response->assertRedirect('/funkos');
    }

    public function test_editImage()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $funko = Funko::first();
        $response = $this->get('/funkos/editImage/' . $funko->id);

        $response->assertViewIs('funkos.image');
    }

    public function test_updateImage()
    {
        /*image must be a image*/
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $fakeStorage = Storage::fake('public');
        $file = UploadedFile::fake()->image('funko.jpg');
        $funko = Funko::first();
        $response = $this->patch('/funkos/editImage/' . $funko->id, ['image' => $file]);

        $response->assertRedirect('/funkos');
    }

    public function test_destroy()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $funko = Funko::first();
        $response = $this->delete('/funkos/delete/' . $funko->id);

        $response->assertRedirect('/funkos');
    }

    public function test_destroy_not_admin()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);
        $funko = Funko::first();
        $response = $this->delete('/funkos/delete/' . $funko->id);

        $response->assertRedirect('/funkos');
    }

    public function test_destroy_not_authenticated()
    {
        $funko = Funko::first();
        $response = $this->delete('/funkos/delete/' . $funko->id);

        $response->assertRedirect('/login');
    }

    public function test_destroy_not_found()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $response = $this->delete('/funkos/delete/1000');

        $response->assertRedirect('/funkos');
    }

}
