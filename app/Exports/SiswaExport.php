<?php

namespace App\Exports;

use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class SiswaExport implements FromCollection, WithHeadings, WithMapping, WithDrawings, ShouldAutoSize
{
    use Exportable;

    public function collection()
    {
        return Siswa::all();
    }

    public function drawings()
    {
        $drawings = [];

        $siswas = Siswa::all();

        foreach ($siswas as $siswa) {
            if ($siswa->image) {
                $imagePath = public_path('storage/' . $siswa->image);

                if (file_exists($imagePath)) {
                    $drawing = new Drawing();
                    $drawing->setName($siswa->name)
                        ->setDescription($siswa->name)
                        ->setPath($imagePath)
                        ->setHeight(90)
                        ->setWidth(90);
                    $drawings[] = $drawing;
                }
            }
        }

        return $drawings;
    }

    public function map($siswa): array
    {
        return [
            $siswa->name,
            $siswa->class,
            $siswa->phone_number,
            (string) $siswa->nik,
            $siswa->gender,
            $siswa->image ? $drawing : 'tidak ada foto', // Path to the image if available
        ];
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Kelas',
            'Nomor Telpon',
            'NIK',
            'Jenis Kelamin',
            'Foto',
        ];
    }
}
