<?php

namespace App\Http\Repositories;
use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Interfaces\RepositoriesInterfaces\IFirstOrCreateRepository;

class ClientRepository implements IFirstOrCreateRepository
{
    protected $model;

    public function __construct(Client $client)
    {
        $this->model = $client;
    }

    /**
     * Créer un nouveau client
     *
     * @param array $data
     * @return client
     */
    public function findOrCreate(array $data): Client
    {
        return $this->model->firstOrCreate(
                ['user_id' => $data['id']],
                ['user_id' => $data['id']]
        );
    }

        // public function findById(string $id): ?client
        // {

        // }

        // public function update(client $client, array $data): client
        // {

        // }  
        // public function delete(client $client): client
        // {

        // }
}