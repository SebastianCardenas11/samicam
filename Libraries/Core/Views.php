<?php

class Views
{
    private string $ruta;

    public function __construct(string $ruta)
    {
        $this->ruta = $ruta;
    }

    public function display(string $vista, array $datos = []): void
    {
        $pathView = $this->ruta . $vista . '.php';
        if (file_exists($pathView)) {
            extract($datos);
            require_once $pathView;
        } else {
            die('La vista ' . $vista . ' no existe en la ruta ' . $pathView);
        }
    }
}