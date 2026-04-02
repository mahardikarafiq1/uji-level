<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root{
            --coffee:#4b2a12;
            --cream:#e5d6c3;
            --paper:#d8c8b5;
        }
        *{box-sizing:border-box}
        body {
            margin: 0;
            font-family: 'Inter', Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background:
              radial-gradient(circle at 20% 20%, rgba(0,0,0,0.03) 0 40%, transparent 41%) 0 0/120px 120px,
              radial-gradient(circle at 80% 70%, rgba(0,0,0,0.03) 0 40%, transparent 41%) 0 0/140px 140px,
              var(--paper);
        }
        .login-card{
            width: 380px;
            max-width: 92vw;
            background: var(--cream);
            border: 4px solid #000;
            border-radius: 24px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            padding: 28px 26px;
        }
        .brand{
            font-family: 'Great Vibes', cursive;
            font-size: 44px;
            text-align: center;
            color: #3a2412;
            margin-bottom: 8px;
        }
        .avatar{
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #fff;
            border: 3px solid var(--coffee);
            display:flex;
            align-items:center;
            justify-content:center;
            color: var(--coffee);
            font-size: 34px;
            margin: 8px auto 18px;
        }
        .form-label{
            font-weight: 600;
            font-size: 12px;
            color:#2b1a0c;
            margin-bottom:6px;
            display:block;
        }
        .form-input{
            width:100%;
            border:none;
            border-radius:12px;
            background:#eee;
            padding:12px 14px;
            font-size:14px;
            outline:none;
        }
        .form-group{margin-bottom:14px}
        .forgot{
            display:block;
            text-align:right;
            font-size:12px;
            margin-top:6px;
            color:#2b1a0c;
            text-decoration:none;
        }
        .forgot:hover{text-decoration:underline}
        .btn-login{
            width:100%;
            background: var(--coffee);
            color:#fff;
            border:none;
            border-radius:12px;
            padding:10px 14px;
            font-weight:600;
            cursor:pointer;
        }
        .btn-login:hover{background:#6b3b1a}
        .error{
            color:#b00020;
            margin:8px 0 0;
            text-align:center;
            font-size:12px;
        }
    </style>
    </head>
<body>
    <div class="login-card">
        <div class="brand">felize <span style="font-size:22px">cafe</span></div>
        <div class="avatar"><i class="bi bi-person"></i></div>
        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">USERNAME</label>
                <input class="form-input" type="text" name="email" required>
            </div>
            <div class="form-group">
                <label class="form-label">PASSWORD</label>
                <input class="form-input" type="password" name="password" required>
                <a class="forgot" href="#">FORGOT PASSWORD</a>
            </div>
            <button class="btn-login" type="submit">Login</button>
        </form>
    </div>
</body>
</html>
