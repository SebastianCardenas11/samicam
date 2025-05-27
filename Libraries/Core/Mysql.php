<?php

class Mysql extends Conexion
{
    private $conexion;
    private $strquery;
    private $arrValues;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->conect();
    }

    //Insertar un registro
    public function insert(string $query, array $arrValues)
    {
        try {
            $this->strquery = $query;
            $this->arrValues = $arrValues;
            
            // Debug - Guardar la consulta y los valores en un archivo de log
            $logFile = 'debug_insert.log';
            $logData = date('Y-m-d H:i:s') . " - Query: " . $this->strquery . "\n";
            $logData .= "Values: " . print_r($this->arrValues, true) . "\n\n";
            file_put_contents($logFile, $logData, FILE_APPEND);
            
            $insert = $this->conexion->prepare($this->strquery);
            $resInsert = $insert->execute($this->arrValues);
            
            if ($resInsert) {
                $lastInsert = $this->conexion->lastInsertId();
                file_put_contents($logFile, "Success! Last Insert ID: " . $lastInsert . "\n\n", FILE_APPEND);
                return $lastInsert;
            } else {
                $errorInfo = $insert->errorInfo();
                file_put_contents($logFile, "Error: " . print_r($errorInfo, true) . "\n\n", FILE_APPEND);
                return 0;
            }
        } catch (PDOException $e) {
            error_log("Error en insert: " . $e->getMessage());
            file_put_contents('debug_insert_error.log', date('Y-m-d H:i:s') . " - Error: " . $e->getMessage() . "\n\n", FILE_APPEND);
            return 0;
        }
    }
    
    //Busca un registro
    public function select(string $query, array $arrValues = [])
    {
        $this->strquery = $query;
        $this->arrValues = $arrValues;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute($this->arrValues);
        $data = $result->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    
    //Devuelve todos los registros
    public function select_all(string $query, array $arrValues = [])
    {
        $this->strquery = $query;
        $this->arrValues = $arrValues;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute($this->arrValues);
        $data = $result->fetchall(PDO::FETCH_ASSOC);
        return $data;
    }
    
    //Actualiza registros
    public function update(string $query, array $arrValues)
    {
        try {
            $this->strquery = $query;
            $this->arrValues = $arrValues;
            
            // Debug - Guardar la consulta y los valores en un archivo de log
            $logFile = 'debug_update.log';
            $logData = date('Y-m-d H:i:s') . " - Query: " . $this->strquery . "\n";
            $logData .= "Values: " . print_r($this->arrValues, true) . "\n\n";
            file_put_contents($logFile, $logData, FILE_APPEND);
            
            $update = $this->conexion->prepare($this->strquery);
            $resExecute = $update->execute($this->arrValues);
            
            if ($resExecute) {
                file_put_contents($logFile, "Success! Rows affected: " . $update->rowCount() . "\n\n", FILE_APPEND);
                return $resExecute;
            } else {
                $errorInfo = $update->errorInfo();
                file_put_contents($logFile, "Error: " . print_r($errorInfo, true) . "\n\n", FILE_APPEND);
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error en update: " . $e->getMessage());
            file_put_contents('debug_update_error.log', date('Y-m-d H:i:s') . " - Error: " . $e->getMessage() . "\n\n", FILE_APPEND);
            return false;
        }
    }
    
    //Eliminar un registros
    public function delete(string $query, array $arrValues = [])
    {
        $this->strquery = $query;
        $this->arrValues = $arrValues;
        $result = $this->conexion->prepare($this->strquery);
        $del = $result->execute($this->arrValues);
        return $del;
    }
}