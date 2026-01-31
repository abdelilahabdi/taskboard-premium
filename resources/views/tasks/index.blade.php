<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mes Tâches') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    ➕ Nouvelle Tâche
                </a>
                <a href="{{ route('tasks.create.bulk') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    ➕ Plusieurs Tâches
                </a>
                <a href="{{ route('tasks.archived') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    🗂️ Archives
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filtres et recherche -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <!-- Tabs de statut -->
                    <div class="mb-4">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('tasks.index', array_merge(request()->except('status'), [])) }}" 
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                                      {{ !request('status') ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                Tous ({{ auth()->user()->tasks()->count() }})
                            </a>
                            <a href="{{ route('tasks.index', array_merge(request()->except('status'), ['status' => 'todo'])) }}" 
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                                      {{ request('status') === 'todo' ? 'bg-gray-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                Todo ({{ auth()->user()->tasks()->where('status', 'todo')->count() }})
                            </a>
                            <a href="{{ route('tasks.index', array_merge(request()->except('status'), ['status' => 'in_progress'])) }}" 
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                                      {{ request('status') === 'in_progress' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                In Progress ({{ auth()->user()->tasks()->where('status', 'in_progress')->count() }})
                            </a>
                            <a href="{{ route('tasks.index', array_merge(request()->except('status'), ['status' => 'done'])) }}" 
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                                      {{ request('status') === 'done' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                Done ({{ auth()->user()->tasks()->where('status', 'done')->count() }})
                            </a>
                        </div>
                    </div>
                    
                    <!-- Autres filtres -->
                    <form method="GET" action="{{ route('tasks.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <!-- Conserver le statut sélectionné -->
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        
                        <div class="md:col-span-2">
                            <input type="text" name="search" placeholder="Rechercher dans titre et description..." value="{{ request('search') }}" class="border rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <select name="priority" class="border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Toutes priorités</option>
                            <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Basse</option>
                            <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Moyenne</option>
                            <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>Haute</option>
                        </select>
                        
                        <select name="sort" class="border rounded px-3 py-2">
                            <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Date création</option>
                            <option value="deadline" {{ request('sort') === 'deadline' ? 'selected' : '' }}>Date limite</option>
                            <option value="priority" {{ request('sort') === 'priority' ? 'selected' : '' }}>Priorité</option>
                        </select>
                        
                        <!-- Bouton toggle pour deadline -->
                        @if(request('sort') === 'deadline')
                            <div class="flex gap-1">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded flex-1">
                                    Filtrer
                                </button>
                                <a href="{{ route('tasks.index', array_merge(request()->all(), ['sort' => 'deadline', 'order' => request('order') === 'asc' ? 'desc' : 'asc'])) }}" 
                                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-3 rounded flex items-center justify-center" 
                                   title="Inverser l'ordre de tri">
                                    @if(request('order') === 'asc')
                                        Asc 
                                    @else
                                        Desc
                                    @endif
                                </a>
                            </div>
                        @else
                            <div class="flex gap-2">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex-1">
                                    Filtrer
                                </button>
                            </div>
                        @endif
                        
                        @if(request()->hasAny(['search', 'priority', 'sort']))
                            <a href="{{ route('tasks.index', request('status') ? ['status' => request('status')] : []) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-center">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($tasks->count() > 0)
                        @if(request('search') || request('priority') || (request('sort') && request('sort') !== 'created_at'))
                            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded">
                                <div class="flex flex-wrap gap-2 items-center text-blue-800">
                                    <span>Filtres actifs :</span>
                                    @if(request('search'))
                                        <span class="bg-blue-200 px-2 py-1 rounded text-xs">
                                            Recherche: "{{ request('search') }}"
                                        </span>
                                    @endif
                                    @if(request('priority'))
                                        <span class="bg-blue-200 px-2 py-1 rounded text-xs">
                                            Priorité: 
                                            @if(request('priority') === 'low') Basse
                                            @elseif(request('priority') === 'medium') Moyenne  
                                            @else Haute @endif
                                        </span>
                                    @endif
                                    @if(request('sort') && request('sort') !== 'created_at')
                                        <span class="bg-blue-200 px-2 py-1 rounded text-xs">
                                            Tri: 
                                            @if(request('sort') === 'deadline')
                                                Date limite 
                                                @if(request('order') === 'asc') Asc @else Desc @endif
                                            @elseif(request('sort') === 'priority')
                                                Priorité
                                            @endif
                                        </span>
                                    @endif
                                    <span class="text-sm text-blue-600">({{ $tasks->total() }} résultat{{ $tasks->total() > 1 ? 's' : '' }})</span>
                                </div>
                            </div>
                        @endif
                        
                        <div class="grid gap-4">
                            @foreach($tasks as $task)
                                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold">{{ $task->title }}</h3>
                                            <p class="text-gray-600 mt-1">{{ $task->description ? Str::limit($task->description, 100) : 'Aucune description' }}</p>
                                            <div class="flex gap-4 mt-2 text-sm">
                                                <span class="px-2 py-1 rounded text-xs
                                                    @if($task->priority === 'high') bg-red-100 text-red-800
                                                    @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800
                                                    @else bg-green-100 text-green-800 @endif">
                                                    Priorité: {{ ucfirst($task->priority) }}
                                                </span>
                                                <span class="px-2 py-1 rounded text-xs
                                                    @if($task->status === 'done') bg-green-100 text-green-800
                                                    @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    Statut: {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                                @if($task->deadline)
                                                    <span class="text-gray-500 {{ $task->deadline->isPast() && $task->status !== 'done' ? 'text-red-600 font-bold' : '' }}">
                                                        Échéance: {{ $task->deadline->format('d/m/Y') }}
                                                        @if($task->deadline->isPast() && $task->status !== 'done')
                                                            (En retard)
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="text-gray-400 text-xs">Pas d'échéance</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex gap-2 ml-4">
                                            <!-- Changement de statut -->
                                            <div class="flex items-center gap-1">
                                                @if($task->status === 'todo')
                                                    <button onclick="updateStatus({{ $task->id }}, 'in_progress')" class="text-yellow-600 hover:text-yellow-900 text-sm">
                                                        En cours
                                                    </button>
                                                @elseif($task->status === 'in_progress')
                                                    <button onclick="updateStatus({{ $task->id }}, 'done')" class="text-green-600 hover:text-green-900 text-sm">
                                                        Terminer
                                                    </button>
                                                @endif
                                            </div>
                                            
                                            <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-900">Modifier</a>
                                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir archiver cette tâche ? Elle n\'apparaîtra plus dans votre liste.')">Archiver</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $tasks->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">Aucune tâche trouvée</p>
                            <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Créer votre première tâche
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-submit form when priority filter changes
        document.querySelector('select[name="priority"]').addEventListener('change', function() {
            this.form.submit();
        });
        
        // Auto-submit form when sort changes
        document.querySelector('select[name="sort"]').addEventListener('change', function() {
            // Si deadline est sélectionné, ajouter order=asc par défaut
            if (this.value === 'deadline') {
                const form = this.form;
                let orderInput = form.querySelector('input[name="order"]');
                if (!orderInput) {
                    orderInput = document.createElement('input');
                    orderInput.type = 'hidden';
                    orderInput.name = 'order';
                    form.appendChild(orderInput);
                }
                orderInput.value = 'asc'; // Par défaut croissant pour deadline
            }
            this.form.submit();
        });

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
</x-app-layout>