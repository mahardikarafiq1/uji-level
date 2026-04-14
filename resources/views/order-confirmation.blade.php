<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan #{{ $order->order_code }} — Felize Cafe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono&family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --coffee-darkest: #1a0d04; --coffee: #4b2a12; --coffee-medium: #6b3b1a;
            --cream: #d8c8b5; --paper: #faf8f5; --gold: #c9a96e; --text-dark: #2b1608;
            --text-muted: #7a5e44; --border: rgba(229, 214, 195, 0.6);
        }
        body { font-family: 'Inter', sans-serif; background: var(--paper); color: var(--text-dark);
            min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 24px; }
        .receipt-container { width: 100%; max-width: 460px; background: #fff;
            border-radius: 8px; box-shadow: 0 12px 48px rgba(75, 42, 18, 0.08); padding: 40px;
            position: relative; border-top: 8px solid var(--coffee); }
        .receipt-container::before, .receipt-container::after { content: ''; position: absolute;
            left: 0; right: 0; height: 12px; background-size: 24px 24px; }
        .receipt-container::before { top: -12px; background-image: radial-gradient(circle at 12px 12px, transparent 12px, var(--coffee) 13px); }
        .receipt-container::after { bottom: -12px; background-image: radial-gradient(circle at 12px 0px, #fff 12px, transparent 13px); }

        .brand { font-family: 'Great Vibes', cursive; font-size: 36px; color: var(--coffee);
            text-align: center; margin-bottom: 4px; }
        .address { text-align: center; font-size: 13px; color: var(--text-muted); margin-bottom: 32px; line-height: 1.5; }

        .status-badge { display: inline-block; padding: 6px 16px; border-radius: 50px; font-size: 13px;
            font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin: 0 auto 24px; }
        .status-badge.pending { background: #fef9c3; color: #a16207; }
        .status-badge.processing { background: #e0f2fe; color: #0369a1; }
        .status-badge.completed { background: #dcfce7; color: #15803d; }
        .status-badge.cancelled { background: #fee2e2; color: #b91c1c; }
        .badge-wrapper { text-align: center; }

        .detail-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; }
        .detail-label { color: var(--text-muted); }
        .detail-val { font-weight: 600; color: var(--coffee); }
        .val-mono { font-family: 'JetBrains Mono', monospace; }

        .divider { height: 1px; background: var(--border); margin: 24px 0; border-bottom: 1px dashed var(--cream); }

        .item-list { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .item-list th { text-align: left; font-size: 12px; color: var(--text-muted); padding-bottom: 12px;
            border-bottom: 1px solid var(--border); font-weight: 500; text-transform: uppercase; }
        .item-list th.right { text-align: right; }
        .item-list td { padding: 12px 0; font-size: 14px; border-bottom: 1px dashed var(--border); }
        .item-list td.right { text-align: right; }
        .item-list tr:last-child td { border-bottom: none; }
        .item-name { font-weight: 600; color: var(--coffee-darkest); margin-bottom: 4px; }
        .item-prc { font-size: 13px; color: var(--text-muted); }

        .total-row { display: flex; justify-content: space-between; align-items: center; font-size: 18px;
            font-weight: 700; color: var(--coffee); background: var(--paper); padding: 16px; border-radius: 8px; }

        .qris-box { text-align: center; margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border); }
        .qris-box h4 { font-family: 'Playfair Display', serif; color: var(--coffee); margin-bottom: 16px; }
        .qris-img { max-width: 200px; height: auto; border: 4px solid var(--cream-lightest); border-radius: 12px; margin-bottom: 16px; }
        .qris-box p { font-size: 13px; color: var(--text-muted); line-height: 1.6; }

        .actions { margin-top: 32px; display: flex; flex-direction: column; gap: 12px; }
        .btn { display: flex; align-items: center; justify-content: center; gap: 8px; padding: 14px;
            border-radius: 8px; font-weight: 600; font-size: 15px; text-decoration: none; transition: all 0.3s; }
        .btn-wa { background: #25D366; color: #fff; }
        .btn-wa:hover { background: #20bd5a; }
        .btn-home { background: var(--paper); color: var(--coffee); border: 1px solid var(--cream); }
        .btn-home:hover { background: var(--cream-lightest); }

        .thanks { text-align: center; font-size: 14px; color: var(--text-muted); margin-top: 32px; font-style: italic; }

        @media print {
            body { background: #fff; padding: 0; }
            .receipt-container { box-shadow: none; max-width: 100%; border: none; padding: 20px; }
            .receipt-container::before, .receipt-container::after { display: none; }
            .actions { display: none; }
        }
    </style>
</head>
<body>

    <div class="receipt-container">
        <div class="brand">felize cafe</div>
        <div class="address">Jl. Coffee No. 12, Jakarta<br>hello@felizecafe.com | +62 812-3456-7890</div>

        <div class="badge-wrapper">
            <div class="status-badge {{ $order->status }}">
                @if($order->status === 'pending')
                    🟡 Menunggu Pembayaran
                @elseif($order->status === 'processing')
                    🔵 Diproses
                @elseif($order->status === 'completed')
                    ✅ Selesai
                @elseif($order->status === 'cancelled')
                    🔴 Dibatalkan
                @endif
            </div>
        </div>

        <div class="detail-row">
            <span class="detail-label">No. Order</span>
            <span class="detail-val val-mono">{{ $order->order_code }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Tanggal</span>
            <span class="detail-val">{{ $order->created_at->format('d M Y, H:i') }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Customer</span>
            <span class="detail-val">{{ $order->customer_name }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Meja</span>
            <span class="detail-val">{{ $order->seat_code ? strtoupper($order->seat_code) : 'Takeaway / Tidak Pilih' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Metode Bayar</span>
            <span class="detail-val">{{ $order->payment_method === 'whatsapp' ? 'WhatsApp Transfer' : 'QRIS' }}</span>
        </div>

        <div class="divider"></div>

        <table class="item-list">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="right">Qty</th>
                    <th class="right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <div class="item-name">{{ $item->product ? $item->product->name : 'Produk Dihapus' }}</div>
                        <div class="item-prc">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</div>
                    </td>
                    <td class="right val-mono">x{{ $item->quantity }}</td>
                    <td class="right val-mono">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-row">
            <span>TOTAL DUE</span>
            <span class="val-mono">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
        </div>

        @if($order->notes)
        <div style="margin-top:20px; font-size:13px; background:var(--paper); padding:12px; border-radius:6px; color:var(--text-muted);">
            <strong>Catatan:</strong> {{ $order->notes }}
        </div>
        @endif

        @if($order->payment_method === 'qris' && $order->status === 'pending')
            <div class="qris-box">
                <h4>Scan untuk Membayar</h4>
                @if($qrisImage)
                    <img src="{{ asset('storage/' . $qrisImage) }}" alt="QRIS Code" class="qris-img">
                @else
                    <div style="width:200px; height:200px; background:#e2e8f0; margin:0 auto 16px; display:flex; align-items:center; justify-content:center; color:#64748b; font-size:12px; border-radius:12px;">QRIS BELUM DISETTING ADMIN</div>
                @endif
                <p>Silakan scan QRIS di atas untuk melakukan pembayaran sejumlah<br><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>.</p>
                <p style="margin-top:12px; font-weight:600;">Setelah membayar, mohon konfirmasi ke kasir atau via WhatsApp.</p>
            </div>
        @endif

        <div class="actions">
            @if(session('wa_url'))
                <a href="{{ session('wa_url') }}" target="_blank" class="btn btn-wa">
                    💬 Lanjut Konfirmasi ke WhatsApp
                </a>
            @elseif($order->status === 'pending')
                <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo Admin, saya ingin mengkonfirmasi pembayaran untuk Order ' . $order->order_code . '. Berikut bukti pembayarannya:') }}" target="_blank" class="btn btn-wa">
                    💬 Konfirmasi via WhatsApp
                </a>
            @endif

            <a href="javascript:window.print()" class="btn btn-home" style="margin-top:-4px;">
                🖨️ Cetak Struk
            </a>
            <a href="/menu" class="btn btn-home" style="margin-top:-4px;">
                ← Kembali ke Menu
            </a>
        </div>

        <div class="thanks">"Terima kasih atas pesanan Anda. Have a wonderful day!"</div>
    </div>

</body>
</html>
