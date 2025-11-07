<?php

namespace App\Http\Repositories;
use App\Models\User;
use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Interfaces\RepositoriesInterfaces\IFirstOrCreateRepository;

class UserRepository implements IFirstOrCreateRepository
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }


    /**
     * Créer un nouveau compte
     *
     * @param array $data
     * @return User
     */
    public function findOrCreate(array $data): User
    {
        return $this->model->firstOrCreate(
                ['nci' => $data['nci']],
                [
                    'prenom' => $data['prenom'],
                    'nom' => $data['nom'],
                    'adresse' => $data['adresse'],
                    'telephone' => $data['telephone'],
                    'email' => $data['email'],
                    'statut' => 'actif',
                ]
        );
    }
}