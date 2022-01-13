<?php

namespace Tests\Unit\Http\Controller;

use App\Http\Controllers\OrderChartController;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class OrderChartControllerTest extends TestCase
{
    protected $repository;
    protected $controller;

    public function setup() : void
    {
        parent::setUp();
        $this->repository = Mockery::mock(OrderRepositoryInterface::class)->makePartial();
        $this->controller = new OrderChartController($this->repository);
    }

    public function tearDown() : void
    {
        Mockery::close();
        unset($this->controller);
        parent::tearDown();
    }

    public function testShowOrderChartView()
    {
        $this->repository->shouldReceive('showOrderSaleInMonth')->once()
            ->andReturn(new Collection(['500000', '800000']));
        $this->repository->shouldReceive('showOrderDayInMonth')->once()
            ->andReturn(new Collection(['2022-01-03', '2022-01-04']));
        $view = $this->controller->showOrderChartView();
        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('admin.chart.orderchart', $view->getName());
        $this->assertArrayHasKey('chart', $view->getData());
    }
}
