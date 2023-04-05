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
        // exec('python Python/ews.py > /dev/null &');
        
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
    
     public function insert($temp, $hum, $fa)
    {
        // Get the current date and time
        $date = date('Y-m-d');
        $time = date('H:i:s');

        // Set empty variable for status
        $status = '';
        
        $data = array(
            'date' => $date,
            'time' => $time,
            'temp' => $temp,
            'hum' => $hum,
            'fa' => $fa,
            'status' => $status
    
        );
        $this->ews->insert($data); 

        return redirect()->to('/');
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

    public function predict()
    {
        helper('form');
        // Mengambil nilai suhu_luar_besok dan suhu_ac_besok dari form
        $suhu_luar_besok = $this->request->getPost('suhu_luar_besok');
        $suhu_ac_besok = $this->request->getPost('suhu_ac_besok');

        // Path ke file ews.py
        $python_script_path = APPPATH . 'Python/ews.py';

        // Menjalankan skrip python dengan argumen yang diberikan
        $output = shell_exec('python ' . $python_script_path . ' ' . $suhu_luar_besok . ' ' . $suhu_ac_besok);

        $delimiter = "\n";
        $token = strtok($output, $delimiter);
        $output_array = [];
        while ($token !== false) {
            $output_array[] = $token;
            $token = strtok($delimiter);
        }

        // Mengambil baris terakhir
        $last_line = end($output_array);

        // Mengirimkan hasil dari skrip python ke view
        $ews = $this->ews->findAll();
        return view('index', ['last_line' => $last_line, 'ews' => $ews]);
    }
}
