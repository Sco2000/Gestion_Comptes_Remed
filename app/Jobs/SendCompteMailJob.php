<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Mail\WelcomeClientMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use App\Mail\ConfirmationNewCompteMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendCompteMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handleEvent($event): void
    {
        $user = $event->user;
        $context = $event->context;

        if ($context === 'user') {
            $mailable = new \App\Mail\WelcomeClientMail();
            $mailable->setUser($user);
        } else {
            $mailable = new \App\Mail\ConfirmationNewCompteMail();
            $mailable->setUser($user);
        }

        \Illuminate\Support\Facades\Mail::to($user->email)->send($mailable);
    }
}
