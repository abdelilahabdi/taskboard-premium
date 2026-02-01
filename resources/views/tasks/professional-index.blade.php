<x-professional-layout>
    <!-- Header Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-4 lg:mb-0">
                    <h1 class="text-3xl font-bold text-gray-900">Gestion des Tâches</h1>
                    <p class="mt-2 text-gray-600">Organisez et suivez vos tâches efficacement</p>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('tasks.create') }}" class="btn-primary inline-flex items-center px-4 py-2 font-semibold rounded-lg shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nouvelle Tâche
                    </a>
                    <a href="{{ route('tasks.create.bulk') }}" class="btn-success inline-flex items-center px-4 py-2 font-semibold rounded-lg shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Création Multiple
                    </a>
                    <a href="{{ route('tasks.archived') }}" class="btn-secondary inline-flex items-center px-4 py-2 font-semibold rounded-lg shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l6 6 6-6"></path>
                        </svg>
                        Archives
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total</p>
                        <p class="text-2xl font-bold text-gray-900">{{ auth()->user()->tasks()->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">En Attente</p>
                        <p class="text-2xl font-bold text-gray-900">{{ auth()->user()->tasks()->where('status', 'todo')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
                <div class="flex items-center">
                    <div class="p-2 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">En Cours</p>
                        <p class="text-2xl font-bold text-gray-900">{{ auth()->user()->tasks()->where('status', 'in_progress')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Terminées</p>
                        <p class="text-2xl font-bold text-gray-900">{{ auth()->user()->tasks()->where('status', 'done')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtres et Recherche</h3>
                
                <!-- Status Tabs -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <button onclick="filterTasks('all')" id="btn-all" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-blue-600 text-white shadow-md">
                        Toutes ({{ auth()->user()->tasks()->count() }})
                    </button>
                    <button onclick="filterTasks('todo')" id="btn-todo" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Todo ({{ auth()->user()->tasks()->where('status', 'todo')->count() }})
                    </button>
                    <button onclick="filterTasks('in_progress')" id="btn-in_progress" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                        En Cours ({{ auth()->user()->tasks()->where('status', 'in_progress')->count() }})
                    </button>
                    <button onclick="filterTasks('done')" id="btn-done" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Terminées ({{ auth()->user()->tasks()->where('status', 'done')->count() }})
                    </button>
                </div>

                <!-- Search Form -->
                <form method="GET" action="{{ route('tasks.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" placeholder="Titre ou description..." value="{{ request('search') }}" class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Priorité</label>
                        <select name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Toutes</option>
                            <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Basse</option>
                            <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Moyenne</option>
                            <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>Haute</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Trier par</label>
                        <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="created_at">Date création</option>
                            <option value="deadline" {{ request('sort') === 'deadline' ? 'selected' : '' }}>Échéance</option>
                            <option value="priority" {{ request('sort') === 'priority' ? 'selected' : '' }}>Priorité</option>
                        </select>
                    </div>
                    
                    <div class="flex items-end gap-2">
                        <button type="submit" class="btn-primary flex-1 font-medium py-2 px-4 rounded-lg">
                            Filtrer
                        </button>
                        @if(request()->hasAny(['search', 'priority', 'sort']))
                            <a href="{{ route('tasks.index', request('status') ? ['status' => request('status')] : []) }}" class="btn-secondary font-medium py-2 px-4 rounded-lg">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Tasks List -->
        <div class="space-y-4" id="tasksList">
            @if($tasks->count() > 0)
                @foreach($tasks as $task)
                    <div class="task-item bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover" data-status="{{ $task->status }}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $task->title }}</h3>
                                    
                                    <!-- Priority Badge -->
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                           ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                    
                                    <!-- Status Badge -->
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $task->status === 'done' ? 'bg-green-100 text-green-800' : 
                                           ($task->status === 'in_progress' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $task->status === 'in_progress' ? 'En cours' : ($task->status === 'done' ? 'Terminée' : 'Todo') }}
                                    </span>
                                </div>
                                
                                <p class="text-gray-600 mb-3">{{ $task->description ?: 'Aucune description' }}</p>
                                
                                @if($task->deadline)
                                    <div class="flex items-center text-sm {{ $task->deadline->isPast() && $task->status !== 'done' ? 'text-red-600' : 'text-gray-500' }}">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Échéance: {{ $task->deadline->format('d/m/Y') }}
                                        @if($task->deadline->isPast() && $task->status !== 'done')
                                            <span class="ml-1 font-semibold">(En retard)</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex items-center space-x-2 ml-4">
                                <!-- Status Change Buttons -->
                                @if($task->status === 'todo')
                                    <button onclick="updateStatus({{ $task->id }}, 'in_progress')" class="btn-warning inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-9-4V8a3 3 0 013-3h6a3 3 0 013 3v2M7 21h10a2 2 0 002-2V9a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        Démarrer
                                    </button>
                                @elseif($task->status === 'in_progress')
                                    <button onclick="updateStatus({{ $task->id }}, 'done')" class="btn-success inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Terminer
                                    </button>
                                @endif
                                
                                <!-- Edit Button -->
                                <a href="{{ route('tasks.edit', $task) }}" class="btn-primary inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Modifier
                                </a>
                                
                                <!-- Delete Button -->
                                <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg" onclick="return confirm('Êtes-vous sûr de vouloir archiver cette tâche ?')">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Archiver
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $tasks->appends(request()->query())->links() }}
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center" id="emptyState" style="display: none;">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Aucune tâche trouvée</h3>
                    <p class="mt-2 text-gray-500">Aucune tâche ne correspond au filtre sélectionné.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        function filterTasks(status) {
            // Get all buttons
            const allBtn = document.getElementById('btn-all');
            const todoBtn = document.getElementById('btn-todo');
            const progressBtn = document.getElementById('btn-in_progress');
            const doneBtn = document.getElementById('btn-done');
            const tasks = document.querySelectorAll('.task-item');
            
            // Reset all buttons to gray with !important styles
            [allBtn, todoBtn, progressBtn, doneBtn].forEach(btn => {
                btn.style.backgroundColor = '#f3f4f6';
                btn.style.color = '#374151';
                btn.style.boxShadow = 'none';
            });
            
            // Set active button color with !important styles
            let activeBtn;
            if (status === 'all') {
                activeBtn = allBtn;
                activeBtn.style.backgroundColor = '#2563eb';
            } else if (status === 'todo') {
                activeBtn = todoBtn;
                activeBtn.style.backgroundColor = '#ca8a04';
            } else if (status === 'in_progress') {
                activeBtn = progressBtn;
                activeBtn.style.backgroundColor = '#ea580c';
            } else if (status === 'done') {
                activeBtn = doneBtn;
                activeBtn.style.backgroundColor = '#16a34a';
            }
            
            if (activeBtn) {
                activeBtn.style.color = 'white';
                activeBtn.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
            }
            
            // Filter tasks
            let visibleCount = 0;
            tasks.forEach(task => {
                if (status === 'all' || task.getAttribute('data-status') === status) {
                    task.style.display = 'block';
                    visibleCount++;
                } else {
                    task.style.display = 'none';
                }
            });
            
            // Show/hide empty state
            const emptyState = document.getElementById('emptyState');
            if (visibleCount === 0) {
                emptyState.style.display = 'block';
            } else {
                emptyState.style.display = 'none';
            }
        }
        
        function updateStatus(taskId, newStatus) {
            fetch(`/tasks/${taskId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Erreur lors de la mise à jour du statut');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la mise à jour du statut');
            });
        }
    </script>
</x-professional-layout>