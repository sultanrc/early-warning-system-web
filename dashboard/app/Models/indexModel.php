<?php

namespace App\Models;
use CodeIgniter\Model;

class indexModel extends Model
{
    protected $table            = 'ews_table';  
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['date', 'time', 'temp', 'hum', 'fa', 'status'];

}

