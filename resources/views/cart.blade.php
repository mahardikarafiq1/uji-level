<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang — Felize Cafe</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700&family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
        :root{--coffee-darkest:#1a0d04;--coffee-dark:#2b1608;--coffee:#4b2a12;--coffee-medium:#6b3b1a;
            --cream:#d8c8b5;--cream-light:#e5d6c3;--cream-lightest:#f0ebe3;--paper:#faf8f5;
            --gold:#c9a96e;--gold-light:#e8d5a8;--text-dark:#2b1608;--text-muted:#7a5e44;--white:#fff;}
        html{scroll-behavior:smooth}
        body{font-family:'Inter',sans-serif;color:var(--text-dark);background:var(--paper);min-height:100vh;}
        .container{max-width:1200px;margin:0 auto;padding:0 24px;}

        /* NAVBAR */
        .navbar{position:fixed;top:0;left:0;right:0;z-index:1000;padding:16px 0;
            background:rgba(250,248,245,0.92);backdrop-filter:blur(20px);box-shadow:0 1px 24px rgba(75,42,18,0.08);}
        .navbar .container{display:flex;justify-content:space-between;align-items:center;}
        .nav-brand{font-family:'Great Vibes',cursive;font-size:32px;color:var(--coffee);text-decoration:none;}
        .nav-links{display:flex;gap:28px;list-style:none;align-items:center;}
        .nav-links a{color:var(--coffee-medium);text-decoration:none;font-size:14px;font-weight:500;
            letter-spacing:0.5px;text-transform:uppercase;transition:color 0.3s;}
        .nav-links a:hover{color:var(--coffee);}
        .nav-cta{background:var(--coffee)!important;color:var(--white)!important;padding:10px 24px;
            border-radius:50px;font-weight:600!important;}
        .nav-cta:hover{background:var(--coffee-medium)!important;}
        .nav-toggle{display:none;background:none;border:none;cursor:pointer;padding:8px;}
        .nav-toggle span{display:block;width:24px;height:2px;background:var(--coffee);margin:6px 0;border-radius:2px;}

        /* PAGE */
        .page-header{padding:120px 0 32px;text-align:center;}
        .page-header h1{font-family:'Playfair Display',serif;font-size:clamp(32px,5vw,48px);
            color:var(--coffee);font-weight:700;margin-bottom:8px;}
        .page-header p{font-size:16px;color:var(--text-muted);}

        /* CART LAYOUT */
        .cart-layout{display:grid;grid-template-columns:1.4fr 1fr;gap:36px;padding-bottom:80px;}

        /* CART ITEMS */
        .cart-items-box{background:var(--white);border-radius:20px;padding:28px;
            box-shadow:0 2px 8px rgba(75,42,18,0.08);border:1px solid rgba(229,214,195,0.4);}
        .cart-item{display:flex;gap:16px;padding:16px 0;border-bottom:1px solid var(--cream-lightest);align-items:center;}
        .cart-item:last-child{border-bottom:none;}
        .cart-item-img{width:72px;height:72px;border-radius:12px;object-fit:cover;background:var(--cream-lightest);}
        .cart-item-info{flex:1;}
        .cart-item-info h4{font-family:'Playfair Display',serif;font-size:16px;color:var(--coffee);margin-bottom:4px;}
        .cart-item-info .price{font-size:14px;color:var(--text-muted);}
        .qty-control{display:flex;align-items:center;gap:8px;}
        .qty-btn{width:32px;height:32px;border-radius:8px;border:1.5px solid var(--cream);background:var(--white);
            font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;
            color:var(--coffee);transition:all 0.2s;font-weight:600;}
        .qty-btn:hover{background:var(--coffee);color:var(--white);border-color:var(--coffee);}
        .qty-val{font-weight:600;font-size:15px;min-width:20px;text-align:center;}
        .cart-item-subtotal{font-family:'Playfair Display',serif;font-size:16px;font-weight:700;
            color:var(--coffee-medium);min-width:100px;text-align:right;}
        .remove-btn{background:none;border:none;color:#c0392b;cursor:pointer;font-size:18px;
            padding:4px;transition:transform 0.2s;}
        .remove-btn:hover{transform:scale(1.2);}

        /* CHECKOUT BOX */
        .checkout-box{background:var(--white);border-radius:20px;padding:28px;
            box-shadow:0 2px 8px rgba(75,42,18,0.08);border:1px solid rgba(229,214,195,0.4);
            position:sticky;top:100px;align-self:start;}
        .checkout-box h3{font-family:'Playfair Display',serif;font-size:22px;color:var(--coffee);margin-bottom:20px;}
        .summary-row{display:flex;justify-content:space-between;padding:8px 0;font-size:14px;color:var(--text-muted);}
        .summary-total{display:flex;justify-content:space-between;padding:14px 0;border-top:2px solid var(--cream);
            margin-top:8px;font-size:18px;font-weight:700;color:var(--coffee);}
        .form-group{margin-bottom:16px;}
        .form-group label{display:block;font-size:13px;font-weight:600;color:var(--coffee);margin-bottom:6px;}
        .form-input{width:100%;padding:12px 16px;border:1.5px solid var(--cream);border-radius:12px;
            font-size:14px;outline:none;transition:border-color 0.3s;background:var(--paper);font-family:'Inter',sans-serif;}
        .form-input:focus{border-color:var(--coffee);}
        .form-select{width:100%;padding:12px 16px;border:1.5px solid var(--cream);border-radius:12px;
            font-size:14px;outline:none;background:var(--paper);font-family:'Inter',sans-serif;cursor:pointer;}
        .form-select:focus{border-color:var(--coffee);}

        /* PAYMENT OPTIONS */
        .payment-options{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;}
        .payment-opt{padding:16px;border:2px solid var(--cream);border-radius:14px;text-align:center;
            cursor:pointer;transition:all 0.3s;background:var(--white);}
        .payment-opt:hover{border-color:var(--gold);}
        .payment-opt.selected{border-color:var(--coffee);background:var(--cream-lightest);}
        .payment-opt input{display:none;}
        .payment-opt .pay-icon{font-size:28px;margin-bottom:6px;}
        .payment-opt .pay-label{font-size:13px;font-weight:600;color:var(--coffee);}

        .btn-checkout{width:100%;padding:16px;border:none;border-radius:14px;background:var(--coffee);
            color:var(--white);font-size:16px;font-weight:600;cursor:pointer;transition:all 0.3s;
            font-family:'Inter',sans-serif;margin-top:8px;}
        .btn-checkout:hover{background:var(--coffee-medium);transform:translateY(-2px);
            box-shadow:0 8px 24px rgba(75,42,18,0.25);}
        .btn-checkout:disabled{opacity:0.5;cursor:not-allowed;transform:none;box-shadow:none;}

        /* EMPTY CART */
        .empty-cart{text-align:center;padding:80px 24px;}
        .empty-cart .icon{font-size:72px;margin-bottom:16px;}
        .empty-cart h3{font-family:'Playfair Display',serif;font-size:24px;color:var(--coffee);margin-bottom:8px;}
        .empty-cart p{color:var(--text-muted);margin-bottom:24px;}
        .btn-browse{display:inline-flex;align-items:center;gap:8px;padding:14px 32px;background:var(--coffee);
            color:var(--white);border-radius:50px;text-decoration:none;font-weight:600;transition:all 0.3s;}
        .btn-browse:hover{background:var(--coffee-medium);transform:translateY(-2px);}

        /* FOOTER */
        .footer{background:var(--coffee-darkest);color:rgba(255,255,255,0.6);padding:72px 0 0;}
        .footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:48px;margin-bottom:48px;}
        .footer-brand{font-family:'Great Vibes',cursive;font-size:36px;color:var(--gold);margin-bottom:16px;}
        .footer-desc{font-size:14px;line-height:1.8;margin-bottom:20px;}
        .footer-socials{display:flex;gap:12px;}
        .footer-socials a{width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,0.06);
            display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.5);
            text-decoration:none;transition:all 0.3s;font-size:16px;}
        .footer-socials a:hover{background:var(--gold);color:var(--coffee-darkest);}
        .footer h4{color:var(--white);font-family:'Playfair Display',serif;font-size:16px;font-weight:600;margin-bottom:20px;}
        .footer ul{list-style:none;}
        .footer ul li{margin-bottom:12px;}
        .footer ul a{color:rgba(255,255,255,0.5);text-decoration:none;font-size:14px;transition:color 0.3s;}
        .footer ul a:hover{color:var(--gold);}
        .footer-bottom{border-top:1px solid rgba(255,255,255,0.08);padding:24px 0;text-align:center;font-size:13px;}

        @media(max-width:1024px){.cart-layout{grid-template-columns:1fr;}}
        @media(max-width:768px){.nav-links{display:none;}
            .nav-links.active{display:flex;flex-direction:column;position:absolute;top:100%;left:0;right:0;
                background:rgba(250,248,245,0.98);backdrop-filter:blur(20px);padding:24px;gap:16px;}
            .nav-toggle{display:block;}
            .payment-options{grid-template-columns:1fr;}
            .footer-grid{grid-template-columns:1fr;text-align:center;}
            .footer-socials{justify-content:center;}}
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container">
            <a href="/" class="nav-brand">felize cafe</a>
            <ul class="nav-links" id="navLinks">
                <li><a href="/#about">Tentang</a></li>
                <li><a href="/menu">Menu</a></li>
                <li><a href="/cart">🛒 Keranjang</a></li>
                <li><a href="{{ url('/admin') }}" class="nav-cta">Pesan Meja</a></li>
            </ul>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    <section class="page-header">
        <h1>Keranjang Anda</h1>
        <p>Periksa pesanan Anda sebelum checkout</p>
    </section>

    <div class="container">
        <!-- EMPTY STATE -->
        <div class="empty-cart" id="emptyCart" style="display:none;">
            <div class="icon">🛒</div>
            <h3>Keranjang Kosong</h3>
            <p>Anda belum menambahkan produk apapun. Yuk jelajahi menu kami!</p>
            <a href="/menu" class="btn-browse">☕ Jelajahi Menu</a>
        </div>

        <!-- CART CONTENT -->
        <div class="cart-layout" id="cartContent" style="display:none;">
            <div class="cart-items-box">
                <h3 style="font-family:'Playfair Display',serif;font-size:20px;color:var(--coffee);margin-bottom:16px;">
                    Item Pesanan
                </h3>
                <div id="cartItemsList"></div>
            </div>

            <div class="checkout-box">
                <h3>Checkout</h3>

                <div id="summarySection"></div>

                <form method="POST" action="{{ route('checkout') }}" id="checkoutForm">
                    @csrf
                    <input type="hidden" name="items" id="cartItemsInput">

                    <div class="form-group">
                        <label>Nama Lengkap *</label>
                        <input type="text" name="customer_name" class="form-input" placeholder="Masukkan nama Anda" required>
                    </div>

                    <div class="form-group">
                        <label>Nomor WhatsApp *</label>
                        <input type="tel" name="customer_phone" class="form-input" placeholder="081234567890" required>
                    </div>

                    <div class="form-group">
                        <label>Pilih Meja (Opsional)</label>
                        <select name="seat_code" class="form-select">
                            <option value="">— Tidak pilih meja —</option>
                            @foreach($seats as $seat)
                                <option value="{{ $seat->seat_code }}">{{ $seat->seat_code }} — {{ $seat->position }} ({{ $seat->capacity }} orang)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Catatan (Opsional)</label>
                        <textarea name="notes" class="form-input" rows="2" placeholder="Tidak pakai gula, dll..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Metode Pembayaran *</label>
                        <div class="payment-options">
                            <label class="payment-opt" id="payWa" onclick="selectPayment('whatsapp')">
                                <input type="radio" name="payment_method" value="whatsapp" required>
                                <div class="pay-icon">💬</div>
                                <div class="pay-label">WhatsApp</div>
                            </label>
                            <label class="payment-opt" id="payQris" onclick="selectPayment('qris')">
                                <input type="radio" name="payment_method" value="qris">
                                <div class="pay-icon">📱</div>
                                <div class="pay-label">QRIS</div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn-checkout" id="btnCheckout" disabled>
                        🛒 Buat Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script>
        function getCart() {
            try { return JSON.parse(localStorage.getItem('felize_cart') || '[]'); }
            catch(e) { return []; }
        }
        function saveCart(cart) { localStorage.setItem('felize_cart', JSON.stringify(cart)); }
        function fmt(n) { return 'Rp ' + n.toLocaleString('id-ID'); }

        function renderCart() {
            var cart = getCart();
            if (cart.length === 0) {
                document.getElementById('emptyCart').style.display = 'block';
                document.getElementById('cartContent').style.display = 'none';
                return;
            }
            document.getElementById('emptyCart').style.display = 'none';
            document.getElementById('cartContent').style.display = 'grid';

            var html = '';
            var total = 0;
            cart.forEach(function(item) {
                var sub = item.price * item.quantity;
                total += sub;
                var imgSrc = item.image_url || '';
                var imgTag = imgSrc
                    ? '<img class="cart-item-img" src="' + imgSrc + '" alt="' + item.name + '">'
                    : '<div class="cart-item-img" style="display:flex;align-items:center;justify-content:center;font-size:24px;">☕</div>';

                html += '<div class="cart-item">' +
                    imgTag +
                    '<div class="cart-item-info"><h4>' + item.name + '</h4>' +
                    '<div class="price">' + fmt(item.price) + '</div></div>' +
                    '<div class="qty-control">' +
                    '<button class="qty-btn" onclick="changeQty(' + item.product_id + ',-1)">−</button>' +
                    '<span class="qty-val">' + item.quantity + '</span>' +
                    '<button class="qty-btn" onclick="changeQty(' + item.product_id + ',1)">+</button></div>' +
                    '<div class="cart-item-subtotal">' + fmt(sub) + '</div>' +
                    '<button class="remove-btn" onclick="removeItem(' + item.product_id + ')" title="Hapus">✕</button>' +
                    '</div>';
            });
            document.getElementById('cartItemsList').innerHTML = html;

            var count = cart.reduce(function(s, i) { return s + i.quantity; }, 0);
            var summary = '<div class="summary-row"><span>' + count + ' item</span><span>' + fmt(total) + '</span></div>' +
                '<div class="summary-total"><span>Total</span><span>' + fmt(total) + '</span></div>';
            document.getElementById('summarySection').innerHTML = summary;

            document.getElementById('cartItemsInput').value = JSON.stringify(
                cart.map(function(i) { return { product_id: i.product_id, quantity: i.quantity }; })
            );
        }

        function changeQty(pid, delta) {
            var cart = getCart();
            var item = cart.find(function(i) { return i.product_id === pid; });
            if (!item) return;
            item.quantity += delta;
            if (item.quantity <= 0) { cart = cart.filter(function(i) { return i.product_id !== pid; }); }
            saveCart(cart);
            renderCart();
        }

        function removeItem(pid) {
            var cart = getCart().filter(function(i) { return i.product_id !== pid; });
            saveCart(cart);
            renderCart();
        }

        function selectPayment(method) {
            document.querySelectorAll('.payment-opt').forEach(function(el) { el.classList.remove('selected'); });
            if (method === 'whatsapp') { document.getElementById('payWa').classList.add('selected'); }
            else { document.getElementById('payQris').classList.add('selected'); }
            document.getElementById('btnCheckout').disabled = false;
        }

        // Clear cart after form submission
        document.getElementById('checkoutForm').addEventListener('submit', function() {
            setTimeout(function() { localStorage.removeItem('felize_cart'); }, 500);
        });

        document.getElementById('navToggle').addEventListener('click', function() {
            document.getElementById('navLinks').classList.toggle('active');
        });

        renderCart();
    </script>
</body>
</html>
