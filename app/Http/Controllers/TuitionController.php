<?php

namespace App\Http\Controllers;

use App\Models\ContentTuition;
use App\Models\Language;
use App\Models\Tuition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class TuitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $tuitions = Tuition::orderBy('numerical_order', 'asc')->get();
        return view('admin.pages.tuition.index', compact('tuitions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages =  Language::all();
        return view('admin.pages.tuition.create')->with('languages', $languages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'numerical_order' => 'required|numeric|unique:tuitions',
        ], [
            'numerical_order.required' => __('numerical_order.required'),
            'numerical_order.numeric' => __('numerical_order.numeric'),
            'numerical_order.unique' => __('numerical_order.unique'),
        ]);

        $languages =  Language::all();

        $validateAll = false;

        foreach ($languages as $language) {
            $titleField = 'title_' . $language->locale;
            if (!empty($request->input($titleField))) {
                $validateAll = true;
                break;
            }
        }
        
        if ($validateAll) {
            $rules = [];
            $messages = [];
            foreach ($languages as $language) {
                $titleField = 'title_' . $language->locale;
                $rules[$titleField] = 'required';
                $messages[$titleField . '.required'] = __('title.required');
            }
            $request->validate($rules, $messages);
        }

        try {
            $tuition = new Tuition();
            $tuition->numerical_order = $request->numerical_order;

            $translations = [];
            foreach ($languages as $language) {
                $translations[$language->locale] = $request->input("title_{$language->locale}") ?? '';
            }

            $tuition->setTranslations('title', $translations);

            $tuition->save();


        } catch (\Exception $e) {
            return redirect()->route('tuitions.create')
                ->with('error', __('tuition_create_error').' '.$e->getMessage());
        }
        return redirect()->route('tuitions.index')
            ->with('success', __('tuition_create_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show($tuition)
    {
        $tuition = Tuition::find($tuition);
        if ($tuition) {
            $contents_tuition = $tuition->content_tuition;
            return view('admin.pages.tuition.show', compact('tuition', 'contents_tuition'));
        } else {
            return redirect()->route('tuitions.index')
                ->with('error', __('tuition_not_found_show'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($tuition)
    {
        $tuition = Tuition::find($tuition);
        if ($tuition) {
            $languages =  Language::all();

            $translatedTitle = [];
            foreach ($languages as $language) {
                $translatedTitle[$language->locale] = $tuition->getTranslation('title', $language->locale);
            }

            return view('admin.pages.tuition.edit', compact('tuition', 'translatedTitle'));
        } else {
            return redirect()->route('tuitions.index')
                ->with('error', __('tuition_not_found_edit'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $tuition)
    {
        $request->validate([
            'numerical_order' => 'required|numeric|unique:tuitions,numerical_order,' . $tuition,
            'title' => 'nullable',
        ], [
            'numerical_order.required' => __('numerical_order.required'),
            'numerical_order.numeric' => __('numerical_order.numeric'),
            'numerical_order.unique' => __('numerical_order.unique'),
        ]);
        $languages =  Language::all();

        $validateAll = false;

        foreach ($languages as $language) {
            $titleField = 'title_' . $language->locale;
            if (!empty($request->input($titleField))) {
                $validateAll = true;
                break;
            }
        }
        
        if ($validateAll) {
            $rules = [];
            $messages = [];
            foreach ($languages as $language) {
                $titleField = 'title_' . $language->locale;
                $rules[$titleField] = 'required';
                $messages[$titleField . '.required'] = __('title.required');
            }
            $request->validate($rules, $messages);
        }

        $tuition = Tuition::find($tuition);
        if ($tuition) {
            try {
                $tuition->numerical_order = $request->numerical_order;

                $translations = [];
                foreach ($languages as $language) {
                    $translations[$language->locale] = $request->input("title_{$language->locale}") ?? '';
                }
    
                $tuition->setTranslations('title', $translations);
    
                $tuition->save();
            } catch (\Exception $e) {
                return redirect()->route('tuitions.edit', $tuition->id)
                    ->with('error', __('tuition_update_error'));
            }
            return redirect()->route('tuitions.index')
                ->with('success', __('tuition_update_success'));
        } else {
            return redirect()->route('tuitions.index')
                ->with('error', __('tuition_not_found_update'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($tuition)
    {
        $tuition = Tuition::find($tuition);
        if ($tuition) {
            try {
                $tuition->delete();
            } catch (\Exception $e) {
                return redirect()->route('tuitions.index')
                    ->with('error', __('tuition_delete_error'));
            }
            return redirect()->route('tuitions.index')
                ->with('success', __('tuition_delete_success'));
        } else {
            return redirect()->route('tuitions.index')
                ->with('error', __('tuition_not_found_delete'));
        }
    }

    public function createContent($tuition)
    {
        $tuition = Tuition::find($tuition);
        if ($tuition) {

            $languages = Language::all();

            return view('admin.pages.tuition.content-tuition.create', compact('tuition', 'languages'));
        } else {
            return redirect()->route('tuitions.index')
                ->with('error', __('tuition_not_found_create_content'));
        }
    }

    public function storeContent(Request $request, $tuition)
    {
       
        $tuition = Tuition::find($tuition);
        if ($tuition) {

            $languages = Language::all();
            foreach ($languages as $language) {
                $request->validate([
                    'list_' . $language->locale => 'required',
                    'cost_' . $language->locale => 'required',
                    'note_' . $language->locale => 'required',
                ], [
                    'list_' . $language->locale . '.required' => __('list.required'),
                    'cost_' . $language->locale . '.required' => __('cost.required'),
                    'cost_' . $language->locale . '.numeric' => __('cost.numeric'),
                    'note_' . $language->locale . '.required' => __('note.required'),
                ]);
            }

            try {
                $content = new ContentTuition();
                $content->tuition_id = $tuition->id;

                    $translationsList = [];
                    $translatedCost = [];
                    $translatedNote = [];

                    foreach ($languages as $language) {
                        $translationsList[$language->locale] = $request->input("list_{$language->locale}") ?? '';
                        $translatedCost[$language->locale] = $request->input("cost_{$language->locale}") ?? '';
                        $translatedNote[$language->locale] = $request->input("note_{$language->locale}") ?? '';
                    }
       
                    $content->setTranslations('list', $translationsList);
                    $content->setTranslations('cost', $translatedCost);
                    $content->setTranslations('note', $translatedNote);

                    $content->save();
            } catch (\Exception $e) {
                return redirect()->route('content-tuitions.create', $tuition->id)->withInput()->with('error', __('content_tuition_create_error') . ' ' . $e->getMessage());
            }
            return redirect()->route('tuitions.show', $tuition->id)
                ->with('success', __('content_tuition_create_success'));
        } else {
            return redirect()->route('tuitions.index')
                ->with('error', __('tuition_not_found_create_content'));
        }
    }

    public function editContent($content)
    {
        $content = ContentTuition::find($content);
        if ($content) {
            $languages =  Language::all();

            $translatedList = [];
            $translatedCost = [];
            $translatedNote = [];
            foreach ($languages as $language) {
                $translatedList[$language->locale] = $content->getTranslation('list', $language->locale);
                $translatedCost[$language->locale] = $content->getTranslation('cost', $language->locale);
                $translatedNote[$language->locale] = $content->getTranslation('note', $language->locale);
            }

            return view('admin.pages.tuition.content-tuition.edit', compact('content', 'translatedList', 'translatedCost', 'translatedNote'));
        } else {
            return redirect()->route('tuitions.index')
                ->with('error', __('content_tuition_not_found'));
        }
    }

    public function updateContent(Request $request, $content)
    {
        $content = ContentTuition::find($content);
        if ($content) {
            $languages = Language::all();
            foreach ($languages as $language) {
                $request->validate([
                    'list_' . $language->locale => 'required',
                    'cost_' . $language->locale => 'required',
                    'note_' . $language->locale => 'required',
                ], [
                    'list_' . $language->locale . '.required' => __('list.required'),
                    'cost_' . $language->locale . '.required' => __('cost.required'),
                    'cost_' . $language->locale . '.numeric' => __('cost.numeric'),
                    'note_' . $language->locale . '.required' => __('note.required'),
                ]);
            }
            try {

                    $translationsList = [];
                    $translatedCost = [];
                    $translatedNote = [];

                    foreach ($languages as $language) {
                        $translationsList[$language->locale] = $request->input("list_{$language->locale}") ?? '';
                        $translatedCost[$language->locale] = $request->input("cost_{$language->locale}") ?? '';
                        $translatedNote[$language->locale] = $request->input("note_{$language->locale}") ?? '';
                    }
       
                    $content->setTranslations('list', $translationsList);
                    $content->setTranslations('cost', $translatedCost);
                    $content->setTranslations('note', $translatedNote);

                    $content->save();
            } catch (\Exception $e) {
                return redirect()->route('content-tuitions.edit', $content->id)
                    ->with('error', __('content_tuition_update_error'));
            }
            return redirect()->route('tuitions.show', $content->tuition_id)
                ->with('success', __('content_tuition_update_success'));
        } else {
            return redirect()->route('tuitions.index')
                ->with('error', __('content_tuition_not_found'));
        }
    }

    public function destroyContent($content)
    {
        $content = ContentTuition::find($content);
        if ($content) {
            try {
                $content->delete();
            } catch (\Exception $e) {
                return redirect()->route('tuitions.show', $content->tuition_id)
                    ->with('error', __('content_tuition_delete_error'));
            }
            return redirect()->route('tuitions.show', $content->tuition_id)
                ->with('success', __('content_tuition_delete_success'));
        } else {
            return redirect()->route('tuitions.index')
                ->with('error', __('content_tuition_not_found'));
        }
    }
}
