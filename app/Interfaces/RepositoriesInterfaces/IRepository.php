<?php
// app/Repositories/CompteRepositoryInterface.php

namespace App\Interfaces\RepositoriesInterfaces;

use App\Models\Admin;
use App\Models\Client;
use App\Models\Compte;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IRepository
{
    public function getAll(array $filters = [], string $sort = 'created_at', string $order = 'desc', int $limit = 10): LengthAwarePaginator;

    // public function findById(string $id): ?Compte;

    public function create(array $data): Compte | Client | Admin | null;

    // public function update(Compte $compte, array $data): Compte;

    // public function delete(Compte $compte): Compte;
}
