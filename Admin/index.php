<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Sistema de Inventario</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Estilos previos sin cambios */
        @import url("https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            color: #333;
            font-weight: bold;
        }
        .container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Barra lateral */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            transition: all 0.3s ease;
        }
        .sidebar h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 15px;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .sidebar ul li a:hover {
            background-color: #34495e;
        }
        
        /* Contenido principal */
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
        .header {
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
        }
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            opacity: 0;
            transform: translateY(20px);
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .card h3 {
            margin-top: 0;
        }
        .card-content {
            height: 200px;
            /* Nuevos estilos para centrar el contenido */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        /* Estilo específico para los números grandes */
        .big-number {
            font-size: 3.5em;
            font-weight: bold;
            margin: 0;
            color: #2c3e50;
        }
        /* Estilo para el menú desplegable */
    .dropdown {
        display: none; /* Oculta el submenú por defecto */
        list-style: none;
        padding-left: 20px;
        margin: auto;
    }
    .dropdown-toggle:hover + .dropdown, 
    .dropdown:hover {
        display: block; /* Muestra el submenú al pasar el ratón */
    }
    .dropdown li a:hover {
        background-color: #ccc;
    }
        
        /* Animaciones */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-in {
            animation: fadeInUp 0.5s ease-out forwards;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php require 'menu.php'; ?>
        <main class="main-content">
            <header class="header">
                <h2>Dashboard</h2>
            </header>
            <section class="dashboard-cards">
                <div class="card">
                    <h3>Total Inventario</h3>
                    <div class="card-content">
                        <canvas id="inventoryChart"></canvas>
                    </div>
                </div>
                <div class="card">
                    <h3>Total Productos</h3>
                    <div class="card-content">
                        <canvas id="productsChart"></canvas>
                    </div>
                </div>
                <div class="card">
                    <h3>Categorías</h3>
                    <div class="card-content">
                        <p class="big-number">56</p>
                    </div>
                </div>
                <div class="card">
                    <h3>Proveedores</h3>
                    <div class="card-content">
                        <p class="big-number">89</p>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Animación para las tarjetas
        document.addEventListener('DOMContentLoaded', (event) => {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.animation = 'fadeInUp 0.5s ease-out forwards';
                }, index * 100);
            });
        });

        // Datos de ejemplo para las gráficas
        const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'];
        const inventoryData = [15000, 17000, 16500, 18000, 17500, 19000];
        const productsData = [500, 550, 525, 575, 600, 625];

        // Gráfica de Inventario Total
        const inventoryCtx = document.getElementById('inventoryChart').getContext('2d');
        new Chart(inventoryCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Valor del Inventario',
                    data: inventoryData,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Valor ($)'
                        }
                    }
                }
            }
        });

        // Gráfica de Total de Productos
        const productsCtx = document.getElementById('productsChart').getContext('2d');
        new Chart(productsCtx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Cantidad de Productos',
                    data: productsData,
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                    borderColor: 'rgb(153, 102, 255)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>