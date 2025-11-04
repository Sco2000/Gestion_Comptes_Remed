<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CompteResource::class, function ($app, $params = []) {
        if (isset($params['collection'])) {
            $collection = $params['collection'];
            return CompteResource::collection($collection)->response()->getData(true);
        }

        $compte = $params['compte'] ?? null;
        return new CompteResource($compte);
});

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
