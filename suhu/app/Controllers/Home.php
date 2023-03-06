<?php

namespace App\Controllers;
use App\Models\indexModel;

class Home extends BaseController
{
    function __construct(){
        $this->ews = new indexModel();
    }

    public function index()
    {
        $data['ews'] = $this->ews->findAll();
        return view('index', $data);
    }
}
