<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Auth::user()->projects()
            ->with(['supervisor', 'milestones'])
            ->latest()
            ->get();
            
        return view('student.projects.index', compact('projects'));
    }

    public function create()
    {
        $supervisors = User::where('role', 'supervisor')->get();
        return view('student.projects.create', compact('supervisors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tech_stack' => 'nullable|array',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'supervisor_id' => 'required|exists:users,id',
            'is_public' => 'boolean',
        ]);

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'tech_stack' => $request->tech_stack,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'supervisor_id' => $request->supervisor_id,
            'created_by' => Auth::id(),
            'is_public' => $request->is_public ?? false,
            'status' => 'planning',
        ]);

        // Add creator as team leader
        $project->members()->attach(Auth::id(), ['role' => 'leader']);

        return redirect()->route('student.projects.show', $project)
            ->with('success', 'Project created successfully!');
    }

    public function show(Project $project)
    {
        // Check if user is a member of this project
        if (!$project->isMember(Auth::id()) && !Auth::user()->isSupervisor()) {
            abort(403, 'You do not have access to this project.');
        }

        $project->load(['members', 'supervisor', 'milestones']);
        return view('student.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        // Only leader can edit
        if (!$project->isLeader(Auth::id())) {
            abort(403, 'Only the project leader can edit this project.');
        }

        $supervisors = User::where('role', 'supervisor')->get();
        return view('student.projects.edit', compact('project', 'supervisors'));
    }

    public function update(Request $request, Project $project)
    {
        if (!$project->isLeader(Auth::id())) {
            abort(403, 'Only the project leader can edit this project.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tech_stack' => 'nullable|array',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'supervisor_id' => 'required|exists:users,id',
            'is_public' => 'boolean',
        ]);

        $project->update($request->all());

        return redirect()->route('student.projects.show', $project)
            ->with('success', 'Project updated successfully!');
    }

    public function addMember(Request $request, Project $project)
    {
        if (!$project->isLeader(Auth::id())) {
            abort(403, 'Only the project leader can add members.');
        }

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|in:developer,documenter,tester',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($project->isMember($user->id)) {
            return back()->with('error', 'User is already a team member.');
        }

        $project->members()->attach($user->id, ['role' => $request->role]);

        return back()->with('success', 'Team member added successfully!');
    }

    public function removeMember(Project $project, User $user)
    {
        if (!$project->isLeader(Auth::id())) {
            abort(403, 'Only the project leader can remove members.');
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot remove yourself as leader.');
        }

        $project->members()->detach($user->id);

        return back()->with('success', 'Team member removed successfully.');
    }

    /**
 * Show delete confirmation page
 */
public function confirmDelete(Project $project)
{
    // Only leader can delete
    if (!$project->isLeader(auth()->id())) {
        abort(403, 'Only the project leader can delete this project.');
    }
    
    return view('student.projects.confirm-delete', compact('project'));
}

/**
 * Delete the project
 */
public function destroy(Project $project)
{
    // Only leader can delete
    if (!$project->isLeader(auth()->id())) {
        abort(403, 'Only the project leader can delete this project.');
    }
    
    // Delete project (will cascade delete milestones and pivot records)
    $project->delete();
    
    return redirect()->route('student.projects.index')
        ->with('success', 'Project deleted successfully!');
}

/**
 * Suspend/cancel the project
 */
public function suspend(Project $project)
{
    // Only leader can suspend
    if (!$project->isLeader(auth()->id())) {
        abort(403, 'Only the project leader can suspend this project.');
    }
    
    // Only allow suspension if project is not already completed or rejected
    if (in_array($project->status, ['completed', 'rejected'])) {
        return back()->with('error', 'This project cannot be suspended.');
    }
    
    $project->update(['status' => 'rejected']);
    
    return redirect()->route('student.projects.show', $project)
        ->with('success', 'Project has been suspended.');
}

/**
 * Archive completed project
 */
public function archive(Project $project)
{
    // Only leader can archive
    if (!$project->isLeader(auth()->id())) {
        abort(403, 'Only the project leader can archive this project.');
    }
    
    // Only allow archiving if project is completed
    if ($project->status !== 'completed') {
        return back()->with('error', 'Only completed projects can be archived.');
    }
    
    // You can add an archived_at field, or just keep status as completed
    // For now, we'll just redirect with message
    
    return redirect()->route('student.projects.show', $project)
        ->with('info', 'Project is already marked as completed.');
}
/**
 * Restore a suspended project
 */
public function restore(Project $project)
{
    // Only leader can restore
    if (!$project->isLeader(auth()->id())) {
        abort(403, 'Only the project leader can restore this project.');
    }
    
    // Only allow restore if project is rejected (suspended)
    if ($project->status !== 'rejected') {
        return back()->with('error', 'Only suspended projects can be restored.');
    }
    
    // Restore to planning status
    $project->update(['status' => 'planning']);
    
    return redirect()->route('student.projects.show', $project)
        ->with('success', 'Project has been restored successfully!');
}
}