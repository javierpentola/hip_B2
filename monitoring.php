<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HIP ENERGY Navigation - Admin Panel</title>
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    :root {
        --primary-color: #f2c517;
        --primary-dark: #d4a017;
        --accent-color: #f2c517;
        --text-color: #000;
        --transition-speed: 0.3s;
        --divider-width: 6px;
        --sidebar-width: 80px;
        --sidebar-expanded-width: 250px;
    }

    body {
        margin: 0;
        font-family: 'Rubik', sans-serif;
        overflow-x: hidden;
        background-color: var(--primary-color);
    }

    .sidebar {
        height: 100vh;
        background-color: var(--primary-color);
        width: var(--sidebar-width);
        position: fixed;
        left: 0;
        top: 0;
        transition: width var(--transition-speed) ease;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        z-index: 1000;
    }

    .sidebar:hover {
        width: var(--sidebar-expanded-width);
    }

    .brand {
        padding: 1rem;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-color);
        text-align: center;
        white-space: nowrap;
        opacity: 0;
        transition: opacity var(--transition-speed);
    }

    .sidebar:hover .brand {
        opacity: 1;
    }

    .nav-items {
        flex: 1;
        padding: 1rem 0;
    }

    .nav-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: var(--text-color);
        text-decoration: none;
        transition: all var(--transition-speed);
        cursor: pointer;
        white-space: nowrap;
        border-radius: 0 25px 25px 0;
        margin: 0.25rem 0;
    }

    .nav-item:hover {
        background-color: white;
        color: var(--primary-color);
    }

    .nav-item.active {
        background-color: var(--primary-dark);
        color: var(--primary-color);
    }

    .nav-item i {
        width: 24px;
        margin-right: 1rem;
        text-align: center;
    }

    .nav-item span {
        opacity: 0;
        transition: opacity var(--transition-speed);
    }

    .sidebar:hover .nav-item span {
        opacity: 1;
    }

    .logo-container {
        padding: 1rem;
        margin: 1rem;
        text-align: center;
        opacity: 0;
        transition: opacity var(--transition-speed);
    }

    .sidebar:hover .logo-container {
        opacity: 1;
    }

    .logo {
        width: 150px;
        height: auto;
    }

    .main-content {
        margin-left: var(--sidebar-width);
        padding: 2rem;
        transition: margin-left var(--transition-speed) ease;
        min-height: 100vh;
        max-width: 1200px;
        margin-right: auto;
    }

    .main-content::before {
        content: '';
        position: fixed;
        left: var(--sidebar-width);
        top: 0;
        width: var(--divider-width);
        height: 100%;
        background-color: var(--primary-dark);
        transition: left var(--transition-speed) ease;
    }

    .sidebar:hover + .main-content::before {
        left: var(--sidebar-expanded-width);
    }

    .logout-btn {
        position: fixed;
        bottom: 1rem;
        right: 1rem;
        padding: 0.3rem 0.6rem;
        background-color: red;
        color: white;
        border: 2px solid black;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 500;
        transition: background-color 0.3s ease;
    }

    .logout-btn:hover {
        background-color: darkred;
    }

    .monitoring-section {
        background-color: white;
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .monitoring-section h2 {
        margin-top: 0;
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 0.5rem;
    }

    .activity-log {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 1rem;
        margin-top: 1rem;
    }

    .activity-item {
        padding: 0.5rem;
        border-bottom: 1px solid #eee;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .system-status {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
        padding: 1rem;
        background-color: #f8f8f8;
        border-radius: 4px;
    }

    .status-indicator {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        margin-right: 0.5rem;
    }

    .status-good {
        background-color: #4CAF50;
    }

    .status-warning {
        background-color: #FFC107;
    }

    .status-error {
        background-color: #F44336;
    }

    .uptime-chart {
        width: 100%;
        height: 200px;
        margin-top: 1rem;
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        border-radius: 4px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: var(--sidebar-width);
        }
        .sidebar:hover {
            width: var(--sidebar-expanded-width);
        }
        .main-content {
            margin-left: var(--sidebar-width);
        }
    }
</style>
</head>
<body>
<nav class="sidebar">
    <div class="brand">HIP ENERGY</div>
    <div class="nav-items">
        <a href="#" class="nav-item">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-users"></i>
            <span>User Management</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>Invoices & Expenses</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-chart-bar"></i>
            <span>Reports</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-shield-alt"></i>
            <span>Security</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-headset"></i>
            <span>Support</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-cog"></i>
            <span>System Settings</span>
        </a>
        <a href="#" class="nav-item active">
            <i class="fas fa-desktop"></i>
            <span>Monitoring</span>
        </a>
    </div>
    <div class="logo-container">
        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Normal-S0ZM46xhJ8Mm0vNUqKXmmqWS9gTvZJ.png" alt="HIP ENERGY Logo" class="logo">
    </div>
</nav>

<main class="main-content">
    <div class="monitoring-section">
        <h2>7. Monitoreo</h2>
        
        <h3>Registro de Actividades</h3>
        <div class="activity-log" id="activityLog">
            <!-- Las actividades se insertarán dinámicamente aquí -->
        </div>

        <h3>Estado del Sistema</h3>
        <div class="system-status">
            <div>
                <span class="status-indicator status-good"></span>
                <span>Estado: Operativo</span>
            </div>
            <div>
                <strong>Uptime:</strong> <span id="uptime">99.99%</span>
            </div>
        </div>
        <div class="uptime-chart">
            <!-- Aquí se insertaría un gráfico de uptime -->
            <p>Gráfico de Uptime (Placeholder)</p>
        </div>
    </div>
</main>

<button class="logout-btn" onclick="logout()">Admin log out</button>

<script>
    // Datos de ejemplo para el registro de actividades
    const activities = [
        { timestamp: '2023-06-15 10:30:00', action: 'Creación de factura', user: 'Admin1' },
        { timestamp: '2023-06-15 11:15:00', action: 'Edición de usuario', user: 'Admin2' },
        { timestamp: '2023-06-15 12:00:00', action: 'Generación de reporte', user: 'Admin1' },
        { timestamp: '2023-06-15 13:45:00', action: 'Actualización de sistema', user: 'Admin3' },
        { timestamp: '2023-06-15 14:30:00', action: 'Bloqueo de IP sospechosa', user: 'Admin2' }
    ];

    function renderActivityLog() {
        const activityLogDiv = document.getElementById('activityLog');
        activityLogDiv.innerHTML = '';
        activities.forEach(activity => {
            const activityDiv = `
                <div class="activity-item">
                    <strong>${activity.timestamp}</strong> - ${activity.user}: ${activity.action}
                </div>
            `;
            activityLogDiv.innerHTML += activityDiv;
        });
    }

    function updateUptime() {
        // Simulación de actualización de uptime
        const uptime = (99.95 + Math.random() * 0.05).toFixed(2);
        document.getElementById('uptime').textContent = uptime + '%';
    }

    function logout() {
        // Implementar lógica de cierre de sesión aquí
        alert("Admin ha cerrado sesión");
    }

    // Inicializar la página
    document.addEventListener('DOMContentLoaded', function() {
        renderActivityLog();
        updateUptime();
        // Actualizar el uptime cada 5 minutos
        setInterval(updateUptime, 300000);
    });
</script>
</body>
</html>