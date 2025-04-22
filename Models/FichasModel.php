<?php
class FichasModel extends Mysql
{
    private $intIdeFicha;
    private $intNumeroFicha;
    private $intUsuarioIde;
    private $intProgramaIde;
    private $strStatus;



    public function __construct()
    {
        parent::__construct();
    }



    public function insertFicha(
        string $numeroficha,
        string $usuarioide,
        string $programaide
    ) {
        $this->intNumeroFicha = $numeroficha;
        $this->intUsuarioIde = $usuarioide;
        $this->intProgramaIde = $programaide;

        $return = 0;

        // $sql = "SELECT * FROM tbl_fichas WHERE numeroficha = $this->strNumeroFicha ";
        // TODO PENDIENTE REVISION IDEUSUARIO FORANEA
        $sql = "SELECT tf.ideficha,tf.numeroficha,tf.usuarioide,tf.programaide,tf.status,tu.ideusuario,tu.identificacion,tu.nombres,tu.password,tu.imgperfil,tu.rolid,tu.status,tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status
        FROM tbl_fichas tf
        INNER JOIN tbl_usuarios  tu
        ON tu.ideusuario = tf.usuarioide
        INNER JOIN tbl_programas  tp
        ON tp.ideprograma = tf.programaide
        WHERE tf.numeroficha = '{$this->intNumeroFicha}' AND tp.status != 0";

        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO tbl_fichas(numeroficha,usuarioide,programaide)
            VALUES(?,?,?)";
            $arrData = array(
                $this->intNumeroFicha,
                $this->intUsuarioIde,
                $this->intProgramaIde
            );
            $request_insert = $this->insert($query_insert,$arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    // TODO LISTADO DE LA TABLA
    public function selectFichas()
    {
        $sql = "SELECT tf.ideficha,tf.numeroficha,tf.usuarioide,tf.programaide,tf.status,tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status,tu.ideusuario,tu.identificacion,tu.nombres,tu.password,tu.imgperfil,tu.rolid,tu.status
        FROM tbl_fichas tf
        INNER JOIN tbl_programas  tp
        ON tp.ideprograma = tf.programaide
        INNER JOIN tbl_usuarios tu
        ON tu.ideusuario = tf.usuarioide
        WHERE tf.status != 0";
        $request = $this->select_all($sql);
        return $request;
    }

    //VISTA INFORMACIÓN PROGRAMA
    public function selectFicha(int $ideficha)
    {
        $this->intIdeFicha = $ideficha;

        $sql = "SELECT tf.ideficha,tf.numeroficha,tf.usuarioide,tf.programaide,tf.status,tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status,tu.ideusuario,tu.identificacion,tu.nombres,tu.password,tu.imgperfil,tu.rolid,tu.status
        FROM tbl_fichas tf
        INNER JOIN tbl_programas  tp
        ON tp.ideprograma = tf.programaide
        INNER JOIN tbl_usuarios tu
        ON tu.ideusuario = tf.usuarioide
        WHERE tf.ideficha = $this->intIdeFicha ";

        $request = $this->select($sql);
        return $request;
    }


    //ACTUALIZAR FICHA
    public function updateFicha(
        int $ideficha,
        int $numeroficha,
        int $usuarioide,
        int $programaide
    ) {

        $this->intIdeFicha = $ideficha;
        $this->intNumeroFicha = $numeroficha;
        $this->intUsuarioIde = $usuarioide;
        $this->intProgramaIde = $programaide;

        $sql = "SELECT * FROM tbl_fichas WHERE (numeroficha = '{$this->intNumeroFicha}')";
        $request = $this->select_all($sql);

        if (empty($request)) {
            if (($this->intNumeroFicha != "") ) {

                $sql = "UPDATE tbl_fichas SET numeroficha=?, usuarioide=?, programaide=?
						WHERE ideficha = $this->intIdeFicha";

                $arrData = array(
                    $this->intNumeroFicha,
                    $this->intUsuarioIde,
                    $this->intProgramaIde
                );
            } 
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteFicha(int $intIdeFicha)
    {
        $this->intIdeFicha = $intIdeFicha;
        $sql = "UPDATE tbl_fichas SET status = ? WHERE ideficha = $this->intIdeFicha ";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }

            //VISTA INFORMACIÓN PROGRAMA
            public function selectPrograma(int $codprograma)
            {
                $this->intCodPrograma = $codprograma;
                $sql = "SELECT *
                        FROM tbl_programas
                        WHERE codigoprograma = $this->intCodPrograma";
                $request = $this->select($sql);
                return $request;
            }

                    //VISTA INFORMACIÓN PROGRAMA
        public function selectInstructor(int $identificacion)
        {
            $this->intIdentificacion = $identificacion;
            $sql = "SELECT *
                    FROM tbl_usuarios
                    WHERE identificacion = $this->intIdentificacion AND rolid = 3";
            $request = $this->select($sql);
            return $request;
        }


}