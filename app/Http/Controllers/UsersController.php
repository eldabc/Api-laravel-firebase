<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;
use Kreait\Firebase\Exception\FirebaseException;

class UsersController extends FirebaseService
{
    private $service;
    private $auth;
    public function __construct()
    {
        $this->service = new FirebaseService();
        $this->auth = $this->service->firebase->createAuth();
    }

    function index()
    {
        $users = $this->auth->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);
        $array=[];
        foreach ($users as $user) {
            array_push($array,$user->uid, $user->email);
        }
        // print_r($array);
        return $array;
    }

    public function store(Request $request)
    {
        try {
            $userProperties = [
                'email' => $request->email,
                'emailVerified' => false,
                'password' => $request->password,
                'displayName' => $request->displayName
            ];
            
            $user   = $this->auth->createUser($userProperties);
            
            // set Custom Claims
            $this->auth->setCustomUserClaims($user->uid, ['isAdmin' => true, 'key' => '1234567']);
            
            // get Custom Claims
            $claims = $this->auth->getUser($user->uid)->customClaims;
            
            $data = ['userData' => $user, 'claims' => $claims];

            return $data;

        } catch (FirebaseException $e) {
            return "Ha ocurrido un error. ".$e->getMessage();
        } 
    }

    public function show($email)
    {
        try {

            return $this->auth->getUserByEmail($email);

        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            echo $e->getMessage();
        }
    }

    public function update(Request $request, $uid)
    {
        try {
            $properties = [
                'email' => $request->email,
                'displayName' => $request->displayName
            ];

            return $this->auth->updateUser($uid, $properties);

        } catch (FirebaseException $e) {
            return "Ha ocurrido un error. ".$e->getMessage();
        } 
    }

    public function destroy($uid)
    {
        try{
            $this->auth->deleteUser($uid);
            return "Deleted";
        }catch (FirebaseException $e){
            return "Error. ".$e;
        }
    }

    public function signIn(Request $request)
    {
      try {

        $signInResult = $this->auth->signInWithEmailAndPassword($request->email, $request->password);

        $claims = $this->auth->getUser($signInResult->firebaseUserId())->customClaims;
        $data = ['userDataToken' => $signInResult->data(), 'claims' => $claims];
        
        return $data;
      } catch (FirebaseException $e) {
        return "Usuario o clave inválidos ".$e->getMessage();
      }
    }

    public function changePassword(Request $request)
    {
      try {
        $updatedUser = $this->auth->changeUserPassword($request->uid, $request->password);
        return "Clave cambiada";

      } catch (FirebaseException $e) {
        return "Algo ha salido mal ".$e->getMessage();
      }
    }
}
