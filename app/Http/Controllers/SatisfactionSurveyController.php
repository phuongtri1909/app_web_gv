<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\SatisfactionSurvey;

class SatisfactionSurveyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchDate = $request->input('search-date');
        $searchDepartmentID = $request->input('search-department_id');

        $satisfactionSurveys = SatisfactionSurvey::query();

        if ($search) {
            $satisfactionSurveys->where(function ($query) use ($search) {
                $query->where('description', 'like', '%' . $search . '%');
            });
        }

        if ($searchDate) {
            $satisfactionSurveys->whereDate('created_at', $searchDate);
        }

        if ($searchDepartmentID) {
            $satisfactionSurveys->where('department_id', $searchDepartmentID);
        }

        $satisfactionSurveys = $satisfactionSurveys->paginate(15);

        // Tính điểm trung bình 5 sao cho từng phòng ban
        $departmentRatings = Department::with(['satisfactionSurveys' => function ($query) use ($search, $searchDate, $searchDepartmentID) {
            if ($search) {
                $query->where('description', 'like', '%' . $search . '%');
            }
            if ($searchDate) {
                $query->whereDate('created_at', $searchDate);
            }
            if ($searchDepartmentID) {
                $query->where('department_id', $searchDepartmentID);
            }
        }])->get()->mapWithKeys(function ($department) {
            $averageRating = $department->satisfactionSurveys->avg('level');
            return [$department->name => $averageRating];
        })->toArray(); // Chuyển đổi Collection thành mảng

        $departments = Department::all();

        return view('admin.pages.p17.satisfaction_survey.index', compact('satisfactionSurveys', 'departments', 'departmentRatings'));
    }
}
