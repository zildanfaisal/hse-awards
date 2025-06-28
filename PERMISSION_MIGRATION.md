# Migrasi dari Role-based ke Permission-based Access Control

## Perubahan yang Telah Dilakukan

### 1. Model User

-   Menambahkan method `hasPermission($permission)` untuk mengecek permission user
-   Method ini mengecek apakah user memiliki role yang memiliki permission tertentu

### 2. View Templates

Semua pengecekan akses di view telah diganti dari:

```php
@if(Auth::user()->role === 'super-admin')
```

Menjadi:

```php
@if(Auth::user()->hasPermission('permission_name'))
```

**Permission yang digunakan:**

-   `kelola_role` - Untuk manajemen user dan role
-   `data_proyek` - Untuk CRUD proyek
-   `data_kriteria` - Untuk CRUD kriteria dan sub-kriteria
-   `penilaian` - Untuk fitur penilaian dan ranking

### 3. Routes

Semua middleware route telah diganti dari:

```php
Route::middleware('role:super-admin')->group(function () {
```

Menjadi:

```php
Route::middleware('permission:permission_name')->group(function () {
```

### 4. Middleware

-   `RolePermissionMiddleware` sudah terdaftar di `app/Http/Kernel.php`
-   Middleware mengecek permission user melalui role yang dimiliki

### 5. Database

-   Seeder `RolePermissionSeeder` telah dijalankan
-   Role dan permission sudah tersedia di database
-   User yang ada telah di-assign role `super_admin` yang memiliki semua permission

## Cara Kerja Sistem Permission

1. **Role** - Kumpulan permission (super_admin, admin, tim_penilai, koordinator)
2. **Permission** - Hak akses spesifik (kelola_role, data_proyek, data_kriteria, penilaian)
3. **User** - Memiliki satu atau lebih role
4. **Access Check** - Menggunakan `$user->hasPermission('permission_name')`

## Keuntungan Sistem Baru

1. **Fleksibilitas** - Mudah menambah/mengubah permission tanpa mengubah kode
2. **Granular Control** - Permission yang lebih spesifik
3. **Scalability** - Mudah menambah role dan permission baru
4. **Maintainability** - Kode lebih bersih dan mudah dipahami

## Langkah Selanjutnya

1. **Hapus kolom `role` dari tabel `users`** (setelah memastikan semua user sudah di-assign role)
2. **Tambahkan permission baru** sesuai kebutuhan
3. **Buat role baru** dengan kombinasi permission yang sesuai
4. **Test semua fitur** untuk memastikan permission berfungsi dengan benar
