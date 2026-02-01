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
            
            // Calcul des statistiques avec vérification
            $total = $user->tasks()->count();
            $todo = $user->tasks()->where('status', 'todo')->count();
            $inProgress = $user->tasks()->where('status', 'in_progress')->count();
            $completed = $user->tasks()->where('status', 'done')->count();
            
            // Calcul des tâches en retard
            $overdue = $user->tasks()
                ->where('deadline', '<', now()->toDateString())
                ->whereIn('status', ['todo', 'in_progress'])
                ->count();
            
            // Calcul du pourcentage de complétion
            $completionPercentage = $total > 0 ? round(($completed / $total) * 100, 1) : 0;
            
            // Préparation des statistiques
            $stats = [
                'total' => $total,
                'todo' => $todo,
                'in_progress' => $inProgress,
                'completed' => $completed,
                'overdue' => $overdue,
                'completion_percentage' => $completionPercentage,
            ];

            // Récupération des tâches récentes
            $recentTasks = $user->tasks()
                ->latest()
                ->limit(5)
                ->get();

            return view('dashboard-professional', compact('stats', 'recentTasks'));
            
        } catch (\Exception $e) {
            // En cas d'erreur, redirection avec message
            return redirect()->route('tasks.index')
                ->with('error', 'Erreur lors du chargement du dashboard');
        }
    }
}