<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Compte;
use App\Http\Services\UserService;
use App\Http\Services\ClientService;
use App\Http\Services\CompteService;
use Illuminate\Support\ServiceProvider;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\ClientRepository;
use App\Http\Repositories\CompteRepository;
use App\Interfaces\RepositoriesInterfaces\IRepository;
use App\Interfaces\RepositoriesInterfaces\IFirstOrCreateRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(IRepository::class, function ($app) {
            return new CompteRepository(new Compte());
        });
        
        $this->app->singleton(CompteService::class, function ($app) {
            return new CompteService($app->make(IRepository::class), $app->make(UserService::class), $app->make(ClientService::class));
        });

        // 🧠 Contexte 1 : pour UserService → injecter UserRepository
        $this->app->when(UserService::class)
            ->needs(IFirstOrCreateRepository::class)
            ->give(UserRepository::class);

        // 🧠 Contexte 2 : pour ClientService → injecter ClientRepository
        $this->app->when(ClientService::class)
            ->needs(IFirstOrCreateRepository::class)
            ->give(ClientRepository::class);

        // ♻️ Ensuite tu peux enregistrer tes services comme singletons
        $this->app->singleton(UserService::class);
        $this->app->singleton(ClientService::class);
            
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
