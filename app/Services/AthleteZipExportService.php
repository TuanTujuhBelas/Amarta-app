<?php

namespace App\Services;

use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use ZipArchive;

class AthleteZipExportService
{
    /**
     * Generate structured ZIP archive containing athlete folders with PDFs and R2 documents.
     *
     * @param  Collection<int, Student>  $students
     * @return array{path: string, filename: string}
     */
    public static function createArchive(Collection $students): array
    {
        $zip = new ZipArchive;
        $tempPath = tempnam(sys_get_temp_dir(), 'amarta_export_');

        if ($tempPath === false) {
            throw new RuntimeException('Gagal membuat temporary file untuk arsip ZIP.');
        }

        if ($zip->open($tempPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('Gagal menginisialisasi ZipArchive.');
        }

        $timestamp = now()->format('Ymd_His');
        $rootFolder = "EXPORT_ATLET_GARUDA_AMARTA_{$timestamp}";
        $disk = R2StorageService::disk();

        foreach ($students as $student) {
            $account = $student->account;
            $posId = $account->id_position ?? 'SSW-'.(string) $student->id;
            $safeName = (string) preg_replace('/[^a-zA-Z0-9_-]/', '_', $student->nama_lengkap);
            $safePosId = (string) preg_replace('/[^a-zA-Z0-9_-]/', '_', $posId);
            $athleteFolder = "{$rootFolder}/{$safePosId}_{$safeName}";

            // 1. Generate & Add PDF Biodata
            try {
                $pdf = Pdf::loadView('pdf.student-card', ['student' => $student])
                    ->setPaper('a4', 'portrait');
                $pdfContent = $pdf->output();
                $zip->addFromString("{$athleteFolder}/Data_Atlet.pdf", $pdfContent);
            } catch (\Throwable) {
                // Lanjutkan jika PDF satu siswa terkendala agar dokumen lainnya tetap lengkap
            }

            // 2. Fetch and add R2 documents
            $documents = [
                'photo' => $student->photo,
                'photo_kk' => $student->photo_kk,
                'photo_akte_kia' => $student->photo_akte_kia,
                'photo_surat_sehat' => $student->photo_surat_sehat,
            ];

            foreach ($documents as $prefix => $path) {
                if (! $path) {
                    continue;
                }

                try {
                    if (Storage::disk($disk)->exists($path)) {
                        $content = Storage::disk($disk)->get($path);
                        if ($content !== null) {
                            $extension = pathinfo($path, PATHINFO_EXTENSION) ?: 'jpg';
                            $fileName = "{$prefix}.{$extension}";
                            $zip->addFromString("{$athleteFolder}/{$fileName}", $content);
                        }
                    }
                } catch (\Throwable) {
                    // Fail-safe per dokumen agar arsip tetap utuh
                }
            }
        }

        $zip->close();

        return [
            'path' => $tempPath,
            'filename' => "{$rootFolder}.zip",
        ];
    }
}
