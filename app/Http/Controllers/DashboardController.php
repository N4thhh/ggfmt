<?php

namespace App\Http\Controllers;

use App\Models\ManagementTrainee;
use App\Models\Coach;
use App\Models\Panelist;
use App\Models\MtProgram;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = ManagementTrainee::query()
            ->when($request->program, fn($q) => $q->whereHas('mtProgram', fn($q) => $q->where('name', $request->program)))
            ->when($request->batch, fn($q) => $q->whereIn('batch', $request->batch));

        $mts = $query->get();

        $total    = $mts->count();
        $active   = $mts->where('status', 'active')->count();
        $graduate = $mts->where('status', 'graduate')->count();
        $withdraw = $mts->where('status', 'withdraw')->count();
        $failed   = $mts->where('status', 'failed')->count();

        $successRate    = $total > 0 ? round(($graduate / $total) * 100) : 0;
        $retentionRate  = $total > 0 ? round(($active / $total) * 100) : 0;
        $avgSuccessRate = $total > 0 ? round((($graduate + $active) / $total) * 100) : 0;

        $totalCoaches   = Coach::count();
        $totalPanelists = Panelist::count();

        $programs = MtProgram::pluck('name');
        $batches  = ManagementTrainee::distinct()->pluck('batch')->sort()->values();

        $allPrograms = MtProgram::all();
        $programStats = [];

        foreach ($allPrograms as $prog) {
            $subtitle = 'Business Manager';
            $progNameLower = strtolower($prog->name);
            
            if (str_contains($progNameLower, 'plantation')) {
                $subtitle = 'Plantation Expert';
            } elseif (str_contains($progNameLower, 'sales')) {
                $subtitle = 'Sales Leader';
            } elseif (str_contains($progNameLower, 'supply')) {
                $subtitle = 'Supply Chain Leader';
            }

            $progMts = ManagementTrainee::whereHas('mtProgram', fn($q) => $q->where('id', $prog->id))
                ->when($request->batch, fn($q) => $q->whereIn('batch', $request->batch))
                ->get();


                $programStats[] = [
                'name'     => $prog->name,
                'subtitle' => $subtitle,
                'hired'    => $progMts->count(),
                'graduate' => $progMts->where('status', 'graduate')->count(),
                'resign'   => $progMts->where('status', 'withdraw')->count(),
                'failed'   => $progMts->where('status', 'failed')->count(),
                'active'   => $progMts->where('status', 'active')->count(),
            ];
        }

        return view('dashboard', compact(
            'total', 'active', 'graduate', 'withdraw', 'failed',
            'successRate', 'retentionRate', 'avgSuccessRate',
            'totalCoaches', 'totalPanelists',
            'programs', 'batches',
            'programStats'
        ));
    }
}