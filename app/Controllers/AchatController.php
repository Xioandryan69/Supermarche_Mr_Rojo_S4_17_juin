<?php

namespace App\Controllers;
use App\Models\ProduitModel;
use App\Models\AchatFilleModel;
use App\Models\AchatMereModel;
use App\Models\CaisseModel;
use App\Models\HistoriquePrixModel;

class AchatController extends BaseController
{
    private $caisseModel;
    private $achatFilleModel;
    private $achatMereModel;
    private $mouvementStockModel;
    private $mouvementStockFilleModel;




    //constructeur 
    public function __construct()
    {
        $this->caisseModel = new \App\Models\CaisseModel();
        $this->achatFilleModel = new \App\Models\AchatFilleModel();
        $this->achatMereModel = new \App\Models\AchatMereModel();
        $this->mouvementStockModel = new \App\Models\MouvementStockModel();
        $this->mouvementStockFilleModel = new \App\Models\MouvementStockFilleModel();
    }
    public function index(): string
    {
        return view('achats/index');
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

    //ajax
    public function verifierStock()
    {
        $idproduit = $this->request->getPost('idproduit');
        $nombre = $this->request->getPost('nombre');
        $stock = 0;

        //returner quantitee restant 
        return $this->response->setJSON(['stock' => $stock]);
    }

    public function validerAchats()
    {
        $panier = $this->request->getPost('panier');

        if (!$panier) {
            return redirect()->back()->with('error', 'Panier vide');
        }

        $db = \Config\Database::connect();
        $db->transStart();


        $achatMereId = $this->achatMereModel->insert([
            'idCaisse' => 1, // à remplacer dynamiquement
            'date' => date('Y-m-d H:i:s'),
            'total' => 0
        ], true);

        $totalGeneral = 0;


        foreach ($panier as $item) {

            $produitId = $item['id'];
            $quantite = (int) $item['qty'];
            $prix = (float) $item['price'];

            $totalLigne = $quantite * $prix;
            $totalGeneral += $totalLigne;

            $this->achatFilleModel->insert([
                'idAchatMere' => $achatMereId,
                'idProduit' => $produitId,
                'quantite' => $quantite,
                'prixUnitaire' => $prix,
            ]);


            $mouvementId = $this->mouvementStockModel->insert([
                'idSource' => 1,
                'date' => date('Y-m-d H:i:s')
            ], true);

            $this->mouvementStockFilleModel->insert([
                'idMouvementStock' => $mouvementId,
                'idProduit' => $produitId,
                'quantite' => $quantite
            ]);
        }

        $this->achatMereModel->update($achatMereId, [
            'total' => $totalGeneral
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Erreur lors de l\'achat');
        }

        return redirect()->to('achats')->with('success', 'Achat validé avec succès');
    }
}
