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
                WHERE a.id = $this->intIdArchivo";
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
        $this->intIdArchivo = $idarchivo;
        
        // Primero obtenemos el nombre del archivo para eliminarlo físicamente
        $sql = "SELECT archivo FROM archivos WHERE id = $this->intIdArchivo";
        $request = $this->select($sql);
        
        if (!empty($request)) {
            $archivo = $request['archivo'];
            $ruta_archivo = 'uploads/archivos/' . $archivo;
            
            if (file_exists($ruta_archivo)) {
                unlink($ruta_archivo);
            }
            
            $sql = "DELETE FROM archivos WHERE id = $this->intIdArchivo";
            $request = $this->delete($sql);
            return $request;
        } else {
            return false;
        }
    }

    public function searchArchivos(string $busqueda)
    {
        $sql = "SELECT a.id, a.id_categoria, a.nombre, a.descripcion, a.archivo, a.extension, 
                DATE_FORMAT(a.fecha_creacion, '%d/%m/%Y %h:%i %p') as fecha_creacion 
                FROM archivos a 
                LEFT JOIN categorias_archivos c ON a.id_categoria = c.id_categoria
                WHERE a.nombre LIKE '%$busqueda%' OR a.descripcion LIKE '%$busqueda%' OR c.nombre LIKE '%$busqueda%'
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
                WHERE a.id_categoria = $idcategoria
                ORDER BY a.id DESC";
        $request = $this->select_all($sql);
        return $request;
    }
}
?>