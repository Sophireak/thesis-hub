<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Milestone;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    public function create(Project $project)
    {
        // Only leader can create milestones
        if (!$project->isLeader(auth()->id())) {
            abort(403, 'Only the project leader can create milestones.');
        }

        return view('student.milestones.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        if (!$project->isLeader(auth()->id())) {
            abort(403, 'Only the project leader can create milestones.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:proposal,progress_1,progress_2,final,presentation',
            'deadline' => 'required|date',
            'order' => 'integer',
        ]);

        $project->milestones()->create($request->all());

        return redirect()->route('student.projects.show', $project)
            ->with('success', 'Milestone created successfully!');
    }

    public function edit(Project $project, Milestone $milestone)
    {
        if (!$project->isLeader(auth()->id())) {
            abort(403, 'Only the project leader can edit milestones.');
        }

        return view('student.milestones.edit', compact('project', 'milestone'));
    }

    public function update(Request $request, Project $project, Milestone $milestone)
    {
        if (!$project->isLeader(auth()->id())) {
            abort(403, 'Only the project leader can edit milestones.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:proposal,progress_1,progress_2,final,presentation',
            'deadline' => 'required|date',
            'order' => 'integer',
        ]);

        $milestone->update($request->all());

        return redirect()->route('student.projects.show', $project)
            ->with('success', 'Milestone updated successfully!');
    }

    public function destroy(Project $project, Milestone $milestone)
    {
        if (!$project->isLeader(auth()->id())) {
            abort(403, 'Only the project leader can delete milestones.');
        }

        $milestone->delete();

        return redirect()->route('student.projects.show', $project)
            ->with('success', 'Milestone deleted successfully!');
    }
}
