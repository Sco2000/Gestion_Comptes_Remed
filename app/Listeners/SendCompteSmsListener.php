<?php

namespace App\Listeners;

use App\Events\CompteCreated;
use App\Jobs\SendCompteSMSJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCompteSmsListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected SendCompteSmsJob $job
    ) {}

    /**
     * Handle the event.
     */
    public function handle(CompteCreated $event): void
    {
        $this->job->handleEvent($event);
    }
}
