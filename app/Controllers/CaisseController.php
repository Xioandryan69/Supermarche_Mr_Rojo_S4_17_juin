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
}
