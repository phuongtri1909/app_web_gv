<?php

namespace App\Imports;

use App\Models\Road;
use App\Models\BusinessHousehold;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BusinessHouseholdImport implements ToModel,WithStartRow
{
    private $currentRow = 0;

    public function startRow(): int
    {
        return 5;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        
        $this->currentRow++;
        if (!isset($row[0]) || empty($row[0])) {
            Log::info('Skipping empty row: ' . $this->currentRow);
            return null;
        }

        $road = Road::where('slug', $row[6])->first();

        if (!$road) {
            return null;
        }

        Log::info('Row: ' . $this->currentRow . ', Column 6 Value: ' . $row[6] . 'name: ' . $row[3]);
        //dd($road);
        return new BusinessHousehold([
            'license_number' => $row[1],
            'date_issued' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]),
            'business_owner_full_name' => $row[3],
            'business_dob' => $row[4],
            'house_number' => $row[5],
            'road_id' => $road ? $road->id : null,
            'signboard' => $row[7],
            'business_field' => $row[8],
            'phone' => $row[9],
            'cccd' => $row[10],
            'address' => $row[11],
            'status' => 'active',
        ]);
    }

   
}
