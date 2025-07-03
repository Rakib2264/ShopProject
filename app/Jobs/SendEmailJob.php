<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $recipient;
    public $mailable;
    public function __construct($recipient, $mailable)
    {
        $this->recipient = $recipient;
        $this->mailable = $mailable;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->recipient)->send($this->mailable);
    }
}
