<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HIP ENERGY Navigation - Admin Panel</title>
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    .user-management, .reports-section {
        background-color: white;
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .user-management h2, .reports-section h2 {
        margin-top: 0;
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 0.5rem;
    }

    .user-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .user-table th, .user-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .user-table th {
        background-color: var(--primary-color);
        color: white;
    }

    .action-btn {
        padding: 0.3rem 0.6rem;
        margin: 0.2rem;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.8rem;
    }

    .action-btn:hover {
        background-color: var(--primary-dark);
    }

    .add-user-form {
        margin-top: 1rem;
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .add-user-form input {
        flex: 1;
        min-width: 200px;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .chart-container {
        width: calc(50% - 0.5rem);
        height: 300px;
        margin: 1rem 0;
    }

    .charts-wrapper {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
    }

    .export-btn {
        margin-top: 1rem;
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
            <a href="dashboard.php" class="nav-item">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="user_management.php" class="nav-item">
                <i class="fas fa-users"></i>
                <span>User Management</span>
            </a>
            <a href="reports.php" class="nav-item active">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </a>
            <a href="security.php" class="nav-item">
                <i class="fas fa-shield-alt"></i>
                <span>Security</span>
            </a>
            <a href="system_settings.php" class="nav-item">
                <i class="fas fa-cog"></i>
                <span>System Settings</span>
            </a>
            <a href="monitoring.php" class="nav-item">
                <i class="fas fa-desktop"></i>
                <span>Monitoring</span>
            </a>
    </div>
    <div class="logo-container">
        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Normal-S0ZM46xhJ8Mm0vNUqKXmmqWS9gTvZJ.png" alt="HIP ENERGY Logo" class="logo">
    </div>
</nav>

<main class="main-content">
    <div class="reports-section">
        <h2>3. Reportes Básicos</h2>
        <h3>Visualización de Reportes</h3>
        
        <div class="charts-wrapper">
            <div class="chart-container">
                <canvas id="incomeExpenseChart"></canvas>
            </div>
            
            <div class="chart-container">
                <canvas id="invoiceStatusChart"></canvas>
            </div>
        </div>
        
        <h3>Exportación de Datos</h3>
        <button class="action-btn export-btn" onclick="exportCSV()">Exportar a CSV</button>
        <button class="action-btn export-btn" onclick="exportPDF()">Exportar a PDF</button>
        
        <h3>Visualización de posibles entradas no autorizadas</h3>
        <table class="user-table" id="unauthorizedEntriesTable">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>IP</th>
                    <th>Usuario</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <!-- Unauthorized entries will be dynamically inserted here -->
            </tbody>
        </table>
    </div>
</main>

<button class="logout-btn" onclick="logout()">Admin log out</button>

<script>
    function logout() {
        // Aquí se implementaría la lógica para cerrar sesión
        alert("Sesión cerrada");

        // Redirigir al index.php
        window.location.href = 'index.php';
    }
</script>

<script>
    // Sample data for charts
    const incomeExpenseData = {
        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
        datasets: [{
            label: 'Ingresos',
            data: [1200, 1900, 3000, 5000, 2000, 3000],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }, {
            label: 'Gastos',
            data: [1000, 1700, 2700, 4500, 1800, 2500],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    };

    const invoiceStatusData = {
        labels: ['Pagadas', 'Pendientes'],
        datasets: [{
            data: [300, 50],
            backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
            borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
            borderWidth: 1
        }]
    };

    // Sample data for unauthorized entries
    const unauthorizedEntries = [
        { date: '2023-06-01', ip: '192.168.1.100', user: 'unknown', action: 'Failed login attempt' },
        { date: '2023-06-02', ip: '10.0.0.5', user: 'john_doe', action: 'Unauthorized access attempt' },
        { date: '2023-06-03', ip: '172.16.0.1', user: 'admin', action: 'Suspicious activity detected' }
    ];

    function renderCharts() {
        new Chart(document.getElementById('incomeExpenseChart'), {
            type: 'bar',
            data: incomeExpenseData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(document.getElementById('invoiceStatusChart'), {
            type: 'pie',
            data: invoiceStatusData,
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    function renderUnauthorizedEntries() {
        const tableBody = document.getElementById('unauthorizedEntriesTable').getElementsByTagName('tbody')[0];
        unauthorizedEntries.forEach(entry => {
            const row = tableBody.insertRow();
            row.insertCell(0).textContent = entry.date;
            row.insertCell(1).textContent = entry.ip;
            row.insertCell(2).textContent = entry.user;
            row.insertCell(3).textContent = entry.action;
        });
    }

    function exportCSV() {
        // Implement CSV export logic here
        console.log('Exporting to CSV...');
        alert('CSV export functionality would be implemented here.');
    }

    function exportPDF() {
        // Implement PDF export logic here
        console.log('Exporting to PDF...');
        alert('PDF export functionality would be implemented here.');
    }
    
    // Initialize the charts and tables
    document.addEventListener('DOMContentLoaded', () => {
        renderCharts();
        renderUnauthorizedEntries();
    });
</script>
</body>
</html>