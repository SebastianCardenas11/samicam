<?php
class ArchivosModel extends Mysql
{
    private $intIdArchivo;
    private $strNombre;
    private $strDescripcion;
    private $strArchivo;
    private $strExtension;
    private $strFecha;
    private $intCategoria;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectArchivos()
    {
        $sql = "SELECT a.id, a.id_categoria, a.nombre, a.descripcion, a.archivo, a.extension, 
                DATE_FORMAT(a.fecha_creacion, '%d/%m/%Y %h:%i %p') as fecha_creacion 
                FROM archivos a 
                WHERE a.status = 1
                ORDER BY a.id DESC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectArchivo(int $idarchivo)
    {
        $this->intIdArchivo = $idarchivo;
        $sql = "SELECT a.id, a.id_categoria, a.nombre, a.descripcion, a.archivo, a.extension, 
                DATE_FORMAT(a.fecha_creacion, '%d/%m/%Y %h:%i %p') as fecha_creacion 
                FROM archivos a 
                WHERE a.id = $this->intIdArchivo AND a.status = 1";
        $request = $this->select($sql);
        return $request;
    }

    public function insertArchivo(string $nombre, string $descripcion, string $archivo, string $extension, $categoria = null)
    {
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->strArchivo = $archivo;
        $this->strExtension = $extension;
        $this->strFecha = date('Y-m-d H:i:s');
        $this->intCategoria = $categoria;

        $query_insert = "INSERT INTO archivos(id_categoria, nombre, descripcion, archivo, extension, fecha_creacion) 
                        VALUES(?,?,?,?,?,?)";
        $arrData = array(
            $this->intCategoria,
            $this->strNombre,
            $this->strDescripcion,
            $this->strArchivo,
            $this->strExtension,
            $this->strFecha
        );
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function updateArchivo(int $idarchivo, string $nombre, string $descripcion, string $archivo, string $extension, $categoria = null)
    {
        $this->intIdArchivo = $idarchivo;
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->strArchivo = $archivo;
        $this->strExtension = $extension;
        $this->intCategoria = $categoria;

        $sql = "UPDATE archivos 
                SET id_categoria = ?, nombre = ?, descripcion = ?, archivo = ?, extension = ? 
                WHERE id = $this->intIdArchivo";
        $arrData = array(
            $this->intCategoria,
            $this->strNombre,
            $this->strDescripcion,
            $this->strArchivo,
            $this->strExtension
        );
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function deleteArchivo(int $idarchivo)
    {
        try {
            $this->intIdArchivo = $idarchivo;
            
            // Primero verificamos si el archivo existe
            $sql_check = "SELECT id FROM archivos WHERE id = ?";
            $exists = $this->select($sql_check, array($this->intIdArchivo));
            
            if(!$exists) {
                throw new Exception("El archivo no existe");
            }
            
            // Realizamos la actualización
            $sql = "UPDATE archivos SET status = 0 WHERE id = ?";
            $request = $this->update($sql, array($this->intIdArchivo));
            
            if($request === false) {
                $error = $this->getError();
                throw new Exception("Error en la actualización: " . $error);
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error en deleteArchivo: " . $e->getMessage());
            throw $e;
        }
    }

    public function searchArchivos(string $busqueda)
    {
        $sql = "SELECT a.id, a.id_categoria, a.nombre, a.descripcion, a.archivo, a.extension, 
                DATE_FORMAT(a.fecha_creacion, '%d/%m/%Y %h:%i %p') as fecha_creacion 
                FROM archivos a 
                LEFT JOIN categorias_archivos c ON a.id_categoria = c.id_categoria
                WHERE a.status = 1 AND (a.nombre LIKE '%$busqueda%' OR a.descripcion LIKE '%$busqueda%' OR c.nombre LIKE '%$busqueda%')
                ORDER BY a.id DESC";
        $request = $this->select_all($sql);
        return $request;
    }
    
    public function getCategoriaNombre(int $idcategoria)
    {
        $sql = "SELECT nombre FROM categorias_archivos WHERE id_categoria = $idcategoria";
        $request = $this->select($sql);
        return $request;
    }
    
    public function selectCategorias()
    {
        $sql = "SELECT * FROM categorias_archivos WHERE status = 1 ORDER BY nombre ASC";
        $request = $this->select_all($sql);
        return $request;
    }
    
    public function getArchivosPorCategoria(int $idcategoria)
    {
        $sql = "SELECT a.id, a.id_categoria, a.nombre, a.descripcion, a.archivo, a.extension, 
                DATE_FORMAT(a.fecha_creacion, '%d/%m/%Y %h:%i %p') as fecha_creacion 
                FROM archivos a 
                WHERE a.id_categoria = $idcategoria AND a.status = 1
                ORDER BY a.id DESC";
        $request = $this->select_all($sql);
        return $request;
    }
}
?>