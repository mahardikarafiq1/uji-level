<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Settings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #e9e9e9;
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            height: 100%;
            background: #e5d6c3;
            padding: 20px 10px;
            border-right: 1px solid #cbb79e;
            transition: 0.3s;
            z-index: 1000;
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
        .sidebar a:hover { background: #d8c8b5; }
        .menu-text { margin-left: 10px; }
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
        .profile { text-align: center; margin-bottom: 20px; }
        .profile i { font-size: 40px; color: #4b2a12; }
        .content { margin-left: 220px; transition: 0.3s; }
        .content.full { margin-left: 70px; }
        .header-main {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #4b2a12;
            color: #fff;
            padding: 10px 16px;
            font-weight: bold;
            letter-spacing: 1px;
            justify-content: center;
            text-align: center;
        }
        .settings-box {
            max-width: 720px;
            margin: 24px auto;
            background: #d8c8b5;
            padding: 28px;
            border: 4px solid #000;
            border-radius: 22px;
        }
        .avatar {
            width: 80px; height: 80px; border-radius: 50%;
            background: #4b2a12; border: 3px solid #4b2a12;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 38px; margin: 0 auto 8px;
        }
        .avatar i { color: #fff; }
        .username { text-align: center; font-weight: 700; margin-bottom: 18px; }
        .form-label { font-weight: 600; font-size: 12px; color: #2b1a0c; }
        .form-control { border-radius: 12px; background: #eee; border: none; padding: 12px 14px; font-size: 14px; }
        .action-buttons { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 18px; }
        .btn-coffee { background:#4b2a12; color:#fff; border:none; border-radius:12px; padding:10px 16px; font-weight:700; display:flex; align-items:center; justify-content:center; gap:8px; }
        .btn-coffee:hover { background:#6b3b1a; }
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
        <a href="#"><i class="bi bi-calendar"></i><span class="menu-text">Calendar</span></a>
        <a href="#"><i class="bi bi-person"></i><span class="menu-text">Seats</span></a>
        <a href="/admin/customers"><i class="bi bi-people"></i><span class="menu-text">Customer list</span></a>
        <a href="#"><i class="bi bi-journal-text"></i><span class="menu-text">Manual</span></a>
    </div>
    <div class="content" id="content">
        <div class="header-main"><i class="bi bi-person"></i> ACCOUNT SETTINGS</div>
        <div class="settings-box">
            <div class="avatar"><i class="bi bi-person"></i></div>
            <div class="username">USERNAME<br><small>Admin</small></div>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form method="POST" action="/admin/account">
                @csrf
                <div class="mb-3">
                    <label class="form-label">NAME:</label>
                    <input class="form-control" type="text" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">POSITION:</label>
                    <input class="form-control" type="text" name="position">
                </div>
                <div class="mb-3">
                    <label class="form-label">ADMIN ID:</label>
                    <input class="form-control" type="text" name="admin_id">
                </div>
                <div class="mb-3">
                    <label class="form-label">EMAIL ADDRESS:</label>
                    <input class="form-control" type="email" name="email" value="{{ $user->email }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">PASSWORD:</label>
                    <input class="form-control" type="password" name="password" placeholder="Leave blank to keep">
                </div>
                <div class="action-buttons">
                    <button type="submit" class="btn-coffee"><i class="bi bi-save"></i> SAVE</button>
                    <a href="/admin" class="btn-coffee"><i class="bi bi-arrow-left"></i> BACK</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        function toggleSidebar(){ document.getElementById("sidebar").classList.toggle("collapsed"); document.getElementById("content").classList.toggle("full"); }
    </script>
</body>
</html>
