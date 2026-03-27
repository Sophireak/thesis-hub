<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🎓 Student Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-2">Welcome, {{ Auth::user()->name }}! 👋</h3>
                    @if(Auth::user()->studentProfile)
                        <p class="text-gray-600">Student ID: {{ Auth::user()->studentProfile->student_id }}</p>
                        <p class="text-gray-600">Department: {{ Auth::user()->studentProfile->department }}</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h4 class="text-lg font-bold mb-4">⚡ Quick Actions</h4>
                    <a href="{{ route('student.projects.create') }}" 
                       class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">
                        + Create New Project
                    </a>
                    <a href="{{ route('student.projects.index') }}" 
                       class="inline-block ml-3 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                        View All Projects
                    </a>
                </div>
            </div>

            <!-- Recent Projects -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-bold mb-4">📁 Your Recent Projects</h4>
                    @php
                        $recentProjects = Auth::user()->projects()->latest()->take(3)->get();
                    @endphp
                    
                    @if($recentProjects->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($recentProjects as $project)
                                <div class="border rounded-lg p-4">
                                    <h5 class="font-bold text-indigo-600 mb-2">
                                        <a href="{{ route('student.projects.show', $project) }}">
                                            {{ $project->title }}
                                        </a>
                                    </h5>
                                    <p class="text-sm text-gray-600 mb-2">{{ Str::limit($project->description, 80) }}</p>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-500">Progress: {{ $project->progress }}%</span>
                                        <span class="px-2 py-1 rounded text-xs
                                            @if($project->status == 'planning') bg-yellow-100 text-yellow-800
                                            @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800
                                            @elseif($project->status == 'completed') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No projects yet. Create your first project!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>