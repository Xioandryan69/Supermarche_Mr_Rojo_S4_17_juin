<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('dashboard/index', [
            'caisse' => $this->getCaisseSession(),
            'resume' => $this->getResume(),
        ]);
    }

    public function stock()
    {
        $db = \Config\Database::connect();
        $produits = $db->query(
            "SELECT
                produit.id,
                produit.designation,
                categorie.libelle AS categorie,
                COALESCE(SUM(
                    CASE
                        WHEN UPPER(typeMouvementStock.libelle) = 'ENTREE' THEN mouvementStockFille.quantite
                        WHEN UPPER(typeMouvementStock.libelle) = 'SORTIE' THEN -mouvementStockFille.quantite
                        ELSE 0
                    END
                ), 0) AS stock
            FROM produit
            LEFT JOIN categorie ON categorie.id = produit.id_categorie
            LEFT JOIN mouvementStockFille ON mouvementStockFille.idProduit = produit.id
            LEFT JOIN mouvementStock ON mouvementStock.id = mouvementStockFille.idMouvementStock
            LEFT JOIN typeMouvementStock ON typeMouvementStock.id = mouvementStock.idTypeMouvementStock
            GROUP BY produit.id, produit.designation, categorie.libelle
            ORDER BY produit.designation"
        )->getResultArray();

        return view('dashboard/stock', [
            'caisse' => $this->getCaisseSession(),
            'produits' => $produits,
        ]);
    }

    public function achats()
    {
        $db = \Config\Database::connect();
        $achats = $db->table('achatMere')
            ->select('achatMere.*, caisse.designation AS caisse')
            ->join('caisse', 'caisse.id = achatMere.idCaisse', 'left')
            ->orderBy('achatMere.date', 'DESC')
            ->get()
            ->getResultArray();

        return view('dashboard/achats', [
            'caisse' => $this->getCaisseSession(),
            'achats' => $achats,
        ]);
    }

    public function achatDetail(int $id)
    {
        $db = \Config\Database::connect();
        $achat = $db->table('achatMere')
            ->select('achatMere.*, caisse.designation AS caisse')
            ->join('caisse', 'caisse.id = achatMere.idCaisse', 'left')
            ->where('achatMere.id', $id)
            ->get()
            ->getRowArray();

        if (! $achat) {
            return redirect()->to(site_url('dashboard/achats'))->with('error', 'Achat introuvable');
        }

        $details = $db->table('achatFille')
            ->select('achatFille.*, produit.designation')
            ->join('produit', 'produit.id = achatFille.idProduit', 'left')
            ->where('achatFille.idAchatMere', $id)
            ->orderBy('produit.designation', 'ASC')
            ->get()
            ->getResultArray();

        return view('dashboard/achat_detail', [
            'caisse' => $this->getCaisseSession(),
            'achat' => $achat,
            'details' => $details,
        ]);
    }

    private function getCaisseSession(): array
    {
        return [
            'id' => session()->get('id_caisse'),
            'designation' => session()->get('caisse_designation'),
        ];
    }

    private function getResume(): array
    {
        $db = \Config\Database::connect();

        return [
            'produits' => (int) $db->table('produit')->countAllResults(),
            'achats' => (int) $db->table('achatMere')->countAllResults(),
            'total' => (float) ($db->table('achatMere')->selectSum('total', 'total')->get()->getRow()->total ?? 0),
        ];
    }
}
