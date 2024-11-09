<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libro Mayor - Sistema de Inventario</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap");

        /* Estilos generales */
        body {
            font-family: "Montserrat", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            color: #334155;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Barra lateral */
        .sidebar {
    width: 280px;
    background-color: #2c3e50;
    color: white;
    height: calc(100vh - 60px); /* Ajusta la altura si tienes una cabecera de 60px */
    position: fixed;
    left: 0;
    top: 0;
    padding-top: 2rem;
    transition: all 0.3s ease;
    /* Si deseas que la barra lateral no tenga borde en el contenido, puedes usar */
    border-right: 1px solid rgba(255, 255, 255, 0.1); /* Borde derecho opcional */
}
/* Estilos de la barra de desplazamiento para navegadores WebKit (Chrome, Safari) */
.sidebar::-webkit-scrollbar {
    width: 8px; /* Ancho de la barra de desplazamiento */
}

.sidebar::-webkit-scrollbar-track {
    background: #34495e; /* Color de fondo del track */
}

.sidebar::-webkit-scrollbar-thumb {
    background: #60a5fa; /* Color de la barra de desplazamiento */
    border-radius: 50%; /* Bordes redondeados */
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: #007bff; /* Color cuando se pasa el mouse */
}

/* Estilos de la barra de desplazamiento para Firefox */
.sidebar {
    scrollbar-width: thin; /* Ancho de la barra de desplazamiento */
    scrollbar-color: #60a5fa #34495e; /* Color de la barra y el track */
}

/* Estilos para navegadores que no soportan barra de desplazamiento personalizada */
.sidebar {
    overflow-y: auto; /* Permitir desplazamiento vertical */
}


        .sidebar h1 {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            padding: 0 1.5rem 2rem;
            margin: 0;
            text-align: center;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            margin: 0.5rem 0;
        }

        .sidebar ul li a {
            color: #94a3b8;
            text-decoration: none;
            padding: 0.875rem 1.5rem;
            display: block;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: #60a5fa;
        }

        /* Contenido principal */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
        }

        .header {
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .header h2 {
            color: #1e293b;
            font-size: 1.875rem;
            font-weight: 600;
            margin: 0;
        }

        /* Tabla de Libro Mayor */
        .ledger-table, .assets-table {
            width: 100%;
            background: white;
            border-radius: 1rem;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 2rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .ledger-table th,
        .ledger-table td,
        .assets-table th,
        .assets-table td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .ledger-table th,
        .assets-table th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .ledger-table tbody tr:hover,
        .assets-table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Botón para generar archivo */
        .generate-btn {
            background-color: #60a5fa;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            margin: 1rem 0;
            font-size: 1rem;
        }

        /* Formulario emergente */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding-top: 1rem;
            }

            .main-content {
                margin-left: 0;
                padding: 1.5rem;
            }

            .ledger-table,
            .assets-table {
                display: block;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }
        /* Estilos para el dropdown (submenú) */
        .dropdown {
    display: none;
    list-style: none;
    padding-left: 20px;
}

.dropdown.show {
    display: block;
}

.dropdown li a:hover {
    background-color: #ccc;
}
.user-profile {
    text-align: center;
    margin-bottom: 20px; /* Espacio entre la foto y la navegación */
}

.profile-img {
    width: 60px; /* Ajusta según tu diseño */
    height: 60px; /* Ajusta según tu diseño */
    border-radius: 50%; /* Hace que la imagen sea circular */
}

.user-name {
    font-weight: bold;
    margin: 5px 0; /* Espaciado entre el nombre y el icono */
}

.logout-icon img {
    width: 20px; /* Ajusta según tu diseño */
    height: 20px; /* Ajusta según tu diseño */
}
    </style>
</head>
<body>
    <?php require "menu.php";?>
    <div class="container">
        <main class="main-content">
            <header class="header">
                <h2>Libro Mayor</h2>
            </header>
            <button class="generate-btn" id="generateReport">Generar archivo</button>

            <table class="ledger-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Débito</th>
                        <th>Crédito</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>01/01/2024</td>
                        <td>Inicio de Año</td>
                        <td>$10,000</td>
                        <td>$0</td>
                        <td>$10,000</td>
                    </tr>
                    <tr>
                        <td>10/01/2024</td>
                        <td>Compra de Producto</td>
                        <td>$1,000</td>
                        <td>$0</td>
                        <td>$9,000</td>
                    </tr>
                    <tr>
                        <td>15/01/2024</td>
                        <td>Venta de Producto</td>
                        <td>$0</td>
                        <td>$2,000</td>
                        <td>$11,000</td>
                    </tr>
                    <tr>
                        <td>20/01/2024</td>
                        <td>Gastos Operativos</td>
                        <td>$500</td>
                        <td>$0</td>
                        <td>$10,500</td>
                    </tr>
                    <!-- Agrega más filas según sea necesario -->
                </tbody>
            </table>

            <h2>Totales de Activos</h2>
            <table class="assets-table">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Dinero De Ventas</td>
                        <td>$11,000</td>
                    </tr>
                    <tr>
                        <td>Inventario De Productos</td>
                        <td>$3,000</td>
                    </tr>
                    <tr>
                        <td><strong>Total Activos</strong></td>
                        <td><strong>$19,000</strong></td>
                    </tr>
                </tbody>
            </table>

            <!-- Modal para seleccionar mes y año -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Generar Reporte</h2>
                    <label for="month">Mes:</label>
                    <select id="month">
                        <option value="01">Enero</option>
                        <option value="02">Febrero</option>
                        <option value="03">Marzo</option>
                        <option value="04">Abril</option>
                        <option value="05">Mayo</option>
                        <option value="06">Junio</option>
                        <option value="07">Julio</option>
                        <option value="08">Agosto</option>
                        <option value="09">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                    <label for="year">Año:</label>
                    <input type="number" id="year" value="2024" min="2000" max="2100">
                    <button id="generateExcel">Generar Excel</button>
                </div>
            </div>

        </main>
    </div>

    <script>
        // Obtener modal
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("generateReport");
        var span = document.getElementsByClassName("close")[0];

        // Cuando el usuario hace clic en el botón, abrir el modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // Cuando el usuario hace clic en <span> (x), cerrar el modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Cuando el usuario hace clic en cualquier parte fuera del modal, cerrarlo
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Funcionalidad para generar el archivo Excel
        document.getElementById("generateExcel").onclick = function() {
            var month = document.getElementById("month").value;
            var year = document.getElementById("year").value;
            // Redirigir a la página PHP que genera el archivo Excel
            window.location.href = 'generate_excel.php?month=' + month + '&year=' + year;
        }
    
    </script>
</body>
</html>
