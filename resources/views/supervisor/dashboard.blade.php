<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            👨‍🏫 Supervisor Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->name }}! 👋</h3>
                    
                    @if(Auth::user()->supervisorProfile)
                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <p class="mb-2"><strong>Department:</strong> {{ Auth::user()->supervisorProfile->department }}</p>
                            <p class="mb-2"><strong>Office Room:</strong> {{ Auth::user()->supervisorProfile->office_room ?? 'Not assigned' }}</p>
                            <p><strong>Max Students:</strong> {{ Auth::user()->supervisorProfile->max_students }}</p>
                        </div>
                    @endif
                    
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-2">Supervised Projects</h4>
                        <p class="text-gray-500">No assigned projects yet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>