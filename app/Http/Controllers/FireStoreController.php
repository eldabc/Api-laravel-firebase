<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FireStoreService;
use Kreait\Firebase\Exception\FirebaseException;

class FireStoreController extends FireStoreService
{
    private $service;
    public function __construct()
    {
        $this->service = new FireStoreService();
    }

    function index(){
        dd($this->service);
        $reference = $this->service->db->getReference('/posts');
        $registros = $reference->getValue();
        return $registros;
    }
}
