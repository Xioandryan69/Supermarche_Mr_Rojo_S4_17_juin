<?php

namespace App\Models;

use CodeIgniter\Model;

class AchatFilleModel extends Model
{
    protected $table            = 'achatFille';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';

    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'idAchatMere',
        'idProduit',
        'quantite'
    ];


}