<?php

namespace App\Domains\Dashboards\Repositories;

use Carbon\Carbon;
use App\Domains\Patients\Models\PatientEntity;
use App\Domains\Visits\Models\VisitEntity;
use Illuminate\Support\Facades\DB;
 
class DashboardEntityRepository
{
    public function getDashboardStats(): array
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $newPatientsCount = PatientEntity::whereDate('created_at', $today)->count();

        $confirmedReservationsCount = VisitEntity::where('status', 'completed')
            ->whereDate('created_at', $today)
            ->count();

        $pendingReservationsCount = VisitEntity::where('status', 'pending')
            ->whereDate('created_at', $today)
            ->count();

        $todayRevenue = VisitEntity::where('status', 'completed')
            ->whereDate('created_at', $today)
            ->sum('price') ?? 0;

        $weeklyStats = VisitEntity::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->where('status', 'completed')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(price) as total_revenue'),
                DB::raw('COUNT(*) as visits_count') 
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
 
        return [
            'new_patients_today'     => $newPatientsCount,
            'confirmed_reservations' => $confirmedReservationsCount,
            'pending_reservations'   => $pendingReservationsCount,
            'today_revenue'          => $todayRevenue,
            'weekly_stats'           => $weeklyStats,
        ];
    }

    public function getSalesAndVisitsChartData(int $days = 7)
    {
        $startDate = Carbon::now()->subDays($days - 1)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $data = VisitEntity::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(price) as total_revenue, COUNT(*) as visits_count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $results = [];
        for ($i = 0; $i < $days; $i++) {
            $date = Carbon::now()->subDays($days - $i - 1)->format('Y-m-d');
            $existingData = $data->where('date', $date)->first();
            
            $results[] = [
                'date' => $date,
                'total_revenue' => $existingData ? (float) $existingData->total_revenue : 0,
                'visits_count' => $existingData ? (int) $existingData->visits_count : 0,
                'formatted_date' => Carbon::parse($date)->format('d M') 
            ];
        }

        return $results;
    }

    public function getReservationsDistribution(): array
    {
        $today = Carbon::today();

        $data = VisitEntity::whereDate('created_at', $today)
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statusLabels = [
            'completed' => 'مكتملة',
            'pending' => 'قيد الانتظار', 
            'cancelled' => 'ملغية',
            'missed' => 'فائتة'
        ];

        $result = [];
        $total = array_sum($data);
        
        foreach ($statusLabels as $status => $label) {
            $count = $data[$status] ?? 0;
            $percentage = $total > 0 ? round(($count / $total) * 100, 1) : 0;
            
            $result[$label] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }

        return $result;
    }
}