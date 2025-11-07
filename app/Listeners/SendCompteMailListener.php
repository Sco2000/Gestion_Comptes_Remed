<?php

namespace App\Listeners;

use App\Events\CompteCreated;
use App\Jobs\SendCompteMailJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCompteMailListener
{
    /**
     * Create the event listener.
     */
   public function __construct(
        protected SendCompteMailJob $job
    ) {}

    /**
     * Handle the event.
     */
    public function handle(CompteCreated $event): void
    {
        $this->job->handleEvent($event);
    }
}
