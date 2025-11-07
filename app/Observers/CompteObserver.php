<?php

namespace App\Observers;

use App\Models\Compte;
use Illuminate\Support\Str;
use App\Events\CompteCreated;

class CompteObserver
{
    /**
     * Handle the Compte "created" event.
     */
    public function created(Compte $compte): void
    {
        $user = $compte->client->user;

        // Determine context based on whether user was recently created
        
        $context = $user->wasRecentlyCreated ? 'user' : 'compte';

        CompteCreated::dispatch($user, $context);
    }

    /**
     * Avant la création (avant que l’objet soit sauvegardé).
     */
    public function creating(Compte $compte): void
    {
        if (empty($compte->id)) {
            $compte->id = (string) Str::uuid();
        }

        if (empty($compte->numero_compte)) {
            do {
                $numero = 'CPT-' . str_pad(mt_rand(100000, 999999), 6, '0', STR_PAD_LEFT);
            } while (Compte::where('numero_compte', $numero)->exists());
            $compte->numero_compte = $numero;
        }
    }

    /**
     * Handle the Compte "updated" event.
     */
    public function updated(Compte $compte): void
    {
        //
    }

    /**
     * Handle the Compte "deleted" event.
     */
    public function deleted(Compte $compte): void
    {
        //
    }

    /**
     * Handle the Compte "restored" event.
     */
    public function restored(Compte $compte): void
    {
        //
    }

    /**
     * Handle the Compte "force deleted" event.
     */
    public function forceDeleted(Compte $compte): void
    {
        //
    }
}
