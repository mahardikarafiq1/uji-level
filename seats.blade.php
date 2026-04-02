<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calendar</title>
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
        .sidebar.collapsed { width:70px; }
        .sidebar.collapsed .menu-text { display:none; }
        .profile { text-align:center; margin-bottom:20px; }
        .profile i { font-size:40px; color:#4b2a12; }
        .content { margin-left:220px; transition:0.3s; }
        .content.full { margin-left:70px; }
        .header-main { display:flex; align-items:center; gap:10px; background:#4b2a12; color:#fff; padding:10px 16px; font-weight:bold; letter-spacing:1px; justify-content:center; }
        .calendar-box { max-width:720px; margin:24px auto; background:#d8c8b5; padding:24px; border:4px solid #000; border-radius:22px; }
        .month-select { display:flex; justify-content:center; margin-bottom:12px; }
        .btn-coffee { background:#4b2a12; color:#fff; border:none; border-radius:12px; padding:8px 12px; font-weight:700; }
        .btn-coffee:hover { background:#6b3b1a; }
        .grid { display:grid; grid-template-columns: repeat(7, 1fr); gap:8px; }
        .day-head { text-align:center; font-weight:700; }
        .cell { text-align:center; padding:8px 0; border-radius:8px; cursor:pointer; }
        .cell .num { display:inline-block; min-width:24px; }
        .cell.booked .num { font-weight:800; }
        .cell.selected { background:#4b2a12; color:#fff; }
        .actions { display:flex; justify-content:flex-end; margin-top:16px; }
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
        <a href="#"><i class="bi bi-person"></i><span class="menu-text">Seats</span></a>
        <a href="/admin/customers"><i class="bi bi-people"></i><span class="menu-text">Customer list</span></a>
        <a href="#"><i class="bi bi-journal-text"></i><span class="menu-text">Manual</span></a>
    </div>
    <div class="content" id="content">
        <div class="header-main"><i class="bi bi-calendar3"></i> CALENDAR</div>
        <div class="calendar-box">
            <div class="month-select">
                <form method="GET" action="/admin/calendar">
                    <select name="month" class="btn-coffee" onchange="this.form.submit()">
                        @for($m=1; $m<=12; $m++)
                            <option value="{{ $m }}" @if($m==$month) selected @endif>{{ date('F', mktime(0,0,0,$m,1,$year)) }}</option>
                        @endfor
                    </select>
                </form>
            </div>
            <div class="grid">
                @php
                    $days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
                @endphp
                @foreach($days as $d)
                    <div class="day-head">{{ $d }}</div>
                @endforeach
                @for($i=1; $i<$startWeekday; $i++)
                    <div></div>
                @endfor
                @for($day=1; $day<=$daysInMonth; $day++)
                    @php
                        $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
                        $isBooked = array_key_exists($dateStr, $bookings);
                    @endphp
                    <div class="cell {{ $isBooked ? 'booked' : '' }}" data-date="{{ $dateStr }}">
                        <span class="num">{{ $day }}</span>
                    </div>
                @endfor
            </div>
            <div class="actions">
                <a href="/admin" class="btn-coffee"><i class="bi bi-arrow-left"></i> BACK</a>
            </div>
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
        // click day to select
        document.addEventListener('DOMContentLoaded', function(){
            var cells = document.querySelectorAll('.cell[data-date]');
            cells.forEach(function(c){
                c.addEventListener('click', function(){
                    document.querySelectorAll('.cell.selected').forEach(function(s){ s.classList.remove('selected'); });
                    this.classList.add('selected');
                });
            });
        });
    </script>
</body>
</html>
