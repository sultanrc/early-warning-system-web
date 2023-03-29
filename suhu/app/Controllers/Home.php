<?php

namespace App\Controllers;

use CodeIgniter\Controller;
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
        $this->email = \Config\Services::email();
        $this->email = service('email');
        $this->email->setTo('emailtesarduino@gmail.com');
        $this->email->setFrom('www.petrochina.co.id', 'Early Warning System');
        helper('url', 'form'); // load URL helper

    }

    public function index()
    {
        $query = $this->ews->where('status', false)->first();
        
        if ($query) {
            if ($query['temp'] >= 24) {
                $this->email->setSubject('High Temperature Alert');
                $message = 'Temperature is ' . strval($query['temp']) . ' degrees. Please take necessary action.';
                $this->email->setMessage($message);
                if (!$this->email->send()) {
                    $data = $this->email->printDebugger(['headers']);
                    print_r($data);
                }
            }
            $this->ews->update($query['id'], ['status' => true]);
        }
        
        $data['ews'] = $this->ews->findAll();
        helper('form');
        return view('index', $data);
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
