<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function create_task_assign_list(Request $request)
    {
        if (auth()->user()->role === 'Manager')
            if ($request->project_id && $request->status) {
                $teammates = User::where('role', '!=', 'Manager')->latest()->get();
                $projects = Project::latest()->get();
                $project_id = $request->project_id;
                $status = $request->status;

                $task_assigns_list = Task::join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->join('users', 'tasks.assigned_to', '=', 'users.id')
                    ->select('tasks.*', 'projects.name as project_name', 'users.name as users_name')
                    ->where('tasks.project_id', $project_id)
                    ->where('tasks.status', $status)
                    ->orderby('tasks.id', 'DESC')
                    ->get();
                return view('Task.task_list', compact('teammates', 'project_id', 'status', 'task_assigns_list', 'projects'));
            } else {
                $project_id = $request->project_id;
                $status = $request->status;
                $teammates = User::where('role', '!=', 'Manager')->latest()->get();
                $projects = Project::latest()->get();
                $task_assigns_list = Task::join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->join('users', 'tasks.assigned_to', '=', 'users.id')
                    ->select('tasks.*', 'projects.name as project_name', 'users.name as users_name')
                    ->orderby('tasks.id', 'DESC')
                    ->get();
                return view('Task.task_list', compact('teammates', 'project_id', 'status', 'task_assigns_list', 'projects'));
            }
        elseif (auth()->user()->role === 'Teammate') {

            if ($request->project_id && $request->status) {
                $teammates = User::where('role', '!=', 'Manager')->latest()->get();
                $projects = Project::latest()->get();
                $project_id = $request->project_id;
                $status = $request->status;

                $task_assigns_list = Task::join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->join('users', 'tasks.assigned_to', '=', 'users.id')
                    ->select('tasks.*', 'projects.name as project_name', 'users.name as users_name')
                    ->where('tasks.project_id', $project_id)
                    ->where('tasks.status', $status)
                    ->where('tasks.assigned_to', Auth::user()->id)
                    ->orderby('tasks.id', 'DESC')
                    ->get();
                return view('Task.task_list', compact('teammates', 'project_id', 'status', 'task_assigns_list', 'projects'));
            } else {
                $project_id = $request->project_id;
                $status = $request->status;
                $teammates = User::where('role', '!=', 'Manager')->latest()->get();
                $projects = Project::latest()->get();
                $task_assigns_list = Task::join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->join('users', 'tasks.assigned_to', '=', 'users.id')
                    ->select('tasks.*', 'projects.name as project_name', 'users.name as users_name')
                    ->where('tasks.assigned_to', Auth::user()->id)
                    ->orderby('tasks.id', 'DESC')
                    ->get();
                return view('Task.task_list', compact('teammates', 'project_id', 'status', 'task_assigns_list', 'projects'));
            }
        }
    }

    public function task_store(Request $request)
    {
       

        $request->validate([
            'task_name' => 'required',
            'task_description' => 'required',
            'project_id' => 'required|exists:projects,id',
            'teammates_id' => 'required|array',
            'teammates_id.*' => 'exists:users,id',
        ]);
        
        foreach ($request->teammates_id as $teammate_id) {
            Task::create([
                'task_name' => $request->task_name,
                'task_description' => $request->task_description,
                'project_id' => $request->project_id,
                'assigned_to' => $teammate_id,
                'status' => 'Pending',
            ]);
        }
        
        return back()->with('success', 'Task created successfully');
        
    }

    public function task_status_update(Request $request)
    {
        $task = Task::find($request->id);
        $task->status = $request->status;
        $task->save();
        return response()->json($task);
    }

    public function filter_task(Request $request)
    {

        $task_assigns_list = Task::join('projects', 'tasks.project_id', '=', 'projects.id')
            ->join('users', 'tasks.assigned_to', '=', 'users.id')
            ->select('tasks.*', 'projects.name as project_name', 'users.name as users_name')
            ->where('tasks.project_id', $request->project_id)
            ->where('tasks.status', $request->status)
            ->latest()
            ->get();

        return $task_assigns_list;
    }

    public function destroy(Request $request)
    {
        Task::find($request->id)->delete();
        return back()->with('success', 'Successfully Deleted');
    }
}
