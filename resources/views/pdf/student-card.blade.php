<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Biodata Atlet - {{ $student->nama_lengkap }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #111111;
            font-size: 12px;
            line-height: 1.5;
            margin: 20px 25px;
        }
        .header {
            border-bottom: 3px double #2B54C6;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header table {
            width: 100%;
        }
        .logo-title {
            color: #2B54C6;
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }
        .logo-subtitle {
            font-size: 11px;
            color: #555555;
            margin: 2px 0 0 0;
        }
        .doc-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 15px 0;
            color: #2B54C6;
            letter-spacing: 0.5px;
        }
        .id-badge {
            background-color: #F8FAFC;
            border: 1px solid #2B54C6;
            border-radius: 6px;
            padding: 8px 12px;
            display: inline-block;
            margin-bottom: 15px;
        }
        .id-badge span {
            font-size: 10px;
            text-transform: uppercase;
            color: #666;
            display: block;
        }
        .id-badge strong {
            font-size: 16px;
            color: #2B54C6;
            font-family: monospace;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .content-table td {
            vertical-align: top;
        }
        .photo-box {
            width: 130px;
            text-align: center;
            padding-right: 20px;
        }
        .photo-img {
            width: 120px;
            height: 160px;
            object-fit: cover;
            border: 2px solid #2B54C6;
            border-radius: 4px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table th, .details-table td {
            padding: 6px 8px;
            font-size: 11px;
        }
        .details-table tr:nth-child(even) {
            background-color: #F8FAFC;
        }
        .details-table th {
            width: 32%;
            text-align: left;
            color: #444444;
            border-bottom: 1px solid #E2E8F0;
        }
        .details-table td {
            border-bottom: 1px solid #E2E8F0;
        }
        .section-header {
            background-color: #2B54C6;
            color: #FFFFFF;
            padding: 5px 8px;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-approved { background-color: #DCFCE7; color: #166534; }
        .status-pending { background-color: #FEF3C7; color: #92400E; }
        .status-revision { background-color: #FEE2E2; color: #991B1B; }
        .footer {
            margin-top: 40px;
            width: 100%;
        }
        .footer-sign {
            width: 200px;
            text-align: center;
            float: right;
        }
        .footer-sign-line {
            margin-top: 60px;
            border-bottom: 1px solid #111;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Header Dokumen -->
    <div class="header">
        <table>
            <tr>
                <td style="width: 15%; vertical-align: middle;">
                    @if (file_exists(public_path('gama.png')))
                        <img src="{{ public_path('gama.png') }}" style="height: 55px; width: auto;" alt="Logo">
                    @endif
                </td>
                <td style="width: 55%; vertical-align: middle;">
                    <h1 class="logo-title">GARUDA AMARTA</h1>
                    <p class="logo-subtitle">Perguruan Pencak Silat — Dewan Pengurus Pusat & Kepelatihan</p>
                    <p class="logo-subtitle">Sistem Informasi & Manajemen Keanggotaan Atlet Resmi</p>
                </td>
                <td style="width: 30%; text-align: right; vertical-align: middle;">
                    <div class="id-badge">
                        <span>ID Position Atlet:</span>
                        <strong>{{ $student->account->id_position ?? '-' }}</strong>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="doc-title">LEMBAR BIODATA RESMI ATLET</div>

    <!-- Konten Utama Biodata & Foto -->
    <table class="content-table">
        <tr>
            <td class="photo-box">
                @php
                    $photoUrl = \App\Services\R2StorageService::url($student->photo);
                @endphp
                @if ($photoUrl)
                    <img src="{{ $photoUrl }}" class="photo-img" alt="Foto Atlet" />
                @else
                    <div style="width: 120px; height: 160px; border: 2px dashed #999; text-align: center; line-height: 160px; color: #999;">
                        Foto 3x4
                    </div>
                @endif
                <div style="margin-top: 8px;">
                    <span class="status-badge status-{{ $student->status_verifikasi === 'approved' ? 'approved' : ($student->status_verifikasi === 'need_revision' ? 'revision' : 'pending') }}">
                        {{ strtoupper($student->status_verifikasi) }}
                    </span>
                </div>
            </td>
            <td>
                <div class="section-header">1. Identitas Pribadi Atlet</div>
                <table class="details-table">
                    <tr>
                        <th>Nama Lengkap</th>
                        <td><strong>{{ $student->nama_lengkap }}</strong></td>
                    </tr>
                    <tr>
                        <th>Nama Panggilan (Akun)</th>
                        <td>{{ $student->account->nama }} (Username: {{ $student->account->username }})</td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td>{{ $student->tanggal_lahir ? $student->tanggal_lahir->format('d F Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $student->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <th>Nomor NIK / KIA</th>
                        <td>{{ $student->nik_kia }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Kartu Keluarga</th>
                        <td>{{ $student->no_kk }}</td>
                    </tr>
                    <tr>
                        <th>Alamat Domisili</th>
                        <td>{{ $student->account->alamat ?? '-' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="section-header">2. Kualifikasi Pencak Silat & Kategori Tanding</div>
    <table class="details-table">
        <tr>
            <th>Tingkat Sabuk</th>
            <td><strong>{{ $student->tingkat_sabuk }}</strong></td>
            <th>Ranting Latihan</th>
            <td><strong>{{ $student->account->nama_ranting ?? '-' }}</strong></td>
        </tr>
        <tr>
            <th>Tingkat Sekolah</th>
            <td>{{ $student->tingkat }} — {{ $student->nama_sekolah }}</td>
            <th>Kategori Pertandingan</th>
            <td><strong>{{ $student->kategori }}</strong></td>
        </tr>
        <tr>
            <th>Kelas Tanding</th>
            <td><strong>{{ $student->kelas }}</strong></td>
            <th>Berat & Tinggi Badan</th>
            <td>{{ $student->berat_badan }} kg / {{ $student->tinggi_badan }} cm</td>
        </tr>
    </table>

    <div class="section-header">3. Informasi Orang Tua / Wali</div>
    <table class="details-table">
        <tr>
            <th>Nama Orang Tua / Wali</th>
            <td>{{ $student->nama_ortu }}</td>
        </tr>
        <tr>
            <th>No. Telepon / WhatsApp</th>
            <td>{{ $student->no_ortu }}</td>
        </tr>
        <tr>
            <th>Email Terdaftar</th>
            <td>{{ $student->account->email }}</td>
        </tr>
    </table>

    <!-- Tanda Tangan & Pengesahan -->
    <table class="footer">
        <tr>
            <td style="width: 50%;">
                <p style="font-size: 10px; color: #666;">
                    * Dokumen ini digenerate secara otomatis oleh Sistem Informasi Garuda Amarta.<br>
                    * Tanggal Cetak: {{ date('d F Y, H:i') }} WIB
                </p>
            </td>
            <td style="width: 50%;">
                <div class="footer-sign">
                    <p style="margin-bottom: 0;">Pelatih / Pengurus Ranting,</p>
                    <div class="footer-sign-line"></div>
                    <p style="margin-top: 4px; font-size: 11px;">Garuda Amarta</p>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
