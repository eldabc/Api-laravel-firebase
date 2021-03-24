<?php 
namespace App\Services;

use Exception;
use MrShan0\PHPFirestore\FirestoreClient;
use MrShan0\PHPFirestore\FirestoreDocument;
use Kreait\Firebase\Exception\FirebaseException;

class FireStoreService
{
  protected $firestoreClient;
  public function __construct()
  {
    $this->firestoreClient = new FirestoreClient('test-6c9bf', 'AIzaSyBXpsfiOvCOaTsGMdeXs4Yzb6c1N4g87_I',  [
      'database' => '(default)',
    ]);
  }

  public function listDocument()
  {
    return $collections = $this->firestoreClient->listDocuments('users');
  }

  public function addDocument()
  {
    try{

      $document = new FirestoreDocument;
      $document->fillValues([
        'string' => 'abc1234567',
        'boolean' => true,
        'string' => ['string'=>'abc1234567', 'data' => 'test data'],
      ]);

      return $this->firestoreClient->addDocument('date', $document);

    }catch(\GuzzleHttp\Exception\ConnectException $e){
      return "Error. ".$e->getMessage();
    }
  }

  public function updateDocument(){
    try{
    
        return $this->firestoreClient->updateDocument('users/IyatDcWVQGdgFRPctXdW', [
            'string' => 'Edit Test',
            'boolean' => true,
            'string' => ['string'=>'String Edit', 'data' => 'Data Edit'],
        ], true);

    }catch(\MrShan0\PHPFirestore\Exceptions\Client\NotFound $e){
      return "Error al actualizar. ".$e->getMessage();
    }
  }

  public function getDocument(){
    try {
        return $this->firestoreClient->getDocument('users/SIvZyzofC6YRzxRcnLwB');
    } catch (FirestoreDocument $e) {
        return "Error al obnete documento. ";
    }
  }

  public function deleteDocument()
  {
    try {
      $collection = 'users/';
      return  $this->firestoreClient->deleteDocument($collection, ['id' => 'IyatDcWVQGdgFRPctXdWf']);
    } catch (Exception $e) {
      return  "Error. ".$e;
    }
  }
}