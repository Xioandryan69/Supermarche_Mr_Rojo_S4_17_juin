<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoriquePrixModel extends Model
{
    protected $table = 'HistoriquePrix';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $allowedFields = [
        'id_produit',
        'prix',
        'dateDebut',
        'dateFin'
    ];

    public function getPrixActuel($idProduit)
    {
        return $this->where('id_produit', $idProduit)
            ->where('dateFin IS NULL')
            ->first();
    }
}