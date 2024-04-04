<?php

namespace App\Exports;

use App\Models\HardwareKey;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class HardeareKeyReport implements FromArray, WithHeadings ,WithStyles, ShouldAutoSize
{
    public function array() : array
    {
        $list=[];
        $hardwareKeys = HardwareKey::Get();

        foreach($hardwareKeys as $hardwareKey){
            $list[]=[
            'id'=>$hardwareKey->id,
            'type'=>$hardwareKey->type,
            'sereal'=>$hardwareKey->sereal,
            'exDate'=>$hardwareKey->exDate,
            'description'=>$hardwareKey->description,
            'department'=>$hardwareKey->device->department->name,
            'device' => $hardwareKey->device->name,
        ];
        }

       return $list;
    }

    public function headings(): array
    {
        return ['id','type','sereal','exDate','description','department','device', ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->insertNewRowBefore(1, 2);
    
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:C2');
    
        $sheet->setCellValue('A1', 'Town Center Specialist Support ...');
        $sheet->setCellValue('A2', 'HardwareKey Report :');
    
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
   
        $numRows = $sheet->getHighestDataRow();
        $lastColumn = $sheet->getHighestDataColumn();
        $sheet->getStyle('A3:' . $lastColumn . $numRows)->applyFromArray([
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,'color' => ['argb' => '000000'],],],
        ]);
        $sheet->getStyle('A3:' . 'A' . $numRows)->applyFromArray([
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF636E72']],
            'font' => ['bold' => true],
        ]);

        for ($i = 4; $i <= $numRows; $i++) {
            $fillColor = $i % 2 == 0 ? 'FFFFFF' : '95afc0'; 
            $sheet->getStyle('B' . $i . ':' . $lastColumn . $i)->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => $fillColor
                    ]
                ]
            ]);
        }
        
        return [
            3    => ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF636E72']],
            'font' => ['bold' => true ,'size' => 15]
             ],
             1   =>['font' => ['bold' => true ,'size' => 15]],
             2   =>['font' => ['bold' => true ,'size' => 12]],
             ]; 

    }




}