<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\indexModel;

class ArduinoController extends Controller
{
    public function temperature()
    {
        $temperature = $this->request->getPost('temperature');
        $sensor = $this->request->getPost('sensor');

        $model = new TemperatureModel();
        $model->insert([
            'temperature' => $temperature,
            'sensor' => $sensor
        ]);

        return 'OK';
    }
}