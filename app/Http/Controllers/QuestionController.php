<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\CategoryQuestion;
use App\Models\Forum;
use App\Models\Question;
use App\Models\Slider;
use App\Models\Tab;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Show the advisory board page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $forumsCp1 = Forum::where('active', 'yes')
            ->where('key_page', 'key_forum_cp1')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $forumCp2 = Forum::where('key_page', 'key_forum_cp2')
            ->where('active', 'yes')
            ->first();
            $forums = Forum::where('active', 'yes')->get();
        $questions = Question::with('answers')->whereHas('answers')->paginate(15, ['*'], 'page_1');
        $question_asks = Question::with('category', 'answers')->whereHas('answers')->paginate(2, ['*'], 'page_2');

        if ($redirect = $this->validatePagination($request, 'page_1', $questions->lastPage())) {
            return $redirect;
        }

        if ($redirect = $this->validatePagination($request, 'page_2', $question_asks->lastPage())) {
            return $redirect;
        }

        $campus_brighton = $request->cookie('campus_brighton');
        if ($campus_brighton) {
            $campus = Branch::where('id', $campus_brighton)->first();
            if (!$campus) {
                $campus = Branch::first();
                $campus = Branch::first();
                if (!$campus) {
                    $personnel = null;
                } else {
                    $personnel = $campus->personnel;
                }
            }else{
                $personnel = $campus->personnel;
            }

        } else {
            $campus = Branch::first();
            if (!$campus) {
                $personnel = null;
            } else {
                $personnel = $campus->personnel;
            }
        }
        $categories = CategoryQuestion::all();
        $campuses = Branch::get();
        $tab = Tab::where('slug', 'advisory-board')->first();
        $forumsCp3 = Forum::where('active', 'yes')
        ->where('key_page', 'key_forum_cp3')
        ->orderBy('created_at', 'desc')
        ->get();
        foreach ($forumsCp3 as $forum) {
            $forum->image = json_decode($forum->image, true) ?? [];
        }

        return view('pages.advisory-board', compact('questions', 'forums', 'forumCp2', 'question_asks', 'forumsCp1', 'tab',"personnel",'categories','forumsCp3'));
    }

    /**
     * Increment the view count for a question.
     *
     * @param int $id Question ID
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function incrementView($id)
    {
        if ($id <= 0 || !Question::find($id)) {
            return response()->json(['error' => __('invalid_id')], 400);
        }
        $viewedQuestions = session()->get('views', []);
        if (!in_array($id, $viewedQuestions)) {
            $question = Question::findOrFail($id);
            $question->increment('view');
            session()->push('views', $id);

            return response()->json(['success' => true, 'view' => $question->view]);
        }
    }



    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Validate and store a new question in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'email' => 'required|email',
            'content' => 'required|string',
        ];

        $messages = [
            'name.required' => __('form.name.required'),
            'name.string' => __('form.name.string'),
            'name.max' => __('form.name.max'),
            'phone.required' => __('form.phone.required'),
            'phone.digits' => __('form.phone.digits'),
            'email.required' => __('form.email_required'),
            'email.email' => __('form.email_email'),
            'content.required' => __('form.content.required'),
            'content.string' => __('form.content.string'),
        ];

        $validated = $request->validate($rules, $messages);

        try {
            $content = htmlspecialchars($validated['content'], ENT_QUOTES, 'UTF-8');

            Question::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'content' => $content,
                'category_id' => null,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => __('error_save_question')]);
        }

        return redirect()->back()->with('success', __('save_success'));
    }
    /**
     * Validate pagination and redirect to the last page if the current page is out of range.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $pageParam  The query parameter name of the current page
     * @param  int  $lastPage  The last page number of the pagination
     * @return  \Illuminate\Http\RedirectResponse|null  The redirect response if the current page is out of range, null otherwise
     */
    protected function validatePagination(Request $request, string $pageParam, int $lastPage)
    {
        if ($request->has($pageParam) && $request->input($pageParam) > $lastPage) {
            return redirect()->route('advisory-board', array_merge(
                $request->query(), // Preserve all existing query parameters
                [$pageParam => $lastPage] // Update the current page parameter to last page
            ));
        }

        return null; // Return null if no redirect is needed
    }

}
