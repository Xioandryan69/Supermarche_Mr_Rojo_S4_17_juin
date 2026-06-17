<?php

namespace App\Controllers;

class CaisseController extends BaseController
{
    private $caisseModel;

    //constructeur 
    public function __construct()
    {
        $this->caisseModel = new \App\Models\CaisseModel();
    }

    public function index(): string
    {
        $caisses = $this->caisseModel->findAll();

        return view('caisse/index', ['caisses' => $caisses]);
    }

    public function valider()
    {
        $idCaisse = (int) $this->request->getPost('id_caisse');
        $caisse = $this->caisseModel->find($idCaisse);

        if (! $caisse) {
            return redirect()->back()->with('error', 'Caisse invalide');
        }

        session()->set([
            'id_caisse' => $idCaisse,
            'caisse_designation' => $caisse['designation'],
        ]);

        return redirect()->to(site_url('dashboard'));
    }
}
