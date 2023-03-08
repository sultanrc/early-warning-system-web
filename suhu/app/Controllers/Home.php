<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\indexModel;
use App\Models\userModel;

class Home extends BaseController
{
    private $email; // add this property

    function __construct(){
        $this->ews = new indexModel();
        $this->email = \Config\Services::email();
    }

    public function index()
    {   
        $email = service('email');
        $email->setTo('emailtesarduino@gmail.com');
        $email->setFrom('www.petrochina.co.id', 'Early Warning System');

        $email->setSubject($subject);
        $email->setMessage($message);

        if (!$email->send()) {
            $data = $email->printDebugger(['headers']);
            print_r($data);
        }
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
                    $tujuan = "tanzjder@gmail.com";
                    $this->email->setTo($tujuan);
                    $sender = "emailtesarduino@gmail.com";
                    $this->email->setFrom($sender);
                    $subject = "High Temperature Alert";
                    $this->email->setSubject($subject);
                    $message = "Temperature is above 24 degrees. Please take necessary action.";
                    $this->email->setMessage($message);
                    // $this->email->setNewline(“\r\n”);
                    $this->email->send();
                }
                
                // Update record status to checked
                $model->update($record['id'], ['status' => true]);
            }
        }
    }
}
