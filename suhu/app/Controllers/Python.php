<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Python extends BaseController
{
    public function index(){
        return view('python');
    }
    public function predict()
    {
        // Mengambil nilai suhu_luar_besok dan suhu_ac_besok dari form
        $suhu_luar_besok = $this->request->getPost('suhu_luar_besok');
        $suhu_ac_besok = $this->request->getPost('suhu_ac_besok');

        // Path ke file ews.py
        $python_script_path = APPPATH . 'Python/ews.py';

        // Menjalankan skrip python dengan argumen yang diberikan
        $output = shell_exec('python ' . $python_script_path . ' ' . $suhu_luar_besok . ' ' . $suhu_ac_besok);

        // Mengirimkan hasil dari skrip python ke view
        return view('python', ['output' => $output]);
    }
}