<?php
namespace App\Controllers;
use App\Models\indexModel;
use App\Controllers\BaseController;
use \Dompdf\dompdf;

class PrintController extends BaseController
{
    function __construct(){
        $this->ews = new indexModel();
        helper('url'); // load URL helper
    }

    public function index()
    {
        
        $dompdf = new Dompdf();
        $data['ews'] = $this->ews->findAll();
        $html = view('print', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('EarlyWarningSystem.pdf', array(
            "Attachment" => false
        ));
        
    }
    
    public function print()
    {
        $data['ews'] = $this->ews->findAll();
        return view('print', $data);
    }
}

