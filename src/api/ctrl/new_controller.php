<?php

require_once __DIR__.'/../svc/new_svc.php';

class NewController {
    
    public function createItem($name, $type, $folderPath, $username) {
        $newFileSVC = new NewFileService();
        
        if (empty($name)) {
            return "El nombre no puede estar vacío.";
        }
        
        // Definir la ruta del nuevo item
        $newPath = __DIR__.'/../../gra_files_storage' . $folderPath .'/'. $name;
        
        if ($type === 'folder') {
            if (!mkdir($newPath, 0777, true)) {
                return "Error al crear la carpeta.";
            }
            $newFileSVC->insertNewFolder($name, $folderPath, $username);
        } else if ($type === 'file') {
            if (!file_put_contents($newPath . ".txt", "")) {
                return "Error al crear el archivo.";
            }
            $newFileSVC->insertNewFile($name, $folderPath . ".txt", $username);
        }
        
        return "Elemento creado exitosamente.";
    }
}

?>
