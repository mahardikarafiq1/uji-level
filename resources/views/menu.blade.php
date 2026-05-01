<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu — Felize Cafe</title>
    <meta name="description" content="Jelajahi menu kopi premium dan kuliner artisan Felize Cafe.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400&family=Inter:wght@300;400;500;600;700&family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
        :root {
            --coffee-darkest:#1a0d04; --coffee-dark:#2b1608; --coffee:#4b2a12;
            --coffee-medium:#6b3b1a; --cream:#d8c8b5; --cream-light:#e5d6c3;
            --cream-lightest:#f0ebe3; --paper:#faf8f5; --gold:#c9a96e;
            --gold-light:#e8d5a8; --text-dark:#2b1608; --text-muted:#7a5e44; --white:#fff;
        }
        html { scroll-behavior:smooth; }
        body { font-family:'Inter',sans-serif; color:var(--text-dark); background:var(--paper); }
        .container { max-width:1200px; margin:0 auto; padding:0 24px; }

        /* NAVBAR */
        .navbar { position:fixed; top:0; left:0; right:0; z-index:1000; padding:16px 0;
            background:rgba(250,248,245,0.92); backdrop-filter:blur(20px); box-shadow:0 1px 24px rgba(75,42,18,0.08); }
        .navbar .container { display:flex; justify-content:space-between; align-items:center; }
        .nav-brand { font-family:'Great Vibes',cursive; font-size:32px; color:var(--coffee); text-decoration:none; }
        .nav-links { display:flex; gap:28px; list-style:none; align-items:center; }
        .nav-links a { color:var(--coffee-medium); text-decoration:none; font-size:14px; font-weight:500;
            letter-spacing:0.5px; text-transform:uppercase; transition:color 0.3s; position:relative; }
        .nav-links a::after { content:''; position:absolute; bottom:-4px; left:0; width:0; height:2px;
            background:var(--gold); transition:width 0.3s; }
        .nav-links a:hover::after { width:100%; }
        .nav-links a:hover { color:var(--coffee); }
        .nav-cta { background:var(--coffee)!important; color:var(--white)!important; padding:10px 24px;
            border-radius:50px; font-weight:600!important; }
        .nav-cta::after { display:none!important; }
        .nav-cta:hover { background:var(--coffee-medium)!important; }
        .nav-cart-link { position:relative; font-size:18px!important; }
        .cart-badge { position:absolute; top:-8px; right:-12px; background:var(--gold); color:var(--coffee-darkest);
            font-size:11px; font-weight:700; width:20px; height:20px; border-radius:50%;
            display:flex; align-items:center; justify-content:center; }
        .nav-toggle { display:none; background:none; border:none; cursor:pointer; padding:8px; }
        .nav-toggle span { display:block; width:24px; height:2px; background:var(--coffee); margin:6px 0; border-radius:2px; }

        /* PAGE HEADER */
        .page-header { padding:120px 0 48px; text-align:center; }
        .page-header h1 { font-family:'Playfair Display',serif; font-size:clamp(36px,5vw,56px);
            color:var(--coffee); font-weight:700; margin-bottom:12px; }
        .page-header p { font-size:17px; color:var(--text-muted); max-width:520px; margin:0 auto; }

        /* CATEGORY TABS */
        .category-tabs { display:flex; gap:12px; justify-content:center; flex-wrap:wrap; margin-bottom:48px; }
        .cat-tab { padding:10px 24px; border-radius:50px; border:1.5px solid var(--cream); background:var(--white);
            color:var(--text-muted); font-size:14px; font-weight:500; cursor:pointer; transition:all 0.3s;
            text-decoration:none; }
        .cat-tab:hover, .cat-tab.active { background:var(--coffee); color:var(--white); border-color:var(--coffee); }

        /* PRODUCT GRID */
        .product-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:28px; padding-bottom:80px; }
        .product-card { background:var(--white); border-radius:20px; overflow:hidden;
            box-shadow:0 2px 8px rgba(75,42,18,0.08); border:1px solid rgba(229,214,195,0.5);
            transition:all 0.4s cubic-bezier(0.16,1,0.3,1); }
        .product-card:hover { transform:translateY(-6px); box-shadow:0 16px 48px rgba(75,42,18,0.15); }
        .product-img-wrap { overflow:hidden; position:relative; height:220px; background:var(--cream-lightest); }
        .product-img { width:100%; height:100%; object-fit:cover; transition:transform 0.6s; }
        .product-card:hover .product-img { transform:scale(1.08); }
        .product-img-wrap .unavailable-badge { position:absolute; top:12px; right:12px; background:rgba(180,40,40,0.9);
            color:#fff; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:600; }
        .product-body { padding:20px 24px 24px; }
        .product-body h3 { font-family:'Playfair Display',serif; font-size:20px; font-weight:700;
            color:var(--coffee); margin-bottom:4px; }
        .product-cat { font-size:12px; color:var(--gold); font-weight:600; letter-spacing:1px;
            text-transform:uppercase; margin-bottom:8px; }
        .product-body p { font-size:14px; color:var(--text-muted); line-height:1.6; margin-bottom:16px;
            min-height:44px; }
        .product-footer { display:flex; justify-content:space-between; align-items:center; }
        .product-price { font-family:'Playfair Display',serif; font-size:22px; font-weight:700; color:var(--coffee-medium); }
        .btn-add { width:44px; height:44px; border-radius:50%; border:none; background:var(--coffee);
            color:var(--white); font-size:22px; cursor:pointer; transition:all 0.3s;
            display:flex; align-items:center; justify-content:center; }
        .btn-add:hover { background:var(--gold); color:var(--coffee-darkest); transform:scale(1.1); }

        /* TOAST */
        .toast { position:fixed; bottom:30px; right:30px; background:var(--coffee); color:var(--white);
            padding:16px 28px; border-radius:16px; font-size:14px; font-weight:500; z-index:9999;
            transform:translateY(100px); opacity:0; transition:all 0.4s cubic-bezier(0.16,1,0.3,1);
            box-shadow:0 8px 32px rgba(75,42,18,0.3); }
        .toast.show { transform:translateY(0); opacity:1; }

        /* FLOATING CART */
        .floating-cart { position:fixed; bottom:30px; left:50%; transform:translateX(-50%);
            background:var(--coffee); color:var(--white); padding:16px 36px; border-radius:50px;
            font-weight:600; font-size:15px; text-decoration:none; z-index:999;
            box-shadow:0 8px 32px rgba(75,42,18,0.3); display:none; align-items:center; gap:10px;
            transition:all 0.3s; }
        .floating-cart:hover { background:var(--coffee-medium); transform:translateX(-50%) translateY(-3px); }

        /* FOOTER */
        .footer { background:var(--coffee-darkest); color:rgba(255,255,255,0.6); padding:72px 0 0; }
        .footer-grid { display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:48px; margin-bottom:48px; }
        .footer-brand { font-family:'Great Vibes',cursive; font-size:36px; color:var(--gold); margin-bottom:16px; }
        .footer-desc { font-size:14px; line-height:1.8; margin-bottom:20px; }
        .footer-socials { display:flex; gap:12px; }
        .footer-socials a { width:40px; height:40px; border-radius:10px; background:rgba(255,255,255,0.06);
            display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,0.5);
            text-decoration:none; transition:all 0.3s; font-size:16px; }
        .footer-socials a:hover { background:var(--gold); color:var(--coffee-darkest); }
        .footer h4 { color:var(--white); font-family:'Playfair Display',serif; font-size:16px;
            font-weight:600; margin-bottom:20px; }
        .footer ul { list-style:none; }
        .footer ul li { margin-bottom:12px; }
        .footer ul a { color:rgba(255,255,255,0.5); text-decoration:none; font-size:14px; transition:color 0.3s; }
        .footer ul a:hover { color:var(--gold); }
        .footer-bottom { border-top:1px solid rgba(255,255,255,0.08); padding:24px 0; text-align:center; font-size:13px; }

        /* EMPTY */
        .empty-state { text-align:center; padding:80px 24px; }
        .empty-state h3 { font-family:'Playfair Display',serif; font-size:24px; color:var(--coffee); margin-bottom:12px; }
        .empty-state p { color:var(--text-muted); }

        /* RESPONSIVE */
        @media (max-width:1024px) { .product-grid { grid-template-columns:repeat(2,1fr); }
            .footer-grid { grid-template-columns:1fr 1fr; gap:36px; } }
        @media (max-width:768px) { .nav-links { display:none; }
            .nav-links.active { display:flex; flex-direction:column; position:absolute; top:100%; left:0;
                right:0; background:rgba(250,248,245,0.98); backdrop-filter:blur(20px); padding:24px;
                gap:16px; box-shadow:0 8px 32px rgba(75,42,18,0.12); }
            .nav-toggle { display:block; }
            .product-grid { grid-template-columns:1fr; max-width:420px; margin:0 auto; }
            .footer-grid { grid-template-columns:1fr; text-align:center; }
            .footer-socials { justify-content:center; } }
    </style>
</head>
<body>
    @include('partials.navbar')

    <!-- HEADER -->
    <section class="page-header">
        <h1>Menu Kami</h1>
        <p>Dari racikan kopi aromatik hingga hidangan lezat, setiap item dibuat dengan bahan premium.</p>
    </section>

    <!-- CATEGORY TABS -->
    <div class="container">
        <div class="category-tabs">
            @foreach($categories as $key => $label)
                <a href="{{ url('/menu') }}{{ $key !== 'all' ? '?category='.$key : '' }}"
                   class="cat-tab {{ ($category ?? 'all') === $key || (empty($category) && $key === 'all') ? 'active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if($products->isEmpty())
            <div class="empty-state">
                <h3>Belum ada produk</h3>
                <p>Produk untuk kategori ini belum tersedia.</p>
            </div>
        @else
            <div class="product-grid">
                @foreach($products as $product)
                    <div class="product-card" id="product-{{ $product->id }}">
                        <a href="{{ url('/menu/' . $product->id) }}" style="text-decoration:none; color:inherit; display:block;">
                            <div class="product-img-wrap">
                                @if($product->image_url)
                                    <img class="product-img" src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                                @else
                                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:48px;color:var(--cream);">☕</div>
                                @endif
                            </div>
                        </a>
                        <div class="product-body">
                            <div class="product-cat">{{ $product->category }}</div>
                            <a href="{{ url('/menu/' . $product->id) }}" style="text-decoration:none; color:inherit;">
                                <h3>{{ $product->name }}</h3>
                            </a>
                            <p>{{ Str::limit($product->description, 80) }}</p>
                            <div class="product-footer">
                                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                <button class="btn-add" onclick="addToCart({{ json_encode([
                                    'product_id' => $product->id,
                                    'name' => $product->name,
                                    'price' => (float)$product->price,
                                    'image_url' => $product->image_url,
                                ]) }})" title="Tambah ke keranjang">+</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- FLOATING CART BUTTON -->
    <a href="/cart" class="floating-cart" id="floatingCart">
        🛒 Lihat Keranjang (<span id="floatingCartCount">0</span>)
    </a>

    <!-- TOAST -->
    <div class="toast" id="toast"></div>

    <!-- FOOTER -->
    @include('partials.footer')

    <script>
        // CART FUNCTIONS
        function getCart() {
            try { return JSON.parse(localStorage.getItem('felize_cart') || '[]'); }
            catch(e) { return []; }
        }
        function saveCart(cart) { localStorage.setItem('felize_cart', JSON.stringify(cart)); }
        function getCartCount() {
            return getCart().reduce(function(sum, item) { return sum + item.quantity; }, 0);
        }

        function addToCart(product) {
            var cart = getCart();
            var existing = cart.find(function(i) { return i.product_id === product.product_id; });
            if (existing) {
                existing.quantity++;
            } else {
                cart.push({ product_id: product.product_id, name: product.name,
                    price: product.price, image_url: product.image_url, quantity: 1 });
            }
            saveCart(cart);
            updateCartUI();
            showToast('✓ ' + product.name + ' ditambahkan ke keranjang!');
        }

        function updateCartUI() {
            var count = getCartCount();
            var badge = document.getElementById('cartBadgeNav');
            var floating = document.getElementById('floatingCart');
            var floatingCount = document.getElementById('floatingCartCount');
            if (badge) { badge.textContent = count; badge.style.display = count > 0 ? 'flex' : 'none'; }
            if (floating) { floating.style.display = count > 0 ? 'flex' : 'none'; }
            if (floatingCount) { floatingCount.textContent = count; }
        }

        function showToast(msg) {
            var t = document.getElementById('toast');
            t.textContent = msg;
            t.classList.add('show');
            setTimeout(function() { t.classList.remove('show'); }, 2500);
        }

        // NAV TOGGLE
        document.getElementById('navToggle').addEventListener('click', function() {
            document.getElementById('navLinks').classList.toggle('active');
        });

        // INIT
        updateCartUI();
    </script>
</body>
</html>
