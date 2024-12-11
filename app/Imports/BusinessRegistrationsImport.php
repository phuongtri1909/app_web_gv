<?php

namespace App\Imports;

use App\Models\BusinessField;
use App\Models\BusinessMember;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;

class BusinessRegistrationsImport implements ToModel, WithHeadingRow, WithValidation
{
    private $currentRow = 0;

    public function startRow(): int
    {
        return 5; 
    }

    /**
     * 
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $this->currentRow++; 
        if (empty($row['business_name'])) {
            Log::info('Skipping empty row: ' . $this->currentRow);
            return null;
        }
        $businessFieldIds = array_filter(array_map('trim', explode(',', $row['business_field']))); 
    
        $businessFieldIdsFound = [];
    
        if (!empty($businessFieldIds)) {
            $businessFields = BusinessField::whereIn('slug', $businessFieldIds)->get();
            foreach ($businessFields as $field) {
                $businessFieldIdsFound[] = $field->id;
            }
            if (empty($businessFieldIdsFound)) {
                Log::info('No business field found for slugs: ' . json_encode($businessFieldIds));
            }
        }
        $businessFieldIdsFound = array_map('strval', $businessFieldIdsFound);
        $businessMember = new BusinessMember([
            'business_name' => $row['business_name'],
            'business_code' => $row['business_code'],
            'address' => $row['address'],
            'email' => $row['email'],
            'phone_zalo' => $row['phone_zalo'],
            'representative_full_name' => $row['representative_full_name'],
            'representative_phone' => $row['representative_phone'],
            'status' => $row['status'] ?? 'approved',
            'link' => $row['link'],
            'business_field_id' => !empty($businessFieldIdsFound) ? json_encode($businessFieldIdsFound) : null, 
        ]);

        $businessMember->save();
        $user = User::updateOrCreate(
            ['username' => $businessMember->business_code],
            [
                'password' => bcrypt($businessMember->business_code),
                'full_name' => $businessMember->business_name,
                'email' => $businessMember->email,
                'role' => 'business',
                'business_member_id' => $businessMember->id,
            ]
        );
        return $businessMember;
    }
    
    

    /**
     * Xác thực dữ liệu trước khi lưu vào cơ sở dữ liệu.
     * @return array
     */
    public function rules(): array
    {
        return [
            'business_name' => 'required|string|max:255',
            // 'business_code' => 'required|regex:/^\d{10}(-\d{3})?$/|unique:business_registrations,business_code',
            'address' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            // 'phone_zalo' => 'nullable|string|max:10|regex:/^[0-9]+$/',
            'representative_full_name' => 'nullable|string|max:255',
            // 'representative_phone' => 'nullable|string|max:10|regex:/^[0-9]+$/',
            'status' => 'in:pending,approved,rejected', 
            'link' => 'nullable|url',
        ];
    }
    public function messages(): array
    {
        return [
            'business_name.required' => 'Tên doanh nghiệp là bắt buộc.',
            'business_name.string' => 'Tên doanh nghiệp phải là một chuỗi ký tự.',
            'business_name.max' => 'Tên doanh nghiệp không được vượt quá 255 ký tự.',
            
            'business_code.required' => 'Mã doanh nghiệp là bắt buộc.',
            'business_code.regex' => 'Mã doanh nghiệp phải có dạng: 10 chữ số hoặc 10 chữ số kèm theo -xxx.',
            'business_code.unique' => 'Mã doanh nghiệp đã tồn tại.',
            
            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.string' => 'Địa chỉ phải là một chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            
            'email.email' => 'Email phải là một địa chỉ email hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            
            'phone_zalo.string' => 'Số điện thoại Zalo phải là một chuỗi ký tự.',
            'phone_zalo.max' => 'Số điện thoại Zalo không được vượt quá 10 ký tự.',
            'phone_zalo.regex' => 'Số điện thoại Zalo chỉ được chứa các chữ số.',
            
            'representative_full_name.string' => 'Tên đại diện phải là một chuỗi ký tự.',
            'representative_full_name.max' => 'Tên đại diện không được vượt quá 255 ký tự.',
            
            'representative_phone.string' => 'Số điện thoại đại diện phải là một chuỗi ký tự.',
            'representative_phone.max' => 'Số điện thoại đại diện không được vượt quá 10 ký tự.',
            'representative_phone.regex' => 'Số điện thoại đại diện chỉ được chứa các chữ số.',
            
            'status.in' => 'Trạng thái không hợp lệ. Các giá trị hợp lệ là: pending, approved, rejected.',
            
            'link.url' => 'Link phải là một URL hợp lệ.',
        ];
    }
    /**
     * Tùy chọn: Xử lý lỗi khi xảy ra.
     *
     * @param \Maatwebsite\Excel\Validators\Failure ...$failures
     * @return void
     */
    public function onFailure(\Maatwebsite\Excel\Validators\Failure ...$failures)
    {
        foreach ($failures as $failure) {
            Log::error('Validation failed on row ' . $failure->row() . ' due to ' . $failure->errors());
        }
    }
}


