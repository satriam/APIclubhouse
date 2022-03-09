<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CheckinModel;
use Firebase\JWT\JWT;

class Checkin extends ResourceController
{

    public function index(){
        $key = getenv('TOKEN_SECRET');
		$header = $this->request->getServer('HTTP_AUTHORIZATION');
		if(!$header) return $this->failUnauthorized('Token Required');
		$token = explode(' ', $header)[1];
        // var_dump($token);die;
        
		try {
            
			$decoded = JWT::decode($token, $key, ['HS256']);
            $db      = \Config\Database::connect();
            $builder = $db->table('checkin');
            $builder->where('checkin.user_id', $decoded->uid);
            $builder->select('*');
            $builder->join('locations','locations.id=checkin.lokasi_id');
            $query= $builder->get()->getResult();
            //  var_dump($query);die;
            // var_dump($decoded);die;
            return $this->response->setJSON([
                "status" => 200,
                "message" => "ok",
                "data" => $query
            ]);
		} catch (\Throwable $th) {
            // var_dump($th);die;
			return $this->fail('Invalid Token');
		}
        // var_dump($locations->findAll());
        
    }
}
