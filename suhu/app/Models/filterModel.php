<?php

namespace App\Models;
use CodeIgniter\Model;

class filterModel extends Model
{
    protected $table            = 'ews_table';  
    protected $primaryKey       = 'id';
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields    = ['date', 'time', 'temp', 'hum', 'fa'];
    
    public function getReportData($date)
    {
        return $this->where('date', $date)->findAll();
    }

}

