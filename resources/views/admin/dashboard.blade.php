<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ⚙️ Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Welcome, Admin {{ Auth::user()->name }}! 👋</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold mb-2">📊 Statistics</h4>
                            <p class="mb-1">Total Students: {{ \App\Models\StudentProfile::count() }}</p>
                            <p class="mb-1">Total Supervisors: {{ \App\Models\SupervisorProfile::count() }}</p>
                            <p>Total Users: {{ \App\Models\User::count() }}</p>
                        </div>
                        
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold mb-2">🔧 Quick Actions</h4>
                            <p class="text-gray-500">Admin panel coming soon...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>