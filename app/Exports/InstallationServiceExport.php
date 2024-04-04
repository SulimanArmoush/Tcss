<?php

namespace App\Exports;

use App\Models\InstallationService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InstallationServiceExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    protected $startDate;

    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function array(): array
    {
        $list = [];
        $services = InstallationService::whereRaw('DATE(created_at) BETWEEN ? AND ?', [$this->startDate, $this->endDate])->get();

        foreach ($services as $service) {
            foreach ($service->materials as $material) {
                $list[] = [
                    'id' => $service->id,
                    'date' => $service->created_at->toDateString(),
                    'department' => $service->department->name,
                    'device' => $service->device->name,
                    'Employee' => $service->user->name,
                    'discription' => $service->description,
                    'code' => $material->code,
                    'material' => $material->name,
                    'quantity' => $material->pivot->quantity,
                ];

            }
        }

        return $list;
    }

    public function headings(): array
    {
        return ['id', 'date', 'department', 'device', 'Employee', 'discription','code', 'materials', 'quantity'];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->insertNewRowBefore(1, 2);

        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:C2');

        $sheet->setCellValue('A1', 'Town Center Specialist Support ...');
        $sheet->setCellValue('A2', 'Installation Report :');

        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $numRows = $sheet->getHighestDataRow();
        $lastColumn = $sheet->getHighestDataColumn();

        $sheet->getStyle('A3:'.$lastColumn.$numRows)->applyFromArray([
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '000000']]],
        ]);
        $sheet->getStyle('A3:'.'A'.$numRows)->applyFromArray([
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF636E72']],
            'font' => ['bold' => true],
        ]);

        $columnsToMerge = ['A', 'B', 'C', 'D', 'E' ,'F'];
        $highestRow = $sheet->getHighestRow();
        $startRow = 1;
        $value = $sheet->getCell('A'.$startRow)->getValue();

        $color = 'FFFFFF';
        for ($row = 2; $row <= $highestRow; $row++) {
            $currentValue = $sheet->getCell('A'.$row)->getValue();

            if ($currentValue == $value) {
                continue;
            }
            if ($row - 1 > $startRow) {
                foreach ($columnsToMerge as $column) {
                    $sheet->mergeCells($column.$startRow.':'.$column.($row - 1));
                    $sheet->getStyle($column.$startRow.':'.$column.$highestRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle($column.$startRow.':'.$column.$highestRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                }
                for ($column = 'B'; $column <= 'I'; $column++) {
                    $sheet->getStyle($column.$startRow.':'.$column.($row - 1))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($color);
                }
                $color = $color === 'FFFFFF' ? '95afc0' : 'FFFFFF';
            }
            $startRow = $row;
            $value = $currentValue;
        }
        if ($highestRow > $startRow) {
            foreach ($columnsToMerge as $column) {
                $sheet->mergeCells($column.$startRow.':'.$column.$highestRow);
                $sheet->getStyle($column.$startRow.':'.$column.$highestRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($column.$startRow.':'.$column.$highestRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            }
            for ($column = 'B'; $column <= 'I'; $column++) {
                $sheet->getStyle($column.$startRow.':'.$column.$highestRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB($color);
            }
        }
        return [
            3 => ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF636E72']],
                'font' => ['bold' => true, 'size' => 15],
            ],
            1 => ['font' => ['bold' => true, 'size' => 15]],
            2 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
