<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\indexModel;
use App\Models\userModel;
use CodeIgniter\Email\Email;

class Home extends BaseController
{
    function __construct(){
        $this->ews = new indexModel();
        $this->checkTemp();
    }

    public function index()
    {   
        $this->checkTemp();
        $data['ews'] = $this->ews->findAll();
        return view('index', $data);
    }

    public function checkTemp()
    {
        // Get all temperature records that have not been checked
        $model = new indexModel();
        $data = $model->where('status', false)->findAll();

        // Loop through each record and check if temperature is above 24 degrees
        foreach ($data as $record) {
            if ($record['temp'] > 24) {
                // Send email notification to all users
                $userModel = new userModel();
                $users = $userModel->findAll();
                
                foreach ($users as $user) {
                    $email = \Config\Services::email();
                    $email->setTo('tanzjder@gmail.com');
                    $email->setFrom('emailtesarduino@gmail.com');
                    $email->setSubject('High Temperature Alert');
                    $email->setMessage('Temperature is above 24 degrees. Please take necessary action.');
                    $email->send();
                }
                
                // Update record status to checked
                $model->update($record['id'], ['status' => true]);
            }
        }
    }

    public function triggerCheckTemp() {
        $this->checkTemp();
        return redirect()->to(site_url('/')); // Redirect to homepage after checking temperatures
    }
    
}
