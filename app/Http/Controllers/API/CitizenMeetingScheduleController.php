<?php

namespace App\Http\Controllers\API;

use App\Models\CitizenMeetingSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class CitizenMeetingScheduleController extends Controller
{

    public function index(Request $request){
        $customer_id = $request->get('customer_id');

        $



    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'department_id' => 'required|exists:departments,id',
                'fullname' => 'required|string|max:255',
                'description' => 'required|string',
                'phone' => 'required|string|max:10|regex:/^[0-9]+$/',
                'card_number' => 'required|regex:/^[0-9]{12}$/',
                'address' => 'required|string|max:255',
                'working_day' => [
                    'required',
                    'date',
                    function ($attribute, $value, $fail) {
                        $dayOfWeek = Carbon::parse($value)->dayOfWeek;
                        if (!in_array($dayOfWeek, [Carbon::WEDNESDAY, Carbon::FRIDAY])) {
                            $fail('Ngày làm việc phải là thứ 4 hoặc thứ 6.');
                        }
                        if (Carbon::parse($value)->isPast()) {
                            $fail('Ngày làm việc bạn chọn đã qua.');
                        }
                    },
                ],
                'customer_id' => 'required|exists:customers,id',
            ], [
                'department_id.required' => 'Phòng ban không được để trống.',
                'department_id.exists' => 'Phòng ban không tồn tại.',
                'fullname.required' => 'Họ tên không được để trống.',
                'fullname.max' => 'Họ tên không được vượt quá 255 ký tự.',
                'description.required' => 'Mô tả không được để trống.',
                'phone.required' => 'Số điện thoại không được để trống.',
                'phone.max' => 'Số điện thoại không được vượt quá 10 ký tự.',
                'phone.regex' => 'Số điện thoại không hợp lệ.',
                'card_number.required' => 'Số CCCD không được để trống.',
                'card_number.regex' => 'Số CCCD phải là 12 chữ số.',
                'address.required' => 'Địa chỉ không được để trống.',
                'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
                'working_day.required' => 'Ngày làm việc không được để trống.',
                'working_day.date' => 'Ngày làm việc không hợp lệ.',
                'customer_id.required' => 'Thao tác không hợp lệ.',
                'customer_id.exists' => 'Thao tác không hợp lệ.',
            ]);

            $currentDateTime = Carbon::now()->format('YmdHis');
            $data['code'] = 'P17-' . $currentDateTime;

            $workingDay = Carbon::parse($data['working_day']);
            $maxStt = CitizenMeetingSchedule::whereDate('working_day', $workingDay)->max('stt');
            $stt = $maxStt ? $maxStt + 1 : 1;
            $data['stt'] = $stt;

            $citizenMeetingSchedule = CitizenMeetingSchedule::create($data);

            return response()->json([
                'message' => 'Tạo lịch hẹn thành công.',
                'data' => $citizenMeetingSchedule
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}