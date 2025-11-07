<?php

namespace App\Http\Services;

use App\Models\Compte;
use Illuminate\Support\Facades\DB;
use App\Interfaces\RepositoriesInterfaces\IRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CompteService
{
    protected $compteRepository;
    protected $userService;
    protected $clientService;

    public function __construct(IRepository $compteRepository, UserService $userService, ClientService $clientService)
    {
        $this->compteRepository = $compteRepository;
        $this->userService = $userService;
        $this->clientService = $clientService;
    }

    // public function createCompte(array $data): Compte
    // {
    //     //
    // }

    public function listComptes(array $filters, $sort, $order, $limit): LengthAwarePaginator
    {
        return $this->compteRepository->getAll($filters, $sort, $order, $limit);
 
    }

    public function createCompte(array $data): Compte
    {
        return DB::transaction(function() use ($data){
            $user = $this->userService->findOrCreate($data['client']);
            $client = $this->clientService->findOrCreate(['id' => $user->id]);
    
            return $this->compteRepository->create([
            'client_id' => $client->id,
            'type' => $data['type']
            ]);

        });
    }
}