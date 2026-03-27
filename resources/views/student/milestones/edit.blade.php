<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✏️ Edit Milestone: {{ $milestone->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('student.milestones.update', [$project, $milestone]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="title">Milestone Title *</label>
                            <input type="text" name="title" id="title" 
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   value="{{ old('title', $milestone->title) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="type">Milestone Type *</label>
                            <select name="type" id="type" 
                                    class="w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="proposal" {{ $milestone->type == 'proposal' ? 'selected' : '' }}>Proposal</option>
                                <option value="progress_1" {{ $milestone->type == 'progress_1' ? 'selected' : '' }}>Progress Report 1</option>
                                <option value="progress_2" {{ $milestone->type == 'progress_2' ? 'selected' : '' }}>Progress Report 2</option>
                                <option value="final" {{ $milestone->type == 'final' ? 'selected' : '' }}>Final Report</option>
                                <option value="presentation" {{ $milestone->type == 'presentation' ? 'selected' : '' }}>Presentation</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="description">Description</label>
                            <textarea name="description" id="description" rows="4" 
                                      class="w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $milestone->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="deadline">Deadline *</label>
                            <input type="date" name="deadline" id="deadline" 
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   value="{{ old('deadline', $milestone->deadline->format('Y-m-d')) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="order">Order</label>
                            <input type="number" name="order" id="order" 
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   value="{{ old('order', $milestone->order) }}">
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('student.projects.show', $project) }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">
                                Cancel
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">
                                Update Milestone
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>