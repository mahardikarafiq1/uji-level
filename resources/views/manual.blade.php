<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        background: #fff;
        font-family: Arial, sans-serif;
        margin: 0;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 230px;
        height: 100%;
        background: #e5d6c3;
        padding: 20px 10px;
        border-right: 1px solid #cbb79e;
        transition: 0.3s;
        z-index: 1000;
    }

    .sidebar.collapsed {
        width: 70px;
    }

    .sidebar .menu-text {
        margin-left: 10px;
    }

    .sidebar.collapsed .menu-text {
        display: none;
    }

    .profile {
        text-align: center;
        margin-bottom: 25px;
    }

    .profile i {
        font-size: 40px;
        color: #4b2a12;
    }

    .sidebar a {
        display: flex;
        align-items: center;
        padding: 10px;
        color: #000;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 8px;
    }

    .sidebar a:hover {
        background: #d8c8b5;
    }

    .toggle-btn {
        position: absolute;
        top: 10px;
        right: -15px;
        background: #4b2a12;
        color: #fff;
        border-radius: 50%;
        padding: 5px 8px;
        cursor: pointer;
    }

    /* ===== CONTENT ===== */
    .content {
        margin-left: 230px;
        transition: 0.3s;
    }

    .content.full {
        margin-left: 70px;
    }

    .top-header {
        background: #4b2a12;
        color: #fff;
        padding: 12px;
        text-align: center;
        font-weight: bold;
        letter-spacing: 1px;
    }

    /* ===== BOOKING BOX DIPERBESAR ===== */
    .booking-container {
        max-width: 640px;
        margin: 28px auto;
        background: #d8c8b5;
        padding: 28px;
        border: 4px solid #000;
        border-radius: 22px;
    }

    h2 {
        font-weight: 800;
        margin-bottom: 18px;
        text-align: center;
        letter-spacing: 1px;
    }

    .form-control {
        border-radius: 12px;
        background: #eee;
        border: none;
        padding: 12px 14px;
        font-size: 14px;
    }

    .btn-coffee {
        background: #4b2a12;
        color: #fff;
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: bold;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }

    .btn-coffee:hover {
        background: #6b3b1a;
        color: white;
    }

    /* ===== SAVE & RETRIEVE SEJAJAR ===== */
    .action-buttons {
        margin-top: 18px;
        display: flex;
        gap: 16px;
        justify-content: center;
    }
    .action-buttons .btn-coffee {
        flex: 1;
        max-width: 180px;
        justify-content: center;
    }

    /* ===== BUTTON BAWAH RAPI 2 KOLOM ===== */
    .bottom-menu {
        margin-top: 30px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        align-items: stretch;
    }

    .bottom-menu .btn {
        width: 100%;
        text-align: center;
        padding: 8px 12px;
        font-size: 14px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .bottom-menu .btn i {
        font-size: 16px;
    }

    .alert-custom {
        background: #fff;
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 15px;
    }
 </style>

</head>
<body>

<!-- ===== SIDEBAR ===== -->

<div class="sidebar" id="sidebar">
    <div class="toggle-btn" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>

<div class="profile">
    <i class="bi bi-person-circle"></i>
    <div class="menu-text">
        <strong>username</strong><br>
        <small>Admin</small>
    </div>
</div>

<a href="/admin">
    <i class="bi bi-grid"></i>
    <span class="menu-text">Dashboard</span>
</a>

<a href="/admin/calendar">
    <i class="bi bi-calendar"></i>
    <span class="menu-text">Calendar</span>
</a>

<a href="/admin/booking">
    <i class="bi bi-book"></i>
    <span class="menu-text">Booking</span>
</a>

<a href="/admin/seats">
    <i class="bi bi-person"></i>
    <span class="menu-text">Seats</span>
</a>

<a href="/admin/customers">
    <i class="bi bi-people"></i>
    <span class="menu-text">Customer list</span>
</a>

<a href="/admin/manual">
    <i class="bi bi-journal-text"></i>
    <span class="menu-text">Manual</span>
</a>

</div>

<!-- ===== CONTENT ===== -->

<div class="content" id="content">

<div class="top-header">
    <i class="bi bi-book"></i> BOOKINGS
</div>

<div class="booking-container">

    <h2>BOOKING FILL UP FORM</h2>

    @if(session('success'))
        <div class="alert-custom">
            <i class="bi bi-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-custom">
            <i class="bi bi-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- FORM SAVE -->
    <form action="/admin/booking" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Customer Name</label>
            <input type="text" class="form-control" name="name"
                   placeholder="FN-MN(optional)-SN"
                   value="{{ $booking->name ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" class="form-control" name="phone"
                   placeholder="000-000-0000"
                   value="{{ $booking->phone ?? '' }}" required>
        </div>

        <input type="hidden" name="datetime" id="datetimeCombined">
        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" class="form-control" id="dateOnly"
                   value="{{ isset($booking->datetime) ? date('Y-m-d', strtotime($booking->datetime)) : '' }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Time</label>
            <input type="time" class="form-control" id="timeOnly"
                   value="{{ isset($booking->datetime) ? date('H:i', strtotime($booking->datetime)) : '' }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Seats (person)</label>
            <input type="number" class="form-control" name="seats"
                   value="{{ $booking->seats ?? '' }}" required>
        </div>

        <!-- SAVE & RETRIEVE SEJAJAR -->
        <div class="action-buttons">
            <button type="submit" class="btn btn-coffee" onclick="composeDateTime()">
                <i class="bi bi-save"></i> SAVE
            </button>

            <button type="submit" form="retrieveForm" class="btn btn-coffee">
                <i class="bi bi-clock-history"></i> RETRIEVE
            </button>
        </div>
    </form>

    <!-- RETRIEVE FORM -->
    <form action="/admin/booking/retrieve" method="POST" id="retrieveForm">
        @csrf
        <input type="hidden" name="phone" id="retrievePhone">
    </form>

    <!-- BUTTON BAWAH RAPI -->
    <div class="bottom-menu">
        <a href="/admin/customers" class="btn btn-coffee">
            <i class="bi bi-people"></i> CUSTOMER LIST
        </a>

        <a href="#" class="btn btn-coffee">
            <i class="bi bi-calendar-check"></i> AVAILABILITY
        </a>

        <a href="#" class="btn btn-coffee">
            <i class="bi bi-person"></i> SEATS
        </a>

        <a href="/admin" class="btn btn-coffee">
            <i class="bi bi-arrow-left"></i> BACK
        </a>
    </div>

</div>

</div>

<script>
function setPhone(){
    var phone = document.querySelector('input[name="phone"]').value;
    document.getElementById('retrievePhone').value = phone;
}

function composeDateTime(){
    var d = document.getElementById('dateOnly').value;
    var t = document.getElementById('timeOnly').value;
    if(d && t){
        document.getElementById('datetimeCombined').value = d + 'T' + t;
    }
}

function toggleSidebar(){
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("content").classList.toggle("full");
}
</script>

</body>
</html>
