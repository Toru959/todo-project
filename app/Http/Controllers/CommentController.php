<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function create($id)
    {
        $task = Task::find($id);
        return view('todo.comment', compact('task'));
    }

    public function store(Request $request, $id) //第二引数に＄idを追加。パラメーターのidを受け取れる
    {
        $task = Task::findOrFail($id); //パラメーターのidでt一致するaskのレコードをとってくることでuser_idを指定できる。
        
        // $task = Task::find($request->task_id);
        $comment = new Comment;
        $comment -> contents = $request -> contents;
        $comment -> user_id = Auth::id(); // 現在ログインしているユーザー
        $comment -> task_id = $id; // パラメーターがそのままtask_idになる
        $comment -> save(); 
        
        // return redirect()->route('todo.show');
        return redirect()->route('todo.show',$id); //とりあえずindexに戻るようにしてる
    }

    // public function show($id)
    // {
    //     $comments = Comment::find($id);
    //     // dd($comments);
    //     return view('todo.show', compact('comments'));
        
    // } 

    public function destroy($id)
    {
        $task = Task::find($id);
        $comments = Comment::where('task_id', $id)->get();

        $comment = Comment::find($id);
        $comment->delete();
        // return redirect()->route('todo.show',compact('task','comment'));
        return view('todo.show', compact('task','comments'));
    }
}
