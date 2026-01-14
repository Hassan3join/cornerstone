<?php

namespace App\Services;

use App\Models\Submission;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardService
{
    /**
     * Get all dashboard statistics for a given date range.
     */
    public function getDashboardStats($startDate, $endDate)
    {
        // 1. Calculate Previous Period (for "Growth" comparison)
        // If user filters 7 days, we compare it to the 7 days before that.
        $diffInDays = $startDate->diffInDays($endDate) + 1;
        $prevStartDate = $startDate->copy()->subDays($diffInDays);
        $prevEndDate = $endDate->copy()->subDays($diffInDays);

        // 2. Fetch Metrics
        return [
            'total_apps'      => $this->getTotalAppsData($startDate, $endDate, $prevStartDate, $prevEndDate),
            'revenue'         => $this->getRevenueData($startDate, $endDate, $prevStartDate, $prevEndDate),
            'pending_count'   => $this->getPendingCount($startDate, $endDate),
            'rejected_count'  => $this->getRejectedCount($startDate, $endDate),
            'recent_requests' => $this->getRecentSubmissions($startDate, $endDate),
            'date_range'      => [
                'start' => $startDate,
                'end'   => $endDate
            ]
        ];
    }

    private function getTotalAppsData($start, $end, $prevStart, $prevEnd)
    {
        $current = Submission::whereBetween('created_at', [$start, $end])->count();
        $previous = Submission::whereBetween('created_at', [$prevStart, $prevEnd])->count();
        
        return [
            'count' => $current,
            'growth' => $this->calculateGrowth($current, $previous)
        ];
    }

    private function getRevenueData($start, $end, $prevStart, $prevEnd)
    {
        $current = Transaction::where('status', 'succeeded')
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');

        $previous = Transaction::where('status', 'succeeded')
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->sum('amount');

        return [
            'amount' => $current,
            'growth' => $this->calculateGrowth($current, $previous)
        ];
    }

    private function getPendingCount($start, $end)
    {
        return Submission::where('status', 'pending')
            ->whereBetween('created_at', [$start, $end])
            ->count();
    }

    private function getRejectedCount($start, $end)
    {
        return Submission::where('status', 'rejected')
            ->whereBetween('created_at', [$start, $end])
            ->count();
    }

    private function getRecentSubmissions($start, $end, $limit = 5)
    {
        return Submission::with(['user', 'form'])
            ->whereBetween('created_at', [$start, $end])
            ->latest()
            ->take($limit)
            ->get();
    }

    /**
     * Helper to calculate percentage growth safely
     */
    private function calculateGrowth($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        
        return round((($current - $previous) / $previous) * 100, 1);
    }
}