<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            if ($record->status === 'approved' || $record->status === 'rejected') {
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
}
