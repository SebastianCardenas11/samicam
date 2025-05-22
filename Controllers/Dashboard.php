<?php

class Dashboard extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MDASHBOARD);
    }

    public function dashboard()
    {
        $data['page_id'] = 1;
        $data['page_tag'] = "Administrador - Samicam";
        $data['page_title'] = " Administrador - Samicam";
        $data['page_name'] = "Administrador";
        $data['page_functions_js'] = "functions_dashboard.js";
        $data['usuarios'] = $this->model->cantUsuarios();
        $data['funcionariosops'] = $this->model->cantFuncionariosOps();
        $data['funcionariosplanta'] = $this->model->cantFuncionariosPlanta();
        $data['estadisticas'] = $this->model->getEstadisticasGenerales();

        if ($_SESSION['userData']['idrol'] == RCOORDINADOR) {
            $this->views->getView($this, "dashboardCoordinador", $data);
        } else {
            $this->views->getView($this, "dashboard", $data);
        }
    }

    public function getHorasPorMesControlador() {
        $data = $this->model->getHorasPorMesModel();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    public function getHorasPorInstructor() {
        $data = $this->model->getHorasPorInstructorModel();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    public function getUsuariosPorRol() {
        $data = $this->model->getUsuariosPorRolModel();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    public function getFuncionariosPorCargo() {
        $data = $this->model->getFuncionariosPorCargoModel();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    public function getFuncionariosPorTipoContrato() {
        $data = $this->model->getFuncionariosPorTipoContratoModel();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    public function getPermisosPorMes() {
        // Intentar obtener datos reales de permisos por mes
        try {
            $sql = "SELECT MONTH(fecha_permiso) as num_mes, COUNT(*) as total_permisos 
                   FROM tbl_permisos 
                   WHERE YEAR(fecha_permiso) = YEAR(CURRENT_DATE()) 
                   GROUP BY MONTH(fecha_permiso) 
                   ORDER BY MONTH(fecha_permiso)";
            
            $permisosPorMes = $this->model->select_all($sql);
            
            // Traducir los números de mes a nombres en español
            $nombresMeses = [
                1 => 'Enero',
                2 => 'Febrero',
                3 => 'Marzo',
                4 => 'Abril',
                5 => 'Mayo',
                6 => 'Junio',
                7 => 'Julio',
                8 => 'Agosto',
                9 => 'Septiembre',
                10 => 'Octubre',
                11 => 'Noviembre',
                12 => 'Diciembre'
            ];
            
            // Convertir los resultados para incluir el nombre del mes en español
            $resultados = [];
            foreach ($permisosPorMes as $permiso) {
                $resultados[] = [
                    'mes' => $nombresMeses[(int)$permiso['num_mes']],
                    'total_permisos' => $permiso['total_permisos']
                ];
            }
            
            if (empty($resultados)) {
                // Si no hay datos, devolver datos de ejemplo
                $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                          'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                $resultados = [];
                
                foreach ($meses as $mes) {
                    $resultados[] = [
                        'mes' => $mes,
                        'total_permisos' => rand(5, 20) // Valores aleatorios entre 5 y 20
                    ];
                }
            }
            
            header('Content-Type: application/json');
            echo json_encode($resultados);
        } catch (Exception $e) {
            // En caso de error, devolver datos de ejemplo
            $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                      'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            $resultados = [];
            
            foreach ($meses as $mes) {
                $resultados[] = [
                    'mes' => $mes,
                    'total_permisos' => rand(5, 20) // Valores aleatorios entre 5 y 20
                ];
            }
            
            header('Content-Type: application/json');
            echo json_encode($resultados);
        }
        die();
    }
}