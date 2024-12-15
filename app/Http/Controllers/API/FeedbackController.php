<?php

namespace App\Http\Controllers\API;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\FeedbackImages;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\ValidationException;

class FeedbackController extends Controller
{

    public function index(Request $request)
    {
        $feedbacks = Feedback::where('customer_id', $request->customer_id)->with('feedbackImages')->get();

        return response()->json(['feedbacks' => $feedbacks], 200);
    }

    public function sendFeedback(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'description' => 'required',
                'customer_id' => 'required|exists:customers,id',
                'feedbackImages.*' => 'nullable|image|mimes:jpeg,png,jpg,webp',
                'feedbackImages' => 'nullable|array|max:3',
            ], [
                'name.required' => 'Tiêu đề không được để trống',
                'name.max' => 'Tiêu đề không được vượt quá 255 ký tự',
                'description.required' => 'Nội dung không được để trống',
                'customer_id.required' => 'Thao tác không hợp lệ',
                'customer_id.exists' => 'Thao tác không hợp lệ',
                'feedbackImages.*.image' => 'Ảnh không hợp lệ',
                'feedbackImages.*.mimes' => 'Định dạng ảnh không hợp lệ',
                'feedbackImages.max' => 'Số lượng ảnh không được vượt quá 3',
                'feedbackImages.array' => 'Ảnh không hợp lệ',
            ]);

            DB::beginTransaction();
            try {
                $feedback = Feedback::create([
                    'name' => $validatedData['name'],
                    'description' => $validatedData['description'],
                    'customer_id' => $validatedData['customer_id'],
                ]);

                if ($request->hasFile('feedbackImages')) {
                    foreach ($request->file('feedbackImages') as $image) {
                        if ($image) {
                            try {
                                $folderName = date('Y/m');
                                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                                $fileName = $originalFileName . '_' . time() . '.webp';
                                $uploadPath = public_path('uploads/images/feedbacks/' . $folderName);

                                if (!File::exists($uploadPath)) {
                                    File::makeDirectory($uploadPath, 0755, true);
                                }

                                $image = Image::make($image->getRealPath());
                                $image->encode('webp', 75);
                                $image->save($uploadPath . '/' . $fileName);

                                $image_path = 'uploads/images/feedbacks/' . $folderName . '/' . $fileName;

                                $imageFeedback = new FeedbackImages();
                                $imageFeedback->feedback_id = $feedback->id;
                                $imageFeedback->imageUrl = $image_path;
                                $imageFeedback->save();
                            } catch (\Exception $e) {
                                DB::rollBack();
                                return response()->json(['message' => 'Có lỗi xảy ra, vui lòng thử lại: ' . $e->getMessage()], 400);
                            }
                        }
                    }
                }

                DB::commit();

                return response()->json(['message' => 'Phản ánh của bạn đã được gửi'], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['message' => 'Có lỗi xảy ra, vui lòng thử lại: ' . $e->getMessage()], 400);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->errors(),
            ], 422);
        }
    }
}
