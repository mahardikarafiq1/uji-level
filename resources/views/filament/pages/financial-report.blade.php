<x-filament-panels::page>
    @php $data = $this->getReportData(); @endphp

    <div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <div>
            <select wire:model.live="period" style="padding: 10px 16px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; background: white;">
                <option value="today">Hari Ini</option>
                <option value="this_week">Minggu Ini</option>
                <option value="this_month">Bulan Ini</option>
                <option value="last_month">Bulan Lalu</option>
                <option value="this_year">Tahun Ini</option>
            </select>
        </div>
        <div>
            <a href="{{ route('filament.admin.pages.financial-report', ['export' => true]) }}" 
               wire:click.prevent="exportExcel"
               style="padding: 10px 20px; background: #27ae60; color: white; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 6px;">
                📊 Export CSV
            </a>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.06);">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">💰 Total Pendapatan</div>
            <div style="font-size: 28px; font-weight: 700; color: #1a0d04;">
                Rp {{ number_format($data['totalRevenue'], 0, ',', '.') }}
            </div>
        </div>
        <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.06);">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">📦 Total Pesanan</div>
            <div style="font-size: 28px; font-weight: 700; color: #4b2a12;">
                {{ $data['totalOrders'] }}
            </div>
        </div>
        <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.06);">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">📊 Rata-rata Pesanan</div>
            <div style="font-size: 28px; font-weight: 700; color: #6b3b1a;">
                Rp {{ number_format($data['avgOrderValue'], 0, ',', '.') }}
            </div>
        </div>
        <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.06);">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">👤 Pelanggan Unik</div>
            <div style="font-size: 28px; font-weight: 700; color: #c9a96e;">
                {{ $data['uniqueCustomers'] }}
            </div>
        </div>
    </div>

    {{-- BREAKDOWN CARDS --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
        <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.06);">
            <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 12px;">🍽️ Tipe Pesanan</h3>
            <div style="display: flex; gap: 16px;">
                <div style="flex:1; text-align:center; padding: 16px; border-radius: 8px; background: #ecfdf5;">
                    <div style="font-size: 24px; font-weight: 700; color: #27ae60;">{{ $data['dineInCount'] }}</div>
                    <div style="font-size: 12px; color: #6b7280;">Dine In</div>
                </div>
                <div style="flex:1; text-align:center; padding: 16px; border-radius: 8px; background: #fffbeb;">
                    <div style="font-size: 24px; font-weight: 700; color: #f59e0b;">{{ $data['takeAwayCount'] }}</div>
                    <div style="font-size: 12px; color: #6b7280;">Take Away</div>
                </div>
            </div>
        </div>
        <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.06);">
            <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 12px;">💳 Metode Pembayaran</h3>
            <div style="display: flex; gap: 16px;">
                <div style="flex:1; text-align:center; padding: 16px; border-radius: 8px; background: #ecfdf5;">
                    <div style="font-size: 24px; font-weight: 700; color: #27ae60;">{{ $data['waCount'] }}</div>
                    <div style="font-size: 12px; color: #6b7280;">WhatsApp</div>
                </div>
                <div style="flex:1; text-align:center; padding: 16px; border-radius: 8px; background: #eef2ff;">
                    <div style="font-size: 24px; font-weight: 700; color: #6366f1;">{{ $data['qrisCount'] }}</div>
                    <div style="font-size: 12px; color: #6b7280;">QRIS</div>
                </div>
            </div>
        </div>
    </div>

    {{-- DAILY REVENUE TABLE --}}
    <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); margin-bottom: 24px;">
        <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 16px;">📅 Pendapatan Harian</h3>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead>
                    <tr style="border-bottom: 2px solid #e5e7eb;">
                        <th style="padding: 12px; text-align: left; color: #6b7280; font-weight: 600;">Tanggal</th>
                        <th style="padding: 12px; text-align: right; color: #6b7280; font-weight: 600;">Pesanan</th>
                        <th style="padding: 12px; text-align: right; color: #6b7280; font-weight: 600;">Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['dailyRevenue'] as $day)
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 12px;">{{ \Carbon\Carbon::parse($day->date)->format('d M Y') }}</td>
                            <td style="padding: 12px; text-align: right;">{{ $day->order_count }}</td>
                            <td style="padding: 12px; text-align: right; font-weight: 600;">Rp {{ number_format($day->revenue, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="padding: 24px; text-align: center; color: #9ca3af;">Belum ada data untuk periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TOP PRODUCTS TABLE --}}
    <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.06);">
        <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 16px;">🏆 Produk Terlaris</h3>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead>
                    <tr style="border-bottom: 2px solid #e5e7eb;">
                        <th style="padding: 12px; text-align: left; color: #6b7280; font-weight: 600;">#</th>
                        <th style="padding: 12px; text-align: left; color: #6b7280; font-weight: 600;">Produk</th>
                        <th style="padding: 12px; text-align: right; color: #6b7280; font-weight: 600;">Terjual</th>
                        <th style="padding: 12px; text-align: right; color: #6b7280; font-weight: 600;">Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['topProducts'] as $index => $tp)
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 12px; font-weight: 600; color: #c9a96e;">{{ $index + 1 }}</td>
                            <td style="padding: 12px; font-weight: 500;">{{ $tp->product ? $tp->product->name : 'Deleted' }}</td>
                            <td style="padding: 12px; text-align: right;">{{ $tp->total_sold }} pcs</td>
                            <td style="padding: 12px; text-align: right; font-weight: 600;">Rp {{ number_format($tp->total_revenue, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 24px; text-align: center; color: #9ca3af;">Belum ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
