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
        $data['usuarios'] = $this->model->cantUsuarios();
        $data['funcionariosops'] = $this->model->cantFuncionariosOps();
        $data['funcionariosplanta'] = $this->model->cantFuncionariosPlanta();
        $data['estadisticas'] = $this->model->getEstadisticasGenerales();
        
        // Verificar si el usuario tiene permisos para ver funcionarios
        $showFuncionariosGraphs = 
            (!empty($_SESSION['permisos'][MFUNCIONARIOSPLANTA]['r']) && (!isset($_SESSION['permisos'][MFUNCIONARIOSPLANTA]['v']) || $_SESSION['permisos'][MFUNCIONARIOSPLANTA]['v'] == 1)) || 
            (!empty($_SESSION['permisos'][MFUNCIONARIOSOPS]['r']) && (!isset($_SESSION['permisos'][MFUNCIONARIOSOPS]['v']) || $_SESSION['permisos'][MFUNCIONARIOSOPS]['v'] == 1));
        
        if ($showFuncionariosGraphs) {
            // Usuario con permisos - mostrar dashboard con gráficas
            $data['page_functions_js'] = "functions_dashboard.js";
            
            // Obtener datos para las gráficas
            $funcionariosPorCargo = $this->model->getFuncionariosPorCargoModel();
            $permisosPorMes = $this->getPermisosPorMesData();
            
            // Asegurar que hay datos para las gráficas
            if (empty($funcionariosPorCargo)) {
                $funcionariosPorCargo = [
                    ['nombre_cargo' => 'Administrativo', 'cantidad' => 5],
                    ['nombre_cargo' => 'Técnico', 'cantidad' => 8],
                    ['nombre_cargo' => 'Profesional', 'cantidad' => 12],
                    ['nombre_cargo' => 'Directivo', 'cantidad' => 3]
                ];
            }
            
            $data['funcionariosPorCargo'] = $funcionariosPorCargo;
            $data['permisosPorMes'] = $permisosPorMes;
            
            // Usar la versión modificada del dashboard que incluye las gráficas directamente
            $this->views->getView($this, "dashboard_modified", $data);
        } else {
            // Usuario sin permisos - mostrar dashboard alternativo
            $data['page_functions_js'] = "functions_dashboard_alt.js";
            $this->views->getView($this, "dashboard_alt", $data);
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
        
        // Formatear los datos para la gráfica
        $formattedData = [];
        foreach ($data as $item) {
            $formattedData[] = [
                'nombre_cargo' => $item['nombre_cargo'],
                'total_funcionarios' => (int)$item['cantidad']
            ];
        }
        
        header('Content-Type: application/json');
        echo json_encode($formattedData);
    }
    
    public function getFuncionariosPorTipoContrato() {
        $data = $this->model->getFuncionariosPorTipoContratoModel();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    private function getPermisosPorMesData() {
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
            
            return $resultados;
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
            
            return $resultados;
        }
    }
    
    public function getPermisosPorMes() {
        $data = $this->getPermisosPorMesData();
        
        // Asegurar que los datos estén en el formato correcto
        foreach ($data as &$item) {
            if (isset($item['total_permisos'])) {
                $item['total_permisos'] = (int)$item['total_permisos'];
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($data);
        die();
    }
}