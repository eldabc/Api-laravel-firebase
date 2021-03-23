<?php 
namespace App\Services;
use Kreait\Firebase\Exception\FirebaseException;
use Throwable;
use Kreait\Firebase\Factory;

  class FirebaseService
  {
    protected $firebase;
    protected $db;

    public function __construct()
    {
      // dd(env('FIREBASE_CREDENTIALS'));
      $this->firebase = (new Factory)->withServiceAccount(__DIR__."/../../key/FirebaseKey.json");
      $this->db = $this->firebase->createDatabase();  
    }

  }