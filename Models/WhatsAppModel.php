<?php

class WhatsAppModel extends Mysql
{
    private $archivoHistorico = "uploads/whatsapp_log.txt";
    
    public function __construct()
    {
        parent::__construct();
        $dirBase = "uploads";
        if (!file_exists($dirBase)) {
            mkdir($dirBase, 0755, true);
        }
        if (!file_exists($this->archivoHistorico)) {
            file_put_contents($this->archivoHistorico, "");
        }
    }

    public function getHistoricoCompleto()
    {
        if (file_exists($this->archivoHistorico)) {
            return file_get_contents($this->archivoHistorico);
        }
        return "";
    }

    public function buscarEnHistorico(string $termino)
    {
        if (!file_exists($this->archivoHistorico) || empty($termino)) {
            return "";
        }
        $contenido = file($this->archivoHistorico);
        $resultado = "";
        foreach ($contenido as $linea) {
            if (stripos($linea, $termino) !== false) {
                $resultado .= $linea;
            }
        }
        return $resultado;
    }
} 