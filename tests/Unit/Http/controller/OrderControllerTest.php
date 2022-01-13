<?php

namespace Tests\Unit\Http\Controller;

use App\Events\PusherEvent;
use App\Http\Controllers\OrderController;
use App\Mail\MailOrderDetail;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Orderdetail\OrderdetailRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use Illuminate\Support\Facades\Session;
use Mockery;
use PhpParser\Node\Expr\Cast\Object_;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    protected $orderRepo;
    protected $productRepo;
    protected $categoryRepo;
    protected $orderdetailRepo;
    protected $notificationRepo;
    protected $controller;
    protected $request;
    protected $user;

    public function setup() : void
    {
        parent::setUp();
        $this->orderRepo = Mockery::mock(OrderRepositoryInterface::class)->makePartial();
        $this->productRepo = Mockery::mock(ProductRepositoryInterface::class)->makePartial();
        $this->categoryRepo = Mockery::mock(CategoryRepositoryInterface::class)->makePartial();
        $this->orderdetailRepo = Mockery::mock(OrderdetailRepositoryInterface::class)->makePartial();
        $this->notificationRepo = Mockery::mock(NotificationRepositoryInterface::class)->makePartial();
        $this->notificationRepo->shouldReceive('getAll')->andReturn(new Collection([new Notification()]));
        $this->user = Mockery::mock(User::class);
        $this->controller = new OrderController(
            $this->orderRepo,
            $this->categoryRepo,
            $this->orderdetailRepo,
            $this->productRepo,
            $this->notificationRepo
        );
        $this->request = Mockery::mock(Request::class);
    }

    public function tearDown() : void
    {
        Mockery::close();
        unset($this->controller);
        parent::tearDown();
    }

    public function testInsertOrder1()
    {
        $product1 = new Product();
        $product1->quantity = 10;
        $product2 = new Product();
        $product2->quantity = 15;
        $this->productRepo->shouldReceive('find')->once()->andReturn($product1);
        $this->request->shouldReceive('session')->andReturn(
            new Collection([
                "cart" => new Collection([$product2]),
            ])
        );
        $response = $this->controller->insertOrder($this->request);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('cart'), $response->headers->get('Location'));
    }

    public function testInsertOrder2()
    {
        $product1 = new Product();
        $product1->quantity = 10;
        $product2 = new Product();
        $product2->quantity = 8;
        $this->productRepo->shouldReceive('find')->once()->andReturn($product1);
        $this->request->shouldReceive('all')->once();
        $this->request->shouldReceive('session')->andReturn(
            new Collection([
                "cart" => new Collection([$product2]),
            ])
        );
        Event::fake();
        $this->orderRepo->shouldReceive('create')->once()->andReturn(new Order());
        $this->orderdetailRepo->shouldReceive('create')->once()->andReturn(new OrderDetail());
        $this->productRepo->shouldReceive('updateQuantity')->once();
        $this->notificationRepo->shouldReceive('create')->once();
        $response = $this->controller->insertOrder($this->request);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('cart'), $response->headers->get('Location'));
        Event::assertDispatched(PusherEvent::class);
    }

    public function testApproveOrder()
    {
        $this->orderRepo->shouldReceive('approveOrder')->once()->andReturn(new Order());
        Mail::fake();
        $response = $this->controller->approveorder(1);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('showOrderPendingView'), $response->headers->get('Location'));
        Mail::assertSent(MailOrderDetail::class);
    }
}
