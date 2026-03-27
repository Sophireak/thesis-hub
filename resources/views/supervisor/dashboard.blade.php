<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            👨‍🏫 Supervisor Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-2">Welcome, {{ Auth::user()->name }}! 👋</h3>
                    @if(Auth::user()->supervisorProfile)
                        <p class="text-gray-600">Department: {{ Auth::user()->supervisorProfile->department }}</p>
                        <p class="text-gray-600">Office: {{ Auth::user()->supervisorProfile->office_room ?? 'Not assigned' }}</p>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            @php
                $supervisedProjects = Auth::user()->supervisedProjects;
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-3xl font-bold text-indigo-600">{{ $supervisedProjects->count() }}</p>
                        <p class="text-gray-600">Total Projects</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-3xl font-bold text-green-600">{{ $supervisedProjects->where('status', 'completed')->count() }}</p>
                        <p class="text-gray-600">Completed</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-3xl font-bold text-yellow-600">{{ $supervisedProjects->where('status', 'in_progress')->count() }}</p>
                        <p class="text-gray-600">In Progress</p>
                    </div>
                </div>
            </div>

            <!-- Recent Projects -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-bold">📁 Recent Projects</h4>
                        <a href="{{ route('supervisor.projects') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                            View All →
                        </a>
                    </div>
                    
                    @if($supervisedProjects->count() > 0)
                        <div class="space-y-3">
                            @foreach($supervisedProjects->take(5) as $project)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h5 class="font-bold">{{ $project->title }}</h5>
                                            <p class="text-sm text-gray-600">Team: {{ $project->members->count() }} members</p>
                                        </div>
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
                                            <div class="bg-indigo-600 rounded-full h-2" style="width: {{ $project->progress }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No projects assigned yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>