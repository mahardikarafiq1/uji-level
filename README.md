# ☕ Felize Cafe – Modern E-Commerce POS & Booking System

Sebuah sistem *Cafe Management* dan *E-Commerce* terpadu yang dibangun menggunakan ekosistem **Laravel 11** dan **Filament v3**. Website ini didesain tidak hanya sebagai perantara untuk melihat menu profil cafe saja, tetapi dioptimalkan secara langsung untuk operasional kafe seperti penerimaan pemesanan meja *Dine-in*, *Takeaway*, Manajemen Order, dan sistem struk mandiri mandiri (*Self-serve Checkout*).

## ✨ Fitur Utama

- **Landing Page Interaktif**: Menampilkan *Coffee Hero Parallax* khusus, seksi sejarah cafe, deskripsi service/fitur kafe, dan kurasi beberapa rekomendasi menu secara otomatis dari database.
- **Menu Guest Checkout**: 
   - Pelanggan (*Customer*) tidak diwajibkan untuk mendaftar akun atau login.
   - Keranjang/Cart secara asinkronus disimpan pada `localStorage` browser pengguna.
- **Sistem Pembayaran Dinamis**:
   - **Order via WhatsApp**: Semua data tagihan, nomor kode pemesanan keranjang, item belanja dirangkum menjadi pesan yang berformat lalu otomatis meneruskan pemesan untuk menge-chat nomor admin WhatsApp (bisa diatur mandiri dari _Pengaturan Dasbor_).
   - **Virtual Struk (QRIS)**: Order dicatat sementara dengan status _Tertunda (Pending)_, pelanggan diarahkan ke halaman virtual struk dengan gambar scanner barcode **QRIS**. Gambar _QRIS_ juga dapat diganti lewat kontrol dasbor kasir admin.
- **Admin Dashboard (Filament v3)**:
   - Panel canggih, minim lag bergaya mode layar terang warna *Kopi (Coffee Theme)*.
   - **Tabel Produk/Menu:** Tambah foto produk, atur ketersedian limit (_Stock Availability_), Harga dan Kategori, CRUD produk.
   - **Manajemen Pesanan:** Verifikasi status pemesanan (1 Kali Klik *Confirm Payment* action toggle dari list menu Order).
   - **Menu Pengaturan Instan:** Update pengaturan nomo HP WhatsApp kafe dan upload/update Gambar QRIS Toko.
- **Statistik & Analisis (Dahsboard Widgets)**:
   - Pantauan Grafik 7 Hari Laporan Income Kafe (Uang Masuk).
   - Indikator perhitungan metrik otomatis (Tingkat Pemasukkan Sukses, Tingkat Order Batal, Kalkulasi ~30% Profit Keuntungan).

## 🛠 Instalasi dan Konfigurasi Lokal

Dikarenakan proyek ini berjalan diatas ekosistem *Laravel*, pastikan lingkungan kerja komputermu sudah terinstall `PHP >= 8.2`, `Composer`, dan `Node.js` (opsional untuk asset bundling). Aplikasi ini secara bawaan menggunakan database **SQLite**, jadi kamu tidak perlu ribet mengkonfigurasikan MySQL/MariaDB!

1. Clone repositori ini atau ekstraksi berkas folder `uji-level`.
2. Buka terminal atau Command Prompt pada direktori project:
    ```bash
    cd uji-level
    ```
3. Lakukan instalasi semua *Dependency* Laravel:
    ```bash
    composer install
    ```
4. Mengcopy konfigurasi *environment* file (Jika belum ada):
    ```bash
    cp .env.example .env
    ```
5. Buat sebuah database SQLite yang kosong dengan men-generate file:
    ```bash
    touch database/database.sqlite
    ```
6. Generate _App Key_ dari Laravel:
    ```bash
    php artisan key:generate
    ```
7. Symlink Folder *Public Storage* (Wajib agar dapat mengunggah gambar produk dan gambar QRIS lalu menpilkannya):
    ```bash
    php artisan storage:link
    ```
8. Eksekusi semua file *Migrations* ke dalam tabel Database SQLite, sekaligus mengeksekusi Seeder (Bawaan _dummy_ user login admin, dan dummy products):
    ```bash
    php artisan migrate --seed
    ```
9. Jalankan web server Laravel!
    ```bash
    php artisan serve
    ```

## 🔒 Akses Kredensial Administrator

Setelah melakukan tahap *migration seeder* diatas, secara asali (*default*), sistem telah mempersiapkan **satu akun sakti Administrator** untuk mengendalikan selipan Filamnet Dashboard Panel. Silakan akses URL dibawah pada peramban web (*browser*):

**URL Login Panel**: `http://localhost:8000/admin`
**Alamat Email**: `admin@felizecafe.com`
**Kata Sandi (Password)**: `password`

## 🗃 Struktur Basis Data (Entity Relationship)

Aplikasi memiliki konsep model utama yang saling ber-relasi yakni:
- `Products` (Kopi, Roti, Hidangan)
- `Seats` (Nomor/Tanda letak bangku pada Kafe)
- `Orders` (Rincian Catatan Belanja, kode unik `FLZ-XXXX`, Metode Bayar)
- `Order_Items` (Koneksi list/daftar produk _Many-to-Many_ kearah pesanan *Orders*)
- `Settings` (Variabel penentu nilai dinamis _WA & Qris_)

---
*Dibuat oleh Tim Pengembang @ 2026 Felize Cafe Enterprise*
