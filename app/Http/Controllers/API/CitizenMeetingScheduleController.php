<?php

namespace App\Http\Controllers\API;

use App\Models\CitizenMeetingSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class CitizenMeetingScheduleController extends Controller
{
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
                'working_day' => 'required|date',
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
            ]);

            // Generate unique code based on current date and time
            $currentDateTime = Carbon::now()->format('YmdHis');
            $data['code'] = 'P17-' . $currentDateTime;

            // Generate sequential number (STT) that resets daily
            $today = Carbon::today();
            $stt = CitizenMeetingSchedule::whereDate('created_at', $today)->max('stt') + 1;
            $data['stt'] = $stt;

            $citizenMeetingSchedule = CitizenMeetingSchedule::create($data);

            return response()->json([
                'message' => 'Tạo lịch hẹn thành công.',
                'data' => [
                    $citizenMeetingSchedule
                ]
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