<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCompteSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
     public function __construct(

    ) {}

    /**
     * Execute the job.
     */
    public function handleEvent($event): void
    {
        $user = $event->user;
        $context = $event->context;

        // TODO: Implement SMS sending logic here
        // For now, just log the event
        \Illuminate\Support\Facades\Log::info("Sending SMS to user {$user->id} with context {$context}");
    }
}
