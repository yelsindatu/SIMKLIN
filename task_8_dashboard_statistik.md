# Task 8: Dashboard Statistik Kunjungan

## Deskripsi
Menyediakan halaman ringkasan performa dan laporan klinik untuk visualisasi manajemen.

## Kebutuhan Fungsional
1. **Grafik & Metrik:** Tampilkan total pasien hari ini, jumlah pendapatan harian/bulanan, dan grafik tren kunjungan mingguan.
2. **Visualisasi Data (Integrasi):** Pastikan tampilan dashboard dapat membaca dan merender seluruh data dummy (Seeder) dari Task 1 hingga Task 7 dengan logis.
3. **Role Akses:** Pastikan data sensitif finansial hanya bisa dilihat oleh Admin, sedangkan Dokter hanya melihat statistik jumlah kunjungan pasiennya.

## Aturan Teknis Tambahan
- Gunakan *query optimization* untuk mengumpulkan total aggregat dari database agar dashboard cepat diload.
