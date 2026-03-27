<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $project->title }}
            </h2>
            @if($project->isLeader(Auth::id()))
                <a href="{{ route('student.projects.edit', $project) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg text-sm">
                    Edit Project
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Project Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <p class="text-gray-500 text-sm">Status</p>
                            <p class="font-semibold">
                                <span class="px-2 py-1 rounded text-xs
                                    @if($project->status == 'planning') bg-yellow-100 text-yellow-800
                                    @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800
                                    @elseif($project->status == 'completed') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Supervisor</p>
                            <p class="font-semibold">{{ $project->supervisor->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Timeline</p>
                            <p class="font-semibold">
                                {{ $project->start_date->format('M d, Y') }} 
                                @if($project->end_date)
                                    - {{ $project->end_date->format('M d, Y') }}
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-gray-500 text-sm">Description</p>
                        <p class="mt-1">{{ $project->description }}</p>
                    </div>
                    
                    @if($project->tech_stack)
                        <div>
                            <p class="text-gray-500 text-sm">Tech Stack</p>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @foreach($project->tech_stack as $tech)
                                    <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">{{ $tech }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Team Members -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">👥 Team Members</h3>
                        @if($project->isLeader(Auth::id()))
                            <button onclick="toggleAddMemberForm()" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded-lg text-sm">
                                + Add Member
                            </button>
                        @endif
                    </div>
                    
                    <!-- Add Member Form (hidden by default) -->
                    @if($project->isLeader(Auth::id()))
                        <div id="addMemberForm" class="hidden mb-4 p-4 bg-gray-50 rounded-lg">
                            <form method="POST" action="{{ route('student.projects.addMember', $project) }}">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <input type="email" name="email" placeholder="Student Email" required
                                           class="border-gray-300 rounded-md shadow-sm">
                                    <select name="role" required class="border-gray-300 rounded-md shadow-sm">
                                        <option value="developer">Developer</option>
                                        <option value="documenter">Documenter</option>
                                        <option value="tester">Tester</option>
                                    </select>
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                                        Add
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <script>
                            function toggleAddMemberForm() {
                                const form = document.getElementById('addMemberForm');
                                form.classList.toggle('hidden');
                            }
                        </script>
                    @endif
                    
                    <div class="space-y-2">
                        @foreach($project->members as $member)
                            <div class="flex justify-between items-center border-b pb-2">
                                <div>
                                    <span class="font-semibold">{{ $member->name }}</span>
                                    <span class="text-sm text-gray-500 ml-2">
                                        ({{ ucfirst($member->pivot->role) }})
                                    </span>
                                    @if($member->id == $project->created_by)
                                        <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded ml-2">Leader</span>
                                    @endif
                                </div>
                                @if($project->isLeader(Auth::id()) && $member->id != Auth::id())
                                    <form method="POST" action="{{ route('student.projects.removeMember', [$project, $member]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                            Remove
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Milestones -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">📋 Milestones</h3>
                        @if($project->isLeader(Auth::id()))
                            <a href="{{ route('student.milestones.create', $project) }}" 
                               class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded-lg text-sm">
                                + Add Milestone
                            </a>
                        @endif
                    </div>
                    
                    @if($project->milestones->count() > 0)
                        <div class="space-y-3">
                            @foreach($project->milestones as $milestone)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-bold">{{ $milestone->title }}</h4>
                                            <p class="text-sm text-gray-600">{{ $milestone->description }}</p>
                                            <div class="flex gap-3 mt-2 text-sm">
                                                <span class="text-gray-500">
                                                    Deadline: {{ $milestone->deadline->format('M d, Y') }}
                                                </span>
                                                <span class="px-2 py-1 rounded text-xs
                                                    @if($milestone->approvedSubmission) bg-green-100 text-green-800
                                                    @elseif($milestone->isOverdue()) bg-red-100 text-red-800
                                                    @else bg-yellow-100 text-yellow-800
                                                    @endif">
                                                    @if($milestone->approvedSubmission)
                                                        Approved
                                                    @elseif($milestone->isOverdue())
                                                        Overdue
                                                    @else
                                                        Pending
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        @if($project->isLeader(Auth::id()))
                                            <div class="flex gap-2">
                                                <a href="{{ route('student.milestones.edit', [$project, $milestone]) }}" 
                                                   class="text-indigo-600 hover:text-indigo-800 text-sm">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('student.milestones.destroy', [$project, $milestone]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm"
                                                            onclick="return confirm('Delete this milestone?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No milestones yet. Add your first milestone!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>