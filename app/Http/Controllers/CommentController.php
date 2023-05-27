<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function create($task_id)
    {
        $task = Task::find($task_id);
        return view('todo.comment', compact('task'));
    }

    public function store(Request $request)
    {
        // dd($request);
        // $task = Task::find($request->task_id);
        $comment = new Comment;
        $comment -> contents = $request -> contents;
        $comment -> user_id = Auth::id();
        $comment -> task_id = $request -> task_id;
        $comment -> save;
        // dd($comment);
        // return redirect()->route('todo.show');
        return redirect()->route('show');
    }
}
