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
      $this->firebase = (new Factory)->withServiceAccount(__DIR__.env('FIREBASE_CREDENTIALS'));
      $this->db = $this->firebase->createDatabase();  
    }

  }