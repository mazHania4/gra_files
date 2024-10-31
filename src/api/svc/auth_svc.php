<?php
require_once '../../vendor/autoload.php'; // Usar Composer para MongoDB

class AuthService {
    private $collection;

    public function __construct() {
        $client = new MongoDB\Client("mongodb://mongo:27017");
        $db = $client->gra_files_storage;
        $this->collection = $db->users;
    }
    
    public function authenticate($username, $password) {
        $hash = hash('sha256', $password); 
        $user = $this->collection->findOne(['_id' => $username, 'password' => $hash]);
        return $user;
    }
}

?>
