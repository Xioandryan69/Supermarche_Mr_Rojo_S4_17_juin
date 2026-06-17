<?php

namespace App\Models;

use CodeIgniter\Model;

class MouvementStockFilleModel extends Model
{
    protected $table            = 'mouvementStockFille';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';

    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'idMouvementStock',
        'quantite',
        'idProduit'
    ];

}