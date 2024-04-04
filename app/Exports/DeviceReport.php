<?php

namespace App\Exports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DeviceReport implements FromArray, ShouldAutoSize, WithStyles
{

    protected $Device;
    public function __construct($Device)
    {
        $this->Device = $Device;
    }
    public function array(): array
    {
        $list = [];
            $list[] = ['id', 'department', 'name', 'type', 'description', 'Note'];
            $list[] = [
                'id' => $this->Device->id,
                'department' => $this->Device->department->name,
                'Device_name' => $this->Device->name,
                'Device_type' => $this->Device->type,
                'descriptionOfDevice' => $this->Device->description,
                'Note' => $this->Device->Note,
            ];

            $list[] = [''];
            $list[] = ['', '', ''];

            $list[] = [
                'CPU',
                'CPU' => $this->Device->property->CPU,
                'Monitor',
                'Monitor' => $this->Device->peripheral->Monitor,
                'type',
                'Hardwarekey_type' => $this->Device->hardwarekey->type,
            ];
            $list[] = [
                'Motherboard',
                'Motherboard' => $this->Device->property->Motherboard,
                'Keyboard',
                'Keyboard' => $this->Device->peripheral->Keyboard,
                'sereal',
                'sereal' => $this->Device->hardwarekey->sereal,
            ];
            $list[] = [
                'RAM',
                'RAM' => $this->Device->property->RAM,
                'Mouse',
                'Mouse' => $this->Device->peripheral->Mouse,
                'exDate',
                'exDate' => $this->Device->hardwarekey->exDate,
            ];
            $list[] = [
                'Hard',
                'Hard' => $this->Device->property->Hard,
                'Printer',
                'Printer' => $this->Device->peripheral->Printer,
                'description',
                'description' => $this->Device->hardwarekey->description,
            ];
            $list[] = [
                'Graphics',
                'Graphics' => $this->Device->property->Graphics,
                'UPS',
                'UPS' => $this->Device->peripheral->UPS,
            ];
            $list[] = [
                'powerSupply',
                'powerSupply' => $this->Device->property->powerSupply,
                'cashBox',
                'cashBox' => $this->Device->peripheral->cashBox,
            ];
            $list[] = [
                'OS',
                'OS' => $this->Device->property->OS,
                'Barcode',
                'Barcode' => $this->Device->peripheral->Barcode,
            ];
            $list[] = [
                'NIC',
                'NIC' => $this->Device->property->NIC,
            ];

        return $list;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->insertNewRowBefore(1, 2);

        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:C2');

        $sheet->mergeCells('A6:B6');
        $sheet->mergeCells('C6:D6');
        $sheet->mergeCells('E6:F6');
        $sheet->mergeCells('A5:F5');

        $sheet->setCellValue('A1', 'Town Center Specialist Support ...');
        $sheet->setCellValue('A2', 'Device Report :');
        $sheet->setCellValue('A6', 'properties');
        $sheet->setCellValue('C6', 'peripherals');
        $sheet->setCellValue('E6', 'hardwarekey');

        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $numRows = $sheet->getHighestDataRow();
        $lastColumn = $sheet->getHighestDataColumn();

        $sheet->getStyle('A3:'.$lastColumn.$numRows)->applyFromArray([
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => '000000']]],
        ]);

        $columns = ['A', 'C', 'E'];
        foreach ($columns as $column) {
            $sheet->getStyle($column . '7:' . $column . $numRows)->applyFromArray([
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '95afc0']],
                'font' => ['bold' => true],
            ]);
        }
        
        return [
            3 => ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF636E72']],
                'font' => ['bold' => true, 'size' => 15],
            ],
            6 => ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF636E72']],
                'font' => ['bold' => true, 'size' => 15],
            ],
            1 => ['font' => ['bold' => true, 'size' => 15]],
            2 => ['font' => ['bold' => true, 'size' => 12]],
        ];

    }
}
