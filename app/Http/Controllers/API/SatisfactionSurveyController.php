<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\SatisfactionSurvey;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class SatisfactionSurveyController extends Controller
{
    public function store(Request $request)
    {
        try{
            $request->validate([
                'description' => 'required|string',
                'department_id' => 'required|exists:departments,id',
                'customer_id' => 'required|exists:customers,id',
                'level' => 'required|integer|between:1,5',
            ],[
                'description.required' => 'Vui lòng nhập nội dung khảo sát',
                'description.string' => 'Nội dung khảo sát phải là chuỗi',
                'department_id.required' => 'Vui lòng chọn phòng ban',
                'department_id.exists' => 'Phòng ban không tồn tại',
                'customer_id.required' => 'Thao tác không hợp lệ',
                'customer_id.exists' => 'Thao tác không hợp lệ',
                'level.required' => 'Vui lòng chọn mức độ hài lòng',
                'level.integer' => 'Vui lòng chọn mức độ hài lòng',
                'level.between' => 'Mức độ hài lòng phải chọn từ 1 đến 5 sao',
            ]);
    
            
            $satisfactionSurvey = new SatisfactionSurvey();
            $satisfactionSurvey->customer_id = $request->customer_id;
            $satisfactionSurvey->description = $request->description;
            $satisfactionSurvey->department_id = $request->department_id;
            $satisfactionSurvey->level = $request->level;
            $satisfactionSurvey->save();
    
            return response()->json([
                'message' => 'Khảo sát hài lòng của bạn đã được ghi nhận. Cảm ơn bạn đã tham gia khảo sát!',
            ]);
        }catch(ValidationException $e){
            return response()->json([
                'message' => $e->errors(),
            ], 422);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau',
            ], 500);
        }
        
    }
}
