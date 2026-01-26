<?php

namespace App\Jobs;

use App\Mail\NewAccountNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendNewAccountNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $email;

    public function __construct($user, $email)
    {
        $this->user = $user;
        $this->email = $email;
    }

    public function handle(): void
    {
        try {
            Mail::to($this->email)->send(new NewAccountNotification($this->user, $this->email));
        } catch (\Exception $e) {
            \Log::error('New account notification job failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
