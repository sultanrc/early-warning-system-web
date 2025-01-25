<?php

namespace App\Controllers;

use App\Models\indexModel;
use App\Models\filterModel;
use \Dompdf\dompdf;

class Home extends BaseController
{
    private $email;
    private $ews;
    
    function __construct()
    {
        $this->ews = new indexModel();
        helper('url', 'form'); // load URL helper

    }

    public function index()
    {   
        $data['ews'] = $this->ews->findAll();
        helper('form');
        return view('index', $data);
    }

    public function getData()
    {
        $data['ews'] = $this->ews->findAll();
        return json_encode($data);
    }

    public function generate()
    {
        $model = new filterModel();
        $date = $this->request->getGet('date');
        $ews = $model->getReportData($date);

        $data = [
            'ews' => $ews,
            'date' => $date,
        ];

        $dompdf = new Dompdf();
        $html = view('print', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream('EarlyWarningSystem.pdf', array(
            "Attachment" => false
        ));

        helper('form');
    }
}
