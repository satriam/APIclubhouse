<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class Register extends ResourceController
{
	/**
	 * Return an array of resource objects, themselves in array format
	 *
	 * @return mixed
	 */
	use ResponseTrait;
	public function index()
	{
		helper(['form']);
		$rules = [
			'email' => 'required|valid_email|is_unique[users.email]',
			'password' => 'required|min_length[6]',
			'nama'=>'required'
		];
		if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
		$data = [
			'email' 	=> $this->request->getVar('email'),
			'password'  => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT) ,
			'nama'		=>$this->request->getVar('nama'),
			'role_id'	=> $this->request->getVar('role_id')
		];
		$model = new UserModel();
		$registered = $model->save($data);
		
		$this->respondCreated($registered);
		return $this->response->setJSON([
			"status" => 200,
			"message" => "berhasil menambahkan data",
			
			]);
	}

}
