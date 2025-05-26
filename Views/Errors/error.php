<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="shortcut icon" href="<?= media();?>/images/favicon.png" type="image/x-icon">
  <title>Error 404</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    html, body {
      height: 100%;
      background-color: #f5f5f5; /* gris claro */
      color: #444;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .contenedor {
      text-align: center;
      max-width: 700px;
      width: 100%;
    }

    .imagen img {
      max-width: 400px;
      width: 100%;
      margin-bottom: 30px;
    }

    h1 {
      font-size: 100px;
      font-weight: 600;
      margin-bottom: 10px;
      color: #222;
    }

    h2 {
      font-size: 24px;
      font-weight: 400;
      margin-bottom: 15px;
      color: #555;
    }

    p {
      font-size: 18px;
      color: #666;
      margin-bottom: 30px;
    }

    .boton {
      padding: 12px 28px;
      background-color: white;
      color: #222;
      border: 2px solid #222;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .boton:hover {
      background-color: #222;
      color: white;
    }

    .creditos {
      margin-top: 30px;
      font-size: 12px;
      color: #aaa;
    }

    .creditos a {
      color: #aaa;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="contenedor">
    <div class="imagen">
      <img src="<?= media();?>/images/samicamIconox.png" alt="Error 404" />
    </div>
    <h1>404</h1>
    <h2>Lo sentimos, esta página no existe</h2>
    <p>La página que estás buscando pudo haber sido eliminada, movida o nunca haber existido.</p>
    <a href="<?= base_url();?>" class="boton">Volver al inicio</a>
  </div>
</body>
</html>
