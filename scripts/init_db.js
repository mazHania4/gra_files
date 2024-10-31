// Conexión a la base de datos
let db = connect("mongodb://localhost:27017/gra_files_storage");
db.dropDatabase() 
db = connect("mongodb://localhost:27017/gra_files_storage");

// 1. Inicializando la colección 'users' con datos de prueba
const users = [
    {
        _id: "admin",
        password: "8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918", // = admin
        email: "admin@empresa.com",
        role: "admin"
    },
    {
        _id: "empleado1",
        password: "650e9595236154547665929c8ff6c06a4e1f89bb63797649b3cfc5337d075be8", // = muffins
        email: "empleado1@empresa.com",
        role: "empl"
    },
    {
        _id: "empleado2",
        password: "cea70552116071b4ea769c41150f7f76c0e7673bfd6dc62453d507e41af9b529", // = tomate
        email: "empleado2@empresa.com",
        role: "empl"
    }
];

users.forEach(user => {
    db.users.insertOne(user);

    // Crear carpetas 'root' y 'shared' por usuario
    db.files.insertOne({
        filename: "root",
        _id: `/${user._id}/root`,
        created_at: new Date(),
        modified_at: new Date(),
        owner_id: user._id,
        is_folder: true,
        is_deleted: false,
        is_shared: false
    }).insertedId;

    db.files.insertOne({
        filename: "shared",
        _id: `/${user._id}/shared`,
        created_at: new Date(),
        modified_at: new Date(),
        owner_id: user._id,
        is_folder: true,
        is_deleted: false,
        is_shared: true
    }).insertedId;

});

// 2. Inicializando la colección 'files' con archivos y carpetas
const files = [
    {
        filename: "hello_world",
        _id: "/admin/root/hello_world.txt",
        created_at: new Date(),
        modified_at: new Date(),
        extension: "txt",
        owner_id: "admin",
        folder_id: "/admin/root",
        is_folder: false,
        is_deleted: false,
        is_shared: false
    },
    {
        filename: "documento1",
        _id: "/empleado1/root/documento1.txt",
        created_at: new Date(),
        modified_at: new Date(),
        extension: "txt",
        owner_id: "empleado1",
        folder_id: "/empleado1/root",
        is_folder: false,
        is_deleted: false,
        is_shared: false
    },
    {
        filename: "documento2",
        _id: "/empleado1/root/documento2.txt",
        created_at: new Date(),
        modified_at: new Date(),
        extension: "txt",
        owner_id: "empleado1",
        folder_id: "/empleado1/root",
        is_folder: false,
        is_deleted: false,
        is_shared: false
    },
    {
        filename: "proyecto",
        _id: "/empleado2/root/proyecto",
        created_at: new Date(),
        modified_at: new Date(),
        owner_id: "empleado2",
        folder_id: "/empleado2/root",
        is_folder: true,
        is_deleted: false,
        is_shared: false
    },
    {
        filename: "enunciado",
        _id: "/empleado2/root/proyecto/enunciado.txt",
        created_at: new Date(),
        modified_at: new Date(),
        extension: "txt",
        owner_id: "empleado2",
        folder_id: "/empleado2/root/proyecto",
        is_folder: false,
        is_deleted: false,
        is_shared: false
    },
    //Archivo compartido
    {
        filename: "documento1",
        _id: "/empleado2/shared/documento1.txt",
        created_at: new Date(),
        modified_at: new Date(),
        shared_at: new Date(),
        extension: "txt",
        owner_id: "empleado1",
        folder_id: "/empleado2/shared",
        shared_with_id: "empleado2",
        is_folder: false,
        is_deleted: false,
        is_shared: true
    }
];

// Inserta archivos y actualiza la carpeta contenedora
files.forEach(file => {
    db.files.insertOne(file);
});

print("Base de datos inicializada con usuarios, archivos y compartidos.");
