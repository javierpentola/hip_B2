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

    .security-section, .support-section {
        background-color: white;
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .security-section h2, .support-section h2 {
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

    .chat-container {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
    }

    .chat-messages {
        width: 60%;
        height: 400px;
        overflow-y: auto;
        border: 1px solid #ddd;
        padding: 1rem;
    }

    .chat-input {
        width: 100%;
        padding: 0.5rem;
        margin-top: 1rem;
    }

    .notifications {
        width: 35%;
        height: 400px;
        overflow-y: auto;
        border: 1px solid #ddd;
        padding: 1rem;
    }

    .ticket-list {
        margin-top: 2rem;
    }

    .ticket-item {
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
        .map-container, .chat-container {
            flex-direction: column;
        }
        #world-map, .access-list, .chat-messages, .notifications {
            width: 100%;
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
        <a href="#" class="nav-item active">
            <i class="fas fa-headset"></i>
            <span>Support</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-cog"></i>
            <span>System Settings</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-desktop"></i>
            <span>Monitoring</span>
        </a>
    </div>
    <div class="logo-container">
        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Normal-S0ZM46xhJ8Mm0vNUqKXmmqWS9gTvZJ.png" alt="HIP ENERGY Logo" class="logo">
    </div>
</nav>

<main class="main-content">
    <div class="support-section">
        <h2>5. Soporte y Comunicación</h2>
        
        <h3>Sistema de Mensajes</h3>
        <div class="chat-container">
            <div class="chat-messages" id="chatMessages">
                <!-- Chat messages will be dynamically inserted here -->
            </div>
            <div class="notifications" id="notifications">
                <h4>Notificaciones</h4>
                <!-- Notifications will be dynamically inserted here -->
            </div>
        </div>
        <input type="text" class="chat-input" id="chatInput" placeholder="Escribe un mensaje...">
        <button class="action-btn" onclick="sendMessage()">Enviar</button>
        <button class="action-btn" onclick="sendNotification()">Enviar Notificación</button>

        <h3>Gestión de Tickets</h3>
        <div class="ticket-list" id="ticketList">
            <!-- Ticket entries will be dynamically inserted here -->
        </div>
        <button class="action-btn" onclick="createTicket()">Crear Nuevo Ticket</button>
    </div>
</main>

<button class="logout-btn" onclick="logout()">Admin log out</button>

<script>
    // Sample data for chat messages
    const chatMessages = [
        { sender: "Admin", message: "Bienvenido al sistema de soporte. ¿En qué puedo ayudarte?" },
        { sender: "Cliente", message: "Hola, tengo una pregunta sobre mi factura." },
        { sender: "Admin", message: "Por supuesto, ¿qué necesitas saber sobre tu factura?" }
    ];

    // Sample data for notifications
    const notifications = [
        { id: 1, message: "Actualización del sistema programada para mañana." },
        { id: 2, message: "Nuevo cliente registrado: Empresa XYZ." },
        { id: 3, message: "Alerta: Alto consumo detectado en el sector 3." }
    ];

    // Sample data for tickets
    const tickets = [
        { id: 1, title: "Problema de conexión", status: "Abierto", priority: "Alta" },
        { id: 2, title: "Solicitud de información", status: "En progreso", priority: "Media" },
        { id: 3, title: "Actualización de datos", status: "Cerrado", priority: "Baja" }
    ];

    function renderChatMessages() {
        const chatMessagesDiv = document.getElementById('chatMessages');
        chatMessagesDiv.innerHTML = '';
        chatMessages.forEach(msg => {
            const messageDiv = `
                <div class="chat-message">
                    <strong>${msg.sender}:</strong> ${msg.message}
                </div>
            `;
            chatMessagesDiv.innerHTML += messageDiv;
        });
        chatMessagesDiv.scrollTop = chatMessagesDiv.scrollHeight;
    }

    function renderNotifications() {
        const notificationsDiv = document.getElementById('notifications');
        notificationsDiv.innerHTML = '<h4>Notificaciones</h4>';
        notifications.forEach(notif => {
            const notificationDiv = `
                <div class="notification-item">
                    ${notif.message}
                    <button class="action-btn" onclick="deleteNotification(${notif.id})">Eliminar</button>
                </div>
            `;
            notificationsDiv.innerHTML += notificationDiv;
        });
    }

    function renderTickets() {
        const ticketListDiv = document.getElementById('ticketList');
        ticketListDiv.innerHTML = '';
        tickets.forEach(ticket => {
            const ticketDiv = `
                <div class="ticket-item">
                    <span>${ticket.title}</span>
                    <span>Status: ${ticket.status}</span>
                    <span>Priority: ${ticket.priority}</span>
                    <button class="action-btn" onclick="updateTicket(${ticket.id})">Actualizar</button>
                </div>
            `;
            ticketListDiv.innerHTML += ticketDiv;
        });
    }

    function sendMessage() {
        const chatInput = document.getElementById('chatInput');
        const message = chatInput.value.trim();
        if (message) {
            chatMessages.push({ sender: "Admin", message: message });
            renderChatMessages();
            chatInput.value = '';
        }
    }

    function sendNotification() {
        const message = prompt("Ingrese el mensaje de notificación:");
        if (message) {
            const newId = notifications.length + 1;
            notifications.push({ id: newId, message: message });
            renderNotifications();
        }
    }

    function deleteNotification(id) {
        const index = notifications.findIndex(notif => notif.id === id);
        if (index !== -1) {
            notifications.splice(index, 1);
            renderNotifications();
        }
    }

    function createTicket() {
        const title = prompt("Ingrese el título del ticket:");
        if (title) {
            const newId = tickets.length + 1;
            tickets.push({ id: newId, title: title, status: "Abierto", priority: "Media" });
            renderTickets();
        }
    }

    function updateTicket(id) {
        const ticket = tickets.find(t => t.id === id);
        if (ticket) {
            const newStatus = prompt("Ingrese el nuevo estado del ticket:", ticket.status);
            const newPriority = prompt("Ingrese la nueva prioridad del ticket:", ticket.priority);
            if (newStatus) ticket.status = newStatus;
            if (newPriority) ticket.priority = newPriority;
            renderTickets();
        }
    }

    function logout() {
        // Implementar lógica de cierre de sesión aquí
        alert("Admin ha cerrado sesión");
    }

    // Inicializar la página
    $(document).ready(function() {
        renderChatMessages();
        renderNotifications();
        renderTickets();
    });
</script>
</body>
</html>