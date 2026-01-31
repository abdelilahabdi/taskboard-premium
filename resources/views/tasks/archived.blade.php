<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tâches Archivées
            </h2>
            <a href="{{ route('tasks.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Retour aux tâches
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($archivedTasks->count() > 0)
                        <div class="grid gap-4">
                            @foreach($archivedTasks as $task)
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-700">{{ $task->title }}</h3>
                                            <p class="text-gray-600 mt-1">{{ $task->description ? Str::limit($task->description, 100) : 'Aucune description' }}</p>
                                            <div class="flex gap-4 mt-2 text-sm">
                                                <span class="px-2 py-1 rounded text-xs
                                                    @if($task->priority === 'high') bg-red-100 text-red-800
                                                    @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800
                                                    @else bg-green-100 text-green-800 @endif">
                                                    Priorité: {{ ucfirst($task->priority) }}
                                                </span>
                                                <span class="px-2 py-1 rounded text-xs bg-gray-200 text-gray-700">
                                                    Statut: {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                                @if($task->deadline)
                                                    <span class="text-gray-500">
                                                        Échéance: {{ $task->deadline->format('d/m/Y') }}
                                                    </span>
                                                @endif
                                                <span class="text-red-500 text-xs">
                                                    Archivée le: {{ $task->deleted_at->format('d/m/Y H:i') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex gap-2 ml-4">
                                            <form method="POST" action="{{ route('tasks.restore', $task->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 font-medium">
                                                    Restaurer
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('tasks.force.delete', $task->id) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium" onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cette tâche ? Cette action est irréversible.')">
                                                    Supprimer définitivement
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $archivedTasks->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">Aucune tâche archivée</p>
                            <a href="{{ route('tasks.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Retour aux tâches
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>