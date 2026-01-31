<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-6">
                <!-- Total -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</div>
                        <div class="text-sm text-gray-600 font-medium">Total</div>
                    </div>
                </div>
                
                <!-- Todo -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-gray-500">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-gray-600">{{ $stats['todo'] }}</div>
                        <div class="text-sm text-gray-600 font-medium">Todo</div>
                    </div>
                </div>
                
                <!-- In Progress -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-yellow-500">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-yellow-600">{{ $stats['in_progress'] }}</div>
                        <div class="text-sm text-gray-600 font-medium">In Progress</div>
                    </div>
                </div>
                
                <!-- Done -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $stats['completed'] }}</div>
                        <div class="text-sm text-gray-600 font-medium">Done</div>
                    </div>
                </div>
                
                <!-- En retard -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-red-500">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-red-600">{{ $stats['overdue'] }}</div>
                        <div class="text-sm text-gray-600 font-medium">En retard</div>
                    </div>
                </div>
                
                <!-- Pourcentage de complétion -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ $stats['completion_percentage'] }}%</div>
                        <div class="text-sm text-gray-600 font-medium">Complétion</div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $stats['completion_percentage'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Actions rapides</h3>
                    <div class="flex gap-4">
                        <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Nouvelle tâche
                        </a>
                        <a href="{{ route('tasks.create.bulk') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            ➕ Plusieurs tâches
                        </a>
                        <a href="{{ route('tasks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Voir toutes les tâches
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tâches récentes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Tâches récentes</h3>
                    @if($recentTasks->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentTasks as $task)
                                <div class="flex justify-between items-center p-3 border rounded">
                                    <div>
                                        <h4 class="font-medium">{{ $task->title }}</h4>
                                        <div class="flex gap-2 mt-1">
                                            <span class="px-2 py-1 rounded text-xs
                                                @if($task->priority === 'high') bg-red-100 text-red-800
                                                @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800
                                                @else bg-green-100 text-green-800 @endif">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                            <span class="px-2 py-1 rounded text-xs
                                                @if($task->status === 'done') bg-green-100 text-green-800
                                                @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-900">Modifier</a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Aucune tâche récente</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>