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
        
        if ($query['temp'] >= 24) {
            $email->setSubject('High Temperature Alert');
            $email->setMessage('Temperature is ' + $query['temp'] + ' degrees. Please take necessary action.');

            if (!$email->send()) {
                $data = $email->printDebugger(['headers']);
                print_r($data);
            }
        }
        $this->ews->update($query['id'], ['status' => true]);
        $data['ews'] = $this->ews->findAll();
        return view('index', $data);
    }
}