<?php 
namespace App\Services;
use Kreait\Firebase\Exception\FirebaseException;
use Throwable;
use Kreait\Firebase\Factory;
use Google\Cloud\Firestore\FirestoreClient;

// require '../../vendor/autoload.php';

ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL);
// namespace Google\Cloud\Firestore\FirestoreClient;

  class FireStoreService
  {
    protected $firestore;
    protected $db;
    protected $storageCliente;

    public function __construct()
    {
        // $this->initialize();
      $this->firestore = (new Factory)->withServiceAccount(__DIR__."/../../key/FirebaseKeyNew.json");
      //   $this->db = new FirestoreClient();  
      $this->db = $this->firestore->createFirestore();  
      // $this->storageCliente = $this->db->getStorageClient();
    }



    function initialize()
    {
        dd($this->storageCliente);
        // Create the Cloud Firestore client
        // $db = new FirestoreClient();
        // printf('Created Cloud Firestore client with default project ID.' . PHP_EOL);
    }

  }