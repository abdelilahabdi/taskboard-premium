<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier la Tâche') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Titre')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $task->title)" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description (optionnel)')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="Décrivez votre tâche...">{{ old('description', $task->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="deadline" :value="__('Date limite (optionnel)')" />
                            <x-text-input id="deadline" class="block mt-1 w-full" type="date" name="deadline" :value="old('deadline', $task->deadline ? $task->deadline->format('Y-m-d') : '')" />
                            <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Laissez vide si pas de date limite</p>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="priority" :value="__('Priorité')" />
                            <select id="priority" name="priority" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="low" {{ old('priority', $task->priority) === 'low' ? 'selected' : '' }}>Faible</option>
                                <option value="medium" {{ old('priority', $task->priority) === 'medium' ? 'selected' : '' }}>Moyenne</option>
                                <option value="high" {{ old('priority', $task->priority) === 'high' ? 'selected' : '' }}>Élevée</option>
                            </select>
                            <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="status" :value="__('Statut')" />
                            <select id="status" name="status" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="todo" {{ old('status', $task->status) === 'todo' ? 'selected' : '' }}>À faire</option>
                                <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>En cours</option>
                                <option value="done" {{ old('status', $task->status) === 'done' ? 'selected' : '' }}>Terminé</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('tasks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Annuler
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                💾 Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>