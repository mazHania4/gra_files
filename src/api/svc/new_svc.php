<?php

require_once __DIR__.'/../../vendor/autoload.php'; // Usar Composer para MongoDB

class NewFileService {

    private $db;

    public function __construct(){
        $client = new MongoDB\Client("mongodb://mongo:27017");
        $this->db = $client->gra_files_storage;
    }
	

    public function insertNewFolder($name, $path, $username){
        $new_id = $path .'/'. $name;
        $folderData = [
            '_id' => $new_id,
            'owner_id' => $username,
            'folder_id' => $path,
            'filename' => $name,
            'is_folder' => true,
            'is_deleted' => false,
            'is_shared' => false
        ];

        $this->db->files->insertOne($folderData);
    }

    public function insertNewFile($name, $path, $username){
        $new_id = $path .'/'. $name;
        $fileData = [
            '_id' => $new_id,
            'owner_id' => $username,
            'filename' => $name,
            'folder_id' => $path,
            'extension' => "txt",
            'is_folder' => false,
            'is_deleted' => false,
            'is_shared' => false
        ];

        $this->db->files->insertOne($fileData);
    }
}

?>