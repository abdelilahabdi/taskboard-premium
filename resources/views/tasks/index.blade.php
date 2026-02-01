<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    📋 {{ __('Mes Tâches') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Gérez vos tâches efficacement</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('tasks.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-2.5 px-5 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                    ➕ Nouvelle Tâche
                </a>
                <a href="{{ route('tasks.create.bulk') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-2.5 px-5 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                    ➕ Plusieurs Tâches
                </a>
                <a href="{{ route('tasks.archived') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold py-2.5 px-5 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                    🗂️ Archives
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-400 text-green-800 px-6 py-4 rounded-r-lg mb-6 shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Filtres et recherche -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl mb-8 border border-gray-100">
                <div class="bg-gradient-to-r from-gray-50 to-white p-6">
                    <!-- Tabs de statut -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">📋 Filtrer par statut</h3>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('tasks.index', array_merge(request()->except('status'), [])) }}" 
                               class="px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-200 transform hover:scale-105
                                      {{ !request('status') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200 shadow-sm' }}">
                                📋 Tous ({{ auth()->user()->tasks()->count() }})
                            </a>
                            <a href="{{ route('tasks.index', array_merge(request()->except('status'), ['status' => 'todo'])) }}" 
                               class="px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-200 transform hover:scale-105
                                      {{ request('status') === 'todo' ? 'bg-gradient-to-r from-gray-500 to-gray-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200 shadow-sm' }}">
                                ⏳ Todo ({{ auth()->user()->tasks()->where('status', 'todo')->count() }})
                            </a>
                            <a href="{{ route('tasks.index', array_merge(request()->except('status'), ['status' => 'in_progress'])) }}" 
                               class="px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-200 transform hover:scale-105
                                      {{ request('status') === 'in_progress' ? 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200 shadow-sm' }}">
                                🔄 In Progress ({{ auth()->user()->tasks()->where('status', 'in_progress')->count() }})
                            </a>
                            <a href="{{ route('tasks.index', array_merge(request()->except('status'), ['status' => 'done'])) }}" 
                               class="px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-200 transform hover:scale-105
                                      {{ request('status') === 'done' ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200 shadow-sm' }}">
                                ✅ Done ({{ auth()->user()->tasks()->where('status', 'done')->count() }})
                            </a>
                        </div>
                    </div>
                    
                    <!-- Autres filtres -->
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">🔍 Recherche et filtres avancés</h3>
                        <form method="GET" action="{{ route('tasks.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                            <!-- Conserver le statut sélectionné -->
                            @if(request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">🔍 Rechercher</label>
                                <input type="text" name="search" placeholder="Rechercher dans titre et description..." value="{{ request('search') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">🏆 Priorité</label>
                                <select name="priority" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <option value="">Toutes priorités</option>
                                    <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>🟢 Basse</option>
                                    <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>🟡 Moyenne</option>
                                    <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>🔴 Haute</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">📅 Trier par</label>
                                <select name="sort" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Date création</option>
                                    <option value="deadline" {{ request('sort') === 'deadline' ? 'selected' : '' }}>Date limite</option>
                                    <option value="priority" {{ request('sort') === 'priority' ? 'selected' : '' }}>Priorité</option>
                                </select>
                            </div>
                        
                            <!-- Boutons d'action -->
                            @if(request('sort') === 'deadline')
                                <div class="flex gap-2">
                                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                        🔍 Filtrer
                                    </button>
                                    <a href="{{ route('tasks.index', array_merge(request()->all(), ['sort' => 'deadline', 'order' => request('order') === 'asc' ? 'desc' : 'asc'])) }}" 
                                       class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center" 
                                       title="Inverser l'ordre de tri">
                                        @if(request('order') === 'asc')
                                            ⬆️
                                        @else
                                            ⬇️
                                        @endif
                                    </a>
                                </div>
                            @else
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                        🔍 Filtrer
                                    </button>
                                </div>
                            @endif
                            
                            @if(request()->hasAny(['search', 'priority', 'sort']))
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                                    <a href="{{ route('tasks.index', request('status') ? ['status' => request('status')] : []) }}" class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 text-center block">
                                        ✖️ Reset
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
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