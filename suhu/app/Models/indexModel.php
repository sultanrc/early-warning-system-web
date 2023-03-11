<?php

namespace App\Models;
use CodeIgniter\Model;

class indexModel extends Model
{
    protected $table            = 'ews_table';  
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['date', 'time', 'temp', 'hum', 'fa', 'status'];
    
    public function getReportData($date, $dataType)
    {
        $builder = $this->db->table('ews_table');
        $builder->select('date, '.$dataType);
        $builder->where('date', $date);
        $query = $builder->get();
        return $query->getResultArray();
    }

}

