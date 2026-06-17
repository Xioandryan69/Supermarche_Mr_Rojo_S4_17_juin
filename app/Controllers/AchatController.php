<?php

namespace App\Controllers;
use App\Models\ProduitModel;
use App\Models\AchatFilleModel;
use App\Models\AchatMereModel;
use App\Models\CaisseModel;

class AchatController extends BaseController
{
    public function index(): string
    {
        return view('achats/index');
    }


    public function ajouterProduit($data)
    {
        $produitModel = new ProduitModel();

        $produitModel->insert([
            'designation' => $data['designation'],
            'id_categorie' => $data['id_categorie']
        ]);

        return "Produit ajouté";
    }


    public function supprimerProduit($id)
    {
        $produitModel = new ProduitModel();

        $produitModel->delete($id);

        return "Produit supprimé";
    }



    public function listeProduit()
    {
        $produitModel = new ProduitModel();

        $data['produits'] = $produitModel->getProduitsAvecCategorie();


        return view(
            'achats/index',
            $data
        );
    }
}
