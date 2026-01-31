<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $user = auth()->user();
            
            $total = $user->tasks()->count();
            $todo = $user->tasks()->where('status', 'todo')->count();
            $inProgress = $user->tasks()->where('status', 'in_progress')->count();
            $completed = $user->tasks()->where('status', 'done')->count();
            $overdue = $user->tasks()
                ->where('deadline', '<', now()->toDateString())
                ->whereIn('status', ['todo', 'in_progress'])
                ->count();
            
            $completionPercentage = $total > 0 ? round(($completed / $total) * 100, 1) : 0;
            
            $stats = [
                'total' => $total,
                'todo' => $todo,
                'in_progress' => $inProgress,
                'completed' => $completed,
                'overdue' => $overdue,
                'completion_percentage' => $completionPercentage,
            ];

            $recentTasks = $user->tasks()->latest()->limit(5)->get();

            return view('dashboard', compact('stats', 'recentTasks'));
        } catch (\Exception $e) {
            // En cas d'erreur, rediriger vers les tâches
            return redirect()->route('tasks.index')->with('error', 'Erreur lors du chargement du dashboard');
        }
    }
}