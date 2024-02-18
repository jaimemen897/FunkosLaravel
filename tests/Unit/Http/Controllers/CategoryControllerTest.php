<?php

namespace Http\Controllers;

use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /*private $categoryController;

    public function setUp(): void
    {
        parent::setUp();
        $this->categoryController = new CategoryController();
    }*/

    public function testIndex()
    {
        $controller = new CategoryController();
        $request = new Request();
        $response = $controller->index($request);
        $this->assertIsObject($response);
    }
}
