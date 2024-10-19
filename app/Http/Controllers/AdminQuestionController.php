<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\CategoryQuestion;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class AdminQuestionController extends Controller
{
    public function adminIndex()
    {
        $questions = Question::with('answers')->get();
        $categories = CategoryQuestion::all();
        return view('admin.pages.questions.index', compact('questions','categories'));
    }

    public function storeAnswer(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'category_id' => 'required|exists:categories_questions,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|',
        ], [
            'image.required' => __('image_required'),
            'image.image' => __('image_image'),
            'title.required' => __('title_required'),
            'content.required' => __('content_required'),
            'title.string' => __('title_string'),
            'title.max' => __('title.max'),
        ]);
        try {
            DB::beginTransaction();
            try {
                $image = $request->file('image');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $image->move(public_path('/uploads/images/answers/' . $folderName), $fileName);
                $image_path = 'uploads/images/answers/' . $folderName . '/' . $fileName;
            } catch (\Exception $e) {
                if (isset($image_path) && File::exists(public_path($image_path))) {
                    File::delete(public_path($image_path));
                }
                return response()->json(['error' => true, 'message' => __('upload_image_error')]);
            }

            $answer = new Answer();
            $answer->question_id = $request->question_id;
            $answer->category_id = $request->category_id;
            $answer->title = $request->title;
            $answer->content = $request->content;
            $answer->image = $image_path;

            $question = Question::findOrFail($request->question_id);
            $question->category_id = $request->category_id;
            $question->save();


            $answer->save();
            DB::commit();
            return response()->json(['success' => true, 'message' => __('reply_success')]);
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return response()->json(['error' => true, 'message' => __('reply_error')]);
        }
    }
    public function updateAnswer(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'category_id' => 'required|exists:categories_questions,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image',
        ],[
            'image.required' => __('image_required'),
            'image.image' => __('image_image'),
            'title.required' => __('title_required'),
            'content.required' => __('content_required'),
            'title.string' => __('title_string'),
            'title.max' => __('title.max'),
        ]);

        try {
            $answer = Answer::where('question_id', $request->input('question_id'))->firstOrFail();
            $answer->title = $request->input('title');
            $answer->content = $request->input('content');
            $answer->category_id = $request->input('category_id');
            if ($request->hasFile('image')) {
                if ($answer->image && File::exists(public_path($answer->image))) {
                    File::delete(public_path($answer->image));
                }
                try {
                    $image = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $originalFileName . '_' . time() . '.' . $extension;
                    $image->move(public_path('/uploads/images/answers/' . $folderName), $fileName);
                    $imagePath = 'uploads/images/answers/' . $folderName . '/' . $fileName;

                    $answer->image = $imagePath;
                } catch (\Exception $e) {
                    return response()->json(['error' => true, 'message' => __('upload_image_error')]);
                }
            }
            $question = Question::findOrFail($request->question_id);
            $question->category_id = $request->category_id;
            $question->save();

            $answer->save();
            return response()->json(['success' => true, 'message' => __('update_success')]);
        } catch (\Exception $e) {
            if (isset($imagePath) && File::exists(public_path($imagePath))) {
                File::delete(public_path($imagePath));
            }
            return response()->json(['error' => true, 'message' => __('update_error')]);
        }
    }

    public function destroyQuestion($id)
    {
        try {
            $question = Question::findOrFail($id);


            if (!$question) {
                return back()->with('error', __('no_find_data'));
            }
            foreach ($question->answers as $answer) {
                if ($answer->image && File::exists(public_path($answer->image))) {
                    File::delete(public_path($answer->image));
                }
                $answer->delete();
            }
            $question->delete();

            return redirect()->back()->with('success', __('delete_success'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('delete_error'));
        }
    }





}
