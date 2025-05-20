<?php
const BASE_URL = "http://localhost/samicam";
// 192.168.150.235:8080
//Zona horaria

date_default_timezone_set('America/Bogota');

//Datos de conexión a Base de Datos
const DB_HOST = "localhost:3307";
const DB_NAME = "samicam";
const DB_USER = "root";
const DB_PASSWORD = "";
const DB_CHARSET = "utf8";

//Datos envio de correo
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
const MROLES= 3;
const MFUNCIONARIOSOPS= 4;
const MFUNCIONARIOSPLANTA= 4;

//Páginas
const PINICIO = 1;

//Roles
const RADMINISTRADOR = 1;
const RCOORDINADOR = 2;