<!-- Navbar partial — shared across landing, menu, cart pages -->
<nav class="navbar" id="navbar">
    <div class="container">
        <a href="/" class="nav-brand">felize cafe</a>
        <ul class="nav-links" id="navLinks">
            <li><a href="/#about">Tentang</a></li>
            <li><a href="/menu">Menu</a></li>
            <li><a href="/reservation">Reservasi</a></li>
            <li><a href="/cart" class="nav-cart-link">
                🛒 <span class="cart-badge" id="cartBadgeNav" style="display:none;">0</span>
            </a></li>
            
            @auth
                @if(auth()->user()->role === 'admin')
                    <li><a href="{{ url('/admin') }}" class="nav-cta">Admin Panel</a></li>
                @else
                    <li style="color:var(--gold); font-size:12px; font-weight:600; display:flex; align-items:center;">
                        ⭐ {{ auth()->user()->loyalty_points }} pts
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="font-size:12px;">LOGOUT</a>
                        </form>
                    </li>
                @endif
            @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}" class="nav-cta">Daftar</a></li>
            @endauth
        </ul>
        <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>
