<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ➕ Create New Project
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('student.projects.store') }}">
                        @csrf

                        <!-- Title -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="title">
                                Project Title *
                            </label>
                            <input type="text" name="title" id="title" 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   value="{{ old('title') }}" required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="description">
                                Description *
                            </label>
                            <textarea name="description" id="description" rows="5" 
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tech Stack -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="tech_stack">
                                Tech Stack (comma-separated)
                            </label>
                            <input type="text" name="tech_stack" id="tech_stack" 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="Laravel, React, MySQL"
                                   value="{{ old('tech_stack') }}">
                            <p class="text-gray-500 text-sm mt-1">Separate technologies with commas</p>
                            @error('tech_stack')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2" for="start_date">
                                    Start Date *
                                </label>
                                <input type="date" name="start_date" id="start_date" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2" for="end_date">
                                    End Date (Optional)
                                </label>
                                <input type="date" name="end_date" id="end_date" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('end_date') }}">
                                @error('end_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Supervisor -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="supervisor_id">
                                Supervisor *
                            </label>
                            <select name="supervisor_id" id="supervisor_id" 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                <option value="">Select a supervisor</option>
                                @foreach($supervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}" {{ old('supervisor_id') == $supervisor->id ? 'selected' : '' }}>
                                        {{ $supervisor->name }} - {{ $supervisor->supervisorProfile->department ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supervisor_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Public/Private -->
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_public" value="1" 
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                       {{ old('is_public') ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Make project public (visible to all students)</span>
                            </label>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('student.projects.index') }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">
                                Create Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>