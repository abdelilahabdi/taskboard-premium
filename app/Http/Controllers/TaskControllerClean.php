<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    /**
     * Afficher la liste des tâches avec filtres
     */
    public function index(Request $request)
    {
        $query = auth()->user()->tasks();
        
        // Application des filtres
        $this->applyFilters($query, $request);
        $this->applySorting($query, $request);
        
        $tasks = $query->paginate(10);
        
        return view('tasks.professional-index', compact('tasks'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('tasks.create');
    }


    /**
     * Enregistrer une nouvelle tâche
     */
    public function store(Request $request)
    {
        $this->validateTask($request);
        
        auth()->user()->tasks()->create($request->all());
        
        return redirect()->route('tasks.index')
            ->with('success', 'Tâche créée avec succès');
    }


    
    /**
     * Afficher le formulaire de création multiple
     */
    public function createBulk()
    {
        return view('tasks.create-bulk');
    }



     /**
     * Enregistrer plusieurs tâches
     */
    public function storeBulk(Request $request)
    {
        $request->validate([
            'tasks' => 'required|array|min:1|max:5',
            'tasks.*.title' => 'required|string|max:255',
            'tasks.*.description' => 'nullable|string',
            'tasks.*.deadline' => 'nullable|date|after_or_equal:today',
            'tasks.*.priority' => 'required|in:low,medium,high',
            'tasks.*.status' => 'required|in:todo,in_progress,done',
        ]);

        $createdCount = 0;
        foreach ($request->tasks as $taskData) {
            if (!empty($taskData['title'])) {
                auth()->user()->tasks()->create($taskData);
                $createdCount++;
            }
        }

        return redirect()->route('tasks.index')
            ->with('success', $createdCount . ' tâche(s) créée(s) avec succès');
    }



     /**
     * Afficher une tâche spécifique
     */
    public function show(Task $task)
    {
        $this->checkOwnership($task);
        return view('tasks.show', compact('task'));
    }


      /**
     * Afficher le formulaire d'édition
     */
    public function edit(Task $task)
    {
        $this->checkOwnership($task);
        return view('tasks.edit', compact('task'));
    }



    /**
     * Mettre à jour une tâche
     */
    public function update(Request $request, Task $task)
    {
        $this->checkOwnership($task);
        $this->validateTask($request, false);
        
        $task->update($request->all());
        
        return redirect()->route('tasks.index')
            ->with('success', 'Tâche mise à jour avec succès');
    }



    /**
     * Supprimer (archiver) une tâche
     */
    public function destroy(Task $task)
    {
        $this->checkOwnership($task);
        
        $task->delete();
        
        return redirect()->route('tasks.index')
            ->with('success', 'Tâche archivée avec succès');
    }



    /**
     * Mettre à jour le statut d'une tâche
     */
    public function updateStatus(Request $request, Task $task)
    {
        $this->checkOwnership($task);
        
        $request->validate([
            'status' => 'required|in:todo,in_progress,done'
        ]);
        
        $task->update(['status' => $request->status]);
        
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('tasks.index')
            ->with('success', 'Statut mis à jour avec succès');
    }



     /**
     * Afficher les tâches archivées
     */
    public function archived()
    {
        $archivedTasks = auth()->user()->tasks()
            ->onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);
        
        return view('tasks.archived', compact('archivedTasks'));
    }


     /**
     * Restaurer une tâche archivée
     */
    public function restore($id)
    {
        $task = auth()->user()->tasks()->onlyTrashed()->findOrFail($id);
        $task->restore();
        
        return redirect()->route('tasks.archived')
            ->with('success', 'Tâche restaurée avec succès');
    }



    /**
     * Supprimer définitivement une tâche
     */
    public function forceDelete($id)
    {
        $task = auth()->user()->tasks()->onlyTrashed()->findOrFail($id);
        $task->forceDelete();
        
        return redirect()->route('tasks.archived')
            ->with('success', 'Tâche supprimée définitivement');
    }


      /**
     * Vérifier la propriété d'une tâche
     */
    private function checkOwnership(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé à cette tâche');
        }
    }



     /**
     * Valider les données d'une tâche
     */
    private function validateTask(Request $request, $requireFutureDate = true)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:todo,in_progress,done',
        ];
        
        // Pour la création, exiger une date future
        if ($requireFutureDate) {
            $rules['deadline'] = 'nullable|date|after_or_equal:today';
        } else {
            $rules['deadline'] = 'nullable|date';
        }
        
        $request->validate($rules);
    }