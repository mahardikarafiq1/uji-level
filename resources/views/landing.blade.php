<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seats</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#e9e9e9; font-family: Arial, sans-serif; margin:0; }
        .sidebar { position:fixed; top:0; left:0; width:220px; height:100%; background:#e5d6c3; padding:20px 10px; border-right:1px solid #cbb79e; z-index:1000; }
        .sidebar a { display:flex; align-items:center; padding:10px; color:#000; text-decoration:none; border-radius:8px; margin-bottom:8px; }
        .sidebar a:hover { background:#d8c8b5; }
        .menu-text { margin-left:10px; }
        .toggle-btn { position:absolute; top:10px; right:-15px; background:#4b2a12; color:#fff; border-radius:50%; padding:5px 8px; cursor:pointer; }
        .profile { text-align:center; margin-bottom:20px; }
        .profile i { font-size:40px; color:#4b2a12; }
        .sidebar.collapsed { width:70px; }
        .sidebar.collapsed .menu-text { display:none; }
        .content { margin-left:220px; transition:0.3s; }
        .content.full { margin-left:70px; }
        .header-main { display:flex; align-items:center; gap:10px; background:#4b2a12; color:#fff; padding:10px 16px; font-weight:bold; letter-spacing:1px; justify-content:center; }
        .box { max-width:960px; margin:24px auto; background:#efe4d7; padding:24px; border:4px solid #000; border-radius:22px; }
        .time-select { display:flex; justify-content:center; margin-bottom:12px; }
        .btn-coffee { background:#4b2a12; color:#fff; border:none; border-radius:12px; padding:8px 12px; font-weight:700; }
        .btn-coffee:hover { background:#6b3b1a; }
        .table-seats { width:100%; }
        .table-seats th, .table-seats td { padding:12px; }
        .status-btn { background:#2e8b57; color:#fff; border:none; border-radius:10px; padding:8px 12px; font-weight:700; }
        .status-btn.reserved { background:#0c6b45; }
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
        <div class="header-main"><i class="bi bi-person-lines-fill"></i> SEATS</div>
        <div class="time-select">
            <form method="GET" action="/admin/seats">
                <input type="date" name="date" value="{{ $date }}" class="btn-coffee" onchange="this.form.submit()">
                <select name="time" class="btn-coffee" onchange="this.form.submit()">
                    @foreach($times as $t)
                        <option value="{{ $t }}" @if($t==$time) selected @endif>{{ $t }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="box">
            <div style="font-weight:800; font-size:20px;">SEATS</div>
            <div style="margin-bottom:12px;">AVAILABLE SEATS</div>
            <table class="table-seats">
                <thead>
                    <tr>
                        <th style="width:35%;">SEAT ID (PERSON)</th>
                        <th style="width:25%;">POSITION</th>
                        <th style="width:25%;">RESERVED BY</th>
                        <th style="width:15%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seats as $s)
                        <tr>
                            <td style="font-weight:700;">{{ $s->seat_code }} ({{ $s->capacity }} PERSON)</td>
                            <td style="text-transform:uppercase;">{{ $s->position }}</td>
                            <td>{{ $s->reserved_by ? strtoupper($s->reserved_by) : '' }}</td>
                            <td>
                                <form method="POST" action="/admin/seats/toggle">
                                    @csrf
                                    <input type="hidden" name="seat_code" value="{{ $s->seat_code }}">
                                    <input type="hidden" name="date" value="{{ $date }}">
                                    <input type="hidden" name="time" value="{{ $time }}">
                                    <button type="submit" class="status-btn {{ $s->status === 'reserved' ? 'reserved' : '' }}">
                                        {{ ucfirst($s->status) }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
