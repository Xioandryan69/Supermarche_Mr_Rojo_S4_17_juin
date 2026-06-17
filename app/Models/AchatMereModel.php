<?php

namespace App\Models;

use CodeIgniter\Model;

class AchatMereModel extends Model
{
    protected $table            = 'achatMere';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';

    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'idCaisse'
    ];

    protected $useTimestamps = true;

    protected $date = 'date';
}