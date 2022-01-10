<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailOrderReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $total;

    public function __construct($total)
    {
        $this->total = $total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $total = $this->total;
        $day = Carbon::today()->toDateString();
        return $this->markdown(
            'emails.orders.reports',
            [
                'total' => $total,
                'day' => $day,
            ]
        )->subject(__('mailreportsubject'));
    }
}
