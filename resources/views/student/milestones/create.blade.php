<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ➕ Add Milestone to: {{ $project->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('student.milestones.store', $project) }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="title">Milestone Title *</label>
                            <input type="text" name="title" id="title" 
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="type">Milestone Type *</label>
                            <select name="type" id="type" 
                                    class="w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="proposal">Proposal</option>
                                <option value="progress_1">Progress Report 1</option>
                                <option value="progress_2">Progress Report 2</option>
                                <option value="final">Final Report</option>
                                <option value="presentation">Presentation</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="description">Description</label>
                            <textarea name="description" id="description" rows="4" 
                                      class="w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="deadline">Deadline *</label>
                            <input type="date" name="deadline" id="deadline" 
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   value="{{ old('deadline') }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="order">Order (optional)</label>
                            <input type="number" name="order" id="order" 
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   value="{{ old('order', 0) }}">
                            <p class="text-gray-500 text-sm mt-1">Lower numbers appear first</p>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('student.projects.show', $project) }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">
                                Cancel
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">
                                Create Milestone
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>