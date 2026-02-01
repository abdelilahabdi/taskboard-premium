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
