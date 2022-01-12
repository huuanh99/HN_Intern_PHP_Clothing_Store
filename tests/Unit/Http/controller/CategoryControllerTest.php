<?php

namespace Tests\Unit\Http\Controller;

use App\Http\Controllers\CategoryController;
use App\Http\Requests\AddCategoryRequest;
use App\Models\Category;
use App\Models\Notification;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;
use Tests\TestCase;
use Mockery;
use Mockery\MockInterface;
use App\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CategoryControllerTest extends TestCase
{
    protected $controller;
    protected $categoryRepo;
    protected $notificationRepo;
    protected $formrequest;

    public function setup() : void
    {
        parent::setUp();
        $this->categoryRepo = Mockery::mock(CategoryRepositoryInterface::class)->makePartial();
        $this->notificationRepo = Mockery::mock(NotificationRepositoryInterface::class)->makePartial();
        $this->notificationRepo->shouldReceive('getAll')->andReturn(new Collection([new Notification()]));
        $this->controller = new CategoryController($this->categoryRepo, $this->notificationRepo);
        $this->formrequest = Mockery::mock(AddCategoryRequest::class);
    }

    public function tearDown() : void
    {
        Mockery::close();
        unset($this->controller);
        parent::tearDown();
    }

    public function testShowAddCategoryView()
    {
        $this->categoryRepo->shouldReceive('getAll')->once()->andReturn(new Collection([new Category()]));
        $view = $this->controller->showAddCategoryView();
        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('admin.category.catadd', $view->getName());
        $this->assertArrayHasKey('category', $view->getData());
    }

    public function testShowListCategoryView()
    {
        $this->categoryRepo->shouldReceive('getAll')->once()->andReturn(new Collection([new Category()]));
        $view = $this->controller->showListCategoryView();
        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('admin.category.catlist', $view->getName());
        $this->assertArrayHasKey('category', $view->getData());
    }

    public function testShowEditCategoryView()
    {
        $this->categoryRepo->shouldReceive('getAll')->once()->andReturn(new Collection([new Category()]));
        $this->categoryRepo->shouldReceive('find')->once()->andReturn(new Category());
        $view = $this->controller->showEditCategoryView(1);
        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('admin.category.catedit', $view->getName());
        $this->assertArrayHasKey('category', $view->getData());
        $this->assertArrayHasKey('cat', $view->getData());
    }

    public function testDeleteCategory()
    {
        $this->categoryRepo->shouldReceive('delete')->once();
        $response = $this->controller->deleteCategory(1);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('catlist'), $response->headers->get('Location'));
    }

    public function testAddCategory()
    {
        $this->formrequest->shouldReceive('all')->once()->andReturn(new Category());
        $this->categoryRepo->shouldReceive('create')->once();
        $response = $this->controller->addCategory($this->formrequest);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('catadd'), $response->headers->get('Location'));
    }

    public function testEditCategory()
    {
        $this->formrequest->shouldReceive('all')->once()->andReturn(new Category());
        $this->categoryRepo->shouldReceive('update')->once();
        $this->formrequest->id = 1;
        $response = $this->controller->editCategory($this->formrequest);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('catedit', ['id' => 1]), $response->headers->get('Location'));
    }
}
