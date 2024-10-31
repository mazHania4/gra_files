
<?php
require_once __DIR__.'/../svc/folder_svc.php';

class FolderController {
    private $folderService;

    public function __construct() {
        $this->folderService = new FolderService();
    }

    public function getFolderContent($folderPath) {
        
        $username = $_SESSION['username'];
        
        // asegurar que se busca dentro de los archivos del usuario
        if (!str_starts_with($folderPath, "/$username/")) {
            echo "Acceso denegado.";
            return [];
        }

        // Obtiene el contenido de la carpeta desde el servicio
        return $this->folderService->fetchFolderContent($folderPath, $username);
    }
}
