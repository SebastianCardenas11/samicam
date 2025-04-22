<?php

class Competencias extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MUSUARIOS);
    }

       // TODO SELECCIONAR PROGRAMAS
       public function getSelectProgramas()
       {
           switch ($_GET['op']) {
               case "combo":
                   $arrData = $this->model->selectProgramas();
                   if (count($arrData) > 0) {
                       $htmlOptions = "<select class='form-control' id='ListadoProgramas' name='ListadoProgramas'>
                       <option >Selecciona el Programa de Formación</option>
                       </select>";
                       foreach ($arrData as $row) {
                           $htmlOptions .= "<option value='" . $row['codigoprograma'] . "'>" . $row['nombreprograma'] . "</option>";
                       }
                       echo $htmlOptions;
                       die();
                   }
                   break;
           }
       }

       public function getSelectProgramasEditar()
       {
        $htmlOptionss = "";
           switch ($_GET['op']) {
               case "combo":
                   $arrData = $this->model->selectProgramasEditar($_POST["codigoprograma"]);
                   if (count($arrData) > 0) {
                       $htmlOptionss = "<select class='form-control' id='ListadoProgramas' name='ListadoProgramas'>
                       <option >Selecciona el Programa de Formación</option>
                       </select>";
                       foreach ($arrData as $row) {
                           $htmlOptionss .= "<option value='" . $row['codigoprograma'] . "'>" . $row['nombreprograma'] . "</option>";
                       }
                    }
                       echo $htmlOptionss;
                       die();
    
                   break;
           }
       }


    public function Competencias()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Competencias";
        $data['page_title'] = "Competencias";
        $data['page_name'] = "competencias";
        $data['page_functions_js'] = "functions_competencias.js";
        $this->views->getView($this, "competencias", $data);
    }

    public function setCompetencia()
    {
        error_reporting(0);
        if ($_POST) {
            if (empty($_POST['txtCodigoCompetencia'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdeCompetencia = intval($_POST['ideCompetencia']);
                $intCodigoCompetencia = strClean($_POST['txtCodigoCompetencia']);
                $strTipoCompetencia = strClean($_POST['txtTipoCompetencia']);
                $strNombreCompetencia = strClean($_POST['txtNombreCompetencia']);
                $intHorasCompetencia = strClean($_POST['txtHorasCompetencia']);
                $intProgramaIde = strClean($_POST['txtIdePrograma']);

                $intTipoId = 5;
                $request_user = "";
                if ($intIdeCompetencia == 0) {
                    $option = 1;
                    if ($_SESSION['permisosMod']['w']) {
                        $request_user = $this->model->insertCompetencia(
                            $intCodigoCompetencia,
                            $strTipoCompetencia,
                            $strNombreCompetencia,
                            $intHorasCompetencia,
                            $intProgramaIde

                        );
                    }
                } else {
                    $option = 2;
                    if ($_SESSION['permisosMod']['u']) {
                        $request_user = $this->model->updateCompetencia(
                            $intIdeCompetencia,
                            $intCodigoCompetencia,
                            $strTipoCompetencia,
                            $strNombreCompetencia,
                            $intHorasCompetencia,
                            $intProgramaIde
                        );
                    }
                }
                if ($request_user > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Competencia guardada correctamente');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Competencia actualizada correctamente');
                    }
                } else if ($request_user == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => 'La competencia ya existe');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getCompetencias()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectCompetencias();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                // if ($arrData[$i]['status'] == 1) {
                //     $arrData[$i]['status'] = '<span class="badge bg-success">Activo</span>';
                // } else {
                //     $arrData[$i]['status'] = '<span class="badge bg-danger">Inactivo</span>';
                // }

                $avancehorascompetencia = ($arrData[$i]['avancehorascompetencia'] * 100) / 100;

                // Si el porcentaje está entre 0 y 49
                if ($avancehorascompetencia >= 0 && $avancehorascompetencia <= 49) {
                    $arrData[$i]['avancehorascompetencia'] = '<div class="progress" role="progressbar" aria-label="Danger example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-danger" style="width: ' . $avancehorascompetencia . '%">' . $avancehorascompetencia . '%</div>
                    </div>';
                }
                else if ($arrData[$i]['avancehorascompetencia'] >= '50' && $arrData[$i]['avancehorascompetencia'] <= '89') {
                    $arrData[$i]['avancehorascompetencia'] = '<div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="1000">
                    <div class="progress-bar bg-warning" style="width: ' . $arrData[$i]['avancehorascompetencia'] . '%">' . $arrData[$i]['avancehorascompetencia'] . '%</div>
                    </div>';
                
                } else if ($arrData[$i]['avancehorascompetencia'] >= '90' && $arrData[$i]['avancehorascompetencia'] <= '100') {
                    $arrData[$i]['avancehorascompetencia'] = '<div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="1000">
                    <div class="progress-bar bg-success" style="width: ' . $arrData[$i]['avancehorascompetencia'] . '%">' . $arrData[$i]['avancehorascompetencia'] . '%</div>
                    </div>';
                }

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $arrData[$i]['idecompetencia'] . ')" title="Ver Competencia"><i class="bi bi-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning" onClick="fntEditInfo(this,' . $arrData[$i]['idecompetencia'] . ')" title="Editar Competencia"><i class="bi bi-pencil"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btnDelRol" onClick="fntDelInfo(' . $arrData[$i]['idecompetencia'] . ')" title="Eliminar Competencia"><i class="bi bi-trash3"></i></button>';
       
                }

                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getCompetencia($idecompetencia)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idecompetencia = intval($idecompetencia);
            $htmlOptions = "";
            if ($idecompetencia > 0) {
                $arrData = $this->model->selectCompetencia($idecompetencia);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                   
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }


        }
        die();
        
    }

    public function getPrograma($codprograma)
    {
        if ($_SESSION['permisosMod']['r']) {
            $codprograma = intval($codprograma);
            $htmlOptions = "";
            if ($codprograma > 0) {
                $arrData = $this->model->selectPrograma($codprograma);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                   
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
        
    }

    public function delCompetencia()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdePrograma = intval($_POST['ideCompetencia']);
                $requestDelete = $this->model->deleteCompetencia($intIdePrograma);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la Competencia');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la Competencia.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }


    }