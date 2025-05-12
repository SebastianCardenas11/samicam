<?php
class CargosModel extends Mysql
{
    private $intIdeCargos;
    private $strNombresCargos;
    private $strNivel;
    private $intSalario;
    private $intEstatus;

    public function __construct()
    {
        parent::__construct();
    }

    public function insertCargos(
        string $nombre,
        string $nivel,
        string $salario,
        string $status,
       
    ) {
        $this->strNombresCargos = $nombre;
        $this->strNivel = $nivel;
        $this->intSalario = $salario;
        $this->intEstatus = $status;
       
       
        $return = 0;
        $sql = "SELECT * FROM tbl_cargos WHERE
				nombre = '{$this->strNombresCargos}'";
        $request = $this->select_all($sql);

        if (empty($request)) {

            // $rs = 1;
            $query_insert = "INSERT INTO tbl_cargos(nombre,nivel,salario,estatus)
            VALUES(?,?,?,?)";

            $arrData = array(
                $this->strNombresCargos,
                $this->strNivel,
                $this->intSalario,
                $this->intEstatus

            );

            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function selectCargos()
    {
        $whereAdmin = "";
        if ($_SESSION['idUser'] != 1) {
        $whereAdmin = " AND u.idecargos != 1 ";
        }
    
        // Ajustando el SELECT para incluir los nuevos campos
            $sql = "SELECT u.idecargos, u.nombre, u.nivel, u.salario, u.estatus
            FROM tbl_cargos u
            WHERE u.estatus != 0 " . $whereAdmin;

        // Ejecutar la consulta y obtener el resultado
        $request = $this->select_all($sql);
        return $request;
    }


    // Seleccionar un usuario específico (con nuevos campos)
    public function selectCargo(int $idecargos)
    {
        $this->intIdeCargos = $idecargos;
        $sql = "SELECT u.idecargos, u.nombre, u.nivel, u.salario, u.estatus
                FROM tbl_cargos u
                WHERE u.idecargos = $this->intIdeCargos";
        $request = $this->select($sql);
        return $request;
    }
    //ACTUALIZAR CARGO
    public function updateCargos(
        int $idecargos,
        string $nombre,
        string $nivel,
        string $salario,
        string $estatus
    ) {

        $this->intIdeCargos = $idecargos;
        $this->strNombresCargos = $nombre;
        $this->strNivel = $nivel;
        $this->intSalario = $salario;
        $this->intEstatus = $estatus;

        $sql = "SELECT * FROM tbl_cargos WHERE (nombre = '{$this->strNombresCargos}' AND idecargos != $this->intIdeCargos)";
        $request = $this->select_all($sql);

        if (empty($request)) {
            // TODO PENDIENTE LA VALIDACIÓN SI EL CODIGO ES IGUAL QUE EL CODIGO DE OTRO USUARIO
            if ($this->strNombresCargos != "" ) {

                $sql = "UPDATE tbl_cargos SET nombre=?, nivel=?, salario=?, estatus=?
						WHERE idecargos = $this->intIdeCargos ";

                $arrData = array(
                    $this->strNombresCargos,
                    $this->strNivel,
                    $this->intSalario,
                    $this->intEstatus
                );
                $request = $this->update($sql, $arrData);
            } else {
                $request = false;
            }
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteCargos(int $intIdeCargos)
    {
        $this->intIdeCargos = $intIdeCargos;
        $sql = "UPDATE tbl_cargos SET estatus = ? WHERE idecargos = $this->intIdeCargos ";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
      }

}