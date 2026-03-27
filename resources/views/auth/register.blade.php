<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Register as')" />
            <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Student Fields -->
        <div id="student-fields" class="mt-4" style="{{ old('role') == 'supervisor' ? 'display: none;' : 'display: block;' }}">
            <div>
                <x-input-label for="student_id" :value="__('Student ID')" />
                <x-text-input id="student_id" class="block mt-1 w-full" type="text" name="student_id" :value="old('student_id')" />
                <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="academic_year" :value="__('Academic Year')" />
                <select id="academic_year" name="academic_year" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">Select Year</option>
                    <option value="1" {{ old('academic_year') == 1 ? 'selected' : '' }}>Year 1</option>
                    <option value="2" {{ old('academic_year') == 2 ? 'selected' : '' }}>Year 2</option>
                    <option value="3" {{ old('academic_year') == 3 ? 'selected' : '' }}>Year 3</option>
                    <option value="4" {{ old('academic_year') == 4 ? 'selected' : '' }}>Year 4</option>
                    <option value="5" {{ old('academic_year') == 5 ? 'selected' : '' }}>Year 5+</option>
                </select>
                <x-input-error :messages="$errors->get('academic_year')" class="mt-2" />
            </div>
        </div>

        <!-- Supervisor Fields -->
        <div id="supervisor-fields" class="mt-4" style="{{ old('role') == 'supervisor' ? 'display: block;' : 'display: none;' }}">
            <div>
                <x-input-label for="office_room" :value="__('Office Room')" />
                <x-text-input id="office_room" class="block mt-1 w-full" type="text" name="office_room" :value="old('office_room')" />
                <x-input-error :messages="$errors->get('office_room')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="max_students" :value="__('Max Students')" />
                <x-text-input id="max_students" class="block mt-1 w-full" type="number" name="max_students" :value="old('max_students', 5)" />
                <x-input-error :messages="$errors->get('max_students')" class="mt-2" />
            </div>
        </div>

        <!-- Department (Common) -->
        <div class="mt-4">
            <x-input-label for="department" :value="__('Department')" />
            <x-text-input id="department" class="block mt-1 w-full" type="text" name="department" :value="old('department')" required />
            <x-input-error :messages="$errors->get('department')" class="mt-2" />
        </div>

        <!-- Phone Number (Common) -->
        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Phone Number (Optional)')" />
            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const studentFields = document.getElementById('student-fields');
            const supervisorFields = document.getElementById('supervisor-fields');

            function toggleFields() {
                if (roleSelect.value === 'student') {
                    studentFields.style.display = 'block';
                    supervisorFields.style.display = 'none';
                } else {
                    studentFields.style.display = 'none';
                    supervisorFields.style.display = 'block';
                }
            }

            roleSelect.addEventListener('change', toggleFields);
            toggleFields(); // Initialize on page load
        });
    </script>
</x-guest-layout>