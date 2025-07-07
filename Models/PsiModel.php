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
        $sql = "SELECT * FROM tbl_psi_prestamos WHERE status != 0 ORDER BY fecha DESC";
        return $this->select_all($sql);
    }
    public function selectPrestamo($id)
    {
        $sql = "SELECT * FROM tbl_psi_prestamos WHERE id_prestamo = ? AND status != 0";
        return $this->select($sql, array($id));
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
}
