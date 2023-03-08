<?php

namespace App\Models;
use CodeIgniter\Model;

class userModel extends Model
{
    protected $table = 'user_table';
    protected $allowedFields = ['email', 'password'];
}
