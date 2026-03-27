<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ⚠️ Delete Project
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6 text-center">
                        <div class="text-red-600 text-6xl mb-4">⚠️</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Are you sure?</h3>
                        <p class="text-gray-600 mb-4">
                            You are about to delete the project: <strong>{{ $project->title }}</strong>
                        </p>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                            <p class="text-red-800 text-sm">
                                <strong>⚠️ Warning:</strong> This action cannot be undone. This will permanently delete:
                            </p>
                            <ul class="list-disc list-inside text-red-700 text-sm mt-2">
                                <li>The project and all its details</li>
                                <li>All milestones associated with this project</li>
                                <li>All team member associations</li>
                                <li>Any submissions (coming in Phase 3)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="flex justify-center space-x-3">
                        <a href="{{ route('student.projects.show', $project) }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg">
                            Cancel
                        </a>
                        <form method="POST" action="{{ route('student.projects.destroy', $project) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg"
                                    onclick="return confirm('Permanently delete this project? This cannot be undone.')">
                                Yes, Delete Project
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>