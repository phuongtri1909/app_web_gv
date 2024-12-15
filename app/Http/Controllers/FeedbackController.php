<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $searchDate = $request->input('search-date');
        $feedbacks = Feedback::query();

        if ($searchDate) {
            $feedbacks->whereDate('created_at', $searchDate);
        }

        $feedbacks = $feedbacks->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.pages.p17.feedback.index', compact('feedbacks'));
    }
}
