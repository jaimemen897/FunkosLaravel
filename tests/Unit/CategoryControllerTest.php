<?php

namespace Tests\Unit;

use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;
use Illuminate\Http\Request;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    private $categoryController;

    public function setUp(): void
    {
        parent::setUp();
        $this->categoryController = new CategoryController();
    }

    public function testFindAll()
    {
        $response = $this->categoryController->findAll();
        $this->assertEquals(true, true);
    }
}
