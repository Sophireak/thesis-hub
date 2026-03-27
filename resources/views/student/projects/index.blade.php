<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📁 My Projects
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('student.projects.create') }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">
                    + Create New Project
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($projects->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($projects as $project)
                                <div class="border rounded-lg p-4 hover:shadow-lg transition">
                                    <h3 class="text-lg font-bold mb-2">
                                        <a href="{{ route('student.projects.show', $project) }}" 
                                           class="text-indigo-600 hover:text-indigo-800">
                                            {{ $project->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 text-sm mb-2">
                                        {{ Str::limit($project->description, 100) }}
                                    </p>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-500">
                                            Supervisor: {{ $project->supervisor->name }}
                                        </span>
                                        <span class="px-2 py-1 rounded text-xs
                                            @if($project->status == 'planning') bg-yellow-100 text-yellow-800
                                            @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800
                                            @elseif($project->status == 'completed') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </div>
                                    <div class="mt-2">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-indigo-600 rounded-full h-2" 
                                                 style="width: {{ $project->progress }}%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Progress: {{ $project->progress }}%</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No projects yet. Create your first project!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>