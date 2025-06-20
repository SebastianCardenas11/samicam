<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//IP del servidor y local
const PROTOCOL = "https";
const IP_SERVER = "100.85.55.128:4443";
const IP_LOCAL = "localhost";
const BASE_URL = PROTOCOL."://".IP_LOCAL."/samicam";

//Zona horaria
date_default_timezone_set('America/Bogota');

//Datos de conexión a Base de Datos
const DB_HOST = IP_LOCAL.":3306";
const DB_NAME = "samicam";
const NOMBRE_REMITENTE = "Alcaldia de la jagua de ibirico";
const EMAIL_REMITENTE = "Alcaldia@lajaguadeibirico-cesar.gov.co";
const NOMBRE_EMPESA = "Alcaldia de la jagua de ibirico";
const WEB_EMPRESA = "https://www.lajaguadeibirico-cesar.gov.co/";
const DESCRIPCION = "Alcaldia de la jagua de ibirico";
const SHAREDHASH = "Alcaldia de la jagua de ibirico";

//Datos Empresa
const DIRECCION = "La Jagua - Cesar, Colombia"; 
const TELEMPRESA = "3148691240";
const WHATSAPP = "3148691240";
const EMAIL_INSTITUCIONAL = "Alcaldia@lajaguadeibirico-cesar.gov.co";
const EMAIL_JUDICIAL = "notificacionjudicial@lajaguadeibirico-cesar.gov.co";
const CAT_SLIDER = "1,2,3";
const CAT_BANNER = "4,5,6";
const CAT_FOOTER = "1,2,3,4,5";

//Datos para Encriptar / Desencriptar
const KEY = 'samicam_key_cam';
const METHODENCRIPT = "AES-128-ECB";

//Módulos
const MDASHBOARD = 1;
const MUSUARIOS = 2;
const MROLES = 3;
const MFUNCIONARIOSOPS = 4;
const MFUNCIONARIOSPLANTA = 5;
const MVACACIONES = 6;
const MVIATICOS = 7;
const MARCHIVOS = 8;
const MCARGOS = 9;
const MTAREAS = 11;
const MPUBLICACIONES = 12;
const MDEPENDENCIAS = 13;
const MSEGUIMIENTOCONTRATO = 14;
const MWHATSAPP = 15;

//Páginas
const PINICIO = 1;

// Paginación
const PROAPAGINAR = 20;