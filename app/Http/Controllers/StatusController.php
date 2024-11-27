<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessMember;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    public function updateStatus(Request $request)
    {
        try {
            DB::beginTransaction();

            $model = $request->input('model');
            $id = $request->input('id');
            $status = $request->input('status');

            $modelClass = "App\\Models\\" . $model;
            $record = $modelClass::findOrFail($id);
            if (!$record instanceof BusinessMember && ($record->status === 'approved' || $record->status === 'rejected')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể thay đổi trạng thái khi đã duyệt hoặc từ chối.'
                ], 403);
            }
            $record->status = $status;
            $record->save();

            DB::commit();

            $statusLabel = [
                'approved' => 'Đã duyệt',
                'rejected' => 'Đã từ chối',
                'pending' => 'Đang chờ'
            ];

            $statusClass = [
                'approved' => 'success',
                'rejected' => 'danger',
                'pending' => 'warning'
            ];

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công',
                'status' => $status,
                'statusLabel' => $statusLabel[$status],
                'statusClass' => $statusClass[$status]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Cập nhật trạng thái thất bại: ' . $e->getMessage()
            ], 500);
        }
    }
    public function updateStatus1(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $validated = $request->validate([
                'model' => 'required|string',
                'id' => 'required|integer',
                'status' => 'required|in:pending,in_progress,completed',
            ]);
    
            $modelClass = "App\\Models\\" . $validated['model'];
            if (!class_exists($modelClass)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Model không tồn tại.'
                ], 404);
            }
    
            $record = $modelClass::findOrFail($validated['id']);
    
            if ($record->status === 'completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể thay đổi trạng thái khi đã hoàn thành.'
                ], 403);
            }
    
            if ($record->status === 'pending' && $validated['status'] === 'completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể chuyển trực tiếp từ Đang chờ sang Hoàn thành. Vui lòng chuyển qua Đang xử lý trước.'
                ], 403);
            }
            if ($record->status === 'in_progress' && $validated['status'] === 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể chuyển từ Đang xử lý về Đang chờ.'
                ], 403);
            }            
            $record->status = $validated['status'];
            $record->save();
    
            DB::commit();
    
            $statusLabel = [
                'completed' => 'Đã hoàn thành',
                'in_progress' => 'Đang xử lý',
                'pending' => 'Đang chờ',
            ];
    
            $statusClass = [
                'completed' => 'success',
                'in_progress' => 'info',
                'pending' => 'warning',
            ];
    
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công.',
                'status' => $record->status,
                'statusLabel' => $statusLabel[$record->status],
                'statusClass' => $statusClass[$record->status],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Cập nhật trạng thái thất bại: ' . $e->getMessage()
            ], 500);
        }
    }
    
    
}
