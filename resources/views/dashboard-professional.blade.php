<x-professional-layout>
    <!-- Hero Section -->
    <div class="gradient-bg text-white py-12 mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Tableau de Bord</h1>
                <p class="text-xl opacity-90">Gérez vos tâches efficacement et suivez vos progrès</p>
                <div class="mt-6 flex justify-center space-x-4">
                    <a href="{{ route('tasks.create') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-200 shadow-lg inline-flex items-center" style="background-color: white !important; color: #2563eb !important;">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Nouvelle Tâche</span>
                    </a>
                    <a href="{{ route('tasks.index') }}" class="bg-transparent border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-all duration-200 inline-flex items-center" style="color: white !important; border-color: white !important;">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        <span>Voir Toutes les Tâches</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Tasks -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 card-hover transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total des Tâches</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">Toutes vos tâches</p>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Todo Tasks -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 card-hover transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">À Faire</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['todo'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">En attente</p>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- In Progress Tasks -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 card-hover transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">En Cours</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['in_progress'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">En progression</p>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Completed Tasks -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 card-hover transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Terminées</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['completed'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">Accomplies</p>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-green-500 to-green-600 rounded-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Overview & Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Completion Progress -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Progression Globale</h3>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">Taux de Completion</span>
                            <span class="text-2xl font-bold text-purple-600">{{ $stats['completion_percentage'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-4 rounded-full transition-all duration-1000 ease-out" style="width: {{ $stats['completion_percentage'] }}%"></div>
                        </div>
                    </div>
                    
                    @if($stats['overdue'] > 0)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-red-700 font-medium">{{ $stats['overdue'] }} tâche(s) en retard</span>
                        </div>
                    </div>
                    @endif
                    
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center p-3 bg-yellow-50 rounded-lg">
                            <p class="text-2xl font-bold text-yellow-600">{{ $stats['todo'] }}</p>
                            <p class="text-xs text-yellow-700">À Faire</p>
                        </div>
                        <div class="text-center p-3 bg-orange-50 rounded-lg">
                            <p class="text-2xl font-bold text-orange-600">{{ $stats['in_progress'] }}</p>
                            <p class="text-xs text-orange-700">En Cours</p>
                        </div>
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <p class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</p>
                            <p class="text-xs text-green-700">Terminées</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Actions Rapides</h3>
                <div class="space-y-4">
                    <a href="{{ route('tasks.create') }}" class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-xl transition-all duration-200 group">
                        <div class="p-3 bg-blue-500 rounded-lg mr-4 group-hover:bg-blue-600 transition-colors">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Créer une tâche</p>
                            <p class="text-sm text-gray-600">Ajouter une nouvelle tâche</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('tasks.create.bulk') }}" class="flex items-center p-4 bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-xl transition-all duration-200 group">
                        <div class="p-3 bg-green-500 rounded-lg mr-4 group-hover:bg-green-600 transition-colors">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Création multiple</p>
                            <p class="text-sm text-gray-600">Créer plusieurs tâches</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('tasks.archived') }}" class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 rounded-xl transition-all duration-200 group">
                        <div class="p-3 bg-gray-500 rounded-lg mr-4 group-hover:bg-gray-600 transition-colors">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l6 6 6-6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Archives</p>
                            <p class="text-sm text-gray-600">Voir les tâches archivées</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Tasks -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Tâches Récentes</h3>
                <a href="{{ route('tasks.index') }}" class="text-blue-600 hover:text-blue-700 font-medium transition-colors">
                    Voir toutes →
                </a>
            </div>
            
            @if($recentTasks->count() > 0)
                <div class="space-y-4">
                    @foreach($recentTasks as $task)
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl hover:from-gray-100 hover:to-gray-200 transition-all duration-200">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 mb-1">{{ $task->title }}</h4>
                                <div class="flex items-center space-x-3">
                                    <!-- Priority Badge -->
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                           ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                    
                                    <!-- Status Badge -->
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        {{ $task->status === 'done' ? 'bg-green-100 text-green-800' : 
                                           ($task->status === 'in_progress' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $task->status === 'in_progress' ? 'En cours' : ($task->status === 'done' ? 'Terminée' : 'Todo') }}
                                    </span>
                                    
                                    @if($task->deadline)
                                        <span class="text-xs text-gray-500 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $task->deadline->format('d/m/Y') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-2 ml-4">
                                <a href="{{ route('tasks.edit', $task) }}" class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune tâche récente</h3>
                    <p class="text-gray-500 mb-6">Commencez par créer votre première tâche.</p>
                    <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Créer une tâche
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-professional-layout>