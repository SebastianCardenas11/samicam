<?php
class CompetenciasModel extends Mysql
{
    private $intIdeCompetencia;
    private $strCodigoCompetencia;
    private $strNombreCompetencia;
    private $strHorasCompetencia;
    private $strCodigoPrograma;
    private $strStatus;
    

    public function __construct()
    {
        parent::__construct();
    }

        // TODO CONSULTA DE LOS PROGRAMAS DE FORMACIÓN
        public function selectProgramas()
        {
            // ORIGINAL DE CONSULTA DE PROGRAMAS
            $sql = "SELECT * FROM tbl_fichas
            WHERE status != 0 ORDER BY numeroficha ASC";

// $sql = "SELECT ,tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status,tc.idecompetencia,tc.codigocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.programaide,tc.status

// FROM tbl_programas tp
// INNER JOIN tbl_competencias  tc
// ON tc.programaide = tp.codigoprograma
// WHERE status != 0 ORDER BY tp.nombreprograma ASC";

            $request = $this->select_all($sql);
            return $request;
        }

        public function selectProgramasEditar($codigoprograma)
        {
            // ORIGINAL DE CONSULTA DE PROGRAMAS
        // OK
        // $sql = "SELECT * FROM tbl_programas
        //     WHERE status != 0 ORDER BY nombreprograma ASC";

        $sql = "SELECT * FROM tbl_programas as m, tbl_competencias as d
        WHERE m.codigoprograma = d.programacodigo ";

        // $this->intIdeCompetencia = $codigoprograma;

        // $sql = "SELECT ,tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status,tc.idecompetencia,tc.codigocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.programaide,tc.status

        // -- FROM tbl_programas tp
        // -- INNER JOIN tbl_competencias  tc
        // -- ON tc.programaide = tp.codigoprograma
        // -- WHERE tp.codigoprograma = $this->intIdeCompetencia ";
        // WHERE status != 0 ORDER BY tp.nombreprograma ASC";

        $request = $this->select_all($sql);
        return $request;
        // /OK

            // $request = $this->select_all($sql);
            // return $request;
        }



    public function insertCompetencia(
        int $codigocompetencia,
        string $tipocompetencia,
        string $nombrecompetencia,
        int $horascompetencia,
        int $programaide
    ) {
        $this->intCodigoCompetencia = $codigocompetencia;
        $this->strTipoCompetencia = $tipocompetencia;
        $this->strNombreCompetencia = $nombrecompetencia;
        $this->intHorasCompetencia = $horascompetencia;
        $this->intProgramaIde = $programaide;

        $return = 0;

        $sql = "SELECT tc.idecompetencia,tc.codigocompetencia,tc.tipocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.fichaide,tc.status,

        tf.ideficha,tf.numeroficha,tf.usuarioide,tf.programaide,tf.status,
       
       tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status

       FROM tbl_competencias tc
       INNER JOIN tbl_fichas tf 
       ON tf.ideficha = tc.fichaide 
       INNER JOIN tbl_programas  tp
       ON tp.ideprograma = tf.ideficha
        WHERE tc.codigocompetencia = $this->intCodigoCompetencia AND tp.status != 0";

        $request = $this->select_all($sql);


        if (empty($request)) {
            $query_insert = "INSERT INTO tbl_competencias(codigocompetencia,tipocompetencia,nombrecompetencia,horascompetencia,fichaide)
            VALUES(?,?,?,?,?)";
            $arrData = array(
                $this->intCodigoCompetencia,
                $this->strTipoCompetencia,
                $this->strNombreCompetencia,
                $this->intHorasCompetencia,
                $this->intProgramaIde
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
            } else {
                $return = "exist";
            }
            return $return;
            }

            //TODO LISTADO DE LA TABLA
            public function selectCompetencias()
            {
                $sql = "SELECT tc.idecompetencia,tc.codigocompetencia,tc.tipocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.fichaide,tc.status,

                 tf.ideficha,tf.numeroficha,tf.usuarioide,tf.programaide,tf.status,
                
                tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status,

                tdtc.idetemporal,tdtc.avancehorascompetencia,tdtc.competenciaide,tdtc.fichaide,tdtc.status

                FROM tbl_competencias tc
                INNER JOIN tbl_fichas tf 
                ON tf.ideficha = tc.fichaide 
                INNER JOIN tbl_programas  tp
                ON tp.ideprograma = tf.ideficha
                INNER JOIN tbl_detalle_temp_competencias  tdtc
                ON tdtc.competenciaide = tc.idecompetencia 
                WHERE tc.status != 0";

                $request = $this->select_all($sql);
                return $request;
            }

        //VISTA INFORMACIÓN PROGRAMA
        public function selectPrograma(int $codprograma)
        {
            $this->intCodPrograma = $codprograma;
            $sql = "SELECT *
                    FROM tbl_fichas
                    WHERE numeroficha = $this->intCodPrograma";
            $request = $this->select($sql);
            return $request;
        }

    

    //VISTA INFORMACIÓN COMPETENCIA
    public function selectCompetencia(int $idecompetencia)
    {
        $this->intIdeCompetencia = $idecompetencia;

        $sql = "SELECT tc.idecompetencia,tc.codigocompetencia,tc.tipocompetencia,tc.nombrecompetencia,tc.horascompetencia,tc.fichaide,tc.status,

        tf.ideficha,tf.numeroficha,tf.usuarioide,tf.programaide,tf.status,
       
       tp.ideprograma,tp.codigoprograma,tp.nivelprograma,tp.nombreprograma,tp.horasprograma,tp.status

       FROM tbl_competencias tc
       INNER JOIN tbl_fichas tf 
       ON tf.ideficha = tc.fichaide 
       INNER JOIN tbl_programas  tp
       ON tp.ideprograma = tf.ideficha
        WHERE tc.idecompetencia = $this->intIdeCompetencia ";

        $request = $this->select($sql);
        return $request;
    }


    //ACTUALIZAR Competencia
    public function updateCompetencia(
        int $ideCompetencia,
        int $codigocompetencia,
        string $tipocompetencia,
        string $nombrecompetencia,
        int $horascompetencia,
        int $programaide
    ) {

        $this->intIdeCompetencia = $ideCompetencia;
        $this->intCodigoCompetencia = $codigocompetencia;
        $this->strTipoCompetencia = $tipocompetencia;
        $this->strNombreCompetencia = $nombrecompetencia;
        $this->intHorasCompetencia = $horascompetencia;
        $this->intProgramaIde = $programaide;

        $sql = "SELECT * FROM tbl_competencias WHERE (codigocompetencia = '{$this->intCodigoCompetencia}')";
        $request = $this->select_all($sql);

        if (!empty($request)) {
            if (($this->intCodigoCompetencia != "")) {

                $sql = "UPDATE tbl_competencias SET codigocompetencia=?, tipocompetencia=?, nombrecompetencia=?, horascompetencia=?, fichaide=?
						WHERE idecompetencia = $this->intIdeCompetencia";

                $arrData = array(
                    $this->intCodigoCompetencia,
                    $this->strTipoCompetencia,
                    $this->strNombreCompetencia,
                    $this->intHorasCompetencia,
                    $this->intProgramaIde
                );
            } 
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteCompetencia(int $intIdeCompetencia)
    {
        $this->intIdeCompetencia = $intIdeCompetencia;
        $sql = "UPDATE tbl_competencias SET status = ? WHERE idecompetencia = $this->intIdeCompetencia ";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }


}