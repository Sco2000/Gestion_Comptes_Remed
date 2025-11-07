<?php

namespace App\Http\Repositories;
use App\Models\Compte;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Interfaces\RepositoriesInterfaces\IRepository;

class CompteRepository implements IRepository
{
    protected $model;

    public function __construct(Compte $compte)
    {
        $this->model = $compte;
    }

    public function getAll(array $filters = [], $sort = 'created_at', $order = 'desc', $limit = 10): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (!empty($filters['client_id'])) {
            $query->where('client_id', $filters['client_id']);
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['statut'])) {
            $query->withoutGlobalScopes();
            if ($filters['statut'] === 'archive') {
                $query->where('statut', 'supprimé');
            } else {
                $query->where('statut', $filters['statut']);
            }
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('numero_compte', 'like', "%$search%")
                  ->orWhereHas('client.user', function ($q2) use ($search) {
                      $q2->where('prenom', 'like', "%$search%")
                         ->orWhere('nom', 'like', "%$search%");
                  });
            });
        }

        return $query->orderBy($sort, $order)->paginate($limit);
    }

    /**
     * Créer un nouveau compte
     *
     * @param array $data
     * @return Compte
     */
    public function create(array $data): ?Compte
    {
        return $this->model->create($data);
    }

        // public function findById(string $id): ?Compte
        // {

        // }

        // public function update(Compte $compte, array $data): Compte
        // {

        // }  
        // public function delete(Compte $compte): Compte
        // {

        // }
}