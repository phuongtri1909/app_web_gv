<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\CitizenMeetingSchedule;

class CitizenMeetingScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchStatus = $request->input('search-status');
        $searchDate = $request->input('search-date', \Carbon\Carbon::today()->toDateString());
        $searchDepartmentID = $request->input('search-department_id');

        $work_schedules = CitizenMeetingSchedule::query();

        if ($search) {
            $work_schedules->where(function ($query) use ($search) {
                $query->where('fullname', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('stt', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%')
                    ->orWhere('card_number', 'like', '%' . $search . '%');
            });
        }

        if ($searchStatus) {
            $work_schedules->where('status', $searchStatus);
        }

        if ($searchDate) {
            $work_schedules->where('working_day', $searchDate);
        }

        if ($searchDepartmentID) {
            $work_schedules->where('department_id', $searchDepartmentID);
        }

        $work_schedules = $work_schedules->paginate(15);

        $departments = Department::all();

        return view('admin.pages.p17.work_schedule.index', compact('work_schedules', 'departments', 'search', 'searchStatus', 'searchDate', 'searchDepartmentID'));
    }

    public function show($id)
    {
        $work_schedule = CitizenMeetingSchedule::find($id);

        if (!$work_schedule) {
            return redirect()->route('work-schedules.index')->with('error', 'Không tìm thấy lịch làm việc');
        }

        return view('admin.pages.p17.work_schedule.show', compact('work_schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $workSchedule = CitizenMeetingSchedule::find($id);

        if (!$workSchedule) {
            return redirect()->route('work-schedules.index')->with('error', 'Không tìm thấy lịch làm việc');
        }

        if (!Carbon::parse($workSchedule->working_day)->isToday()) {
            return redirect()->route('work-schedules.show', $id)->with('error', 'Chỉ có thể cập nhật trạng thái cho lịch làm việc của ngày hôm nay.');
        }

        $workSchedule->status = $request->input('status');
        $workSchedule->save();

        return redirect()->route('work-schedules.show', $id)->with('success', 'Trạng thái đã được cập nhật.');
    }
}
