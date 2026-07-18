# Task 6: Manajemen Kamar dan Jadwal Perawat

## Deskripsi
Mengembangkan fitur alokasi penggunaan kamar dan penjadwalan dinas (shift) harian untuk perawat.

## Kebutuhan Fungsional
1. **Tabel & Migrasi:** Buat tabel `rooms` dan `nurse_schedules`.
2. **Alokasi Kamar & Perawat:** Modul untuk menetapkan perawat (berdasarkan role user Perawat) ke kamar tertentu pada shift (pagi/sore/malam) di tanggal tertentu.
3. **Validasi:** Memastikan tidak ada tabrakan jadwal perawat di waktu yang sama, serta 1 kamar hanya untuk 1 dokter/perawat dalam satu waktu.
4. **Visualisasi Data (Seeder):** Buat daftar dummy ruangan (misal: Ruang Triage, Ruang Periksa 1, 2) dan distribusikan jadwal perawat fiktif secara merata dalam seminggu.
