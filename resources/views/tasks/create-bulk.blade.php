<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Créer plusieurs tâches
            </h2>
            <a href="{{ route('tasks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('tasks.store.bulk') }}">
                        @csrf
                        
                        <div class="mb-6">
                            <p class="text-gray-600 mb-4">Créez jusqu'à 5 tâches en une seule fois. Seules les tâches avec un titre seront enregistrées.</p>
                            
                            <div id="tasks-container">
                                @for($i = 0; $i < 3; $i++)
                                <div class="task-form border rounded-lg p-4 mb-4 {{ $i > 0 ? 'bg-gray-50' : '' }}">
                                    <h3 class="font-semibold mb-3">Tâche {{ $i + 1 }}</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Titre *</label>
                                            <input type="text" name="tasks[{{ $i }}][title]" 
                                                   class="border rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                   placeholder="Titre de la tâche">
                                        </div>
                                        
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                            <textarea name="tasks[{{ $i }}][description]" rows="2"
                                                      class="border rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                      placeholder="Description de la tâche"></textarea>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Priorité *</label>
                                            <select name="tasks[{{ $i }}][priority]" 
                                                    class="border rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="low"> Basse</option>
                                                <option value="medium" selected> Moyenne</option>
                                                <option value="high"> Haute</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Statut *</label>
                                            <select name="tasks[{{ $i }}][status]" 
                                                    class="border rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="todo" selected> À faire</option>
                                                <option value="in_progress"> En cours</option>
                                                <option value="done"> Terminée</option>
                                            </select>
                                        </div>
                                        
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Date limite</label>
                                            <input type="date" name="tasks[{{ $i }}][deadline]" 
                                                   min="{{ date('Y-m-d') }}"
                                                   class="border rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                </div>
                                @endfor
                            </div>
                            
                            <div class="flex justify-between items-center mb-4">
                                <button type="button" id="add-task" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    ➕ Ajouter une tâche
                                </button>
                                <span class="text-sm text-gray-600">Maximum 5 tâches</span>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="flex gap-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                💾 Créer les tâches
                            </button>
                            <a href="{{ route('tasks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let taskCount = 3;
        const maxTasks = 5;
        
        document.getElementById('add-task').addEventListener('click', function() {
            if (taskCount < maxTasks) {
                const container = document.getElementById('tasks-container');
                const taskForm = document.createElement('div');
                taskForm.className = 'task-form border rounded-lg p-4 mb-4 bg-gray-50';
                taskForm.innerHTML = `
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-semibold">Tâche ${taskCount + 1}</h3>
                        <button type="button" class="remove-task text-red-600 hover:text-red-900 font-bold">Supprimer</button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Titre *</label>
                            <input type="text" name="tasks[${taskCount}][title]" 
                                   class="border rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Titre de la tâche">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="tasks[${taskCount}][description]" rows="2"
                                      class="border rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Description de la tâche"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Priorité *</label>
                            <select name="tasks[${taskCount}][priority]" 
                                    class="border rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="low"> Basse</option>
                                <option value="medium" selected> Moyenne</option>
                                <option value="high" Haute</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Statut *</label>
                            <select name="tasks[${taskCount}][status]" 
                                    class="border rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="todo" selected> À faire</option>
                                <option value="in_progress"> En cours</option>
                                <option value="done"> Terminée</option>
                            </select>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date limite</label>
                            <input type="date" name="tasks[${taskCount}][deadline]" 
                                   min="${new Date().toISOString().split('T')[0]}"
                                   class="border rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                `;
                
                container.appendChild(taskForm);
                taskCount++;
                
                // Ajouter l'événement de suppression
                taskForm.querySelector('.remove-task').addEventListener('click', function() {
                    taskForm.remove();
                    taskCount--;
                    updateTaskNumbers();
                    updateAddButton();
                });
                
                updateAddButton();
            }
        });
        
        function updateAddButton() {
            const addButton = document.getElementById('add-task');
            if (taskCount >= maxTasks) {
                addButton.disabled = true;
                addButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                addButton.disabled = false;
                addButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
        
        function updateTaskNumbers() {
            const taskForms = document.querySelectorAll('.task-form');
            taskForms.forEach((form, index) => {
                const title = form.querySelector('h3');
                if (title) {
                    title.textContent = `Tâche ${index + 1}`;
                }
            });
        }
    </script>
</x-app-layout>