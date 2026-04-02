<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background: #e9e9e9;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 220px;
        height: 100%;
        background: #e5d6c3;
        padding-top: 20px;
        transition: 0.3s;
        z-index: 1000;
    }

    .sidebar.collapsed {
        width: 70px;
    }

    .sidebar a {
        display: flex;
        align-items: center;
        padding: 10px;
        color: #000;
        text-decoration: none;
        font-size: 18px;
        transition: 0.2s;
        border-radius: 8px;
        margin-bottom: 8px;
    }

    .sidebar a:hover {
        background: #cbb79e;
    }

    .menu-text {
        margin-left: 10px;
        white-space: nowrap;
    }

    .sidebar.collapsed .menu-text {
        display: none;
    }

    .profile {
        text-align: center;
        margin-bottom: 20px;
    }
    .profile i {
        font-size: 40px;
        color: #4b2a12;
    }
    .profile .menu-text {
        display: block;
        margin-top: 6px;
    }
    /* Toggle button */
    .toggle-btn {
        position: absolute;
        top: 15px;
        right: -15px;
        background: #4b2a12;
        color: #fff;
        border-radius: 50%;
        padding: 6px 8px;
        cursor: pointer;
    }

    /* ===== CONTENT ===== */
    .content {
        margin-left: 220px;
        padding: 20px;
        transition: 0.3s;
    }

    .content.full {
        margin-left: 70px;
    }

    /* ===== HEADER ===== */
    .header-main {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #4b2a12;
        color: #fff;
        padding: 10px 16px;
        font-weight: bold;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }
    .header-main i {
        font-size: 20px;
    }
    .header-sub {
        background: #efe6db;
        color: #2b1a0c;
        padding: 8px 16px;
        border-bottom: 2px solid #cbb79e;
        margin-bottom: 16px;
        font-weight: 600;
    }

    /* ===== DASHBOARD GRID ===== */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(180px, 1fr));
        gap: 24px;
    }

    .dash-card {
        background: #d8c8b5;
        border-radius: 15px;
        box-shadow: 0 6px 10px rgba(0,0,0,0.15);
        text-align: center;
        overflow: hidden;
        transition: 0.2s;
    }

    .dash-card:hover {
        transform: translateY(-5px);
    }

    .dash-top {
        padding: 24px 16px 12px;
    }

    .dash-top i {
        font-size: 46px;
        color: #000;
    }

    .dash-number {
        font-size: 20px;
        font-weight: bold;
        margin-top: 8px;
    }

    .dash-bottom {
        background: #4b2a12;
        color: #fff;
        padding: 12px;
        font-size: 16px;
        font-weight: bold;
        letter-spacing: 1px;
    }

    /* ===== RESPONSIVE ===== */
    @media(max-width: 992px){
        .dashboard-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width: 768px){
        .sidebar {
            left: -220px;
        }

        .sidebar.show {
            left: 0;
        }

        .content {
            margin-left: 0;
        }
    }

    @media(max-width: 576px){
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="toggle-btn" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </div>
        <div class="profile">
            <i class="bi bi-person-circle"></i>
            <div class="menu-text">
                <strong>{{ $user->name }}</strong><br>
                <small>Admin</small>
            </div>
        </div>
        <a href="/admin">
            <i class="bi bi-grid"></i>
            <span class="menu-text">Dashboard</span>
        </a>
        <a href="/admin/booking">
            <i class="bi bi-book"></i>
            <span class="menu-text">Booking</span>
        </a>
        <a href="/admin/calendar">
            <i class="bi bi-calendar"></i>
            <span class="menu-text">Calendar</span>
        </a>
        <a href="/admin/seats">
            <i class="bi bi-person"></i>
            <span class="menu-text">Seats</span>
        </a>
        <a href="/admin/customers">
            <i class="bi bi-people"></i>
            <span class="menu-text">Customers</span>
        </a>
        <a href="/admin/account">
            <i class="bi bi-person"></i>
            <span class="menu-text">Account</span>
        </a>
        <a href="#">
            <i class="bi bi-journal-text"></i>
            <span class="menu-text">Manual</span>
        </a>
    </div>
    <div class="content" id="content">
        <div class="header-main">
            <i class="bi bi-grid"></i>
            <div>DASHBOARD</div>
        </div>
        <div class="header-sub">ADMIN</div>
        <div class="dashboard-grid">
            <div class="dash-card">
                <div class="dash-top">
                    <i class="bi bi-people-fill"></i>
                    <div class="dash-number">{{ $data['customers'] }}</div>
                </div>
                <div class="dash-bottom">CUSTOMERS</div>
            </div>
            <div class="dash-card">
                <div class="dash-top">
                    <i class="bi bi-book"></i>
                    <div class="dash-number">{{ $data['bookings'] }}</div>
                </div>
                <div class="dash-bottom">BOOKINGS</div>
            </div>
            <div class="dash-card">
                <div class="dash-top">
                    <i class="bi bi-calendar"></i>
                    <div class="dash-number">{{ date('d M Y') }}</div>
                </div>
                <div class="dash-bottom">CALENDAR</div>
            </div>
            <div class="dash-card">
                <div class="dash-top">
                    <i class="bi bi-person"></i>
                    <div class="dash-number">{{ $data['seats'] }}</div>
                </div>
                <div class="dash-bottom">SEATS</div>
            </div>
            <div class="dash-card">
                <div class="dash-top">
                    <i class="bi bi-check-circle-fill"></i>
                    <div class="dash-number">{{ $data['availability'] }}</div>
                </div>
                <div class="dash-bottom">AVAILABILITY</div>
            </div>
            <a href="/admin/account" style="text-decoration:none; color:inherit;">
                <div class="dash-card">
                    <div class="dash-top">
                        <i class="bi bi-person-fill"></i>
                        <div class="dash-number">{{ $user->name }}</div>
                    </div>
                    <div class="dash-bottom">ACCOUNT</div>
                </div>
            </a>
        </div>
    </div>
    <script>
        function toggleSidebar(){
            var sidebar = document.getElementById("sidebar");
            var content = document.getElementById("content");
            sidebar.classList.toggle("collapsed");
            content.classList.toggle("full");
            sidebar.classList.toggle("show");
        }
    </script>
</body>
</html>
