<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Meja — Felize Cafe</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700&family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
        :root{--coffee-darkest:#1a0d04;--coffee-dark:#2b1608;--coffee:#4b2a12;--coffee-medium:#6b3b1a;
            --cream:#d8c8b5;--cream-light:#e5d6c3;--cream-lightest:#f0ebe3;--paper:#faf8f5;
            --gold:#c9a96e;--gold-light:#e8d5a8;--text-dark:#2b1608;--text-muted:#7a5e44;--white:#fff;
            --success:#27ae60;--danger:#c0392b;}
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

        /* PAGE HEADER */
        .page-header{padding:120px 0 40px;text-align:center;}
        .page-header h1{font-family:'Playfair Display',serif;font-size:clamp(32px,5vw,48px);
            color:var(--coffee);font-weight:700;margin-bottom:8px;}
        .page-header p{font-size:16px;color:var(--text-muted);max-width:500px;margin:0 auto;}

        /* ALERTS */
        .alert{padding:16px 20px;border-radius:12px;margin-bottom:24px;font-weight:500;font-size:14px;
            display:flex;align-items:center;gap:8px;}
        .alert-success{background:rgba(39,174,96,0.1);border-left:4px solid var(--success);color:var(--success);}
        .alert-error{background:rgba(192,57,43,0.1);border-left:4px solid var(--danger);color:var(--danger);}

        /* LAYOUT */
        .reservation-layout{display:grid;grid-template-columns:1fr 1fr;gap:40px;padding-bottom:80px;}

        /* TABLE MAP */
        .table-map-card{background:var(--white);border-radius:20px;padding:32px;
            box-shadow:0 2px 12px rgba(75,42,18,0.06);border:1px solid rgba(229,214,195,0.4);}
        .table-map-card h3{font-family:'Playfair Display',serif;font-size:22px;color:var(--coffee);margin-bottom:4px;}
        .table-map-card .subtitle{font-size:14px;color:var(--text-muted);margin-bottom:24px;}
        .tables-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:16px;}
        .table-card{border:2px solid var(--cream);border-radius:16px;padding:20px;text-align:center;
            cursor:pointer;transition:all 0.3s;background:var(--white);position:relative;}
        .table-card:hover{border-color:var(--gold);transform:translateY(-2px);box-shadow:0 6px 20px rgba(75,42,18,0.1);}
        .table-card.selected{border-color:var(--coffee);background:var(--cream-lightest);}
        .table-card.unavailable{opacity:0.45;cursor:not-allowed;pointer-events:none;}
        .table-card .table-icon{font-size:32px;margin-bottom:8px;}
        .table-card .table-name{font-family:'Playfair Display',serif;font-size:16px;font-weight:600;color:var(--coffee);margin-bottom:4px;}
        .table-card .table-capacity{font-size:12px;color:var(--text-muted);}
        .table-card .table-status{font-size:11px;font-weight:600;margin-top:6px;padding:3px 10px;
            border-radius:20px;display:inline-block;}
        .table-status.available{background:rgba(39,174,96,0.12);color:var(--success);}
        .table-status.reserved{background:rgba(192,57,43,0.12);color:var(--danger);}

        /* FORM CARD */
        .form-card{background:var(--white);border-radius:20px;padding:32px;
            box-shadow:0 2px 12px rgba(75,42,18,0.06);border:1px solid rgba(229,214,195,0.4);
            position:sticky;top:100px;align-self:start;}
        .form-card h3{font-family:'Playfair Display',serif;font-size:22px;color:var(--coffee);margin-bottom:20px;}
        .form-group{margin-bottom:18px;}
        .form-group label{display:block;font-size:13px;font-weight:600;color:var(--coffee);margin-bottom:6px;}
        .form-input,.form-select{width:100%;padding:12px 16px;border:1.5px solid var(--cream);border-radius:12px;
            font-size:14px;outline:none;transition:border-color 0.3s;background:var(--paper);font-family:'Inter',sans-serif;}
        .form-input:focus,.form-select:focus{border-color:var(--coffee);}

        /* TIME SLOTS */
        .time-slots{display:grid;grid-template-columns:repeat(auto-fill,minmax(75px,1fr));gap:8px;margin-top:8px;}
        .time-slot{padding:10px 8px;border:1.5px solid var(--cream);border-radius:10px;text-align:center;
            cursor:pointer;font-size:13px;font-weight:500;transition:all 0.2s;background:var(--white);}
        .time-slot:hover{border-color:var(--gold);}
        .time-slot.selected{border-color:var(--coffee);background:var(--coffee);color:var(--white);}
        .time-slot.booked{opacity:0.35;cursor:not-allowed;pointer-events:none;text-decoration:line-through;}

        .btn-reserve{width:100%;padding:16px;border:none;border-radius:14px;background:var(--coffee);
            color:var(--white);font-size:16px;font-weight:600;cursor:pointer;transition:all 0.3s;
            font-family:'Inter',sans-serif;margin-top:8px;}
        .btn-reserve:hover{background:var(--coffee-medium);transform:translateY(-2px);
            box-shadow:0 8px 24px rgba(75,42,18,0.25);}
        .btn-reserve:disabled{opacity:0.5;cursor:not-allowed;transform:none;box-shadow:none;}

        .selected-info{background:var(--cream-lightest);border-radius:12px;padding:14px 18px;margin-bottom:20px;
            font-size:13px;color:var(--coffee);display:none;}
        .selected-info strong{color:var(--coffee-dark);}

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

        @media(max-width:1024px){.reservation-layout{grid-template-columns:1fr;}}
        @media(max-width:768px){
            .nav-links{display:none;}
            .nav-links.active{display:flex;flex-direction:column;position:absolute;top:100%;left:0;right:0;
                background:rgba(250,248,245,0.98);backdrop-filter:blur(20px);padding:24px;gap:16px;}
            .nav-toggle{display:block;}
            .tables-grid{grid-template-columns:repeat(auto-fill,minmax(120px,1fr));}
            .footer-grid{grid-template-columns:1fr;text-align:center;}
            .footer-socials{justify-content:center;}
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <section class="page-header">
        <h1>Reservasi Meja</h1>
        <p>Pilih meja favorit Anda dan pesan waktu kunjungan. Kami akan mengonfirmasi reservasi Anda segera.</p>
    </section>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">⚠ {{ session('error') }}</div>
        @endif

        <div class="reservation-layout">
            <!-- TABLE MAP -->
            <div class="table-map-card">
                <h3>Pilih Meja</h3>
                <p class="subtitle">Klik meja yang tersedia untuk melanjutkan reservasi</p>
                <div class="tables-grid">
                    @forelse($tables as $table)
                        <div class="table-card" 
                             data-id="{{ $table->id }}" 
                             data-name="{{ $table->name }}" 
                             data-capacity="{{ $table->capacity }}"
                             onclick="selectTable(this)">
                            <div class="table-icon">🪑</div>
                            <div class="table-name">{{ $table->name }}</div>
                            <div class="table-capacity">{{ $table->capacity }} Kursi</div>
                            <div class="table-status available">Tersedia</div>
                        </div>
                    @empty
                        <p style="color:var(--text-muted);grid-column:1/-1;text-align:center;padding:40px;">
                            Belum ada meja yang tersedia. Silakan hubungi admin.
                        </p>
                    @endforelse
                </div>
            </div>

            <!-- RESERVATION FORM -->
            <div class="form-card">
                <h3>Detail Reservasi</h3>

                <div class="selected-info" id="selectedInfo">
                    🪑 Meja: <strong id="selectedTableName">—</strong> 
                    &bull; Kapasitas: <strong id="selectedTableCapacity">—</strong> kursi
                </div>

                @auth
                <form method="POST" action="{{ route('reservation.store') }}" id="reservationForm">
                    @csrf
                    <input type="hidden" name="cafe_table_id" id="inputTableId">

                    <div class="form-group">
                        <label>Tanggal Reservasi *</label>
                        <input type="date" name="reservation_date" class="form-input" 
                               id="inputDate" min="{{ date('Y-m-d') }}" required
                               onchange="loadSlots()">
                    </div>

                    <div class="form-group">
                        <label>Waktu Reservasi *</label>
                        <input type="hidden" name="reservation_time" id="inputTime">
                        <div class="time-slots" id="timeSlots">
                            <p style="color:var(--text-muted);font-size:13px;grid-column:1/-1;">
                                Pilih meja dan tanggal terlebih dahulu
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Jumlah Tamu *</label>
                        <input type="number" name="guest_count" class="form-input" 
                               min="1" max="20" value="2" required>
                    </div>

                    <div class="form-group">
                        <label>Catatan (Opsional)</label>
                        <textarea name="notes" class="form-input" rows="2" 
                                  placeholder="Ulang tahun, acara spesial, dll..."></textarea>
                    </div>

                    <button type="submit" class="btn-reserve" id="btnReserve" disabled>
                        📋 Buat Reservasi
                    </button>
                </form>
                @else
                <div style="text-align:center;padding:40px 20px;">
                    <p style="font-size:48px;margin-bottom:16px;">🔒</p>
                    <h4 style="font-family:'Playfair Display',serif;color:var(--coffee);margin-bottom:8px;">Login Diperlukan</h4>
                    <p style="color:var(--text-muted);margin-bottom:20px;font-size:14px;">
                        Silakan login atau daftar terlebih dahulu untuk membuat reservasi.
                    </p>
                    <a href="{{ route('login') }}" style="display:inline-block;padding:12px 32px;background:var(--coffee);color:var(--white);border-radius:50px;text-decoration:none;font-weight:600;transition:all 0.3s;">
                        Login Sekarang
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script>
        let selectedTableId = null;

        function selectTable(el) {
            document.querySelectorAll('.table-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            selectedTableId = el.dataset.id;
            document.getElementById('inputTableId').value = selectedTableId;
            document.getElementById('selectedTableName').textContent = el.dataset.name;
            document.getElementById('selectedTableCapacity').textContent = el.dataset.capacity;
            document.getElementById('selectedInfo').style.display = 'block';
            loadSlots();
        }

        function loadSlots() {
            const date = document.getElementById('inputDate').value;
            if (!selectedTableId || !date) return;

            fetch(`/api/reservation/slots?cafe_table_id=${selectedTableId}&reservation_date=${date}`)
                .then(r => r.json())
                .then(data => {
                    const container = document.getElementById('timeSlots');
                    const allSlots = [];
                    for (let h = 8; h <= 21; h++) {
                        allSlots.push(String(h).padStart(2, '0') + ':00');
                    }
                    let html = '';
                    allSlots.forEach(slot => {
                        const isBooked = data.booked.includes(slot);
                        html += `<div class="time-slot ${isBooked ? 'booked' : ''}" 
                                      onclick="${isBooked ? '' : 'selectTime(this, \'' + slot + '\')'}">${slot}</div>`;
                    });
                    container.innerHTML = html;
                    document.getElementById('inputTime').value = '';
                    validateForm();
                });
        }

        function selectTime(el, time) {
            document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
            el.classList.add('selected');
            document.getElementById('inputTime').value = time;
            validateForm();
        }

        function validateForm() {
            const tableId = document.getElementById('inputTableId').value;
            const date = document.getElementById('inputDate').value;
            const time = document.getElementById('inputTime').value;
            const btn = document.getElementById('btnReserve');
            if (btn) btn.disabled = !(tableId && date && time);
        }

        document.getElementById('navToggle').addEventListener('click', function() {
            document.getElementById('navLinks').classList.toggle('active');
        });

        // Update Cart Badge from localStorage
        function updateCartBadge() {
            try { 
                var cart = JSON.parse(localStorage.getItem('felize_cart') || '[]');
                var count = cart.reduce((sum, item) => sum + item.quantity, 0);
                var badge = document.getElementById('cartBadgeNav');
                if (badge) {
                    badge.textContent = count;
                    badge.style.display = count > 0 ? 'flex' : 'none';
                }
            } catch(e) {}
        }
        updateCartBadge();
    </script>
</body>
</html>
