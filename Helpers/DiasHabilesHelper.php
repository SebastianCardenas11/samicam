<?php

/**
 * Helper para cálculo de días hábiles
 * Incluye funciones para calcular días hábiles excluyendo fines de semana y festivos
 */

class DiasHabilesHelper
{
    private $conexion;
    
    public function __construct()
    {
        require_once "Libraries/Core/Mysql.php";
        $this->conexion = new Mysql();
    }
    
    /**
     * Calcula los días hábiles entre dos fechas
     * @param string $fecha_inicio Fecha de inicio (Y-m-d)
     * @param string $fecha_fin Fecha de fin (Y-m-d)
     * @return int Número de días hábiles
     */
    public function calcularDiasHabiles($fecha_inicio, $fecha_fin)
    {
        $inicio = new DateTime($fecha_inicio);
        $fin = new DateTime($fecha_fin);
        
        if ($inicio > $fin) {
            return 0;
        }
        
        $dias_habiles = 0;
        $fecha_actual = clone $inicio;
        
        // Obtener festivos del año
        $festivos = $this->obtenerFestivos($inicio->format('Y'));
        
        while ($fecha_actual <= $fin) {
            $dia_semana = $fecha_actual->format('N'); // 1=Lunes, 7=Domingo
            $fecha_str = $fecha_actual->format('Y-m-d');
            
            // Verificar si es día hábil (lunes a viernes) y no es festivo
            if ($dia_semana >= 1 && $dia_semana <= 5 && !in_array($fecha_str, $festivos)) {
                $dias_habiles++;
            }
            
            $fecha_actual->add(new DateInterval('P1D'));
        }
        
        return $dias_habiles;
    }
    
    /**
     * Calcula la fecha de vencimiento agregando días hábiles a una fecha
     * @param string $fecha_inicio Fecha de inicio (Y-m-d)
     * @param int $dias_habiles Número de días hábiles a agregar
     * @return string Fecha de vencimiento (Y-m-d)
     */
    public function calcularFechaVencimiento($fecha_inicio, $dias_habiles)
    {
        $fecha = new DateTime($fecha_inicio);
        $dias_agregados = 0;
        
        // Obtener festivos del año
        $festivos = $this->obtenerFestivos($fecha->format('Y'));
        
        while ($dias_agregados < $dias_habiles) {
            $fecha->add(new DateInterval('P1D'));
            $dia_semana = $fecha->format('N');
            $fecha_str = $fecha->format('Y-m-d');
            
            // Si es día hábil y no es festivo, contar
            if ($dia_semana >= 1 && $dia_semana <= 5 && !in_array($fecha_str, $festivos)) {
                $dias_agregados++;
            }
        }
        
        return $fecha->format('Y-m-d');
    }
    
    /**
     * Obtiene los días festivos de un año específico
     * @param int $anio Año a consultar
     * @return array Array de fechas festivas (Y-m-d)
     */
    private function obtenerFestivos($anio)
    {
        $sql = "SELECT fecha FROM tbl_dias_festivos WHERE anio = ? AND status = 1";
        $festivos = $this->conexion->select_all($sql, [$anio]);
        
        return array_column($festivos, 'fecha');
    }
    
    /**
     * Verifica si una fecha es día hábil
     * @param string $fecha Fecha a verificar (Y-m-d)
     * @return bool True si es día hábil, false si no
     */
    public function esDiaHabil($fecha)
    {
        $fecha_obj = new DateTime($fecha);
        $dia_semana = $fecha_obj->format('N');
        
        // Verificar si es fin de semana
        if ($dia_semana > 5) {
            return false;
        }
        
        // Verificar si es festivo
        $festivos = $this->obtenerFestivos($fecha_obj->format('Y'));
        return !in_array($fecha, $festivos);
    }
    
    /**
     * Obtiene el próximo día hábil a partir de una fecha
     * @param string $fecha Fecha de referencia (Y-m-d)
     * @return string Próximo día hábil (Y-m-d)
     */
    public function obtenerProximoDiaHabil($fecha)
    {
        $fecha_obj = new DateTime($fecha);
        $festivos = $this->obtenerFestivos($fecha_obj->format('Y'));
        
        do {
            $fecha_obj->add(new DateInterval('P1D'));
            $dia_semana = $fecha_obj->format('N');
            $fecha_str = $fecha_obj->format('Y-m-d');
        } while ($dia_semana > 5 || in_array($fecha_str, $festivos));
        
        return $fecha_str;
    }
    
    /**
     * Actualiza los días hábiles restantes para todas las peticiones activas
     * @return bool True si se actualizó correctamente
     */
    public function actualizarDiasHabilesRestantes()
    {
        try {
            $fecha_actual = date('Y-m-d');
            
            // Obtener todas las peticiones activas
            $sql = "SELECT id_peticion, fecha_vencimiento FROM tbl_peticiones 
                    WHERE estado IN ('radicada', 'en_proceso')";
            $peticiones = $this->conexion->select_all($sql);
            
            foreach ($peticiones as $peticion) {
                $dias_restantes = $this->calcularDiasHabiles($fecha_actual, $peticion['fecha_vencimiento']);
                
                // Determinar estado del semáforo
                $estado_semaforo = 'verde';
                if ($dias_restantes <= 0) {
                    $estado_semaforo = 'rojo';
                } elseif ($dias_restantes <= 5) {
                    $estado_semaforo = 'rojo';
                } elseif ($dias_restantes <= 10) {
                    $estado_semaforo = 'amarillo';
                }
                
                // Actualizar petición
                $sql_update = "UPDATE tbl_peticiones SET 
                              dias_habiles_restantes = ?, 
                              estado_semaforo = ? 
                              WHERE id_peticion = ?";
                $this->conexion->update($sql_update, [$dias_restantes, $estado_semaforo, $peticion['id_peticion']]);
            }
            
            // Marcar como vencidas las que corresponda
            $sql_vencidas = "UPDATE tbl_peticiones SET estado = 'vencida' 
                            WHERE estado IN ('radicada', 'en_proceso') 
                            AND fecha_vencimiento < ?";
            $this->conexion->update($sql_vencidas, [$fecha_actual]);
            
            return true;
            
        } catch (Exception $e) {
            error_log("Error actualizando días hábiles: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Agrega un nuevo día festivo
     * @param string $fecha Fecha del festivo (Y-m-d)
     * @param string $descripcion Descripción del festivo
     * @param string $tipo Tipo de festivo (nacional, local, religioso)
     * @return bool True si se agregó correctamente
     */
    public function agregarFestivo($fecha, $descripcion, $tipo = 'nacional')
    {
        try {
            $anio = date('Y', strtotime($fecha));
            
            $sql = "INSERT INTO tbl_dias_festivos (fecha, descripcion, tipo, anio) 
                    VALUES (?, ?, ?, ?)";
            $result = $this->conexion->insert($sql, [$fecha, $descripcion, $tipo, $anio]);
            
            return $result > 0;
            
        } catch (Exception $e) {
            error_log("Error agregando festivo: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtiene estadísticas de días hábiles para un rango de fechas
     * @param string $fecha_inicio Fecha de inicio
     * @param string $fecha_fin Fecha de fin
     * @return array Estadísticas de días hábiles
     */
    public function obtenerEstadisticasDiasHabiles($fecha_inicio, $fecha_fin)
    {
        $total_dias = $this->calcularDiasCalendario($fecha_inicio, $fecha_fin);
        $dias_habiles = $this->calcularDiasHabiles($fecha_inicio, $fecha_fin);
        $fines_semana = $this->calcularFinesSemana($fecha_inicio, $fecha_fin);
        $festivos = $this->calcularFestivos($fecha_inicio, $fecha_fin);
        
        return [
            'total_dias' => $total_dias,
            'dias_habiles' => $dias_habiles,
            'fines_semana' => $fines_semana,
            'festivos' => $festivos,
            'porcentaje_habiles' => $total_dias > 0 ? round(($dias_habiles / $total_dias) * 100, 2) : 0
        ];
    }
    
    /**
     * Calcula el total de días calendario entre dos fechas
     */
    private function calcularDiasCalendario($fecha_inicio, $fecha_fin)
    {
        $inicio = new DateTime($fecha_inicio);
        $fin = new DateTime($fecha_fin);
        $diferencia = $inicio->diff($fin);
        return $diferencia->days + 1;
    }
    
    /**
     * Calcula los fines de semana entre dos fechas
     */
    private function calcularFinesSemana($fecha_inicio, $fecha_fin)
    {
        $inicio = new DateTime($fecha_inicio);
        $fin = new DateTime($fecha_fin);
        $fines_semana = 0;
        $fecha_actual = clone $inicio;
        
        while ($fecha_actual <= $fin) {
            $dia_semana = $fecha_actual->format('N');
            if ($dia_semana > 5) {
                $fines_semana++;
            }
            $fecha_actual->add(new DateInterval('P1D'));
        }
        
        return $fines_semana;
    }
    
    /**
     * Calcula los días festivos entre dos fechas
     */
    private function calcularFestivos($fecha_inicio, $fecha_fin)
    {
        $inicio = new DateTime($fecha_inicio);
        $fin = new DateTime($fecha_fin);
        $festivos_count = 0;
        
        // Obtener festivos de los años involucrados
        $anio_inicio = $inicio->format('Y');
        $anio_fin = $fin->format('Y');
        
        for ($anio = $anio_inicio; $anio <= $anio_fin; $anio++) {
            $festivos = $this->obtenerFestivos($anio);
            
            foreach ($festivos as $festivo) {
                $fecha_festivo = new DateTime($festivo);
                if ($fecha_festivo >= $inicio && $fecha_festivo <= $fin) {
                    $festivos_count++;
                }
            }
        }
        
        return $festivos_count;
    }
}

/**
 * Función global para calcular días hábiles
 * @param string $fecha_inicio
 * @param string $fecha_fin
 * @return int
 */
function calcularDiasHabiles($fecha_inicio, $fecha_fin)
{
    $helper = new DiasHabilesHelper();
    return $helper->calcularDiasHabiles($fecha_inicio, $fecha_fin);
}

/**
 * Función global para calcular fecha de vencimiento
 * @param string $fecha_inicio
 * @param int $dias_habiles
 * @return string
 */
function calcularFechaVencimiento($fecha_inicio, $dias_habiles)
{
    $helper = new DiasHabilesHelper();
    return $helper->calcularFechaVencimiento($fecha_inicio, $dias_habiles);
}
?>