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

        .management-section {
            background-color: white;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .management-section h2 {
            margin-top: 0;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .data-table th, .data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .data-table th {
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

        .add-form {
            margin-top: 1rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .add-form input, .add-form select {
            flex: 1;
            min-width: 200px;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .tab-container {
            display: flex;
            margin-bottom: 1rem;
        }

        .tab {
            padding: 0.5rem 1rem;
            background-color: #f1f1f1;
            border: 1px solid #ddd;
            cursor: pointer;
        }

        .tab.active {
            background-color: var(--primary-color);
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
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
            <a href="#" class="nav-item active">
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
        <div class="management-section">
            <h2>2. Gestión de Facturas y Gastos</h2>
            <div class="tab-container">
                <div class="tab active" onclick="showTab('invoices')">Facturas</div>
                <div class="tab" onclick="showTab('expenses')">Gastos</div>
            </div>
            <div id="invoices" class="tab-content active">
                <h3>Administración de Facturas</h3>
                <table class="data-table" id="invoiceTable">
                    <thead>
                        <tr>
                            <th>ID Factura</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="invoiceTableBody">
                        <!-- Invoice data will be dynamically inserted here -->
                    </tbody>
                </table>
                <h4>Añadir Nueva Factura</h4>
                <form id="addInvoiceForm" class="add-form">
                    <input type="text" id="invoiceClient" placeholder="Cliente" required>
                    <input type="date" id="invoiceDate" required>
                    <input type="number" id="invoiceAmount" placeholder="Monto" step="0.01" required>
                    <select id="invoiceStatus" required>
                        <option value="">Seleccionar Estado</option>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Pagada">Pagada</option>
                        <option value="Vencida">Vencida</option>
                    </select>
                    <button type="submit" class="action-btn">Añadir Factura</button>
                </form>
            </div>
            <div id="expenses" class="tab-content">
                <h3>Administración de Gastos</h3>
                <table class="data-table" id="expenseTable">
                    <thead>
                        <tr>
                            <th>ID Gasto</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="expenseTableBody">
                        <!-- Expense data will be dynamically inserted here -->
                    </tbody>
                </table>
                <h4>Añadir Nuevo Gasto</h4>
                <form id="addExpenseForm" class="add-form">
                    <input type="text" id="expenseDescription" placeholder="Descripción" required>
                    <input type="date" id="expenseDate" required>
                    <input type="number" id="expenseAmount" placeholder="Monto" step="0.01" required>
                    <select id="expenseCategory" required>
                        <option value="">Seleccionar Categoría</option>
                        <option value="Operativo">Operativo</option>
                        <option value="Administrativo">Administrativo</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Otro">Otro</option>
                    </select>
                    <button type="submit" class="action-btn">Añadir Gasto</button>
                </form>
            </div>
        </div>
    </main>

    <button class="logout-btn" onclick="logout()">Admin log out</button>

    <script>
        // Sample data
        let invoices = [
            { id: 1, client: "Empresa A", date: "2023-07-01", amount: 1000.00, status: "Pendiente" },
            { id: 2, client: "Empresa B", date: "2023-07-05", amount: 1500.50, status: "Pagada" }
        ];

        let expenses = [
            { id: 1, description: "Suministros de oficina", date: "2023-07-02", amount: 200.00, category: "Operativo" },
            { id: 2, description: "Publicidad en redes sociales", date: "2023-07-06", amount: 500.00, category: "Marketing" }
        ];

        function renderInvoices() {
            const tableBody = document.getElementById('invoiceTableBody');
            tableBody.innerHTML = '';
            invoices.forEach(invoice => {
                const row = `
                    <tr>
                        <td>${invoice.id}</td>
                        <td>${invoice.client}</td>
                        <td>${invoice.date}</td>
                        <td>$${invoice.amount.toFixed(2)}</td>
                        <td>${invoice.status}</td>
                        <td>
                            <button class="action-btn" onclick="editInvoice(${invoice.id})">Editar</button>
                            <button class="action-btn" onclick="deleteInvoice(${invoice.id})">Eliminar</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        }

        function renderExpenses() {
            const tableBody = document.getElementById('expenseTableBody');
            tableBody.innerHTML = '';
            expenses.forEach(expense => {
                const row = `
                    <tr>
                        <td>${expense.id}</td>
                        <td>${expense.description}</td><td>${expense.description}</td>
                        <td>${expense.date}</td>
                        <td>$${expense.amount.toFixed(2)}</td>
                        <td>${expense.category}</td>
                        <td>
                            <button class="action-btn" onclick="editExpense(${expense.id})">Editar</button>
                            <button class="action-btn" onclick="deleteExpense(${expense.id})">Eliminar</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        }

        function addInvoice(event) {
            event.preventDefault();
            const newInvoice = {
                id: invoices.length + 1,
                client: document.getElementById('invoiceClient').value,
                date: document.getElementById('invoiceDate').value,
                amount: parseFloat(document.getElementById('invoiceAmount').value),
                status: document.getElementById('invoiceStatus').value
            };
            invoices.push(newInvoice);
            renderInvoices();
            document.getElementById('addInvoiceForm').reset();
        }

        function addExpense(event) {
            event.preventDefault();
            const newExpense = {
                id: expenses.length + 1,
                description: document.getElementById('expenseDescription').value,
                date: document.getElementById('expenseDate').value,
                amount: parseFloat(document.getElementById('expenseAmount').value),
                category: document.getElementById('expenseCategory').value
            };
            expenses.push(newExpense);
            renderExpenses();
            document.getElementById('addExpenseForm').reset();
        }

        function editInvoice(id) {
            const invoice = invoices.find(inv => inv.id === id);
            if (invoice) {
                // Here you would typically open a modal or form to edit the invoice
                console.log('Editing invoice:', invoice);
            }
        }

        function deleteInvoice(id) {
            invoices = invoices.filter(inv => inv.id !== id);
            renderInvoices();
        }

        function editExpense(id) {
            const expense = expenses.find(exp => exp.id === id);
            if (expense) {
                // Here you would typically open a modal or form to edit the expense
                console.log('Editing expense:', expense);
            }
        }

        function deleteExpense(id) {
            expenses = expenses.filter(exp => exp.id !== id);
            renderExpenses();
        }

        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            document.getElementById(tabName).classList.add('active');
            event.target.classList.add('active');
        }

        function logout() {
            // Implement logout logic here
            alert("Admin logged out");
        }

        // Initialize the tables and forms
        document.addEventListener('DOMContentLoaded', () => {
            renderInvoices();
            renderExpenses();
            document.getElementById('addInvoiceForm').addEventListener('submit', addInvoice);
            document.getElementById('addExpenseForm').addEventListener('submit', addExpense);
        });
    </script>
</body>
</html>