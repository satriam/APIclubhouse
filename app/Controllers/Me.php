<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;




class Me extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    public function index()
    {
        // return $this->respond($this->model->findAll());
        // $data = $this->model->orderBy('id', 'asc')->findAll();
        // return $this->respond($data, 200);
        $db      = \Config\Database::connect();
        $builder = $db->table('users');
$builder->select('nama,email,role_id'); 

$query= $builder->get()->getResult();
return $this->response->setJSON($query);
    }
}
