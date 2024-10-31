<?php require_once 'vendor/autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>

<div class="container">
    <h3 class="text-custom"><?=isset($_GET['folder']) ? $_GET['folder'] : '/root' ?></h3>
    
    <hr>

    <div class="dropdown my-3">
        <button class="btn btn-success dropdown-toggle" type="button" id="newButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-plus"></i> <span class="mx-2">Nuevo</span>
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#" onclick="createNewItem('folder')">Carpeta</a>
            <a class="dropdown-item" href="#" onclick="createNewItem('file')">Archivo de texto</a>
        </div>
    </div>

    <?php
        require_once 'api/ctrl/folder_controller.php';
        require_once 'api/ctrl/new_controller.php';
        if (!isset($_SESSION['username'])) {
            header('Location: /');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $type = $_POST['newItemType'];
            $folderPath = $_POST['folderPath'];
            $newController = new NewController();
            $message = $newController->createItem($name, $type, $folderPath, $_SESSION['username']);
            echo '<div class="alert alert-warning alert-dismissible fade show m-2" role="alert">
                    '.$message.'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }

        $folderController = new FolderController();
        $newController = new NewController();
        $folderPath = isset($_GET['folder']) ? $_GET['folder'] : "/".$_SESSION['username']."/root";
        $folderContent = $folderController->getFolderContent($folderPath);

        function formatDate($mongoDate) {
            if ($mongoDate){
                $dateTime = $mongoDate->toDateTime();
                return $dateTime->format('Y-m-d H:i:s');
            }
            return '-';
        }

        
    ?>



    <?php if (!empty($folderContent)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Propietario</th>
                    <th scope="col">Modificación</th>
                    <th scope="col">Creacion</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($folderContent as $item): ?>
                    <tr>
                        <td>
                            <?php if ($item['is_folder']): ?>
                                <a href="home.php?folder=<?=$item['_id']?>" class="nav-link px-0 align-middle">
                                    <i class="fa-regular fa-folder-open mx-2"></i> <span class="ms-1 d-none d-sm-inline"><?=$item['filename'];?></span>
                                </a>
                            <?php else: ?>

                                <?php if ($item['extension'] == 'txt'): ?>
                                    <a class="nav-link px-0 align-middle file-link" data-filepath="<?=$item['_id']?>">
                                    <i class="text-custom fa-solid fa-align-left mx-2"></i> <span class="ms-1 d-none d-sm-inline"><?=$item['filename']. '.' . $item['extension'];?></span>
                                    </a>
                                <?php endif; ?>
                                <?php if ($item['extension'] == 'png'): ?>
                                    <a class="nav-link px-0 align-middle file-link" data-filepath="<?=$item['_id']?>">
                                        <i class="text-custom fa-solid fa-image mx-2"></i> <span class="ms-1 d-none d-sm-inline"><?=$item['filename']. '.' . $item['extension'];?></span>
                                    </a>
                                <?php endif; ?>
                                <?php if ($item['extension'] == 'jpg'): ?>
                                    <a class="nav-link px-0 align-middle file-link" data-filepath="<?=$item['_id']?>">
                                        <i class="text-custom fa-solid fa-image mx-2"></i> <span class="ms-1 d-none d-sm-inline"><?=$item['filename']. '.' . $item['extension'];?></span>
                                    </a>
                                <?php endif; ?>
                                <?php if ($item['extension'] == 'html'): ?>
                                    <a class="nav-link px-0 align-middle file-link" data-filepath="<?=$item['_id']?>">
                                        <i class="text-custom fa-solid fa-file-code mx-2"></i> <span class="ms-1 d-none d-sm-inline"><?=$item['filename']. '.' . $item['extension'];?></span>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>

                        </td>
                        <td><?= $item['is_folder'] ? "folder" : $item['extension'] ?></td>
                        <td><?= $item['owner_id'] ?></td>
                        <td><?= formatDate(isset($item['created_at'])? $item['created_at'] :'') ?></td>
                        <td><?= formatDate(isset($item['modified_at'])? $item['modified_at'] :'') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>

    <?php else: ?>
        <span>La carpeta está vacía o no se encontró</span>
    <?php endif; ?>


</div>


<div id="fileModal" class="modal">
    <div class="modal-content">
        <div class="row">
            <pre id="filename" class="col-11 mt-3"></pre>
            <span id="closeModal" class="close col-1">&times;</span>
        </div>
        <hr>
        <div class="modal-body">
            <pre id="fileContent"></pre>
        </div>
    </div>
</div>



<!-- Formulario modal para ingresar el nombre del nuevo archivo -->
<div class="modal fade" id="newItemModal" tabindex="-1" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newItemModalLabel">Crear nuevo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>    
            </div>
            <div class="modal-body">
                <form id="createForm" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="newItemType" id="newItemType">
                        <input type="hidden" name="folderPath" id="folderPath" value="<?=$folderPath?>">
                        <div class="form-group">
                            <label for="newItemName">Nombre</label>
                            <input type="text" class="form-control" id="newItemName" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function createNewItem(type) {
    document.getElementById("newItemType").value = type;
    $('#newItemModal').modal('show');
    $('#newItemModal').modal({ backdrop: false });
    $('.modal-backdrop').remove();
}
</script>



<script>
    document.querySelectorAll('.file-link').forEach(fileLink => {
        fileLink.addEventListener('click', function(event) {
            event.preventDefault();
            const filePath = this.getAttribute('data-filepath');

            fetch(`api/ctrl/get_file_content.php?path=${filePath}`)
                .then(response => response.text())
                .then(content => {
                    document.getElementById('filename').innerText = filePath;
                    document.getElementById('fileContent').innerText = content;
                    document.getElementById('fileModal').style.display = 'block';
                })
                .catch(error => console.error('Error loading file content:', error));
        });
    });

    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('fileModal').style.display = 'none';
    });

</script>


