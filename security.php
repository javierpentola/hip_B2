<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HIP ENERGY Navigation - Admin Panel</title>
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jvectormap/2.0.5/jquery-jvectormap.min.css" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jvectormap/2.0.5/jquery-jvectormap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jvectormap/2.0.5/jquery-jvectormap-world-mill.min.js"></script>
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

    .security-section {
        background-color: white;
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .security-section h2 {
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

    .map-container {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
    }

    #world-map {
        width: 60%;
        height: 400px;
    }

    .access-list {
        width: 35%;
        max-height: 400px;
        overflow-y: auto;
    }

    .access-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem;
        border-bottom: 1px solid #ddd;
    }

    .roles-menu {
        margin-top: 2rem;
    }

    .role-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem;
        border-bottom: 1px solid #ddd;
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
        .map-container {
            flex-direction: column;
        }
        #world-map, .access-list {
            width: 100%;
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
            <a href="reports.php" class="nav-item">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </a>
            <a href="security.php" class="nav-item active">
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
    <div class="security-section">
        <h2>4. Seguridad y Control de Acceso</h2>
        
        <h3>Autenticación Segura</h3>
        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Usuario</th>
                    <th>Última Conexión</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="adminTableBody">
                <!-- Admin entries will be dynamically inserted here -->
            </tbody>
        </table>

        <h3>Roles Básicos</h3>
        <div class="roles-menu" id="rolesMenu">
            <!-- Role entries will be dynamically inserted here -->
        </div>

        <h3>Accesos no autorizados</h3>
        <div class="map-container">
            <div id="world-map"></div>
            <div class="access-list" id="accessList">
                <!-- Access entries will be dynamically inserted here -->
            </div>
        </div>
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
    // Sample data for admins
    const admins = [
        { id: 1, username: "admin1", lastLogin: "2023-06-10 14:30", status: "Activo" },
        { id: 2, username: "admin2", lastLogin: "2023-06-09 09:15", status: "Activo" },
        { id: 3, username: "admin3", lastLogin: "2023-06-08 18:45", status: "Inactivo" }
    ];

    // Sample data for roles
    const roles = [
        { id: 1, name: "Admin Superior", permissions: "Acceso total" },
        { id: 2, name: "Admin Medio", permissions: "Acceso parcial" },
        { id: 3, name: "Admin Bajo", permissions: "Acceso limitado" }
    ];

    // Sample data for access attempts
    const accessAttempts = [
        { id: 1, country: "Spain", countryCode: "ES", ip: "192.168.1.100", timestamp: "2023-06-10 15:30" },
        { id: 2, country: "United States", countryCode: "US", ip: "10.0.0.5", timestamp: "2023-06-10 16:45" },
        { id: 3, country: "China", countryCode: "CN", ip: "172.16.0.1", timestamp: "2023-06-10 17:20" }
    ];

    function renderAdmins() {
        const tableBody = document.getElementById('adminTableBody');
        tableBody.innerHTML = '';
        admins.forEach(admin => {
            const row = `
                <tr>
                    <td>${admin.id}</td>
                    <td>${admin.username}</td>
                    <td>${admin.lastLogin}</td>
                    <td>${admin.status}</td>
                    <td>
                        <button class="action-btn" onclick="blockAdmin(${admin.id})">Bloquear</button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    }

    function renderRoles() {
        const rolesMenu = document.getElementById('rolesMenu');
        rolesMenu.innerHTML = '';
        roles.forEach(role => {
            const roleItem = `
                <div class="role-item">
                    <span>${role.name}</span>
                    <span>${role.permissions}</span>
                    <button class="action-btn" onclick="editRole(${role.id})">Editar</button>
                </div>
            `;
            rolesMenu.innerHTML += roleItem;
        });
    }

    function renderAccessAttempts() {
        const accessList = document.getElementById('accessList');
        accessList.innerHTML = '';
        accessAttempts.forEach(attempt => {
            const accessItem = `
                <div class="access-item">
                    <span>${attempt.country} (${attempt.ip})</span>
                    <span>${attempt.timestamp}</span>
                    <button class="action-btn" onclick="blockIP('${attempt.ip}')">Bloquear IP</button>
                </div>
            `;
            accessList.innerHTML += accessItem;
        });
    }

    function initMap() {
        $('#world-map').vectorMap({
            map: 'world_mill',
            backgroundColor: '#fff',
            zoomOnScroll: false,
            series: {
                regions: [{
                    values: accessAttempts.reduce((acc, attempt) => {
                        acc[attempt.countryCode] = (acc[attempt.countryCode] || 0) + 1;
                        return acc;
                    }, {}),
                    scale: ['#C8EEFF', '#0071A4'],
                    normalizeFunction: 'polynomial'
                }]
            },
            onRegionTipShow: function(e, el, code) {
                const attempts = accessAttempts.filter(attempt => attempt.countryCode === code);
                if (attempts.length > 0) {
                    el.html(el.html() + ': ' + attempts.length + ' acceso(s)');
                }
            }
        });
    }

    function blockAdmin(id) {
        console.log(`Bloqueando admin con ID: ${id}`);
        alert(`Admin con ID ${id} ha sido bloqueado.`);
        // Aquí iría la lógica real para bloquear al admin
    }

    function editRole(id) {
        console.log(`Editando rol con ID: ${id}`);
        alert(`Editando rol con ID ${id}.`);
        // Aquí iría la lógica real para editar el rol
    }

    function blockIP(ip) {
        console.log(`Bloqueando IP: ${ip}`);
        alert(`IP ${ip} ha sido bloqueada.`);
        // Aquí iría la lógica real para bloquear la IP
    }

    // Inicializar la página
    $(document).ready(function() {
        renderAdmins();
        renderRoles();
        renderAccessAttempts();
        initMap();
    });
</script>
</body>
</html>