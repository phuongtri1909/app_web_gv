<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class CapitalNeedExport implements FromView, WithEvents, ShouldAutoSize
{
    protected $CapitalNeeds;

    public function __construct($CapitalNeeds)
    {
        $this->CapitalNeeds = $CapitalNeeds;
    }

    public function view(): View
    {
        return view('admin.pages.client.form-capital-needs.report', [
            'CapitalNeeds' => $this->CapitalNeeds
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Center align column A
                $sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Set width for columns B to H
                $columns = ['B', 'C', 'D', 'E', 'F', 'G', 'H'];
                foreach ($columns as $column) {
                    $sheet->getColumnDimension($column)->setWidth(20);
                }

                // Wrap text for columns B to H
                $sheet->getStyle('B:H')->getAlignment()->setWrapText(true);
            },
        ];
    }
}