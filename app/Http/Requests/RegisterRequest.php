<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:student,supervisor',
            'student_id' => 'required_if:role,student|unique:student_profiles|nullable',
            'department' => 'required|string',
            'academic_year' => 'required_if:role,student|integer|min:1|max:5|nullable',
            'phone_number' => 'nullable|string',
            'office_room' => 'required_if:role,supervisor|nullable|string',
            'max_students' => 'required_if:role,supervisor|integer|min:1|max:20|nullable',
        ];
    }

    public function messages()
    {
        return [
            'student_id.required_if' => 'Student ID is required for students',
            'academic_year.required_if' => 'Academic year is required for students',
            'office_room.required_if' => 'Office room is required for supervisors',
        ];
    }
}