<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✏️ Edit Project: {{ $project->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('student.projects.update', $project) }}">
                        @csrf
                        @method('PUT')

                        <!-- Same fields as create form with old values -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="title">Project Title *</label>
                            <input type="text" name="title" id="title" 
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   value="{{ old('title', $project->title) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="description">Description *</label>
                            <textarea name="description" id="description" rows="5" 
                                      class="w-full border-gray-300 rounded-md shadow-sm"
                                      required>{{ old('description', $project->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Tech Stack (comma-separated)</label>
                            <input type="text" name="tech_stack" id="tech_stack" 
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   value="{{ old('tech_stack', implode(', ', $project->tech_stack ?? [])) }}">
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2" for="start_date">Start Date *</label>
                                <input type="date" name="start_date" id="start_date" 
                                       class="w-full border-gray-300 rounded-md shadow-sm"
                                       value="{{ old('start_date', $project->start_date->format('Y-m-d')) }}" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2" for="end_date">End Date</label>
                                <input type="date" name="end_date" id="end_date" 
                                       class="w-full border-gray-300 rounded-md shadow-sm"
                                       value="{{ old('end_date', $project->end_date?->format('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="supervisor_id">Supervisor *</label>
                            <select name="supervisor_id" id="supervisor_id" 
                                    class="w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select a supervisor</option>
                                @foreach($supervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}" 
                                        {{ old('supervisor_id', $project->supervisor_id) == $supervisor->id ? 'selected' : '' }}>
                                        {{ $supervisor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_public" value="1" 
                                       class="rounded border-gray-300 text-indigo-600"
                                       {{ old('is_public', $project->is_public) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Make project public</span>
                            </label>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('student.projects.show', $project) }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">
                                Cancel
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">
                                Update Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>