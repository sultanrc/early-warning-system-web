<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\indexModel;

class Home extends BaseController
{
    private $email; // add this property

    function __construct(){
        $this->ews = new indexModel();
        $this->email = \Config\Services::email();
        $this->email = service('email');
        $this->email->setTo('emailtesarduino@gmail.com');
        $this->email->setFrom('www.petrochina.co.id', 'Early Warning System');
    }

    public function index()
    {   
        $query = $this->ews->where('status', false)->first();
        
        if($query){
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
        return view('index', $data);
    }
}