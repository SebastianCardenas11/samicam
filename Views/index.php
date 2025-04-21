<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Producto</title>
    <style>
    .suggestions {
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        position: absolute;
        z-index: 1000;
        background-color: white;
        width: 200px;
    }

    .suggestions div {
        padding: 8px;
        cursor: pointer;
    }

    .suggestions div:hover {
        background-color: #e0e0e0;
    }
    </style>
    <script>
    function buscarProducto(query) {
        if (query.length === 0) {
            document.getElementById("sugerencias").innerHTML = "";
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open("GET", "buscar.php?query=" + query, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("sugerencias").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }

    function seleccionarProducto(nombre) {
        document.getElementById("producto").value = nombre;
        document.getElementById("sugerencias").innerHTML = "";
    }
    </script>
</head>

<body>

    <h2>Buscar un Producto</h2>
    <input type="text" id="producto" onkeyup="buscarProducto(this.value)" placeholder="Escribe un producto..."
        autocomplete="off">
    <div id="sugerencias" class="suggestions"></div>

</body>

</html>