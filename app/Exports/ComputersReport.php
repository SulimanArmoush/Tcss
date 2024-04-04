<?php

namespace App\Exports;

use App\Models\Floor;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ComputersReport implements FromArray, WithHeadings , ShouldAutoSize, WithStyles
{
    public function array() : array
    {
        $list=[];
        $floors = Floor::Get();
    
        foreach($floors as $floor){
            foreach($floor->department as $department){
                foreach($department->device as $device){
                    $list[]=[
                        'floor'=>$floor->name,
                        'department'=>$department->name,
                        'name'=>$device->name,
                        'type'=>$device->type,
                        'description'=>$device->description,
                        'Note'=>$device->Note,
                    ];
                }
            }
        }
        return $list;
    }
    

    public function headings(): array
    {
        return ['floor','department','name','type','discription','Note'];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->insertNewRowBefore(1, 2);
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:C2');
    
        $sheet->setCellValue('A1', 'Town Center Specialist Support ...');
        $sheet->setCellValue('A2', 'Computers Report :');
    
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    
        $numRows = $sheet->getHighestDataRow();
        $lastColumn = 'F';
    
        $sheet->getStyle('A3:' . $lastColumn . $numRows)->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,'color' => ['argb' => '000000'],],],
        ]);
    
        $this->applyAlternatingRowColor($sheet, 'A', 'F', 4);
        $this->mergeConsecutiveCells($sheet, 'A');
        $this->mergeConsecutiveCells($sheet, 'B');
    
        return [
            3    => ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF636E72']],
            'font' => ['bold' => true ,'size' => 15]
             ],
             1   =>['font' => ['bold' => true ,'size' => 15]],
             2   =>['font' => ['bold' => true ,'size' => 12]],
             ]; 
    }
    
    private function mergeConsecutiveCells(Worksheet $sheet, string $column)
    {
        $startRow = 1;
        $endRow = 1;
        $previousValue = null;
    
        for ($row = 4; $row <= $sheet->getHighestRow(); $row++) {
            $value = $sheet->getCell($column.$row)->getValue();
    
            if ($value == $previousValue) {
                $endRow = $row;
            } else {
                if ($endRow > $startRow) {
                    $sheet->mergeCells($column.$startRow.':'.$column.$endRow);
                    $sheet->getStyle($column.$startRow.':'.$column.$endRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                }
                $startRow = $row;
                $endRow = $row;
                $previousValue = $value;
            }
        }
    
        if ($endRow > $startRow) {
            $sheet->mergeCells($column.$startRow.':'.$column.$endRow);
            $sheet->getStyle($column.$startRow.':'.$column.$endRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        }
    }
    
    private function applyAlternatingRowColor(Worksheet $sheet, string $column, string $endColumn, int $startRow)
    {
        $previousValue = $sheet->getCell($column . $startRow)->getValue();
        $color = 'FFFFFF';
    
        for ($row = $startRow; $row <= $sheet->getHighestRow(); $row++) {
            $currentValue = $sheet->getCell($column . $row)->getValue();
            if ($currentValue != $previousValue) {
                $color = $color == 'FFFFFF' ? '95afc0' : 'FFFFFF'; // Switch between white and gray
                $previousValue = $currentValue;
            }
            $sheet->getStyle($column . $row . ':' . $endColumn . $row)->applyFromArray([
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => $color]],
            ]);
        }
    }
    
    
}
