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
 
            if($decoded->role_id=="1"){
                
              $db      = \Config\Database::connect();
        $builder = $db->table('checkin');
$builder->select('checkin.id,nama_lokasi,created_at,nama,gambar,email'); 
$builder->join('locations','locations.id=checkin.lokasi_id');
$builder->join('users','users.id=checkin.user_id');
$builder->where('checkin.lokasi_id = 1');
$builder->orderBy('created_at','DESC');
$query= $builder->get()->getResult();
return $this->response->setJSON($query);
    }else if($decoded->role_id=="2"){
            
            $db      = \Config\Database::connect();
            $builder = $db->table('checkin');
            $builder->where('checkin.user_id', $decoded->uid);
            $builder->select('checkin.id,lokasi_id,created_at,nama_lokasi,gambar,nama,email');
            $builder->join('locations','locations.id=checkin.lokasi_id');
            $builder->join('users','users.id=checkin.user_id');
            $builder->orderBy('created_at','DESC');
            $query= $builder->get()->getResult();
           
            return $this->response->setJSON($query);
		}if($decoded->role_id=="3"){
                
              $db      = \Config\Database::connect();
        $builder = $db->table('checkin');
$builder->select('checkin.id,nama_lokasi,created_at,nama,gambar,email'); 
$builder->join('locations','locations.id=checkin.lokasi_id');
$builder->join('users','users.id=checkin.user_id');
$builder->where('checkin.lokasi_id = 2');
$builder->orderBy('created_at','DESC');
$query= $builder->get()->getResult();
return $this->response->setJSON($query);
    }else{
            return $this->fail('tidak ada data');
        }
        // var_dump($locations->findAll());
    
    }catch (\Throwable $th) {
            // var_dump($th);die;
			return $this->fail('Invalid Token');
		}
    }


    public function store(){
        $db      = \Config\Database::connect();
       
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
		if(!$header) return $this->failUnauthorized('Token Required');
		$token = explode(' ', $header)[1];
      
		try {
            
		$decoded = JWT::decode($token, $key, ['HS256']);
        
        
            if($decoded->role_id=="1"){
                $db      = \Config\Database::connect();
                 //query untuk scan
                $builder = $db->table('locations');
                $builder->select('locations.id');
                $builder->where('locations.kode', $this->request->getVar('kode_lokasi'));
                $id_lokasi = $builder->get()->getResult()[0]->id;
                //query untuk melihat tanggal user
               
                 $builder = $db->table('checkin');
                $builder ->select('COUNT(user_id) as total');
                $builder ->where ('DAY(created_at)=DAY(NOW())');
                $builder ->where ('HOUR(created_at)=HOUR(NOW())');
                $builder ->where('user_id', $decoded->uid);
                $hari = $builder->get()->getResult()[0]->total;
                // var_dump($created_at);die;
                $builder = $db->table('checkin');
                $builder ->select('COUNT(user_id) as jam');
                $builder ->where ('HOUR(created_at)=HOUR(NOW())');
                $builder ->where('user_id', $decoded->uid);
                $jam = $builder->get()->getResult()[0]->jam;
                // var_dump($created_at);die;
                //  var_dump($id_lokasi);die;
                    if($id_lokasi == 1 && $hari<2 && $jam ==1 ){
                            return $this->response->setJSON([
                                "status" => 403
                            ]);
                        }else if($id_lokasi != 1  ){
                            return $this->response->setJSON([
                                "status" => 404
                            ]);
                        }else if($id_lokasi == 1 && $hari>2 ){
                            return $this->response->setJSON([
                                "status" => 402
                            ]);
                       
                        }else{
                            $builderin = $db->table('checkin');
                            $data = [
                                'lokasi_id'  => $id_lokasi ,
                                'user_id'=> $decoded->uid
                            ];
                            $builderin->insert($data);
                            $query= $builder->get()->getResult();
                        
                            return $this->response->setJSON([
                                "status" => 200
                            ]);
                        }
           
           
                    }else if($decoded->role_id=="3"){
                $db      = \Config\Database::connect();
                $builder = $db->table('locations');
                $builder->select('locations.id');
                $builder->where('locations.kode', $this->request->getVar('kode_lokasi'));
                $id_lokasi = $builder->get()->getResult()[0]->id;

                 $builder = $db->table('checkin');
                $builder ->select('COUNT(user_id) as total');
                $builder ->where ('DAY(created_at)=DAY(NOW())');
                $builder ->where('user_id', $decoded->uid);
                $hari = $builder->get()->getResult()[0]->total;
                // var_dump($created_at);die;
                $builder = $db->table('checkin');
                $builder ->select('COUNT(user_id) as jam');
                $builder ->where ('HOUR(created_at)=HOUR(NOW())');
                $builder ->where('user_id', $decoded->uid);
                $jam = $builder->get()->getResult()[0]->jam;
                // var_dump($created_at);die;
                //  var_dump($id_lokasi);die;
                    if($id_lokasi == 2 && $hari<2 && $jam ==1 ){
                            return $this->response->setJSON([
                                "status" => 403
                            ]);
                        }else if($id_lokasi != 1  ){
                            return $this->response->setJSON([
                                "status" => 404
                            ]);
                        }else if($id_lokasi == 2 && $hari>2 ){
                            return $this->response->setJSON([
                                "status" => 402
                            ]);
                       
                        }else{
                            $builderin = $db->table('checkin');
                            $data = [
                                'lokasi_id'  => $id_lokasi ,
                                'user_id'=> $decoded->uid
                            ];
                            $builderin->insert($data);
                            $query= $builder->get()->getResult();
                        
                            return $this->response->setJSON([
                                "status" => 200
                            ]);
                        }
               
            }else if($decoded->role_id=="2"){

                $db      = \Config\Database::connect();
                $builder = $db->table('locations');
                $builder->select('locations.id');
                $builder->where('locations.kode', $this->request->getVar('kode_lokasi'));
                $id_lokasi = $builder->get()->getResult()[0]->id;
                $id = $builder->get()->getResult();
             
                

                 $builder = $db->table('checkin');
                $builder ->select('COUNT(user_id) as total');
                $builder ->where ('DAY(created_at)=DAY(NOW())');
                $builder ->where('user_id', $decoded->uid);
                $builder ->where ('lokasi_id',$id_lokasi);
                $hari = $builder->get()->getResult()[0]->total;
                // var_dump($created_at);die;
                $builder = $db->table('checkin');
                $builder ->select('COUNT(user_id) as jam');
                $builder ->where ('HOUR(created_at)=HOUR(NOW())');
                $builder ->where ('lokasi_id',$id_lokasi);
                $builder ->where('user_id', $decoded->uid);
                $jam = $builder->get()->getResult()[0]->jam;
                
             
                 
                    if($id_lokasi == 1 && $hari<2 && $jam ==1  ){
                            return $this->response->setJSON([
                                "status" => 403
                            ]);
                       
                        }else if($id_lokasi == 2 && $hari<2 && $jam ==1 ){
                            return $this->response->setJSON([
                                "status" => 408
                            ]);
                       
                        }else{
                            $builderin = $db->table('checkin');
                            $data = [
                                'lokasi_id'  => $id_lokasi ,
                                'user_id'=> $decoded->uid
                            ];
                            $builderin->insert($data);
                            $query= $builder->get()->getResult();
                        
                            return $this->response->setJSON([
                                "status" => 200
                            ]);
                        }

               
            }
		} catch (\Throwable $th) {
           
			return $this->fail('Invalid Token');
		}

    }

    
}
