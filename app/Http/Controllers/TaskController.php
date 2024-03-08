<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Session ;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $high_priority_tasks = Task::where('priority', 'High')->orderBy('id', 'desc')->get();
        $medium_priority_tasks = Task::where('priority', 'Medium')->orderBy('id', 'desc')->get();
        $low_priority_tasks = Task::where('priority', 'Low')->orderBy('id', 'desc')->get();
        return view('tasks.index', compact('high_priority_tasks', 'medium_priority_tasks', 'low_priority_tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:2048',
            'description' => 'max:2048',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $task = new Task;
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->priority = $request->input('priority');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/tasks/', $filename);
            $task->image = 'uploads/tasks/' . $filename; 
            $task->save(); 
        }
        
        $task->save();
        return redirect()->route('tasks.index')
                        ->with('success','Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::where('id',$id)->first();
        if(!$task)
        {
            return redirect()->back();
        }
        return view('tasks.show',compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::where('id',$id)->first();
        if(!$task)
        {
            return redirect()->back();
        }
        return view('tasks.edit',compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $task_id = $request->task_id;
        $request->validate([
            'name' => 'required|max:2048',
            'description' => 'max:2048',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $task = Task::where('id',$task_id)->first();
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->priority = $request->input('priority');
    
        if ($request->hasFile('image')) {
            if ($task->image) {
                unlink(public_path($task->image));
            }
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/tasks/'), $filename);
            $task->image = 'uploads/tasks/' . $filename;
        }
        $task->save();
        return redirect()->route('tasks.show', ['id' => $task_id])
                ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $task = Task::find($id);

        if($task){
            if (file_exists($task->image)) {
                unlink($imagePath);
            }
            $task->delete();
            return response()->json(['status' => 'true','tr'=>'tr_'.$id]);
        } 
    }

    public function updatePriority(Request $request, Task $task) 
    {
        $priority = $request->get('priority');
        $id = $request->get('id');

        $task = Task::find($id);
        $task->priority = $priority;
        $task->save();

        return response()->json(['status' => 'true']);
    }

    public function updateStatus(Request $request)
    {
        $status = $request->status;   
        $task_id = $request->task_id;
        $task = Task::find($task_id);
        $task->completed = $status;
        $task->save();
        
        return response()->json(['success'=>'Task status change successfully.']);
    }
}
