<?php
class CategoriasArchivosModel extends Mysql
{
    private $intIdCategoria;
    private $strNombre;
    private $strDescripcion;
    private $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectCategorias()
    {
        $sql = "SELECT * FROM categorias_archivos ORDER BY id_categoria DESC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectCategoria(int $idcategoria)
    {
        $this->intIdCategoria = $idcategoria;
        $sql = "SELECT * FROM categorias_archivos WHERE id_categoria = $this->intIdCategoria";
        $request = $this->select($sql);
        return $request;
    }

    public function insertCategoria(string $nombre, string $descripcion, int $status)
    {
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;

        $query_insert = "INSERT INTO categorias_archivos(nombre, descripcion, status) VALUES(?,?,?)";
        $arrData = array(
            $this->strNombre,
            $this->strDescripcion,
            $this->intStatus
        );
        
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function updateCategoria(int $idcategoria, string $nombre, string $descripcion, int $status)
    {
        $this->intIdCategoria = $idcategoria;
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;

        $sql = "SELECT * FROM categorias_archivos WHERE nombre = '$this->strNombre' AND id_categoria != $this->intIdCategoria";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE categorias_archivos SET nombre = ?, descripcion = ?, status = ? WHERE id_categoria = $this->intIdCategoria";
            $arrData = array(
                $this->strNombre,
                $this->strDescripcion,
                $this->intStatus
            );
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteCategoria(int $idcategoria)
    {
        $this->intIdCategoria = $idcategoria;
        
        // Verificar si hay archivos asociados a esta categoría
        $sql = "SELECT COUNT(*) as total FROM archivos WHERE id_categoria = $this->intIdCategoria";
        $request = $this->select($sql);
        
        if ($request['total'] > 0) {
            return "exist";
        } else {
            $sql = "DELETE FROM categorias_archivos WHERE id_categoria = $this->intIdCategoria";
            $request = $this->delete($sql);
            if ($request) {
                return "ok";
            } else {
                return "error";
            }
        }
    }
}
?>