<?php

namespace App\Models;

use CodeIgniter\Model;

class CheckinModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'checkin';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['lokasi_id','created_at'];
}