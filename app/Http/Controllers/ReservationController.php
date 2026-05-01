<?php

namespace App\Http\Controllers;

use App\Models\CafeTable;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $tables = CafeTable::withCount(['reservations' => function ($query) {
            $query->where('reservation_date', '>=', now()->toDateString())
                  ->whereIn('status', ['pending', 'confirmed']);
        }])->orderBy('name')->get();

        return view('reservation', compact('tables'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cafe_table_id'    => 'required|exists:cafe_tables,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required|date_format:H:i',
            'guest_count'      => 'required|integer|min:1|max:20',
            'notes'            => 'nullable|string|max:500',
        ]);

        // Check if the table is already reserved at that date & time
        $existing = Reservation::where('cafe_table_id', $validated['cafe_table_id'])
            ->where('reservation_date', $validated['reservation_date'])
            ->where('reservation_time', $validated['reservation_time'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($existing) {
            return back()->with('error', 'Meja ini sudah direservasi pada tanggal dan waktu tersebut. Silakan pilih waktu lain.')
                         ->withInput();
        }

        // Check table capacity
        $table = CafeTable::findOrFail($validated['cafe_table_id']);
        if ($validated['guest_count'] > $table->capacity) {
            return back()->with('error', 'Jumlah tamu melebihi kapasitas meja (' . $table->capacity . ' orang).')
                         ->withInput();
        }

        Reservation::create([
            'user_id'          => auth()->id(),
            'cafe_table_id'    => $validated['cafe_table_id'],
            'reservation_date' => $validated['reservation_date'],
            'reservation_time' => $validated['reservation_time'],
            'guest_count'      => $validated['guest_count'],
            'notes'            => $validated['notes'] ?? null,
            'status'           => 'pending',
        ]);

        return redirect()->route('reservation.index')
                         ->with('success', 'Reservasi berhasil dibuat! Menunggu konfirmasi admin.');
    }

    /**
     * API: Get available time slots for a table on a given date.
     */
    public function availableSlots(Request $request)
    {
        $request->validate([
            'cafe_table_id'    => 'required|exists:cafe_tables,id',
            'reservation_date' => 'required|date',
        ]);

        $bookedTimes = Reservation::where('cafe_table_id', $request->cafe_table_id)
            ->where('reservation_date', $request->reservation_date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('reservation_time')
            ->map(fn ($t) => substr($t, 0, 5))
            ->toArray();

        // Operating hours: 08:00 - 22:00, 1 hour slots
        $allSlots = [];
        for ($h = 8; $h <= 21; $h++) {
            $allSlots[] = sprintf('%02d:00', $h);
        }

        $available = array_values(array_diff($allSlots, $bookedTimes));

        return response()->json(['slots' => $available, 'booked' => $bookedTimes]);
    }
}
