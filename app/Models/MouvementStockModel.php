<?php

namespace App\Models;

use CodeIgniter\Model;

class MouvementStockModel extends Model
{
    protected $table            = 'mouvementStock';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';

    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'idSource'
    ];

    protected $useTimestamps = true;

    protected $date = 'date';
}