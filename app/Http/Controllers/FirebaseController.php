<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;
use Kreait\Firebase\Exception\FirebaseException;

class FirebaseController extends FirebaseService
{
    private $service;
    public function __construct()
    {
        $this->service = new FirebaseService();
    }

    function index(){
        $reference = $this->service->db->getReference('/posts');
        $registros = $reference->getValue();
        return $registros;
    }

    function store(Request $request)
    {
        $postData = [
            'name' => $request->name,
            'body' => $request->body,  
        ];
        
        $postRef = $this->service->db->getReference('/posts')->push($postData);

        $postKey = $postRef->getKey();
        return $postKey;
    }

    public function update(Request $request, $uid)
    {
      $editData = [
          "name" => $request->name,
          "body" => $request->body
      ];

      $newPostKey = $this->service->db->getReference('/posts')->push()->getKey();

      $updates = [
          'posts/'.$uid => $editData,
      ];

      $this->service->db->getReference()
             ->update($updates);
    }

    public function destroy($uid)
    {
        try{
            $this->service->db->getReference('/posts/'.$uid)->remove();
            return "Deleted";
        }catch (FirebaseException $e){
            return "Error";
        }
    }
}
