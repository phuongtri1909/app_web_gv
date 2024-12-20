<?php

namespace App\Imports;

use App\Models\Road;
use App\Models\BusinessHousehold;
use App\Models\CategoryMarket;
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
    public function chunkSize(): int
    {
        return 1000;
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
        $category = CategoryMarket::where('slug', $row[12])->first();
        $road = $road ?? null;
        $category = $category ?? null;
        $stalls = isset($row[13]) && !empty($row[13]) ? trim($row[13]) : null;
        Log::info('Row: ' . $this->currentRow . ', Column 6 Value: ' . $row[6] . 'name: ' . $row[3]);

        //dd($road);
        try {
            return new BusinessHousehold([
                'license_number' => $row[1] ?? null,
                'date_issued' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]) ?? null,
                'business_owner_full_name' => $row[3] ?? null,
                'business_dob' => $row[4] ?? null,
                'house_number' => $row[5] ?? null,
                'road_id' => $road ? $road->id : null,
                'signboard' => $row[7] ?? null,
                'business_field' => $row[8] ?? null,
                'phone' => $row[9] ?? null,
                'cccd' => $row[10] ?? null,
                'address' => $row[11] ?? null,
                'category_market_id' => $category ? $category->id : null,
                'stalls' => $stalls,
                'status' => 'active',
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving row ' . $this->currentRow . ': ' . $e->getMessage());
            return null;
        }
    }


}
