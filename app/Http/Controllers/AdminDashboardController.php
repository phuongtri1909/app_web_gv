<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BusinessMember;
use App\Models\Business;

class AdminDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $period = $request->input('period', 'month');
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $businessMemberRegistrations = $this->getRegistrationsByPeriod(BusinessMember::class, $period, $month, $year);
        $businessRegistrations = $this->getRegistrationsByPeriod(Business::class, $period, $month, $year);

        $businessMemberPercentageChange = $this->getPercentageChange($businessMemberRegistrations['current'], $businessMemberRegistrations['previous']);
        $businessPercentageChange = $this->getPercentageChange($businessRegistrations['current'], $businessRegistrations['previous']);

        return view('admin.pages.dashboard', compact('businessMemberRegistrations', 'businessMemberPercentageChange', 'businessRegistrations', 'businessPercentageChange', 'period', 'month', 'year'));
    }

    public function getPercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return (($current - $previous) / $previous) * 100;
    }

    public function getRegistrationsByPeriod($model, $period, $month, $year)
    {
        $current = Carbon::create($year, $month, 1);
        $previous = Carbon::create($year, $month, 1);

        switch ($period) {
            case 'day':
                $current = $current->startOfDay();
                $previous = $previous->subDay()->startOfDay();
                break;
            case 'week':
                $current = $current->startOfWeek();
                $previous = $previous->subWeek()->startOfWeek();
                break;
            case 'month':
            default:
                $current = $current->startOfMonth();
                $previous = $previous->subMonth()->startOfMonth();
                break;
        }

        $currentRegistrations = $model::where('created_at', '>=', $current)->where('created_at', '<', $current->copy()->addMonth())->count();
        $previousRegistrations = $model::where('created_at', '>=', $previous)->where('created_at', '<', $current)->count();

        return [
            'current' => $currentRegistrations,
            'previous' => $previousRegistrations,
        ];
    }
}