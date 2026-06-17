<?php

namespace App\Controllers;

use App\Models\CaisseModel;

class Home extends BaseController
{
    public function index(): string
    {
        $caisses = (new CaisseModel())->findAll();

        return view('home/index', ['caisses' => $caisses]);
    }
}
