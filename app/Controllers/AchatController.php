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

        $entrees = (int) ($db->table('mouvementStockFille')
            ->selectSum('quantite', 'total')
            ->join('mouvementStock', 'mouvementStock.id = mouvementStockFille.idMouvementStock')
            ->join('typeMouvementStock', 'typeMouvementStock.id = mouvementStock.idTypeMouvementStock')
            ->where('idProduit', $idProduit)
            ->where('UPPER(typeMouvementStock.libelle)', 'ENTREE', false)
            ->get()
            ->getRow()
            ->total ?? 0);

        $sorties = (int) ($db->table('mouvementStockFille')
            ->selectSum('quantite', 'total')
            ->join('mouvementStock', 'mouvementStock.id = mouvementStockFille.idMouvementStock')
            ->join('typeMouvementStock', 'typeMouvementStock.id = mouvementStock.idTypeMouvementStock')
            ->where('idProduit', $idProduit)
            ->where('UPPER(typeMouvementStock.libelle)', 'SORTIE', false)
            ->get()
            ->getRow()
            ->total ?? 0);

        return max(0, $entrees - $sorties);
    }

    private function getTypeMouvementStockId(string $libelle): ?int
    {
        $db = \Config\Database::connect();
        $type = $db->table('typeMouvementStock')
            ->select('id')
            ->where('UPPER(libelle)', strtoupper($libelle), false)
            ->get()
            ->getRow();

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

        return redirect()->to('achats')->with('success', 'Achat validé avec succès');
    }
}
