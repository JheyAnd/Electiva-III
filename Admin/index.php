<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Sistema de Inventario</title>
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
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    padding-top: 2rem;
    transition: all 0.3s ease;
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

/* Dashboard Cards */
.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    opacity: 0;
    transform: translateY(20px);
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.card h3 {
    color: #64748b;
    font-size: 0.875rem;
    font-weight: 500;
    margin-top: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.card-content {
    height: 200px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

/* Estilo específico para los números grandes */
.big-number {
    color: #2c3e50;
    font-size: 3.5em;
    font-weight: bold;
    margin: 0;
}

/* Estilo para el menú desplegable */
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

/* Animación para las tarjetas */
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
        document.addEventListener('DOMContentLoaded', () => {
        // Selecciona el enlace que despliega el submenú
        const dropdownToggle = document.querySelector('.dropdown-toggle');
        const dropdownMenu = document.querySelector('.dropdown');

        // Agrega el evento de clic para alternar la clase 'show'
        dropdownToggle.addEventListener('click', (event) => {
            event.preventDefault(); // Evita que el enlace se active
            dropdownMenu.classList.toggle('show');
        });
    });
    </script>
</body>
</html>