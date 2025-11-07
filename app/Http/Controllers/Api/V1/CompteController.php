<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompteRequest;
use App\Http\Services\CompteService;
use App\Http\Resources\CompteResource;
use PhpParser\Node\Stmt\TryCatch;

class CompteController extends Controller
{
    use ApiResponse;
    protected $compteService; 

    public function __construct(CompteService $compteService) {
        $this->compteService = $compteService;
    }

    public function index(Request $request)
    {
        try {
            // $user = auth()->user();

            $filters = $request->only(['type', 'statut', 'search']);
            $sort = $request->get('sort', 'created_at');
            $order = $request->get('order', 'desc');
            $limit = min($request->get('limit', 10), 100);

            $comptes = $this->compteService->listComptes($filters, $sort, $order, $limit);
            $compteCollection = CompteResource::collection($comptes)->response()->getData(true);

            return $this->successResponse($compteCollection, 'Liste des comptes');
        } catch (\Throwable $e) {
            throw $e; // Let the middleware handle it
        }
    }

    public function store(CompteRequest $request)
    {
        try{
            $data = $request->validated();
            // dd($data);
            $compte = $this->compteService->createCompte($data);
            $compteResource = new CompteResource($compte);
            return $this->successResponse($compteResource, 'Compte créé avec succès', 201);
        } catch(\Throwable $e){
            throw $e;
        }
    }
}
