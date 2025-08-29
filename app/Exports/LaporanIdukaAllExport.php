<?php

namespace App\Exports;

use App\Models\Iduka;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LaporanIdukaAllExport implements FromArray, ShouldAutoSize, WithStyles, WithTitle
{
    public function array(): array
    {
        $data = [];

        
        $data[] = ['LAPORAN DATA SISWA PKL - SEMUA IDUKA'];
        $data[] = ['Tanggal Export: ' . date('d/m/Y H:i:s')];
        $data[] = [];

        $idukas = Iduka::with(['siswa.kelas'])->get();

        $idukaNumber = 1;
        foreach ($idukas as $iduka) {
            $idukaTitle = $idukaNumber . '. ' . strtoupper($iduka->nama);
            $data[] = [$idukaTitle];

            $data[] = ['No', 'Nama Siswa', 'Kelas'];

            if ($iduka->siswa->count() > 0) {
                $no = 1;
                foreach ($iduka->siswa as $siswa) {
                    $data[] = [
                        $no++,
                        $siswa->name,
                        $siswa->kelas->name_kelas ?? '-',
                    ];
                }
                $totalSiswa = $iduka->siswa->count();
            } else {
                $data[] = ['-', 'Belum ada siswa yang terdaftar', '-', '-'];
                $totalSiswa = 0;
            }

            $data[] = ['', 'Total Siswa: ' . $totalSiswa . ' orang', '', ''];

            $data[] = [];

            $idukaNumber++;
        }

        $totalSiswaAll = $idukas->sum(function($iduka) {
            return $iduka->siswa->count();
        });
        $totalIduka = $idukas->count();
        $idukaWithSiswa = $idukas->filter(function($iduka) {
            return $iduka->siswa->count() > 0;
        })->count();
        $idukaWithoutSiswa = $totalIduka - $idukaWithSiswa;

        $data[] = [];
        $data[] = ['RINGKASAN'];
        $data[] = ['Total IDUKA: ' . $totalIduka];
        $data[] = ['IDUKA dengan Siswa: ' . $idukaWithSiswa];
        $data[] = ['IDUKA tanpa Siswa: ' . $idukaWithoutSiswa];
        $data[] = ['Total Siswa PKL: ' . $totalSiswaAll . ' orang'];

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 16],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => '2E7D32']
                ]
            ],
            2 => [
                'font' => ['italic' => true, 'size' => 10]
            ]
        ];
    }

    public function title(): string
    {
        return 'Laporan Siswa PKL - ' . date('d-m-Y');
    }
}
