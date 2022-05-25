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
            $builder->orderBy('created_at','DESC');
            $query= $builder->get()->getResult();
            //  var_dump($query);die;
            // var_dump($decoded);die;
            return $this->response->setJSON($query);
		} catch (\Throwable $th) {
            // var_dump($th);die;
			return $this->fail('Invalid Token');
		}
        // var_dump($locations->findAll());
        
    }

    public function store(){
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
		if(!$header) return $this->failUnauthorized('Token Required');
		$token = explode(' ', $header)[1];
        // var_dump($token);die;
        
		try {
            
			$decoded = JWT::decode($token, $key, ['HS256']);
            $db      = \Config\Database::connect();
            $builder = $db->table('locations');
            $builder->select('locations.id');
            $builder->where('locations.kode', $this->request->getVar('kode_lokasi'));
            $id_lokasi = $builder->get()->getResult()[0]->id;
            // var_dump($id_lokasi);die;

            $builderin = $db->table('checkin');
            $data = [
                'lokasi_id'  => $id_lokasi ,
                'user_id'=> $decoded->uid
            ];
            // var_dump($data);die;
            $builderin->insert($data);
            
            
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
