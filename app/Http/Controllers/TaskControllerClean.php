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