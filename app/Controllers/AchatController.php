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
        $idProduit = (int) $this->request->getPost('idproduit');
        $nombre = (int) $this->request->getPost('nombre');

        if ($idProduit <= 0) {
            return $this->response->setJSON([
                'stock' => 0,
                'disponible' => false,
                'message' => 'Produit invalide',
            ]);
        }

        $stock = $this->getStockProduit($idProduit);

        return $this->response->setJSON([
            'stock' => $stock,
            'disponible' => $nombre <= $stock,
            'message' => $nombre <= $stock
                ? 'Stock disponible'
                : 'Stock insuffisant',
        ]);
    }

    private function getStockProduit(int $idProduit): int
    {
        $db = \Config\Database::connect();

        $row = $db->query(
            "SELECT COALESCE(SUM(
                CASE
                    WHEN UPPER(typeMouvementStock.libelle) = 'ENTREE' THEN mouvementStockFille.quantite
                    WHEN UPPER(typeMouvementStock.libelle) = 'SORTIE' THEN -mouvementStockFille.quantite
                    ELSE 0
                END
            ), 0) AS stock
            FROM mouvementStockFille
            JOIN mouvementStock ON mouvementStock.id = mouvementStockFille.idMouvementStock
            JOIN typeMouvementStock ON typeMouvementStock.id = mouvementStock.idTypeMouvementStock
            WHERE mouvementStockFille.idProduit = ?",
            [$idProduit]
        )->getRow();

        return max(0, (int) ($row->stock ?? 0));
    }

    private function getTypeMouvementStockId(string $libelle): ?int
    {
        $db = \Config\Database::connect();
        $type = $db->query(
            'SELECT id FROM typeMouvementStock WHERE UPPER(libelle) = ?',
            [strtoupper($libelle)]
        )->getRow();

        return $type ? (int) $type->id : null;
    }

    public function validerAchats()
    {
        $panier = $this->request->getPost('panier');

        if (!$panier) {
            return redirect()->back()->with('error', 'Panier vide');
        }

        $quantitesParProduit = [];

        foreach ($panier as $item) {
            $produitId = (int) ($item['id'] ?? 0);
            $quantite = (int) ($item['qty'] ?? 0);

            if ($produitId <= 0 || $quantite <= 0) {
                return redirect()->back()->with('error', 'Produit ou quantité invalide');
            }

            $quantitesParProduit[$produitId] = ($quantitesParProduit[$produitId] ?? 0) + $quantite;
        }

        foreach ($quantitesParProduit as $produitId => $quantiteDemandee) {
            if ($quantiteDemandee > $this->getStockProduit((int) $produitId)) {
                return redirect()->back()->with('error', 'Stock insuffisant pour un produit du panier');
            }
        }

        $typeSortieId = $this->getTypeMouvementStockId('SORTIE');

        if ($typeSortieId === null) {
            return redirect()->back()->with('error', 'Type de mouvement SORTIE introuvable');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $idCaisse = session()->get('id_caisse');
        $achatMereId = $this->achatMereModel->insert([
            'idCaisse' => $idCaisse,
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
                'idTypeMouvementStock' => $typeSortieId,
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

        return redirect()->to('dashboard/achats')->with('success', 'Achat validé avec succès');
    }
}
