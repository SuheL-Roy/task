<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function create_project_list()
    {
        $projects = Project::latest()->get();
        return view('Project.project_list', compact('projects'));
    }

    public function project_store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $project = new Project();
        $project->project_code = $request->project_code;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->deadline = $request->deadline;
        $project->save();

        return back()->with('success', 'Project created Successfully');
    }

    public function project_wise_task_filter(Request $request)
    {


        if ($request->project_id && $request->teammates_id && $request->task_id) {
            $project_id = $request->project_id;
            $teammates_id = $request->teammates_id;
            $task_id = $request->task_id;
            $teammates = User::where('role', '!=', 'Manager')->latest()->get();
            $projects = Project::latest()->get();

            $task_list = Task::select('id', 'task_name')
                ->whereIn('id', function ($query) {
                    $query->selectRaw('MAX(id)')
                        ->from('tasks')
                        ->groupBy('task_name');
                })
                ->orderByDesc('id')
                ->get();
                
            $project_wise_task_assigns_list = Task::join('projects', 'tasks.project_id', '=', 'projects.id')
                ->join('users', 'tasks.assigned_to', '=', 'users.id')
                ->select('tasks.*', 'projects.name as project_name', 'projects.project_code as project_code', 'users.name as users_name')
                ->where('tasks.project_id', $project_id)
                ->where('tasks.assigned_to', $teammates_id)
                ->where('tasks.id', $task_id)
                ->latest()
                ->get();
            return view('Filter_project.project_filter', compact('project_id', 'teammates_id', 'teammates', 'task_id', 'projects', 'project_wise_task_assigns_list', 'task_list', 'teammates', 'project_wise_task_assigns_list'));
        } else {
            $project_id = $request->project_id;
            $teammates_id = $request->teammates_id;
            $task_id = $request->task_id;
            $teammates = User::where('role', '!=', 'Manager')->latest()->get();
            $projects = Project::latest()->get();

            $task_list = Task::select('id', 'task_name')
                ->whereIn('id', function ($query) {
                    $query->selectRaw('MAX(id)')
                        ->from('tasks')
                        ->groupBy('task_name');
                })
                ->orderByDesc('id')
                ->get();


            $project_wise_task_assigns_list = Task::join('projects', 'tasks.project_id', '=', 'projects.id')
                ->join('users', 'tasks.assigned_to', '=', 'users.id')
                ->select('tasks.*', 'projects.name as project_name', 'projects.project_code as project_code', 'users.name as users_name')
                ->latest()
                ->get();
            return view('Filter_project.project_filter', compact('project_id', 'teammates_id', 'teammates', 'task_id', 'projects', 'project_wise_task_assigns_list', 'task_list', 'teammates', 'project_wise_task_assigns_list'));
        }
    }

    public function delete(Request $request)
    {

        Project::find($request->id)->delete();
        Task::where('project_id', $request->id)->delete();
        return back()->with('success', 'Successfully Deleted');
    }
}
