<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🎓 Student Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->name }}! 👋</h3>
                    
                    @if(Auth::user()->studentProfile)
                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <p class="mb-2"><strong>Student ID:</strong> {{ Auth::user()->studentProfile->student_id }}</p>
                            <p class="mb-2"><strong>Department:</strong> {{ Auth::user()->studentProfile->department }}</p>
                            <p class="mb-2"><strong>Academic Year:</strong> Year {{ Auth::user()->studentProfile->academic_year }}</p>
                            <p><strong>Phone:</strong> {{ Auth::user()->studentProfile->phone_number ?? 'Not provided' }}</p>
                        </div>
                    @endif
                    
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-2">Your Projects</h4>
                        <p class="text-gray-500">No projects yet. Check back later!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>