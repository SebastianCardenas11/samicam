<?php

class WhatsAppHelper
{
    private $apiKey;
    private $instanceId;
    private $apiUrl;
    private $config;
    
    public function __construct()
    {
        // Cargar configuración
        require_once "Config/WhatsAppConfig.php";
        $this->config = getWhatsAppConfig();
        
        // Configurar según el proveedor
        $this->setupProvider();
    }
    
    /**
     * Configura el proveedor de WhatsApp según la configuración
     */
    private function setupProvider()
    {
        $provider = $this->config['provider'];
        
        switch ($provider) {
            case 'callmebot':
                $this->apiUrl = $this->config['callmebot']['api_url'];
                $this->apiKey = $this->config['callmebot']['api_key'];
                break;
            case 'whatsapp_business':
                $this->apiUrl = 'https://graph.facebook.com/v17.0/' . $this->config['whatsapp_business']['phone_number_id'] . '/messages';
                $this->apiKey = $this->config['whatsapp_business']['token'];
                break;
            case 'wamr':
                $this->apiUrl = $this->config['wamr']['api_url'];
                $this->apiKey = $this->config['wamr']['api_key'];
                break;
            default:
                $this->apiUrl = $this->config['callmebot']['api_url'];
                $this->apiKey = $this->config['callmebot']['api_key'];
        }
    }
    
    /**
     * Envía un mensaje de WhatsApp usando el proveedor configurado con fallback
     * @param string $phoneNumber Número de teléfono con código de país (ej: 573001234567)
     * @param string $message Mensaje a enviar
     * @return bool True si se envió correctamente, False en caso contrario
     */
    public function sendWhatsAppMessage($phoneNumber, $message)
    {
        // Verificar si WhatsApp está habilitado
        if (!isWhatsAppEnabled()) {
            logWhatsAppMessage("Las notificaciones de WhatsApp están desactivadas", "WARNING");
            return false;
        }
        
        try {
            // Formatear el número de teléfono
            $phoneNumber = $this->formatPhoneNumber($phoneNumber);
            
            // Log del intento de envío
            logWhatsAppMessage("Intentando enviar mensaje de WhatsApp al número {$phoneNumber}");
            
            $provider = $this->config['provider'];
            $success = false;
            
            // Intentar con el proveedor principal
            switch ($provider) {
                case 'callmebot':
                    $success = $this->sendViaCallmebot($phoneNumber, $message);
                    break;
                case 'whatsapp_business':
                    $success = $this->sendViaWhatsAppBusiness($phoneNumber, $message);
                    break;
                case 'wamr':
                    $success = $this->sendViaWAMR($phoneNumber, $message);
                    break;
                default:
                    $success = $this->sendViaCallmebot($phoneNumber, $message);
            }
            
            // Si falla, intentar con proveedores alternativos
            if (!$success) {
                logWhatsAppMessage("El proveedor principal falló, intentando alternativas", "WARNING");
                $success = $this->tryAlternativeProviders($phoneNumber, $message);
            }
            
            if ($success) {
                logWhatsAppMessage("Mensaje de WhatsApp enviado correctamente al número {$phoneNumber}");
            } else {
                logWhatsAppMessage("No se pudo enviar el mensaje de WhatsApp al número {$phoneNumber}", "ERROR");
            }
            
            return $success;
            
        } catch (Exception $e) {
            logWhatsAppMessage("Error al enviar mensaje de WhatsApp: " . $e->getMessage(), "ERROR");
            return false;
        }
    }
    
    /**
     * Envía mensaje usando Callmebot
     */
    private function sendViaCallmebot($phoneNumber, $message)
    {
        // Seleccionar el API Key correcto según el número de destino
        if ($phoneNumber == $this->config['task_number']) {
            $apiKey = $this->config['task_api_key'];
        } elseif ($phoneNumber == $this->config['general_number']) {
            $apiKey = $this->config['general_api_key'];
        } else {
            $apiKey = $this->apiKey; // fallback
        }
        $encodedMessage = urlencode($message);
        $url = $this->apiUrl . "?phone={$phoneNumber}&text={$encodedMessage}&apikey={$apiKey}";
        $response = $this->makeHttpRequest($url);
        return $response && strpos($response, 'success') !== false;
    }
    
    /**
     * Envía mensaje usando WhatsApp Business API
     */
    private function sendViaWhatsAppBusiness($phoneNumber, $message)
    {
        $data = [
            'messaging_product' => 'whatsapp',
            'to' => $phoneNumber,
            'type' => 'text',
            'text' => [
                'body' => $message
            ]
        ];
        
        $headers = [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return $httpCode == 200;
    }
    
    /**
     * Envía mensaje usando WAMR
     */
    private function sendViaWAMR($phoneNumber, $message)
    {
        $data = [
            'api_key' => $this->apiKey,
            'phone' => $phoneNumber,
            'message' => $message
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return $httpCode == 200;
    }
    
    /**
     * Envía notificación de nueva tarea a múltiples usuarios
     * @param array $usuarios Array de usuarios con información de contacto
     * @param array $tareaInfo Información de la tarea
     * @return array Resultado del envío para cada usuario
     */
    public function sendTareaNotification($usuarios, $tareaInfo)
    {
        $results = [];
        $message = $this->createTareaMessageForSpecificNumber($usuarios, $tareaInfo);
        
        // Enviar a número de tareas
        $taskPhoneNumber = $this->formatPhoneNumber($this->config['task_number']);
        $taskSuccess = $this->sendWhatsAppMessage($taskPhoneNumber, $message);
        $results[] = [
            'usuario_id' => 'task',
            'nombre' => 'Número de Tarea',
            'telefono' => $taskPhoneNumber,
            'enviado' => $taskSuccess,
            'mensaje' => $taskSuccess ? 'Enviado correctamente' : 'Error al enviar'
        ];
        logWhatsAppMessage("Enviado a número de tarea: {$taskPhoneNumber}", "INFO");
        
        // Enviar también a número general (573163819809)
        $generalPhoneNumber = $this->formatPhoneNumber($this->config['general_number']);
        $generalSuccess = $this->sendWhatsAppMessage($generalPhoneNumber, $message);
        $results[] = [
            'usuario_id' => 'general',
            'nombre' => 'Número General',
            'telefono' => $generalPhoneNumber,
            'enviado' => $generalSuccess,
            'mensaje' => $generalSuccess ? 'Enviado correctamente' : 'Error al enviar'
        ];
        logWhatsAppMessage("Enviado a número general: {$generalPhoneNumber}", "INFO");
        
        // Si ambos WhatsApp fallaron, intentar email de respaldo
        if (!$taskSuccess && !$generalSuccess && $this->config['email_backup']['enabled']) {
            logWhatsAppMessage("WhatsApp failed, trying email backup", "WARNING");
            $this->sendEmailBackup($usuarios, $tareaInfo);
        }
        
        return $results;
    }
    
    /**
     * Envía notificación por email como respaldo
     * @param array $usuarios Array de usuarios
     * @param array $tareaInfo Información de la tarea
     */
    private function sendEmailBackup($usuarios, $tareaInfo)
    {
        try {
            require_once "Helpers/EmailBackupHelper.php";
            $emailHelper = new EmailBackupHelper();
            $emailHelper->sendTareaNotification($usuarios, $tareaInfo);
        } catch (Exception $e) {
            logWhatsAppMessage("Error sending email backup: " . $e->getMessage(), "ERROR");
        }
    }
    
    /**
     * Obtiene el número de teléfono del usuario
     * @param array $usuario Información del usuario
     * @return string|null Número de teléfono o null si no está disponible
     */
    private function getUserPhoneNumber($usuario)
    {
        // Primero intentar obtener de la tabla de funcionarios
        if (isset($usuario['celular']) && !empty($usuario['celular'])) {
            return $usuario['celular'];
        }
        
        // Si no hay celular, intentar buscar en la tabla de funcionarios por correo
        if (isset($usuario['correo']) && !empty($usuario['correo'])) {
            $phoneNumber = $this->getPhoneByEmail($usuario['correo']);
            if ($phoneNumber) {
                return $phoneNumber;
            }
        }
        
        return null;
    }
    
    /**
     * Busca el número de teléfono por correo electrónico en la tabla de funcionarios
     * @param string $email Correo electrónico
     * @return string|null Número de teléfono o null si no se encuentra
     */
    private function getPhoneByEmail($email)
    {
        try {
            $sql = "SELECT celular FROM tbl_funcionarios_planta WHERE correo_elc = ? AND celular IS NOT NULL AND celular != ''";
            $db = new Mysql();
            $result = $db->select($sql, [$email]);
            
            if ($result && !empty($result['celular'])) {
                return $result['celular'];
            }
            
            return null;
        } catch (Exception $e) {
            logWhatsAppMessage("Error getting phone by email: " . $e->getMessage(), "ERROR");
            return null;
        }
    }
    
    /**
     * Crea el mensaje de notificación de tarea para número específico
     * @param array $usuarios Array de usuarios asignados
     * @param array $tareaInfo Información de la tarea
     * @return string Mensaje formateado
     */
    private function createTareaMessageForSpecificNumber($usuarios, $tareaInfo)
    {
        $fechaInicio = date('d/m/Y', strtotime($tareaInfo['fecha_inicio']));
        $fechaFin = date('d/m/Y', strtotime($tareaInfo['fecha_fin']));
        
        $message = "🔔 *NUEVA TAREA CREADA EN SAMICAM*\n\n";
        $message .= "📋 *Descripción:* {$tareaInfo['descripcion']}\n";
        $message .= "🏷️ *Tipo:* {$tareaInfo['tipo']}\n";
        $message .= "🏢 *Dependencia:* {$tareaInfo['dependencia_nombre']}\n";
        $message .= "📅 *Fecha de inicio:* {$fechaInicio}\n";
        $message .= "📅 *Fecha de fin:* {$fechaFin}\n";
        
        if (!empty($tareaInfo['observacion'])) {
            $message .= "📝 *Observación:* {$tareaInfo['observacion']}\n";
        }
        
        $message .= "\n👥 *Usuarios Asignados:*\n";
        foreach ($usuarios as $usuario) {
            $message .= "   • {$usuario['nombres']}\n";
        }
        
        $message .= "\n📊 *Resumen:*\n";
        $message .= "   • Total de usuarios: " . count($usuarios) . "\n";
        $message .= "   • Estado: Sin empezar\n";
        $message .= "   • Prioridad: Normal\n";
        
        $message .= "\n💻 Accede al sistema para más detalles.\n";
        $message .= "¡Gracias por tu atención!";
        
        return $message;
    }
    
    /**
     * Crea el mensaje de notificación de tarea
     * @param array $tareaInfo Información de la tarea
     * @param array $usuario Información del usuario
     * @return string Mensaje formateado
     */
    private function createTareaMessage($tareaInfo, $usuario)
    {
        $fechaInicio = date('d/m/Y', strtotime($tareaInfo['fecha_inicio']));
        $fechaFin = date('d/m/Y', strtotime($tareaInfo['fecha_fin']));
        
        $message = $this->config['messages']['prefix'] . "\n\n";
        $message .= "Hola *{$usuario['nombres']}*, se te ha asignado una nueva tarea:\n\n";
        $message .= "📋 *Descripción:* {$tareaInfo['descripcion']}\n";
        $message .= "🏷️ *Tipo:* {$tareaInfo['tipo']}\n";
        $message .= "🏢 *Dependencia:* {$tareaInfo['dependencia_nombre']}\n";
        $message .= "📅 *Fecha de inicio:* {$fechaInicio}\n";
        $message .= "📅 *Fecha de fin:* {$fechaFin}\n";
        
        if (!empty($tareaInfo['observacion'])) {
            $message .= "📝 *Observación:* {$tareaInfo['observacion']}\n";
        }
        
        $message .= "\n" . $this->config['messages']['suffix'] . "\n";
        $message .= "¡Gracias por tu atención!";
        
        return $message;
    }
    
    /**
     * Formatea el número de teléfono para WhatsApp
     * @param string $phoneNumber Número de teléfono
     * @return string Número formateado
     */
    private function formatPhoneNumber($phoneNumber)
    {
        // Eliminar espacios, guiones y paréntesis
        $phoneNumber = preg_replace('/[\s\-\(\)]/', '', $phoneNumber);
        
        // Si no tiene código de país, agregar el configurado
        $defaultCode = $this->config['phone']['default_country_code'];
        if (strlen($phoneNumber) == 10 && substr($phoneNumber, 0, 1) == '3') {
            $phoneNumber = $defaultCode . $phoneNumber;
        }
        
        // Si empieza con +, eliminarlo
        if (substr($phoneNumber, 0, 1) == '+') {
            $phoneNumber = substr($phoneNumber, 1);
        }
        
        return $phoneNumber;
    }
    
    /**
     * Realiza una petición HTTP
     * @param string $url URL a consultar
     * @return string|false Respuesta o false si hay error
     */
    private function makeHttpRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode == 200) {
            return $response;
        }
        
        return false;
    }
    
    /**
     * Intenta enviar usando proveedores alternativos
     * @param string $phoneNumber Número de teléfono
     * @param string $message Mensaje
     * @return bool True si se envió correctamente
     */
    private function tryAlternativeProviders($phoneNumber, $message)
    {
        // Lista de proveedores alternativos a probar
        $alternativeProviders = [
            'wamr',
            'whatsapp_business',
            'callmebot'
        ];
        
        foreach ($alternativeProviders as $provider) {
            if ($provider === $this->config['provider']) {
                continue; // Saltar el proveedor principal ya que ya falló
            }
            
            logWhatsAppMessage("Intentando proveedor alternativo: {$provider}", "INFO");
            
            $success = false;
            switch ($provider) {
                case 'callmebot':
                    $success = $this->sendViaCallmebot($phoneNumber, $message);
                    break;
                case 'whatsapp_business':
                    $success = $this->sendViaWhatsAppBusiness($phoneNumber, $message);
                    break;
                case 'wamr':
                    $success = $this->sendViaWAMR($phoneNumber, $message);
                    break;
            }
            
            if ($success) {
                logWhatsAppMessage("Mensaje enviado correctamente mediante proveedor alternativo: {$provider}", "INFO");
                return true;
            }
        }
        
        logWhatsAppMessage("Todos los proveedores fallaron", "ERROR");
        return false;
    }
    
    public function getNumeroEspecifico() {
        return $this->config['specific_number'];
    }
    
    /**
     * Obtiene el número de WhatsApp según el tipo de notificación
     * @param string $tipo 'task' para tareas, 'general' para todo lo demás
     * @return string
     */
    public function getNumeroPorTipo($tipo = 'general') {
        if ($tipo === 'task') {
            return $this->config['task_number'];
        }
        return $this->config['general_number'];
    }
} 