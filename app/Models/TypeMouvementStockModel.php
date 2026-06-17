<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeMouvementStockModel extends Model
{
    protected $table            = 'typeMouvementStock';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';

    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'libelle'
    ];
}