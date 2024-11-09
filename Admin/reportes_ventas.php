<?php
// Incluir el archivo de configuración si existe
if (file_exists('config.php')) {
    require_once 'config.php';
}

// Datos de ejemplo para el informe de ventas
$salesData = [
    'totalSales' => 15000,
    'averageOrderValue' => 250,
    'topSellingProduct' => 'Widget X',
    'recentSales' => [
        ['id' => 1, 'date' => '2023-05-01', 'product' => 'Widget X', 'quantity' => 5, 'total' => 500],
        ['id' => 2, 'date' => '2023-05-02', 'product' => 'Gadget Y', 'quantity' => 3, 'total' => 450],
        ['id' => 3, 'date' => '2023-05-03', 'product' => 'Tool Z', 'quantity' => 2, 'total' => 300],
        ['id' => 4, 'date' => '2023-05-04', 'product' => 'Widget X', 'quantity' => 4, 'total' => 400],
        ['id' => 5, 'date' => '2023-05-05', 'product' => 'Gadget Y', 'quantity' => 1, 'total' => 150],
    ]
];

// Función para formatear números como moneda
function formatCurrency($number) {
    return '$' . number_format($number, 2);
}

// Incluir el encabezado si existe
if (file_exists('header.php')) {
    require_once 'header.php';
} else {
    // Si no existe un encabezado, generamos uno básico
    echo '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Informe de Ventas</title>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
         @import url("https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

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
    margin-bottom: 2rem;
}

.header h2 {
    color: #1e293b;
    font-size: 1.875rem;
    font-weight: 600;
    margin: 0;
}

/* Dashboard Cards */
.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.card h3 {
    color: #64748b;
    font-size: 0.875rem;
    font-weight: 500;
    margin: 0 0 1rem 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.card-content {
    text-align: center;
}

.big-number {
    color: #1e293b;
    font-size: 2.25rem;
    font-weight: 700;
    line-height: 1.2;
    margin: 0;
}

/* Gráfico de Ventas */
.chart-container {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-top: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.chart-container h3 {
    color: #1e293b;
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0 0 1.5rem 0;
}

#salesChart {
    height: 400px !important;
}

/* Tabla de ventas */
.products-table {
    width: 100%;
    background: white;
    border-radius: 1rem;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 2rem;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.products-table th,
.products-table td {
    padding: 1rem 1.5rem;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
}

.products-table th {
    background-color: #f8fafc;
    color: #64748b;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.products-table tr:last-child td {
    border-bottom: none;
}

.products-table tbody tr:hover {
    background-color: #f8fafc;
}

/* Responsive */
@media (max-width: 1280px) {
    .dashboard-cards {
        grid-template-columns: repeat(2, 1fr);
    }
}

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

    .dashboard-cards {
        grid-template-columns: 1fr;
    }

    .big-number {
        font-size: 2rem;
    }

    .products-table {
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
';
}

// Incluir el menú
require "menu.php";
?>

<div class="container">
    <div class="main-content">
        <div class="header">
            <h2>Informe de Ventas</h2>
        </div>
        <div class="dashboard-cards">
            <div class="card fade-in">
                <h3>Ventas Totales</h3>
                <div class="card-content">
                    <p class="big-number"><?php echo formatCurrency($salesData['totalSales']); ?></p>
                </div>
            </div>
            <div class="card fade-in">
                <h3>Valor Promedio de Orden</h3>
                <div class="card-content">
                    <p class="big-number"><?php echo formatCurrency($salesData['averageOrderValue']); ?></p>
                </div>
            </div>
            <div class="card fade-in">
                <h3>Producto Más Vendido</h3>
                <div class="card-content">
                    <p class="big-number"><?php echo htmlspecialchars($salesData['topSellingProduct']); ?></p>
                </div>
            </div>
        </div>
        <div class="card fade-in" style="margin-top: 20px;">
            <h3>Gráfico de Ventas</h3>
            <canvas id="salesChart"></canvas>
        </div>
        <div class="card fade-in" style="margin-top: 20px;">
            <h3>Ventas Recientes</h3>
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($salesData['recentSales'] as $sale): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($sale['date']); ?></td>
                            <td><?php echo htmlspecialchars($sale['product']); ?></td>
                            <td><?php echo htmlspecialchars($sale['quantity']); ?></td>
                            <td><?php echo formatCurrency($sale['total']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Configuración del gráfico de ventas
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_column($salesData['recentSales'], 'date')); ?>,
            datasets: [{
                label: 'Ventas',
                data: <?php echo json_encode(array_column($salesData['recentSales'], 'total')); ?>,
                backgroundColor: '#2c3e50',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Ventas Recientes'
                }
            }
        }
    });

<?php
// Incluir el pie de página si existe
if (file_exists('footer.php')) {
    require_once 'footer.php';
} else {
    // Si no existe un pie de página, cerramos las etiquetas body y html
    echo '</body></html>';
}
?>