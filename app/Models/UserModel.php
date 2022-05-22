<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{

	protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
		'id',
		'email',
		'password',
		'nama',
		'role_id'
    ];

    protected $validationRules = [
        'email' => 'required',
        'password'=> 'required',
    ];

    protected $validationMessages = [
        'email' =>[
            'required' => 'Email tidak boleh kosong'
        ],
        'password' =>[
            'required' => 'password tidak boleh kosong'
        ],        
    ];
	protected $DBGroup              = 'default';
	

	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;


	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation

	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];
}
