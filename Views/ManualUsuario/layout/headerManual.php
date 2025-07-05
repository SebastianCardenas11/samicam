<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual de Usuario Samicam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
  <link rel="icon" type="image/png" href="<?= media() ?>/images/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            scrollbar-width: thin;
            scrollbar-color: #4b5563 #1f2937;
        }
        .sidebar::-webkit-scrollbar {
            width: 8px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: #1f2937;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background-color: #4b5563;
            border-radius: 4px;
        }
        .highlight {
            position: relative;
        }
        .highlight::before {
            content: "";
            position: absolute;
            left: -4px;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: #3b82f6;
            border-radius: 2px;
        }
        .screenshot {
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .tooltip {
            position: relative;
            display: inline-block;
        }
        .tooltip .tooltiptext {
            visibility: hidden;
            width: 200px;
            background-color: #111827;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -100px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Header -->
    <header class="bg-blue-800 text-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center mb-4 md:mb-0">
                    <img src="<?= media() ?>/images/samicamIcono.png" alt="Logo SAMICAM" class="h-12 mr-4">
                    
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold">Manual de Usuario</h1>
                        <p class="text-blue-200">Sistema de Administración Municipal Integrado - SAMICAM</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="bg-blue-700 px-3 py-1 rounded-full text-sm">Versión 2.1</span>
                    <span class="bg-blue-600 px-3 py-1 rounded-full text-sm">Última actualización: 05/07/2025</span>
                </div>
            </div>
        </div>
    </header>
