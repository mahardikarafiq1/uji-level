<!-- Navbar partial — shared across landing, menu, cart pages -->
<nav class="navbar" id="navbar">
    <div class="container">
        <a href="/" class="nav-brand">felize cafe</a>
        <ul class="nav-links" id="navLinks">
            <li><a href="/#about">Tentang</a></li>
            <li><a href="/menu">Menu</a></li>
            <li><a href="/#features">Kenapa Kami</a></li>
            <li><a href="/cart" class="nav-cart-link">
                🛒 <span class="cart-badge" id="cartBadge" style="display:none;">0</span>
            </a></li>
            <li><a href="{{ url('/admin') }}" class="nav-cta">Pesan Meja</a></li>
        </ul>
        <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>
