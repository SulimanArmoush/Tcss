<?php

namespace App\Exports;
use App\Models\MaintenanceService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MaintenanceOfDepartment implements FromArray, WithHeadings ,WithStyles, ShouldAutoSize
{

    protected $department;
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate ,$department)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->department = $department;
    }

    public function array() : array
    {
        $list = [];
        $services = MaintenanceService::where('department_id', $this->department->id)->whereRaw('DATE(created_at) BETWEEN ? AND ?', [$this->startDate, $this->endDate])->get();
        
        foreach($services as $service){
            $list[]=[
                'id'=>$service->id,
                'date'=>$service->created_at->toDateString(),
                'device'=>$service->device->name,
                'Employee'=>$service->user->name,
                'discription'=>$service->description
        ];
        }
    
       return $list;
    }
    
    public function headings(): array
    {
        return [
                'id',
                'date',
                'device',
                'Employee',
                'discription',
        ];
    }
    
    public function styles(Worksheet $sheet)
{
    
    $sheet->insertNewRowBefore(1, 2);

    $sheet->mergeCells('A1:E1');
    $sheet->mergeCells('A2:C2');
    $sheet->mergeCells('D2:E2');

    $sheet->setCellValue('A1', 'Town Center Specialist Support ...');
    $sheet->setCellValue('A2', 'Maintenance Report :');
    $sheet->setCellValue('D2', 'Department :' . $this->department->name);

    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('D2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $numRows = $sheet->getHighestDataRow();
    $lastColumn = $sheet->getHighestDataColumn();
    $sheet->getStyle('A3:' . $lastColumn . $numRows)->applyFromArray([
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,],
        'borders' => [
        'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,'color' => ['argb' => '000000'],],],
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
