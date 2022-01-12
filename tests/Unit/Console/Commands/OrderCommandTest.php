<?php

namespace Tests\Unit\Console\Commands;

use App\Console\Commands\OrderCommand;
use App\Console\Kernel;
use App\Mail\MailOrderReport;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Mockery;
use Tests\TestCase;

class OrderCommandTest extends TestCase
{
    protected $orderRepo;
    protected $orderCommand;

    public function setup() : void
    {
        parent::setUp();
        $this->orderRepo = Mockery::mock(OrderRepositoryInterface::class)->makePartial();
        $this->orderCommand = new OrderCommand($this->orderRepo);
    }

    public function tearDown() : void
    {
        Mockery::close();
        unset($this->orderCommand);
        parent::tearDown();
    }

    public function testSignature()
    {
        $signature = 'order:report';
        $this->assertEquals($signature, $this->orderCommand->signature);
    }

    public function testDescription()
    {
        $description = 'Command description';
        $this->assertEquals($description, $this->orderCommand->description);
    }

    public function testHandle()
    {
        $this->orderRepo->shouldReceive('showOrderSaleToday')->once()->andReturn(500000);
        Mail::fake();
        $this->orderCommand->handle();
        Mail::assertSent(MailOrderReport::class);
    }
}
