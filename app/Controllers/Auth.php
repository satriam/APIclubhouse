<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use Firebase\JWT\JWT;

class Auth extends ResourceController
{
	/**
	 * Return an array of resource objects, themselves in array format
	 *
	 * @return mixed
	 */
	use ResponseTrait;

public function update($id = NULL){
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
		if(!$header) return $this->failUnauthorized('Token Required');
		$token = explode(' ', $header)[1];
        // var_dump($token);die;
        
		try {
          
			$decoded = JWT::decode($token, $key, ['HS256']);
            $db      = \Config\Database::connect();
            $builder = $db->table('users');
            // var_dump($decoded);die;
            $model = new UserModel();
            $id = $this->request->getVar('id');
            $data = [
                'nama' => $this->request->getVar('nama'),
                'password'  => $this->request->getVar('password'),
            ];
            // var_dump($data);die;
            $builder->set($data);
            // $this->update();
            $builder->update($decoded["uid"]);
           var_dump($builder);die;
            
            $query= $builder->get()->getResult();
            
            //  var_dump($query);die;
            // var_dump($decoded);die;
            return $this->response->setJSON([
                "status" => 200
            ]);
		} catch (\Throwable $th) {
            var_dump($th);die;
			return $this->fail('Invalid Token');
		}

    }
}