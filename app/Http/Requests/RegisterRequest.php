<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:student,supervisor',
            'student_id' => 'required_if:role,student|unique:student_profiles,student_id|nullable|string',
            'department' => 'required|string|max:255',
            'academic_year' => 'required_if:role,student|integer|min:1|max:5|nullable',
            'phone_number' => 'nullable|string|max:20',
            'office_room' => 'required_if:role,supervisor|nullable|string|max:50',
            'max_students' => 'required_if:role,supervisor|integer|min:1|max:20|nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required_if' => 'Student ID is required for student registration.',
            'academic_year.required_if' => 'Academic year is required for student registration.',
            'office_room.required_if' => 'Office room is required for supervisor registration.',
            'max_students.required_if' => 'Max students is required for supervisor registration.',
        ];
    }
}