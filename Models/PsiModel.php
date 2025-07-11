<?php
class PsiModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    // ==================== PRÉSTAMOS ====================
    public function selectPrestamos()
    {
        $sql = "SELECT * FROM tbl_prestamos WHERE status != 0 ORDER BY fecha_prestamo DESC";
        return $this->select_all($sql);
    }
    public function selectPrestamo($id)
    {
        $sql = "SELECT * FROM tbl_prestamos WHERE id_prestamos = ? AND status != 0";
        return $this->select($sql, array($id));
    }
    public function insertPrestamo($data)
    {
        $sql = "INSERT INTO tbl_prestamos (dependencia, funcionario_responsable, cargo_funcionario, fecha_prestamo, fecha_devolucion, item, dispositivo, marca_modelo, activo, serial, estado, mac, observaciones, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $arrData = [
            $data['dependencia'], $data['funcionario_responsable'], $data['cargo_funcionario'],
            $data['fecha_prestamo'], $data['fecha_devolucion'], $data['item'], $data['dispositivo'],
            $data['marca_modelo'], $data['activo'], $data['serial'], $data['estado'], $data['mac'],
            $data['observaciones'], 1
        ];
        return $this->insert($sql, $arrData);
    }
    public function updatePrestamo($id, $data)
    {
        $sql = "UPDATE tbl_prestamos SET dependencia=?, funcionario_responsable=?, cargo_funcionario=?, fecha_prestamo=?, fecha_devolucion=?, item=?, dispositivo=?, marca_modelo=?, activo=?, serial=?, estado=?, mac=?, observaciones=? WHERE id_prestamos=?";
        $arrData = [
            $data['dependencia'], $data['funcionario_responsable'], $data['cargo_funcionario'],
            $data['fecha_prestamo'], $data['fecha_devolucion'], $data['item'], $data['dispositivo'],
            $data['marca_modelo'], $data['activo'], $data['serial'], $data['estado'], $data['mac'],
            $data['observaciones'], $id
        ];
        return $this->update($sql, $arrData);
    }
    public function deletePrestamo($id)
    {
        $sql = "UPDATE tbl_prestamos SET status = 0 WHERE id_prestamos = ?";
        return $this->update($sql, [$id]);
    }
    // Métodos insert/update/delete aquí...

    // ==================== SALIDAS ====================
    public function selectSalidas()
    {
        $sql = "SELECT * FROM tbl_psi_salidas WHERE status != 0 ORDER BY fecha DESC";
        return $this->select_all($sql);
    }
    public function selectSalida($id)
    {
        $sql = "SELECT * FROM tbl_psi_salidas WHERE id_salida = ? AND status != 0";
        return $this->select($sql, array($id));
    }
    // Métodos insert/update/delete aquí...

    // ==================== INGRESOS ====================
    public function selectIngresos()
    {
        $sql = "SELECT * FROM tbl_psi_ingresos WHERE status != 0 ORDER BY fecha DESC";
        return $this->select_all($sql);
    }
    public function selectIngreso($id)
    {
        $sql = "SELECT * FROM tbl_psi_ingresos WHERE id_ingreso = ? AND status != 0";
        return $this->select($sql, array($id));
    }
    // Métodos insert/update/delete aquí...

    public function getFuncionariosPlanta() {
        $sql = "SELECT fp.idefuncionario AS id, fp.nombre_completo, d.nombre AS dependencia, c.nombre AS cargo FROM tbl_funcionarios_planta fp LEFT JOIN tbl_dependencia d ON fp.dependencia_fk = d.dependencia_pk LEFT JOIN tbl_cargos c ON fp.cargo_fk = c.idecargos WHERE fp.status = 1 ORDER BY fp.nombre_completo";
        return $this->select_all($sql);
    }
    public function getFuncionariosOps() {
        $sql = "SELECT fo.nombre_contratista AS nombre_completo, d.nombre AS dependencia, fo.clase_contrato AS cargo FROM tbl_funcionarios_ops fo LEFT JOIN tbl_dependencia d ON fo.unidad_ejecucion = CAST(d.dependencia_pk AS CHAR) WHERE fo.status = 1 ORDER BY fo.nombre_contratista";
        return $this->select_all($sql);
    }
}
