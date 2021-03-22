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
        // dd($request->name);
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
        // dd($editData);
      $newPostKey = $this->service->db->getReference('/posts')->push()->getKey();

      $updates = [
          'posts/'.$uid => $editData,
      ];

      $this->service->db->getReference() // this is the root reference
             ->update($updates);
    }

    public function destroy($uid)
    {
        try{
            $this->service->db->getReference('/posts/'.$uid)->remove();
            return "Deleted";
        }catch (\Exception $exception){
            return "Error";
        }
    }

    // public function addUser(Request $request)
    // {
    //     try {
    //         $auth = $this->service->firebase->createAuth();
    //         $userProperties = [
    //             'email' => $request->email,
    //             'emailVerified' => false,
    //             'password' => $request->password,
    //             'displayName' => $request->displayName,
    //         ];
   
    //         return $auth->createUser($userProperties);
    //     } catch (FirebaseException $e) {
    //         return "Ha ocurrido un error, email debe ser único";
    //     } 
    // } 

    // public function signIn($email, $password)
    // {
    //   try {
    //     $auth = $this->service->firebase->createAuth();
    //     $signInResult = $auth->signInWithEmailAndPassword($email, $password);
    //     return $signInResult->firebaseUserId();

    //   } catch (FirebaseException $e) {
    //     return "Usuario o clave inválidos";
    //   }
    // }

    // public function signOut($email, $password)
    // {
    //   $auth = $this->service->firebase->createAuth();
    //   try {
    //     $signInResult = $auth->signOut();
    //     return "Salir";

    //   } catch (Exception $e) {
    //     return "Error";
    //   }
      
    //   return $signInResult;
    // }

    // public function changePassword(Request $request)
    // {
    //   echo "hika";
    //       // dd($request);
    //   try {
    //     $auth = $this->service->firebase->createAuth();
          

    //     $updatedUser = $auth->changeUserPassword($request->uid, $request->password);
    //     return "Clave cambiada";

    //   } catch (FirebaseException $e) {
    //     return "Algo ha salido mal ".$e;
    //   }
    // }
}
