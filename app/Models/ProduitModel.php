<?php

namespace App\Models;

use CodeIgniter\Model;

class ProduitModel extends Model
{
    protected $table = 'produit';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $allowedFields = [
        'designation',
        'id_categorie'
    ];

    public function getProduitsAvecCategorie()
    {
        return $this->select('produit.*, categorie.libelle')
            ->join('categorie', 'categorie.id = produit.id_categorie')
            ->findAll();
    }
}