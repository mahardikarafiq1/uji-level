<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Felize Cafe — Lebih dari Sekadar Secangkir Kopi</title>
    <meta name="description" content="Kopi premium, hidangan lezat, dan kemudahan manajemen kafe lewat Felize Cafe. Pesan meja sekarang.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400&family=Inter:wght@300;400;500;600;700&family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        /* ===== RESET & BASE ===== */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --coffee-darkest: #1a0d04; --coffee-dark: #2b1608; --coffee-deep: #3a1f0d;
            --coffee: #4b2a12; --coffee-medium: #6b3b1a; --coffee-light: #8b5e3c;
            --cream-dark: #c4a882; --cream: #d8c8b5; --cream-light: #e5d6c3;
            --cream-lightest: #f0ebe3; --paper: #faf8f5; --gold: #c9a96e;
            --gold-light: #e8d5a8; --text-dark: #2b1608; --text-muted: #7a5e44;
            --white: #ffffff;
            --shadow-sm: 0 4px 12px rgba(75,42,18,0.05);
            --shadow-md: 0 8px 24px rgba(75,42,18,0.08);
            --shadow-lg: 0 16px 48px rgba(75,42,18,0.12);
        }
        html { scroll-behavior: smooth; font-size: 16px; }
        body { font-family: 'Inter', sans-serif; color: var(--text-dark); background-color: var(--paper); line-height: 1.5; overflow-x: hidden; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; position: relative; }
        
        /* ===== ANIMATION CLASSES ===== */
        .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .reveal-left { opacity: 0; transform: translateX(-40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal-left.active { opacity: 1; transform: translateX(0); }
        .reveal-right { opacity: 0; transform: translateX(40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal-right.active { opacity: 1; transform: translateX(0); }
        .reveal-scale { opacity: 0; transform: scale(0.95); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal-scale.active { opacity: 1; transform: scale(1); }
        .stagger-1 { transition-delay: 0.1s; }
        .stagger-2 { transition-delay: 0.2s; }
        .stagger-3 { transition-delay: 0.3s; }
        .stagger-4 { transition-delay: 0.4s; }
        .stagger-5 { transition-delay: 0.5s; }
        .stagger-6 { transition-delay: 0.6s; }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000; padding: 20px 0;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .navbar.scrolled {
            background: rgba(250, 248, 245, 0.92); padding: 12px 0;
            backdrop-filter: blur(20px) saturate(180%); -webkit-backdrop-filter: blur(20px) saturate(180%);
            box-shadow: 0 1px 24px rgba(75,42,18,0.08);
        }
        .navbar .container { display: flex; justify-content: space-between; align-items: center; }
        .nav-brand { font-family: 'Great Vibes', cursive; font-size: 32px; color: var(--white); text-decoration: none; transition: color 0.3s; }
        .navbar.scrolled .nav-brand { color: var(--coffee); }
        .nav-links { display: flex; gap: 36px; list-style: none; align-items: center; }
        .nav-links a {
            color: rgba(255,255,255,0.85); text-decoration: none; font-size: 14px; font-weight: 500;
            text-transform: uppercase; transition: color 0.3s; position: relative;
        }
        .nav-links a::after {
            content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px;
            background: var(--gold); transition: width 0.3s;
        }
        .nav-links a:hover::after { width: 100%; }
        .navbar.scrolled .nav-links a { color: var(--coffee-medium); }
        .navbar.scrolled .nav-links a:hover { color: var(--coffee); }

        .nav-cart-link { position:relative; font-size:18px!important; }
        .cart-badge {
            position:absolute; top:-8px; right:-12px; background:var(--gold); color:var(--coffee-darkest);
            font-size:11px; font-weight:700; width:20px; height:20px; border-radius:50%;
            display:flex; align-items:center; justify-content:center; display: none;
        }
        .navbar.scrolled .nav-cart-link { color: var(--coffee)!important; }

        .nav-cta {
            background: var(--gold) !important; color: var(--coffee-darkest) !important;
            padding: 10px 24px; border-radius: 50px; font-weight: 600 !important; font-size: 13px !important; transition: all 0.3s !important;
        }
        .nav-cta::after { display: none !important; }
        .nav-cta:hover { background: var(--gold-light) !important; transform: translateY(-1px); }
        .navbar.scrolled .nav-cta { background: var(--coffee) !important; color: var(--white) !important; }

        .nav-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
        .nav-toggle span { display: block; width: 24px; height: 2px; background: var(--white); margin: 6px 0; transition: all 0.3s; border-radius: 2px; }
        .navbar.scrolled .nav-toggle span { background: var(--coffee); }

        /* ===== HERO ===== */
        .hero { position: relative; min-height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .hero-bg { position: absolute; inset: 0; z-index: 0; }
        .hero-bg img { width: 100%; height: 100%; object-fit: cover; transform: scale(1.1); transition: transform 0.1s linear; }
        .hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(180deg, rgba(26,13,4,0.65) 0%, rgba(43,22,8,0.55) 40%, rgba(75,42,18,0.70) 100%); z-index: 1;
        }
        .hero-content { position: relative; z-index: 2; text-align: center; padding: 0 24px; max-width: 800px; }
        .hero-badge {
            display: inline-block; background: rgba(201,169,110,0.2); border: 1px solid rgba(201,169,110,0.4);
            backdrop-filter: blur(10px); padding: 8px 20px; border-radius: 50px; color: var(--gold-light);
            font-size: 12px; font-weight: 600; letter-spacing: 3px; text-transform: uppercase; margin-bottom: 28px;
            opacity: 0; animation: fadeInDown 1s 0.3s forwards;
        }
        .hero h1 {
            font-family: 'Playfair Display', serif; font-size: clamp(48px, 8vw, 96px); font-weight: 700;
            color: var(--white); line-height: 1.05; margin-bottom: 24px;
            opacity: 0; animation: fadeInUp 1s 0.5s forwards;
        }
        .hero h1 em { font-style: italic; color: var(--gold-light); }
        .hero-subtitle {
            font-size: clamp(16px, 2vw, 20px); color: rgba(255,255,255,0.75); font-weight: 300; line-height: 1.7;
            max-width: 560px; margin: 0 auto 40px; opacity: 0; animation: fadeInUp 1s 0.7s forwards;
        }
        .hero-buttons { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; opacity: 0; animation: fadeInUp 1s 0.9s forwards; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 10px; background: var(--gold); color: var(--coffee-darkest);
            padding: 16px 36px; border-radius: 50px; font-weight: 600; font-size: 15px; text-decoration: none;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); border: none; cursor: pointer;
        }
        .btn-primary:hover { background: var(--gold-light); transform: translateY(-3px); box-shadow: 0 12px 32px rgba(201,169,110,0.35); }
        .btn-outline {
            display: inline-flex; align-items: center; gap: 10px; background: transparent; color: var(--white);
            padding: 16px 36px; border-radius: 50px; font-weight: 500; font-size: 15px; text-decoration: none;
            transition: all 0.3s; border: 1.5px solid rgba(255,255,255,0.35);
        }
        .btn-outline:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.6); transform: translateY(-2px); }

        .hero-scroll { position: absolute; bottom: 40px; left: 50%; transform: translateX(-50%); z-index: 2; color: rgba(255,255,255,0.5); text-align: center; animation: float 3s ease-in-out infinite; }
        .hero-scroll span { display: block; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px; }
        .mouse { width: 24px; height: 38px; border: 2px solid rgba(255,255,255,0.4); border-radius: 12px; margin: 0 auto; position: relative; }
        .mouse::after {
            content: ''; position: absolute; top: 8px; left: 50%; transform: translateX(-50%);
            width: 3px; height: 8px; background: rgba(255,255,255,0.6); border-radius: 3px; animation: mouseScroll 2s infinite;
        }

        @keyframes fadeInDown { from { opacity:0; transform:translateY(-20px); } to { opacity:1; transform:translateY(0); } }
        @keyframes fadeInUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
        @keyframes float { 0%,100% { transform: translateX(-50%) translateY(0); } 50% { transform: translateX(-50%) translateY(-10px); } }
        @keyframes mouseScroll { 0% { opacity:1; transform: translateX(-50%) translateY(0); } 100% { opacity:0; transform: translateX(-50%) translateY(14px); } }

        /* ===== ABOUT SECTION ===== */
        .section-pad { padding: 120px 0; }
        .about { background: var(--white); }
        .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center; }
        .about-image { position: relative; border-radius: 20px; overflow: hidden; box-shadow: var(--shadow-lg); }
        .about-image img { width: 100%; height: 480px; object-fit: cover; display: block; transition: transform 0.6s; }
        .about-image:hover img { transform: scale(1.05); }
        .about-image::after { content: ''; position: absolute; inset: 0; border: 1px solid rgba(201,169,110,0.2); border-radius: 20px; }
        
        .section-tag { font-size: 12px; font-weight: 600; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: 16px; }
        .about-content h2 { font-family: 'Playfair Display', serif; font-size: clamp(32px, 4vw, 48px); font-weight: 700; color: var(--coffee); line-height: 1.2; margin-bottom: 24px; }
        .about-content p { font-size: 16px; color: var(--text-muted); line-height: 1.8; margin-bottom: 16px; }
        .about-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 36px; padding-top: 36px; border-top: 1px solid var(--cream-light); }
        .stat-item h3 { font-family: 'Playfair Display', serif; font-size: 36px; font-weight: 700; color: var(--coffee); }
        .stat-item span { font-size: 13px; color: var(--text-muted); font-weight: 500; }

        /* ===== MENU SECTION ===== */
        .menu-section { background: linear-gradient(180deg, var(--cream-lightest) 0%, var(--paper) 100%); }
        .section-header { text-align: center; margin-bottom: 60px; }
        .section-header h2 { font-family: 'Playfair Display', serif; font-size: clamp(32px, 4vw, 48px); font-weight: 700; color: var(--coffee); margin-bottom: 16px; }
        .section-header p { font-size: 16px; color: var(--text-muted); max-width: 560px; margin: 0 auto; line-height: 1.7; }
        
        .menu-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
        .menu-card {
            background: var(--white); border-radius: 20px; overflow: hidden; box-shadow: var(--shadow-sm);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); border: 1px solid rgba(229,214,195,0.5);
        }
        .menu-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-lg); }
        .menu-card-img { width: 100%; height: 220px; object-fit: cover; transition: transform 0.6s; }
        .menu-card:hover .menu-card-img { transform: scale(1.08); }
        .menu-card-img-wrap { overflow: hidden; position: relative; background: var(--cream-lightest); }
        .menu-card-img-wrap::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 60px;
            background: linear-gradient(transparent, var(--white));
        }
        .menu-card-body { padding: 20px 24px 24px; }
        .menu-card-body h3 { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 700; color: var(--coffee); margin-bottom: 8px; }
        .menu-card-body p { font-size: 14px; color: var(--text-muted); line-height: 1.6; margin-bottom: 16px; min-height: 44px; }
        .menu-card-price { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; color: var(--coffee-medium); }

        /* ===== FEATURES SECTION ===== */
        .features { background: var(--coffee); color: var(--white); position: relative; overflow: hidden; }
        .features::before, .features::after { content: ''; position: absolute; border-radius: 50%; }
        .features::before { top: -100px; right: -100px; width: 400px; height: 400px; background: rgba(201,169,110,0.08); }
        .features::after { bottom: -150px; left: -100px; width: 500px; height: 500px; background: rgba(201,169,110,0.05); }
        .features .section-tag { color: var(--gold-light); }
        .features .section-header h2 { color: var(--white); }
        .features .section-header p { color: rgba(255,255,255,0.65); }
        .features-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px; position: relative; z-index: 1; }
        .feature-card {
            text-align: center; padding: 40px 24px; border-radius: 20px; background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08); backdrop-filter: blur(10px); transition: all 0.4s;
        }
        .feature-card:hover { background: rgba(255,255,255,0.1); transform: translateY(-6px); }
        .feature-icon {
            width: 64px; height: 64px; border-radius: 16px; background: rgba(201,169,110,0.15);
            display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 28px;
        }
        .feature-card h3 { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 600; margin-bottom: 10px; }
        .feature-card p { font-size: 14px; color: rgba(255,255,255,0.6); line-height: 1.6; }

        /* ===== CAFE MANAGEMENT & CTA ===== */
        .cta-section { background: linear-gradient(135deg, var(--cream-lightest) 0%, var(--cream-light) 100%); text-align: center; position: relative; overflow: hidden; padding: 80px 24px; }
        .cta-section::before { content: '☕'; position: absolute; top: 20%; left: 8%; font-size: 120px; opacity: 0.04; }
        .cta-section::after { content: '☕'; position: absolute; bottom: 10%; right: 8%; font-size: 160px; opacity: 0.04; }
        .cta-content { position: relative; z-index: 1; max-width: 640px; margin: 0 auto; }
        .cta-content h2 { font-family: 'Playfair Display', serif; font-size: clamp(32px, 4vw, 52px); font-weight: 700; color: var(--coffee); margin-bottom: 20px; line-height: 1.2; }
        .cta-content p { font-size: 17px; color: var(--text-muted); margin-bottom: 36px; line-height: 1.7; }
        .cta-content .btn-primary { background: var(--coffee); color: var(--white); font-size: 16px; padding: 18px 44px; }
        .cta-content .btn-primary:hover { background: var(--coffee-medium); box-shadow: 0 12px 32px rgba(75,42,18,0.3); }

        .mgmt-cards { display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; margin-bottom: 36px; }
        .mgmt-card { background: var(--white); padding: 24px; border-radius: 16px; border: 1px solid rgba(229,214,195,0.5); box-shadow: var(--shadow-sm); min-width: 200px; flex: 1; text-align: center; }
        .mgmt-card .icon { font-size: 36px; margin-bottom: 16px; }
        .mgmt-card h3 { font-family: 'Playfair Display', serif; color: var(--coffee); font-size: 20px; margin-bottom: 8px; }
        .mgmt-card p { font-size: 14px; color: var(--text-muted); }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .about-grid { grid-template-columns: 1fr; gap: 40px; }
            .about-image img { height: 360px; }
            .menu-grid { grid-template-columns: repeat(2, 1fr); }
            .features-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .section-pad { padding: 64px 0; }
            .nav-links { display: none; }
            .nav-links.active {
                display: flex; flex-direction: column; position: absolute; top: 100%; left: 0; right: 0;
                background: rgba(250,248,245,0.98); backdrop-filter: blur(20px); padding: 24px; gap: 16px; box-shadow: var(--shadow-md);
            }
            .nav-toggle { display: block; }
            .menu-grid { grid-template-columns: 1fr; max-width: 400px; margin: 0 auto; }
            .features-grid { grid-template-columns: 1fr; max-width: 360px; margin: 0 auto; }
            .about-stats { grid-template-columns: 1fr; text-align: center; gap: 24px; }
            .mgmt-cards { flex-direction: column; }
        }
    </style>
</head>
<body>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="/" class="nav-brand">felize cafe</a>
            <ul class="nav-links" id="navLinks">
                <li><a href="#about">Tentang Kami</a></li>
                <li><a href="#menu">Sajian Menu</a></li>
                <li><a href="#features">Kenapa Kami</a></li>
                <li><a href="/cart" class="nav-cart-link">🛒 <span class="cart-badge" id="cartBadge">0</span></a></li>
                <li><a href="{{ url('/admin') }}" class="nav-cta">Pesan Meja</a></li>
            </ul>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    <!-- ===== HERO ===== -->
    <section class="hero" id="hero">
        <div class="hero-bg">
            <img src="{{ asset('images/cafe-hero.png') }}" alt="Felize Cafe Coffee" id="heroBg" loading="eager">
        </div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-badge">✦ Cita Rasa Autentik</div>
            <h1>Lebih dari Sekadar<br><em>Secangkir Kopi</em></h1>
            <p class="hero-subtitle">Diramu dengan semangat, disajikan dengan cinta. Temukan racikan kopi khas kami dan kuliner ekskuisit dalam suasana yang hangat dan mengundang.</p>
            <div class="hero-buttons">
                <a href="{{ url('/admin') }}" class="btn-primary">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Pesan Meja
                </a>
                <a href="/menu" class="btn-outline">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    Lihat Menu Lengkap
                </a>
            </div>
        </div>
        <div class="hero-scroll">
            <span>Scroll</span>
            <div class="mouse"></div>
        </div>
    </section>

    <!-- ===== ABOUT ===== -->
    <section class="about section-pad" id="about">
        <div class="container">
            <div class="about-grid">
                <div class="about-image reveal-left">
                    <img src="{{ asset('images/cafe-about.png') }}" alt="Suasana Felize Cafe" loading="lazy">
                </div>
                <div class="about-content reveal-right">
                    <div class="section-tag">Cerita Kami</div>
                    <h2>Dedikasi untuk <br>Kopi yang Sempurna</h2>
                    <p>Di Felize Cafe, kami percaya bahwa kopi yang luar biasa adalah sebuah karya seni. Setiap biji kopi dipilih dengan hati-hati, setiap cangkir diracik oleh ahlinya, dan setiap momen yang dihabiskan di sini dirancang untuk tak terlupakan.</p>
                    <p>Mulai dari racikan khas kami hingga roti artisan, semua yang kami sajikan dibuat dari bahan-bahan terbaik dan kecintaan mendalam pada profesi ini.</p>
                    <div class="about-stats">
                        <div class="stat-item reveal stagger-1">
                            <h3>5+</h3>
                            <span>Tahun Pengalaman</span>
                        </div>
                        <div class="stat-item reveal stagger-2">
                            <h3>20+</h3>
                            <span>Varian Rasa Orisinal</span>
                        </div>
                        <div class="stat-item reveal stagger-3">
                            <h3>10K+</h3>
                            <span>Pelanggan Bahagia</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== HIGHLIGHT MENU ===== -->
    <section class="menu-section section-pad" id="menu">
        <div class="container">
            <div class="section-header reveal">
                <div class="section-tag">Kurasi Spesial</div>
                <h2>Dibuat Penuh Cinta</h2>
                <p>Dari racikan harum hingga hidangan lezat, setiap makanan disiapkan dengan bahan premium pilihan.</p>
            </div>
            
            <div class="menu-grid">
                @php
                    $highlightProducts = \App\Models\Product::where('is_available', true)->take(6)->get();
                @endphp

                @forelse($highlightProducts as $delay => $product)
                <div class="menu-card reveal stagger-{{ min($delay + 1, 6) }}">
                    <div class="menu-card-img-wrap">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="menu-card-img">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:48px;">☕</div>
                        @endif
                    </div>
                    <div class="menu-card-body">
                        <h3>{{ $product->name }}</h3>
                        <p>{{ Str::limit($product->description, 60) }}</p>
                        <div class="menu-card-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>
                </div>
                @empty
                    <div style="grid-column: 1/-1; text-align:center; padding: 40px; color:var(--text-muted);">
                        Menu belum tersedia saat ini.
                    </div>
                @endforelse
            </div>

            <div style="text-align: center; margin-top: 48px;" class="reveal">
                <a href="/menu" class="btn-primary" style="padding: 16px 40px; border-radius: 50px;">
                    Jelajahi Menu Penuh & Pesan Online →
                </a>
            </div>
        </div>
    </section>

    <!-- ===== FEATURES ===== -->
    <section class="features section-pad" id="features">
        <div class="container">
            <div class="section-header reveal">
                <div class="section-tag">Kenapa Kami</div>
                <h2>Pengalaman Bintang Lima</h2>
                <p>Lebih dari sekadar secangkir kopi — kami mendedikasikan tempat ini untuk momen paling berharga Anda.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card reveal stagger-1">
                    <div class="feature-icon">✨</div>
                    <h3>Biji Premium Asli</h3>
                    <p>Biji kopi single-origin pilihan dari perkebunan panen terbaik dunia.</p>
                </div>
                <div class="feature-card reveal stagger-2">
                    <div class="feature-icon">🛋️</div>
                    <h3>Suasana Nyaman</h3>
                    <p>Pencahayaan temaram, kursi yang empuk, sangat cocok untuk bersantai.</p>
                </div>
                <div class="feature-card reveal stagger-3">
                    <div class="feature-icon">🚀</div>
                    <h3>Internet Gesit</h3>
                    <p>Koneksi WiFi tak berbatas, dirancang khusus untuk kenyamanan meeting atau WFC.</p>
                </div>
                <div class="feature-card reveal stagger-4">
                    <div class="feature-icon">🥐</div>
                    <h3>Fresh Bakery</h3>
                    <p>Nikmati croissant hangat hasil panggangan in-house chef kami setiap pagi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CAFE MANAGEMENT & CTA ===== -->
    <section class="cta-section" id="reserve">
        <div class="container">
            <div class="cta-content reveal-scale">
                <div class="section-tag" style="background:var(--gold-light); display:inline-block; padding:4px 16px; border-radius:20px; font-weight:600; font-size:12px; margin-bottom:12px;">SISTEM KAMI</div>
                <h2>Sistem Cafe Terpadu</h2>
                <p>Website ini bukan hanya profil, namun didesain khusus membantu operasional bisnis cafe. Fitur seperti booking meja, order otomatis terhubung ke WhatsApp dan QRIS payment.</p>
                
                <div class="mgmt-cards">
                    <div class="mgmt-card">
                        <div class="icon">🛒</div>
                        <h3>E-Commerce Ready</h3>
                        <p>Pelanggan bisa pesan makanan tanpa buat akun. Simpel & Cepat!</p>
                    </div>
                    <div class="mgmt-card">
                        <div class="icon">📱</div>
                        <h3>Smart Checkout</h3>
                        <p>Sinkronisasi chat via WhatsApp otomatis dan struk via QRIS dinamis.</p>
                    </div>
                    <div class="mgmt-card">
                        <div class="icon">📊</div>
                        <h3>Admin Filament</h3>
                        <p>Panel admin indah dengan metrik analitik dashboard yang profesional.</p>
                    </div>
                </div>

                <a href="{{ url('/admin') }}" class="btn-primary" style="background-color: var(--coffee-darkest); color: var(--gold-light);">
                    Masuk ke Dashboard Panel Admin Anda
                </a>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    @include('partials.footer')

    <!-- ===== JAVASCRIPT ===== -->
    <script>
        // Update Cart Badge from localStorage
        function updateCartBadge() {
            try { 
                var cart = JSON.parse(localStorage.getItem('felize_cart') || '[]');
                var count = cart.reduce((sum, item) => sum + item.quantity, 0);
                var badge = document.getElementById('cartBadge');
                if (badge) {
                    badge.textContent = count;
                    badge.style.display = count > 0 ? 'flex' : 'none';
                }
            } catch(e) {}
        }
        updateCartBadge();

        // Navbar scroll effect
        (function() {
            var navbar = document.getElementById('navbar');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) navbar.classList.add('scrolled');
                else navbar.classList.remove('scrolled');
            }, { passive: true });
        })();

        // Mobile menu toggle
        (function() {
            var btn = document.getElementById('navToggle');
            var links = document.getElementById('navLinks');
            if(btn && links) {
                btn.addEventListener('click', function() { links.classList.toggle('active'); });
            }
        })();

        // Parallax & Scroll animations using IntersectionObserver
        (function() {
            // Parallax
            var heroBg = document.getElementById('heroBg');
            window.addEventListener('scroll', function() {
                var scrolled = window.scrollY;
                if (heroBg && scrolled < window.innerHeight) {
                    heroBg.style.transform = 'scale(1.1) translateY(' + (scrolled * 0.4) + 'px)';
                }
            }, { passive: true });

            // Intersection Observer
            var observerOptions = { root: null, rootMargin: '0px', threshold: 0.15 };
            var observer = new IntersectionObserver(function(entries, obs) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        obs.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            var revealEls = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
            revealEls.forEach(function(el) { observer.observe(el); });
        })();
    </script>
</body>
</html>
