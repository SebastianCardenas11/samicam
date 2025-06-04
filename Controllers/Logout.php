<?php
class Logout
{
    public function __construct()
    {
        session_start();
        
        // Registrar cierre de sesión en auditoría si el usuario estaba logueado
        if (isset($_SESSION['login']) && $_SESSION['login'] === true && isset($_SESSION['userData'])) {
            $this->registrarCierreSesion($_SESSION['userData']);
        }
        
        session_unset();
        session_destroy();
        header('location: ' . base_url() . '/login');
        die();
    }
    
    /**
     * Registra el cierre de sesión en archivos de auditoría
     */
    private function registrarCierreSesion($userData)
    {
        require_once "Models/AuditoriaModel.php";
        $auditoriaModel = new AuditoriaModel();
        
        return $auditoriaModel->registrarAccion([
            'id' => $userData['ideusuario'],
            'usuario' => $userData['nombres'],
            'correo' => $userData['correo'],
            'rol' => $userData['nombrerol'],
            'accion' => 'Cierre de sesión'
        ]);
    }
}