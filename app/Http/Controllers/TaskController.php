<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->tasks();
        
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->priority) {
            $query->where('priority', $request->priority);
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        // Tri par deadline avec gestion des valeurs nulles
        if ($request->sort === 'deadline') {
            $order = $request->get('order', 'asc');
            if ($order === 'asc') {
                $query->orderByRaw('deadline IS NULL, deadline ASC');
            } else {
                $query->orderByRaw('deadline IS NULL, deadline DESC');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        $tasks = $query->paginate(10);
        
        return view('tasks.professional-index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'deadline' => 'nullable|date|after_or_equal:today',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:todo,in_progress,done',
        ]);
        
        auth()->user()->tasks()->create($request->all());
        
        return redirect()->route('tasks.index')->with('success', 'Tâche créée avec succès');
    }

    public function createBulk()
    {
        return view('tasks.create-bulk');
    }

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

        return redirect()->route('tasks.index')->with('success', $createdCount . ' tâche(s) créée(s) avec succès');
    }

    public function show(Task $task)
    {
        // virefy utilisateurs owner this tache
        if ($task->user_id !== auth()->id()) {
            abort(403, 'interdit pour afficher this tahe');
        }
         
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        // virefy utilisateurs owner this tache
        if ($task->user_id !== auth()->id()) {
            abort(403, 'interdit pour edit et modifier this tache');
        }
        
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        // virefy utilisateurs owner this tache
        if ($task->user_id !== auth()->id()) {
            abort(403, 'interdit pour edit et modifier this tache');
        }
        
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'deadline' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:todo,in_progress,done',
        ]);
        
        $task->update($request->all());
        
        return redirect()->route('tasks.index')->with('success', 'Tâche mise à jour avec succès');
    }

    public function destroy(Task $task)
    {
        // virefy utilisateurs owner this tache
        if ($task->user_id !== auth()->id()) {
            abort(403,  'interdit pour supprimer this tache');
        }
        
        $task->delete();
        
        return redirect()->route('tasks.index')->with('success', 'Tâche supprimée avec succès');
    }

    public function updateStatus(Request $request, Task $task)
    {
        
        // virefy utilisateurs owner this tache
        if ($task->user_id !== auth()->id()) {
            abort(403, 'interdit pour edit this tache');
        }   
        
        $request->validate([
            'status' => 'required|in:todo,in_progress,done'
        ]);
        
        $task->update(['status' => $request->status]);
        
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('tasks.index')->with('success', 'Statut mis à jour avec succès');
    }

    
    // afficher les tache que archiver
    public function archived()
    {
        $archivedTasks = auth()->user()->tasks()->onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);
        
        return view('tasks.archived', compact('archivedTasks'));
    }

    // recuperer un tache from archive
    public function restore($id)
    {
        $task = auth()->user()->tasks()->onlyTrashed()->findOrFail($id);
        
        $task->restore();
        
        return redirect()->route('tasks.archived')->with('success', 'Tâche restaurée avec succès');
    }

    // supprimer definitivement la tache 
    public function forceDelete($id)
    {
        $task = auth()->user()->tasks()->onlyTrashed()->findOrFail($id);
        
        $task->forceDelete();
        
        return redirect()->route('tasks.archived')->with('success', 'Tâche supprimée définitivement');
    }


    
}

