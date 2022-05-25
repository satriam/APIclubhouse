<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class readcheckin extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\CheckinModel';
    protected $format    = 'json';

    public function index()
    {
        // return $this->respond($this->model->findAll());
        // $data = $this->model->orderBy('id', 'asc')->findAll();
        // return $this->respond($data, 200);
        $db      = \Config\Database::connect();
        $builder = $db->table('checkin');
$builder->select('checkin.id,nama_lokasi,created_at,nama'); 
$builder->join('locations','locations.id=checkin.lokasi_id');
$builder->join('users','users.id=checkin.user_id');
$builder->orderBy('created_at','DESC');
$query= $builder->get()->getResult();
return $this->response->setJSON($query);
    }

    public function delete($id = null)
    {
        $check_data = $this->model->where('id', $id)->find();

        if($check_data){
            $this->model->delete($id);

            $response = [
                'status' => 200,
                'error' => null,
                'message' => [
                    'success' => "Berhasil menghapus Data"
                    ]
                ];

            return $this->respondDeleted($response);

        }else {
            return $this->failNotFound("Data tidak ditemukan");
        }
    }
}