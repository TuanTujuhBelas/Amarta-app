# 🦅 Garuda Amarta — Sistem Manajemen & Registrasi Atlet Pencak Silat

[![Laravel Version](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-v4-4E56A6?style=for-the-badge&logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Cloudflare R2](https://img.shields.io/badge/Cloudflare_R2-Storage-F38020?style=for-the-badge&logo=cloudflare&logoColor=white)](https://www.cloudflare.com/products/r2/)

Platform web modern berbasis **Laravel, Livewire, Tailwind CSS, dan Cloudflare R2** yang dirancang untuk memodernisasi pendaftaran atlet pencak silat, administrasi keanggotaan, verifikasi berkas terarah, hingga pencetakan dokumen resmi PDF dan arsip berkas ZIP terstruktur.

---

## 🎨 Identitas Visual (Brand Identity)

Aplikasi mengadopsi tema visual resmi **GARUDA AMARTA**:

| Warna | Hex Code | Penggunaan |
| :--- | :--- | :--- |
| **Royal Blue** | `#2B54C6` | Header Utama, Navbar, Tombol Primer |
| **Vibrant Yellow** | `#FFE500` | Aksen, Judul Logo, State Aktif, Progress Bar |
| **Crimson Red** | `#E52320` | Badges, Notifikasi Error, Tombol Revisi |
| **Deep Black** | `#111111` | Tipografi Utama, Border, Ikon |
| **Light Gray** | `#F8FAFC` | Latar Belakang Kanvas Aplikasi |

---

## ✨ Fitur Unggulan

### 1. Registrasi Atlet Mandiri (*Mobile-First Multistep Form*)
* **Step 1: Akun & Identitas Utama:** Input nama akun, username unik, email, password confirmed (disimpan dalam format MD5 aman), domisili, dan ranting latihan.
* **Step 2: Tingkat & Kategori Atlet:** Pemilihan tingkat sabuk, jenis kelamin, tingkat sekolah, dan kelas tanding.
  * *Auto-Mapping Kategori:*
    * **TK** $\rightarrow$ Kategori otomatis terkunci pada `Pra-UD`.
    * **SD** $\rightarrow$ Memunculkan pilihan manual `UD1` atau `UD2`.
    * **SMP** $\rightarrow$ Kategori otomatis terkunci pada `Pra Remaja`.
    * **SMA** $\rightarrow$ Kategori otomatis terkunci pada `Remaja`.
    * **Universitas** $\rightarrow$ Kategori otomatis terkunci pada `Dewasa`.
* **Step 3: Data Fisik & Orang Tua:** Input nama lengkap sesuai akte, tanggal lahir, berat badan (kg), tinggi badan (cm), kontak WhatsApp orang tua, NIK/KIA 16 digit, dan No. KK 16 digit.
* **Step 4: Unggah Berkas & Dokumen:** Upload Foto Profil, Kartu Keluarga, Akte/KIA, dan Surat Keterangan Sehat dilengkapi pratinjau langsung (*instant image preview*).
* **Generator ID Position Otomatis:**
  Sistem secara *atomic* membuat ID registrasi resmi dengan pembedaan prefix:
  * **Siswa / Atlet:** `SSW.[Tahun]-[TglBln]-[KodeSabuk][Urut]` *(Contoh: `SSW.2026-2710-005001`)*
  * **Pelatih:** `PLT.PELATIH-[Tahun]-[Urut]` *(Contoh: `PLT.PELATIH-2026-001`)*

### 2. Panel Manajemen Pelatih (*Coach Dashboard*)
* **Tabel Terpadu:** Memonitor status verifikasi atlet (`pending`, `approved`, `need_revision`).
* **Filter Bar Dinamis:** Penyaringan data atlet berdasarkan Ranting, Kategori, Kelas Tanding, dan Status.
* **Fitur Permintaan Revisi Berkas:** Pelatih dapat menandai dokumen tertentu yang tidak valid dan menambahkan catatan perbaikan langsung ke atlet.
* **Ekspor Dokumen & Berkas:**
  * Cetak Kartu / Dokumen Biodata Atlet format PDF berlogo resmi Garuda Amarta.
  * Ekspor arsip ZIP terstruktur folder per atlet melalui *Laravel Queue Background Job*.

### 3. Arsitektur Penyimpanan & Keamanan
* **Cloudflare R2 (S3-Compatible Storage):** Penyimpanan dokumen atlet di cloud object storage dengan kompresi otomatis di sisi server menggunakan PHP GD.
* **Auto-Delete File Lama:** Ketika atlet mengunggah ulang dokumen revisi, file usang di storage akan otomatis terhapus untuk mencegah penumpukan file yatim.
* **Audit Trail Lengkap (`t_activity_log`):** Merekam seluruh aktivitas data (`REGISTER`, `UPDATE_MANUAL`, `REQUEST_REVISION`, `SUBMIT_REVISION`, `EXPORT_DATA`) beserta alamat IP pelaku aksi.

---

## 🗄️ Skema Database

Sistem dibangun di atas 4 tabel utama:

1. **`m_account`**: Otentikasi pengguna (pelatih/siswa), MD5 password hash, status akun, dan `id_position`.
2. **`m_siswa`**: Biodata lengkap atlet, relasi 1-to-1 dengan `m_account`, jalur berkas dokumen, dan status verifikasi.
3. **`t_revisi_request`**: Log permintaan revisi berkas dari pelatih ke atlet (item disimpan dalam tipe data `JSON`).
4. **`t_activity_log`**: Log audit jejak perubahan data dan aktivitas sistem.

---

## 🚀 Panduan Instalasi Lokal (Getting Started)

### Prasyarat Sistem:
* **PHP:** Versi 8.2 atau lebih baru (dengan ekstensi `pdo_mysql`, `gd`, `fileinfo`)
* **Composer:** Versi 2.x
* **Node.js:** Versi 20.x atau lebih baru & NPM
* **Database:** MySQL 8.0 / MariaDB 10.6+

### Langkah-Langkah:

1. **Clone Repositori:**
   ```bash
   git clone https://github.com/TuanTujuhBelas/Amarta-app.git
   cd Amarta-app
   ```

2. **Install Dependensi PHP & Frontend:**
   ```bash
   composer install
   npm install
   ```

3. **Pengaturan Environment (`.env`):**
   Salin template environment:
   ```bash
   cp .env.example .env
   ```
   Generate application key:
   ```bash
   php artisan key:generate
   ```

4. **Konfigurasi Database di `.env`:**
   Sesuaikan konfigurasi database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3307        # Sesuaikan port MySQL Anda (3306 atau 3307)
   DB_DATABASE=AmartaDB
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Konfigurasi Cloudflare R2 (Opsional):**
   ```env
   CLOUDFLARE_R2_ACCESS_KEY_ID=your_access_key
   CLOUDFLARE_R2_SECRET_ACCESS_KEY=your_secret_key
   CLOUDFLARE_R2_BUCKET=amarta-documents
   CLOUDFLARE_R2_ENDPOINT=https://<accountid>.r2.cloudflarestorage.com
   CLOUDFLARE_R2_URL=https://pub-<id>.r2.dev
   ```
   *(Jika R2 belum diisi, sistem otomatis menggunakan local public storage).*

6. **Jalankan Migrasi Database & Symlink Storage:**
   ```bash
   php artisan migrate
   php artisan storage:link
   ```

7. **Compile Asset Frontend:**
   ```bash
   npm run build
   # atau untuk mode development hot-reload:
   npm run dev
   ```

8. **Jalankan Server Lokal:**
   ```bash
   php artisan serve
   ```
   Akses aplikasi di browser melalui: **`http://127.0.0.1:8000/register`**

---

## 🛠️ Struktur Direktori Kunci

```text
app/
├── Auth/
│   └── Md5EloquentUserProvider.php   # Autentikasi custom MD5 untuk m_account
├── Livewire/
│   └── AthleteRegistration.php       # Komponen wizard form registrasi atlet
├── Models/
│   ├── Account.php                   # Model m_account
│   ├── Student.php                   # Model m_siswa
│   ├── RevisionRequest.php           # Model t_revisi_request
│   └── ActivityLog.php               # Model t_activity_log
└── Services/
    ├── PositionIdService.php         # Generator ID Position atlet
    ├── R2StorageService.php          # Manajemen kompresi & storage R2
    └── ActivityLogger.php            # Helper audit log
resources/
├── css/
│   └── app.css                       # Tema palet warna Garuda Amarta di Tailwind v4
└── views/
    └── livewire/
        └── athlete-registration.blade.php  # Tampilan mobile-first form pendaftaran
```

---

## 📜 Lisensi & Hak Cipta

Dikembangkan untuk **Perguruan Pencak Silat Garuda Amarta**. Seluruh hak cipta dilindungi undang-undang.
