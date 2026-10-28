<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Anggota Atlet - {{ $student->nama_lengkap }}</title>
    <style>
        @page {
            margin: 0;
            size: 550pt 350pt landscape;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 20pt;
            background-color: #f1f5f9;
            color: #1e293b;
            -webkit-print-color-adjust: exact;
        }
        .card-container {
            width: 500pt;
            height: 300pt;
            background-color: #ffffff;
            border-radius: 16pt;
            border: 2pt solid #1e3a8a;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
            margin: 0 auto;
        }
        .header-table {
            width: 100%;
            border-bottom: 2pt solid #1e3a8a;
            padding: 12pt 16pt;
            background-color: #ffffff;
        }
        .logo-img {
            height: 50pt;
            width: auto;
        }
        .header-title {
            color: #1e3a8a;
            font-size: 20pt;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1.5pt;
            margin: 0;
            line-height: 1.1;
        }
        .header-subtitle {
            color: #b45309;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2pt;
            margin: 3pt 0 0 0;
        }
        .content-table {
            width: 100%;
            padding: 16pt;
            box-sizing: border-box;
        }
        .photo-cell {
            width: 120pt;
            vertical-align: top;
            text-align: center;
        }
        .photo-frame {
            width: 105pt;
            height: 140pt;
            border: 2pt solid #d97706;
            border-radius: 8pt;
            object-fit: cover;
        }
        .photo-placeholder {
            width: 105pt;
            height: 140pt;
            border: 2pt dashed #94a3b8;
            border-radius: 8pt;
            background-color: #f8fafc;
            color: #94a3b8;
            font-size: 9pt;
            font-weight: bold;
            text-align: center;
            line-height: 140pt;
        }
        .data-cell {
            vertical-align: top;
            padding-left: 16pt;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table td {
            padding: 5pt 0;
            font-size: 11pt;
            line-height: 1.3;
        }
        .label-col {
            width: 110pt;
            color: #64748b;
            font-weight: 600;
        }
        .sep-col {
            width: 12pt;
            color: #64748b;
            font-weight: bold;
        }
        .val-col {
            color: #0f172a;
            font-weight: bold;
        }
        .id-position {
            font-family: monospace;
            color: #1e3a8a;
            font-size: 13pt;
            font-weight: 900;
            letter-spacing: 0.5pt;
        }
        .footer-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #1e3a8a;
            color: #ffffff;
            padding: 6pt 16pt;
            font-size: 8pt;
            font-weight: bold;
            letter-spacing: 0.5pt;
            text-transform: uppercase;
        }
        .watermark {
            position: absolute;
            right: -30pt;
            bottom: -30pt;
            width: 180pt;
            opacity: 0.06;
            z-index: 1;
        }
    </style>
</head>
<body>

    <div class="card-container">
        @if (file_exists(public_path('gama.png')))
            <img src="{{ public_path('gama.png') }}" class="watermark" alt="" />
        @endif

        <!-- Header Kartu -->
        <table class="header-table">
            <tr>
                <td style="width: 60pt; vertical-align: middle;">
                    @if (file_exists(public_path('gama.png')))
                        <img src="{{ public_path('gama.png') }}" class="logo-img" alt="Logo" />
                    @endif
                </td>
                <td style="vertical-align: middle; padding-left: 8pt;">
                    <h1 class="header-title">GARUDA AMARTA</h1>
                    <h2 class="header-subtitle">KARTU ANGGOTA ATLET</h2>
                </td>
                <td style="vertical-align: middle; text-align: right;">
                    <span style="display: inline-block; padding: 4pt 8pt; background-color: #fef3c7; color: #b45309; border: 1pt solid #f59e0b; border-radius: 4pt; font-size: 8pt; font-weight: bold; text-transform: uppercase;">
                        Anggota Resmi
                    </span>
                </td>
            </tr>
        </table>

        <!-- Body Kartu -->
        <table class="content-table" style="position: relative; z-index: 2;">
            <tr>
                <td class="photo-cell">
                    @php
                        $photoDataUri = \App\Services\R2StorageService::base64($student->photo);
                    @endphp
                    @if ($photoDataUri)
                        <img src="{{ $photoDataUri }}" class="photo-frame" alt="Foto Atlet" />
                    @else
                        <div class="photo-placeholder">FOTO PROFIL</div>
                    @endif
                </td>
                <td class="data-cell">
                    <table class="details-table">
                        <tr>
                            <td class="label-col">Nama Lengkap</td>
                            <td class="sep-col">:</td>
                            <td class="val-col">{{ $student->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="label-col">Tanggal Lahir</td>
                            <td class="sep-col">:</td>
                            <td class="val-col">{{ $student->tanggal_lahir ? $student->tanggal_lahir->translatedFormat('d F Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label-col">Sabuk</td>
                            <td class="sep-col">:</td>
                            <td class="val-col" style="color: #b45309;">{{ $student->nama_sabuk }}</td>
                        </tr>
                        <tr>
                            <td class="label-col">Ranting</td>
                            <td class="sep-col">:</td>
                            <td class="val-col">{{ $student->account->nama_ranting ?? $student->account->ranting?->nm_ranting ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label-col">Email</td>
                            <td class="sep-col">:</td>
                            <td class="val-col">{{ $student->account->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label-col">ID Position</td>
                            <td class="sep-col">:</td>
                            <td class="val-col"><span class="id-position">{{ $student->account->id_position ?? '-' }}</span></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Footer Bar -->
        <table class="footer-bar">
            <tr>
                <td style="text-align: left;">Perguruan Seni Bela Diri Pencak Silat Garuda Amarta Indonesia</td>
                <td style="text-align: right;">Status: Terverifikasi</td>
            </tr>
        </table>
    </div>

</body>
</html>
