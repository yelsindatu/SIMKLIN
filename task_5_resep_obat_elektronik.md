# Task 5: Resep Obat Elektronik

## Deskripsi
Membuat modul e-prescription dan katalog obat yang akan digunakan oleh dokter saat melengkapi rekam medis.

## Kebutuhan Fungsional
1. **Tabel & Migrasi:** Buat tabel `medicines` dan `prescriptions`.
2. **Katalog Obat:** Sediakan fitur CRUD data obat (nama, tipe, harga, stok).
3. **Resep Dokter:** Tambahkan fitur penulisan resep (jumlah & dosis) yang berelasi ke tabel rekam medis.
4. **Visualisasi Data (Seeder):** Buat seeder untuk men-generate stok awal obat dan berikan data dummy resep obat pada rekam medis fiktif sebelumnya.

## Aturan Teknis Tambahan
- Sistem dapat otomatis memvalidasi sisa ketersediaan obat di database saat resep diterbitkan.
