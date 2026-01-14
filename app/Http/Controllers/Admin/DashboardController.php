<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Services\DashboardService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardService;

    // Inject the Service
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        // 1. Resolve Date Range Inputs
        $startDate = $request->input('start_date') 
            ? Carbon::parse($request->input('start_date'))->startOfDay() 
            : Carbon::now()->startOfMonth();

        $endDate = $request->input('end_date') 
            ? Carbon::parse($request->input('end_date'))->endOfDay() 
            : Carbon::now()->endOfMonth();

        // 2. Delegate Heavy Logic to Service
        $data = $this->dashboardService->getDashboardStats($startDate, $endDate);

        // 3. Return View
        return view('admin.dashboard', $data);
    }

    public function disbursed()
    {
        return view('admin.disbursed');
    }
    public function settings()
    {
        return view('admin.settings');
    }
}
