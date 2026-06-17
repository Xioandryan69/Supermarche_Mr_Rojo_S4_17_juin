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
            $userId = session()->get('id');

    $username = session()->get('username');

    $caisses = $this->caisseModel->findAll();

    return view('caisse/index', [
        'caisses' => $caisses,
        'username' => $username
    ]);
    }
    
    public function valider()
    {
        $idCaisse = $this->request->getPost('id_caisse');


        session()->set('id_caisse', $idCaisse);

        return redirect()->to(site_url('achats'));
    }


}
