<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\LocationModel;

class Location extends ResourceController
{

    public function index(){

        $locations = new LocationModel();

        // var_dump($locations->findAll());
        return $this->response->setJSON([
			"status" => 200,
			"message" => "ok",
			"data" => $locations->findAll()
		]);
    }
}
