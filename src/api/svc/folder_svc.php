
<?php
require_once __DIR__.'/../../vendor/autoload.php'; // Usar Composer para MongoDB

class FolderService {

    private $db;

    public function __construct(){
        $client = new MongoDB\Client("mongodb://mongo:27017");
        $this->db = $client->gra_files_storage;
    }
	

    public function fetchFolderContent($folderPath, $username) {
        $folder = $this->db->files->findOne(['_id' => $folderPath]);

        if (!$folder || !$folder['is_folder']) {
            return [];
        }

        // Obtiene el contenido de la carpeta (archivos y subcarpetas)
        $content = $this->db->files->find(['folder_id' => $folderPath])->toArray();
        return $content;
    }
}
