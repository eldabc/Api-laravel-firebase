<?php 
namespace App\Services;

  // require '../../../vendor/autoload.php';

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

    public function getData()
    {
      // dd($this->db);
      $reference = $this->db->getReference('/posts');
      $registros = $reference->getValue();
      return $registros;
    }

    public function replaceData()
    {
      $this->db->getReference('/users/data')
      ->set([
        'name' => 'Test name elda bb 1',
        'emails' => [
            'support' => 'support@domain.tld1',
            'sales' => 'sales@domain.tld1',
        ],
        'website' => 'https://app.domain.tld1',
       ]);
    }

    public function insertData()
    {
      $postData = [
        'name' => 'Test name post',
        'body' => 'Test body post',
        
      ];
      $postRef = $this->db->getReference('/posts')->push($postData);

      $postKey = $postRef->getKey();
      return $postKey;
    }

    //Nota: método update inserta sino consigue id
    public function updateData()
    {
      $uid = '-MW2ColDf7c0VDlBTU0-';
      $postData = [
          'name' => 'My awesome post title 221 3333',
          'body' => 'This text should be longer 221',
      ];

      // Create a key for a new post
      $newPostKey = $this->db->getReference('/posts')->push()->getKey();

      $updates = [
          'posts/'.$uid => $postData,
      ];

      $this->db->getReference() // this is the root reference
        ->update($updates);
    }

    public function deleteData()
    {
      $this->db->getReference('/posts/-MW2Jxg5TvvtF0T88pqL')->remove();
    }

    public function addUser($email, $password, $displayName)
    {
      $auth = $this->firebase->createAuth();
      $userProperties = [
        'email' => $email,
        'emailVerified' => false,
        'password' => $password,
        'displayName' => $displayName,
      ];
      
      return $auth->createUser($userProperties);
    }

    public function signIn($email, $password)
    {
      $auth = $this->firebase->createAuth();
      // try {
        $signInResult = $auth->signInWithEmailAndPassword($email, $password);
      // } catch (Exception $e) {
        // echo "Datos incorrectos";
      // }
      
      return $signInResult;
    }
  }