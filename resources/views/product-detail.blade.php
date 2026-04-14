<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} — Felize Cafe</title>
    <meta name="description" content="{{ Str::limit($product->description, 150) }}">
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
        .nav-links a::after { content:''; position:absolute; bottom:-4px; left:0; width:0; height:2px; background:var(--gold); transition:width 0.3s;}
        .nav-links a:hover::after { width:100%; }
        .nav-links a:hover { color:var(--coffee); }
        .nav-cart-link { position:relative; font-size:18px!important; }
        .cart-badge { position:absolute; top:-8px; right:-12px; background:var(--gold); color:var(--coffee-darkest); font-size:11px; font-weight:700; width:20px; height:20px; border-radius:50%; display:flex; align-items:center; justify-content:center; }

        .back-btn { display:inline-flex; align-items:center; gap:8px; margin-top:120px; margin-bottom:24px; padding:10px 20px; text-decoration:none; color:var(--coffee-medium); font-weight:500; font-size:14px; border:1px solid var(--cream); border-radius:50px; transition:all 0.3s; }
        .back-btn:hover { background:var(--coffee); color:var(--white); border-color:var(--coffee); }

        /* PRODUCT DETAIL */
        .detail-card { background:var(--white); border-radius:24px; overflow:hidden; box-shadow:0 16px 48px rgba(75,42,18,0.08); border:1px solid rgba(229,214,195,0.5); display:flex; flex-direction:row; margin-bottom: 80px; }
        .detail-img-wrap { flex:1; background:var(--cream-lightest); position:relative; min-height:400px; display:flex; align-items:center; justify-content:center; }
        .detail-img { width:100%; height:100%; object-fit:cover; position:absolute; inset:0; }
        .detail-body { flex:1; padding:56px 48px; display:flex; flex-direction:column; justify-content:center; }
        
        .cat-badge { display:inline-block; background:rgba(201,169,110,0.15); color:var(--coffee-medium); font-size:13px; font-weight:700; letter-spacing:1px; text-transform:uppercase; padding:6px 16px; border-radius:50px; margin-bottom:16px; align-self:flex-start; border:1px solid rgba(201,169,110,0.3); }
        
        .detail-title { font-family:'Playfair Display',serif; font-size:48px; color:var(--coffee-darkest); font-weight:700; line-height:1.1; margin-bottom:24px; }
        .detail-desc { font-size:16px; color:var(--text-muted); line-height:1.8; margin-bottom:32px; }
        .detail-price { font-family:'Playfair Display',serif; font-size:36px; color:var(--coffee-medium); font-weight:700; margin-bottom:40px; }

        .add-cart-btn { background:var(--coffee); color:var(--white); font-size:16px; font-weight:600; padding:18px 36px; border-radius:12px; border:none; cursor:pointer; transition:all 0.3s; display:inline-flex; justify-content:center; align-items:center; width:100%; gap:12px; }
        .add-cart-btn:hover { background:var(--gold); color:var(--coffee-darkest); transform:translateY(-2px); box-shadow:0 8px 24px rgba(201,169,110,0.3); }
        .add-cart-btn:disabled { background:var(--cream); color:var(--text-muted); cursor:not-allowed; transform:none; box-shadow:none; }

        /* FLOATING CART AND TOAST */
        .toast { position:fixed; bottom:30px; right:30px; background:var(--coffee); color:var(--white); padding:16px 28px; border-radius:16px; font-size:14px; font-weight:500; z-index:9999; transform:translateY(100px); opacity:0; transition:all 0.4s cubic-bezier(0.16,1,0.3,1); box-shadow:0 8px 32px rgba(75,42,18,0.3); }
        .toast.show { transform:translateY(0); opacity:1; }
        .floating-cart { position:fixed; bottom:30px; left:50%; transform:translateX(-50%); background:var(--coffee); color:var(--white); padding:16px 36px; border-radius:50px; font-weight:600; font-size:15px; text-decoration:none; z-index:999; box-shadow:0 8px 32px rgba(75,42,18,0.3); display:none; align-items:center; gap:10px; transition:all 0.3s; }
        .floating-cart:hover { background:var(--coffee-medium); transform:translateX(-50%) translateY(-3px); }

        @media (max-width:900px) {
            .detail-card { flex-direction:column; }
            .detail-img-wrap { height:360px; min-height:360px; }
            .detail-body { padding:32px 24px; }
            .detail-title { font-size:36px; }
        }
    </style>
</head>
<body>

    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="/" class="nav-brand">felize cafe</a>
            <ul class="nav-links" id="navLinks">
                <li><a href="/#about">Tentang</a></li>
                <li><a href="/menu">Menu</a></li>
                <li><a href="/cart" class="nav-cart-link">🛒 <span class="cart-badge" id="cartBadgeNav" style="display:none">0</span></a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <a href="{{ url('/menu') }}" class="back-btn">← Kembali ke Menu</a>

        <div class="detail-card">
            <div class="detail-img-wrap">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="detail-img">
                @else
                    <div style="font-size:72px; padding: 40px; text-align:center;">☕<br><span style="font-size:16px; font-family:'Inter',sans-serif; color:var(--coffee-medium); display:block; margin-top:20px;">Gambar tidak tersedia</span></div>
                @endif
            </div>

            <div class="detail-body">
                <div class="cat-badge">{{ strtoupper($product->category) }}</div>
                <h1 class="detail-title">{{ $product->name }}</h1>
                <p class="detail-desc">{{ $product->description ?: 'Belum ada deskripsi untuk sajian lezat ini.' }}</p>
                <div class="detail-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

                @if($product->is_available)
                <button class="add-cart-btn" onclick="addSingleToCart()">
                    <span>Tambahkan ke Keranjang</span>
                    <span>🛒</span>
                </button>
                @else
                <button class="add-cart-btn" disabled>
                    ❌ Maaf, Produk Sedang Habis
                </button>
                @endif
            </div>
        </div>
    </div>

    <!-- FLOATING CART BUTTON -->
    <a href="/cart" class="floating-cart" id="floatingCart">
        🛒 Lihat Keranjang (<span id="floatingCartCount">0</span>)
    </a>

    <!-- TOAST -->
    <div class="toast" id="toast"></div>

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

        // Product payload generated via blade explicitly
        var currentProduct = {
            product_id: {{ $product->id }},
            name: @json($product->name),
            price: {{ (float) $product->price }},
            image_url: @json($product->image_url)
        };

        function addSingleToCart() {
            var cart = getCart();
            var existing = cart.find(function(i) { return i.product_id === currentProduct.product_id; });
            if (existing) {
                existing.quantity++;
            } else {
                currentProduct.quantity = 1;
                cart.push(currentProduct);
            }
            saveCart(cart);
            updateCartUI();
            showToast('✓ ' + currentProduct.name + ' ditambahkan ke keranjang!');
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

        updateCartUI();
    </script>
</body>
</html>
