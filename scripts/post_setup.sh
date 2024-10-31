#!/bin/bash

echo "Esperando a que el contenedor de MongoDB esté listo..."
sleep 5

# Inicializa la base de datos ejecutando el script init_db.js en el contenedor de MongoDB
echo "Inicializando la base de datos..."
docker exec -i gra_files-mongo-1 mongosh scripts/init_db.js
echo "Inicialización de la base de datos completada."

# Ruta de almacenamiento de los archivos
STORAGE_DIR="gra_files_storage"

sudo mkdir -p $STORAGE_DIR
sudo chmod -R 777 $STORAGE_DIR

# Crear la estructura de carpetas de almacenamiento
echo "Creando estructura de carpetas de almacenamiento..."
mkdir -p "$STORAGE_DIR/admin/root"
mkdir -p "$STORAGE_DIR/admin/shared"
mkdir -p "$STORAGE_DIR/empleado1/root/"
mkdir -p "$STORAGE_DIR/empleado1/shared"
mkdir -p "$STORAGE_DIR/empleado2/root/proyecto"
mkdir -p "$STORAGE_DIR/empleado2/shared"

# Crear archivos de prueba en el sistema de archivos
echo "Creando archivos de prueba..."
echo "Hola Mundo" > "$STORAGE_DIR/admin/root/hello_world.txt"
echo "Contenido de prueba para documento1.txt" > "$STORAGE_DIR/empleado1/root/documento1.txt"
echo "Contenido de prueba para documento2.txt" > "$STORAGE_DIR/empleado1/root/documento2.txt"
echo "Enunciado del proyeccto" > "$STORAGE_DIR/empleado2/root/proyecto/enunciado.txt"
echo "Contenido compartido de prueba para documento1.txt" > "$STORAGE_DIR/empleado2/shared/documento1.txt"

echo "Inicialización del almacenamiento de archivos completada."
