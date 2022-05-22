<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
// use App\Models\LocationModel;

class Location extends ResourceController
{
    protected $modelName = 'App\Models\LocationModel';
    protected $format    = 'json';

    public function index(){

        $data = $this->model->orderBy('id', 'asc')->findAll();
        return $this->respond($data, 200);
    }

    public function create()
    {
        $data = null;
        $data = $this->request->getRawInput();

        if (empty($data)) {
            return $this->fail("Data yang diinput Kosong");
        }

        $save = $this->model->save($data);

        if(!$save){
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 201,
            'error' => null,
            'message' => [
                'success' => "Berhasil Menambahkan Data"
            ]
        ];

        return $this->respondCreated($response);
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
