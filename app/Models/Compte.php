<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Scopes\NonArchiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Compte extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'client_id',
        'numero_compte',
        'type',
        'statut',
        'date_debut_blocage',
        'date_fin_blocage',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new NonArchiveScope);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
