<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manual</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#fff; font-family: Arial, sans-serif; margin:0; }
        .sidebar { position:fixed; top:0; left:0; width:230px; height:100%; background:#e5d6c3; padding:20px 10px; border-right:1px solid #cbb79e; transition:0.3s; z-index:1000; }
        .sidebar.collapsed { width:70px; }
        .sidebar .menu-text { margin-left:10px; }
        .sidebar.collapsed .menu-text { display:none; }
        .profile { text-align:center; margin-bottom:25px; }
        .profile i { font-size:40px; color:#4b2a12; }
        .sidebar a { display:flex; align-items:center; padding:10px; color:#000; text-decoration:none; border-radius:8px; margin-bottom:8px; }
        .sidebar a:hover { background:#d8c8b5; }
        .toggle-btn { position:absolute; top:10px; right:-15px; background:#4b2a12; color:#fff; border-radius:50%; padding:5px 8px; cursor:pointer; }
        .content { margin-left:230px; transition:0.3s; }
        .content.full { margin-left:70px; }
        .top-header { background:#4b2a12; color:#fff; padding:12px; text-align:center; font-weight:bold; letter-spacing:1px; }
        .topic-select { display:flex; justify-content:center; margin-top:16px; }
        .select-btn { background:#4b2a12; color:#fff; border:none; border-radius:12px; padding:10px 18px; font-weight:800; }
        .manual-box { max-width:960px; margin:20px auto; background:#efe4d7; border:4px solid #000; border-radius:22px; padding:18px; height:480px; overflow-y:auto; }
        .manual-title { font-weight:800; font-size:24px; }
        .manual-sub { color:#555; font-weight:700; margin-top:2px; }
        .manual-section h5 { font-weight:800; margin-top:14px; }
        .manual-section p { margin-bottom:8px; }
        .btn-coffee { background:#4b2a12; color:#fff; border:none; border-radius:12px; padding:10px 16px; font-weight:800; display:inline-flex; align-items:center; gap:8px; }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></div>
        <div class="profile">
            <i class="bi bi-person-circle"></i>
            <div class="menu-text"><strong>{{ $user->name }}</strong><br><small>Admin</small></div>
        </div>
        <a href="/admin"><i class="bi bi-grid"></i><span class="menu-text">Dashboard</span></a>
        <a href="/admin/booking"><i class="bi bi-book"></i><span class="menu-text">Booking</span></a>
        <a href="/admin/calendar"><i class="bi bi-calendar"></i><span class="menu-text">Calendar</span></a>
        <a href="/admin/seats"><i class="bi bi-person"></i><span class="menu-text">Seats</span></a>
        <a href="/admin/customers"><i class="bi bi-people"></i><span class="menu-text">Customer list</span></a>
        <a href="/admin/manual"><i class="bi bi-journal-text"></i><span class="menu-text">Manual</span></a>
    </div>
    <div class="content" id="content">
        <div class="top-header"><i class="bi bi-journal-text"></i> MANUAL</div>
        <div class="topic-select">
            <form method="GET" action="/admin/manual">
                <select name="topic" class="select-btn" onchange="this.form.submit()">
                    @foreach($topics as $key => $label)
                        <option value="{{ $key }}" @if($key===$topic) selected @endif>{{ $label }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="manual-box">
            <div class="manual-title">MANUAL</div>
            <div class="manual-sub">HOW TO USE THIS SYSTEM</div>
            <hr>
            @if($topic==='dashboard')
            <div class="manual-section">
                <p>Welcome to the Dashboard User Manual. This document provides you with essential information to navigate and utilize the dashboard effectively. The dashboard is a powerful tool designed to provide you with insights and control over your business. It displays critical statistics and allows you to manage date and account settings.</p>
                <h5>Number of Customers</h5>
                <p>This section shows the current total number of customers using your services. It helps you track your customer base and monitor its growth.</p>
                <h5>Number of Bookings</h5>
                <p>Here, you can see the total number of bookings made within a specified time frame. This metric helps you analyze booking trends and assess your business's performance.</p>
                <h5>Availability Status</h5>
                <p>The availability status section indicates the current availability of your services. It can include information on whether your services are fully booked, partially booked, or available.</p>
            </div>
            @elseif($topic==='booking')
            <div class="manual-section">
                <p>The Booking page allows you to create and retrieve customer bookings. Fill in the required fields and save to store the booking. Use the retrieve function to load existing bookings using phone number.</p>
                <h5>Customer Name</h5>
                <p>Enter the customer's full name in the specified format.</p>
                <h5>Phone Number</h5>
                <p>Provide a valid phone number; it is used for retrieval.</p>
                <h5>Date & Time</h5>
                <p>Select the desired date and time for the reservation.</p>
                <h5>Seats</h5>
                <p>Specify the number of seats required. Use the bottom menu to navigate to Customer List, Availability, Seats, or Back.</p>
            </div>
            @elseif($topic==='calendar')
            <div class="manual-section">
                <p>The Calendar provides a monthly overview with booking counts per day. Use the arrows or dropdown to change months, and click a date to view details.</p>
                <h5>Month and Year</h5>
                <p>Navigate between months and years to see bookings.</p>
                <h5>Daily Counts</h5>
                <p>Each date displays the number of bookings registered.</p>
            </div>
            @elseif($topic==='seats')
            <div class="manual-section">
                <p>The Seats page shows seat availability per date and time. Toggle the status to mark a seat as Reserved or Available.</p>
                <h5>Date & Time Filters</h5>
                <p>Choose the date and time from the controls above to load seats.</p>
                <h5>Status Toggle</h5>
                <p>Use the status button to change the seat state. Reserved By will show the booking name if available.</p>
            </div>
            @elseif($topic==='customers')
            <div class="manual-section">
                <p>The Customer List displays all registered customers. Use search and filters to find entries and review booking history.</p>
                <h5>Search</h5>
                <p>Type keywords to filter by name or phone.</p>
                <h5>Details</h5>
                <p>Open a customer to view bookings and actions.</p>
            </div>
            @elseif($topic==='account')
            <div class="manual-section">
                <p>Account Settings lets you update your profile information such as name, position, admin ID, email address, and password.</p>
                <h5>Save Changes</h5>
                <p>Click Save to store updates, or Back to return.</p>
            </div>
            @endif
        </div>
        <div class="text-center" style="margin:14px 0 24px;">
            <a href="/admin" class="btn btn-coffee"><i class="bi bi-arrow-left"></i> BACK</a>
        </div>
    </div>
    <script>
        function toggleSidebar(){
            var sidebar = document.getElementById("sidebar");
            var content = document.getElementById("content");
            sidebar.classList.toggle("collapsed");
            content.classList.toggle("full");
        }
    </script>
</body>
</html>
