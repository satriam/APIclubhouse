<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use App\Models\UserModel;




class Me extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    public function index()
    {
        $key = getenv('TOKEN_SECRET');
		$header = $this->request->getServer('HTTP_AUTHORIZATION');
		if(!$header) return $this->failUnauthorized('Token Required');
		$token = explode(' ', $header)[1];
        // var_dump($token);die;
       $decoded = JWT::decode($token, $key, ['HS256']);
           	    $db      = \Config\Database::connect();
             
		try {
             $id=intval($decoded->uid);
    
                $builder = $db->table('users');
                $builder->select('users.nama,users.id,roles.nama as jenis'); 
                $builder->join('roles','roles.id=users.role_id');
                $builder->where('users.id',$id);
                // $query= $builder->get()->getResult();
                // var_dump($query);die;
                 $query = $builder->get()->getResult()[0]->jenis;
                //  return $this->response->setJSON($query);
           return $this->response->setJSON([
			"status" => 200,
			"message" => "ok",
			"nama"=> $decoded->name,
			"Jenis_user"=>$query
			]);
	
        }catch (\Throwable $th) {
            // var_dump($th);die;
			return $this->fail('Invalid Token');
		}
    }
}
