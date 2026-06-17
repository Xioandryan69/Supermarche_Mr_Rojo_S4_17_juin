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
        $idCaisse = $this->request->getPost('id_caisse');


        session()->set('id_caisse', $idCaisse);

        return redirect()->to(site_url('achat'));
    }
}
