<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
// use App\Models\UserModel;
use Firebase\JWT\JWT;

class Auth extends ResourceController
{
	/**
	 * Return an array of resource objects, themselves in array format
	 *
	 * @return mixed
	 */
	use ResponseTrait;
    protected $modelName = 'App\Models\UserModel';
    
    public function index()
    {
        // return $this->respond($this->model->findAll());
        $db      = \Config\Database::connect();
        $builder = $db->table('users');
$builder->select('users.id,email,users.nama,roles.nama as jenis'); 
$builder->join('roles','roles.id=users.role_id');

$query= $builder->get()->getResult();
return $this->response->setJSON($query);
    
    }
    
    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        
        $data['id'] = $id;

        $check_data = $this->model->where('id', $id)->find();
        if(!$check_data){
            return $this->failNotFound("Data tidak ditemukan");
        }
      

        $save = $this->model->save($data);

        if(!$save){
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 200,
            'error' => null,
            'message' => [
                'success' => "Berhasil mengubah Data"
            ]
        ];

        return $this->respondUpdated($response);
    }
}